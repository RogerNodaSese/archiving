<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Thesis;
use App\Models\Author;
use App\Models\Subject;
class LibraryController extends Controller
{
    public function index()
    {
        // $file_size = 0;

        //     $files = \Illuminate\Support\Facades\Storage::disk('google')->allFiles();
        //     foreach( $files as $file)
        //     {
        //         $data = \Illuminate\Support\Facades\Storage::disk('google')->getAdapter()->getMetadata($file);
        //         $file_size += $data['size'];
        //     }
            
        // $count = collect([
        //     'userCount' => User::whereIn('role_id', [Role::STUDENT, ROLE::ADMIN])->count(),
        //     'collegeCount' => User::where('role_id', Role::ADMIN)->count(),
        //     'studentCount' => User::where('role_id', Role::STUDENT)->count(),
        //     'authorCount' =>  Author::count(),
        //     'thesisCount' => Thesis::count(),
        //     // 'file_size' => $total_file_size = round($file_size / 1024 / 1024,2)
        // ]);
        $count = [
            'thesis' => Thesis::count(),
            'user'   => User::count(),
            'author' => Author::count(),
            'subject' => Subject::count(),
            'recent' => Thesis::latest()->take(10)->get()
        ];

        return view('library.dashboard')->with('count', $count);
    }

    public function userList()
    {
        return view('library.users');
    }

    public function userCreate()
    {
        return view('library.form.college-acc');
    }
}
