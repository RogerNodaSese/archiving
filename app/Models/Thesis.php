<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Keyword;
use App\Models\Subject;
use App\Models\Author;
use App\Models\Program;
use App\Models\File;
use App\Models\SubjectThesis;
use App\Models\User;

class Thesis extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'title',
        // 'accession_number',
        'place_of_publication',
        'user_id',
        'publisher',
        'date_of_publication',
        'abstract',
        'program_id',
        'citation',
        'file_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class,'keyword_thesis', 'thesis_id', 'keyword_id')
                            ->whereNull('deleted_at')
                            ->withPivot(['deleted_at']);;
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_thesis', 'thesis_id', 'subject_id')
                            ->whereNull('deleted_at')
                            ->withPivot(['deleted_at']);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'author_thesis', 'thesis_id', 'author_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }

    public function subjectsWithTrashed(){
        return $this->belongsToMany(Subject::class, 'subject_thesis', 'thesis_id', 'subject_id')
                    ->whereNull('deleted_at')
                    ->orWhereNotNull('deleted_at')
                    ->withPivot(['deleted_at']);
    }

    public function keywordsWithTrashed()
    {
        return $this->belongsToMany(Keyword::class,'keyword_thesis', 'thesis_id', 'keyword_id')
                    ->whereNull('deleted_at')
                    ->orWhereNotNull('deleted_at')
                    ->withPivot(['deleted_at']);
    }

    public static function boot(){
        parent::boot();
        self::deleting(function($thesis){
            $thesis->subjects()->each(function($subject) use($thesis){
                $thesis->subjects()->updateExistingPivot($subject, ['deleted_at' => \Carbon\Carbon::now()]);
            });

            $thesis->keywords()->each(function($keyword) use($thesis){
                $thesis->keywords()->updateExistingPivot($keyword, ['deleted_at' => \Carbon\Carbon::now()]);
            });
        });
    }

//     public static function boot(){
//         // parent::boot();
//         // self::deleting(function($thesis){
//         //     $thesis->authors()->each(function($author){
//         //         $author->delete();
//         //     });
//         //     $thesis->keywords()->each(function($keyword){
//         //         $keyword->delete();
//         //     });
//         //     $thesis->subjects()->each(function($subject){
//         //         $subject->delete();
//         //     });

//             // File::doesntHave('thesis')->delete();
//         // });
//     }
}
