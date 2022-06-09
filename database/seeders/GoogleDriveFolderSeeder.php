<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\College;
use App\Models\Program;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class GoogleDriveFolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storage = Storage::disk('google');

        foreach(College::all() as $college)
        {
            $storage->makeDirectory($college->description);
            $directories = $storage->directories();
            foreach($directories as $directory)
            {
                $data = $storage->getAdapter()->getMetadata($directory);
                if(Str::is(Str::lower($data['filename']), Str::lower($college->description)))
                {
                    $college->directory()->create([
                        'path' => $data['path']
                    ]);
                }
            }
        }

        foreach(Program::all() as $program)
        {
            $college_path = College::find($program->college_id)->directory->path;
            $storage->makeDirectory($college_path.'/'. $program->description);
            $directories = $storage->directories($college_path);

            foreach($directories as $directory)
            {
                $data = $storage->getAdapter()->getMetadata($directory);
                if(Str::is(Str::lower($data['filename']), Str::lower($program->description)))
                {
                    $program->directory()->create([
                        'path' => $data['path']
                    ]);
                }
            }
        }
    }
}
