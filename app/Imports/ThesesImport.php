<?php

namespace App\Imports;

use App\Models\Thesis;
use App\Models\College;
use App\Models\Program;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Subject;
use App\Models\Author;
use Illuminate\Support\Str;

class ThesesImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnFailure
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
        $formattedAuthors = explode(';',$row['authors']);
        $serializedAuthors = array_filter($formattedAuthors, fn($name)=> !empty($name));
        $authors = array_map(fn($name) => explode(',', $name), $serializedAuthors);
        $citationIni = array_map(fn($name)=> trim($name[0]) .", " .substr(trim($name[1]), 0, 1), $authors);
        $date = explode('-', $row['date_of_publication']);
        $year = $date[0];
        $citation = implode(',',$citationIni) . "({$year}) . {$row['title']}";
        $subjects = explode(',', $row['subject']);
        

        return DB::transaction(function () use($row,$subId ,$authors, $subjects, $citation){
            
            $programID = Program::select('id')->where('description', trim($row['college_program']))->first()->id;
            $thesis = Thesis::create([
                'title'         => trim($row['title']),
                'publisher'     => trim($row['publisher']),
                'date_of_publication' => trim($row['date_of_publication']),
                'citation'      => trim($citation),
                'abstract'      => trim($row['abstract']),
                'program_id'    => $programID,
                'file_id'       => NULL,
            ]);

            foreach($authors as $data)
            {
                $author = new Author();
                $author->first_name = trim($data[1]);
                $author->last_name = trim($data[0]);
                $author->middle_name = trim($data[2]);
                $thesis->authors()->save($author);
            }

            foreach ($subjects as $data) {

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
            '*.title' => ['required', 'unique:theses,title'],
            '*.authors' => ['required'],
            '*.publisher' => ['required'],
            '*.date_of_publication' => ['required', 'date_format:Y-m'],
            '*.college_program' => ['required', 'exists:programs,description'],
            '*.subject' => ['required'],
            '*.abstract' => ['required']
        ];
    }

    public function customValidationMessages()
    {
        return [
            'college_program.exists' => 'College program does not exists.',
            'date_of_publication.date_format' => 'Date of publication must be Y-m format (ex. 2022-01)',
        ];
    }
    
    public function customValidationAttributes()
    {
        return [
            1 => 'title',
            2 => 'authors',
            3 => 'publisher',
            4 => 'date_of_publication',
            5 => 'college_program',
            6 => 'subject',
            7 => 'abstract'
        ];
    }

}
