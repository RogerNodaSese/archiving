<?php

namespace App\Imports;

use App\Models\Thesis;
use App\Models\College;
use App\Models\Program;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Subject;
use App\Models\Author;
use Illuminate\Support\Str;

class ThesesImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnFailure, WithBatchInserts, WithChunkReading
{
    use Importable, SkipsFailures;

    private $collegeID;
    private $collegeProgram;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $subId = [];
        $autId = [];
        $formattedAuthors = explode(';',$row['authors']);
        $serializedAuthors = array_filter($formattedAuthors, fn($name)=> !empty($name));
        $authors = array_map(fn($name) => explode(',', $name), $serializedAuthors);
        $citationIni = array_map(fn($name)=> trim($name[0]) .", " .substr(trim($name[1]), 0, 1), $authors);
        $date = explode('-', $row['date']);
        $year = $date[0];
        $citation = implode(',',$citationIni) . "({$year}) . {$row['title']}";
        $subjects = explode(',', $row['subjects']);
        
        // if(Thesis::where('title', $row['title'])->exists())
        // {
        //     return;
        // }

        return DB::transaction(function () use($row,$subId ,$authors,$autId, $subjects, $citation){
            
            $programID = Program::select('id')->where('description', trim($row['college']))->first()->id;
            // $thesis = Thesis::create([
            //     'title'         => trim($row['title']),
            //     'publisher'     => trim($row['publisher']),
            //     'date_of_publication' => trim($row['date']),
            //     'citation'      => trim($citation),
            //     'abstract'      => trim($row['abstract']),
            //     'program_id'    => $programID,
            //     'file_id'       => NULL,
            // ]);

            $thesis = Thesis::updateOrCreate(
                ['title' => trim($row['title'])],
                [
                    'publisher'     => trim($row['publisher']),
                    'date_of_publication' => trim($row['date']),
                    'citation'      => trim($citation),
                    'abstract'      => trim($row['abstract']),
                    'program_id'    => $programID,
                    'file_id'       => NULL,
                ]
            );



            foreach($authors as $data)
            {
                $result = Author::where([
                    ['first_name','=', trim($data[1])],
                    ['last_name','=', trim($data[0])],
                    ['middle_name','=', trim($data[2])],
                ])->first();

                if(is_null($result))
                {
                    $author = new Author();
                    $author->first_name = trim($data[1]);
                    $author->last_name = trim($data[0]);
                    $author->middle_name = trim($data[2]);
                    $thesis->authors()->save($author);
                    array_push($autId, $author->id);
                }else
                {
                    array_push($autId, $result->id);
                }
            }
            $thesis->authors()->sync($autId);
            
            foreach ($subjects as $data) {
                if(empty($data))
                {
                    return;
                }
                $subResult = Subject::where('description', '=', Str::of($data)->trim())->first();
                if(is_null($subResult))
                {
                    $subject = new Subject();
                    $subject->description = Str::of($data)->trim();
                    $thesis->subjects()->save($subject);
                    array_push($subId, $subject->id);
                }else
                {
                    array_push($subId, $subResult->id);
                }
            }
            $thesis->subjects()->sync($subId);
        
        }, 3);

    }

    public function rules() : array 
    {
        return [
            '*.title' => ['required'],
            '*.authors' => ['required'],
            '*.publisher' => ['required'],
            '*.date' => ['required', 'date_format:Y-m'],
            '*.college' => ['required', 'exists:programs,description'],
            '*.subjects' => ['required'],
            '*.abstract' => ['required']
        ];
    }

    public function customValidationMessages()
    {
        return [
            'college.exists' => 'College program does not exists.',
            'date.date_format' => 'Date of publication must be Y-m format (ex. 2022-01)',
        ];
    }
    
    public function customValidationAttributes()
    {
        return [
            1 => 'title',
            2 => 'authors',
            3 => 'publisher',
            4 => 'date',
            5 => 'college',
            6 => 'subjects',
            7 => 'abstract'
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }

}
