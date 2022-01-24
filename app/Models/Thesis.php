<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Keyword;
use App\Models\Subject;
use App\Models\Author;
use App\Models\Program;
use App\Models\File;

class Thesis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'date_of_issue',
        'abstract',
        'program_id',
        'citation',
        'file_id'
    ];

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class,'keyword_thesis', 'thesis_id', 'keyword_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_thesis', 'thesis_id', 'subject_id');
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

    public static function boot(){
        parent::boot();
        self::deleting(function($thesis){
            $thesis->authors()->each(function($author){
                $author->delete();
            });
            $thesis->keywords()->each(function($keyword){
                $keyword->delete();
            });
            $thesis->subjects()->each(function($subject){
                $subject->delete();
            });

            File::doesntHave('thesis')->delete();
        });
    }
}
