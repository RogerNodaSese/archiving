<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;
use App\Models\Directory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class College extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'slug'
    ];


    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function directory()
    {
        return $this->morphOne(Directory::class, 'dir');
    }

    public static function booted()
    {
        static::created(function ($college){
            $storage = Storage::disk('google');
            $storage->makeDirectory($college->description);
            $directories = $storage->directories();
            foreach($directories as $directory)
            {
                $data = $storage->getAdapter()->getMetadata($directory);
                if(Str::is(Str::lower($data['filename']), Str::lower($college->description)))
                {
                    return $college->directory()->create([
                        'path' => $data['path']
                    ]);
                }
            }

            

        });
    }

}
