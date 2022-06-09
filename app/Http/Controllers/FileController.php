<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Thesis;
use App\Models\Program;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class FileController extends Controller
{
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|min:100|max:16000'
        ]);

        $program = Thesis::where('id', $id)->first()->program;
        $path = Program::find($program->id)->directory->path;
        $thesis = Thesis::find($id);
        $filename = Str::slug($thesis->title . " " . $thesis->date_of_publication, "-");
        $save = $request->file('file')->storeAs($path, $filename, 'google');
        $file = File::create([
            'description' => $filename,
            'path' => $this->fileDirectory($program->id, $filename)
        ]);
        $thesis->file_id = $file->id;
        $thesis->save();
        return back();
    }

    private function fileDirectory($program, $filename)
    {
        $storage = Storage::disk('google');
        $files = $storage->files(Program::find($program)->directory->path);
        foreach($files as $file)
        {
            $data = $storage->getAdapter()->getMetadata($file);

            if(Str::is(Str::lower($data['filename']), Str::lower($filename)))
            {
                return $data['path'];
            }
        }
    }
}
