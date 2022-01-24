<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Thesis;
use App\Models\College;
use App\Models\Directory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Program extends Model
{
    use HasFactory;


    public function theses()
    {
        return $this->hasMany(Thesis::class,'program_id','id');
    }

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'id');
    }
    
    public function directory()
    {
        return $this->morphOne(Directory::class, 'dir');
    }

    public static function booted()
    {
        static::created(function($program){
            $college_path = College::find($program->college_id)->directory->path;
            $storage = Storage::disk('google');
            $storage->makeDirectory($college_path.'/'. $program->description);
            $directories = $storage->directories($college_path);

            foreach($directories as $directory)
            {
                $data = $storage->getAdapter()->getMetadata($directory);
                if(Str::is(Str::lower($data['filename']), Str::lower($program->description)))
                {
                    return $program->directory()->create([
                        'path' => $data['path']
                    ]);
                }
            }
        });
    }
}
