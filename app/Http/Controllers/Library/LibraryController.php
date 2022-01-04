<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Thesis;
use App\Models\Author;
class LibraryController extends Controller
{
    public function index()
    {
        $count = collect([
            'userCount' => User::whereIn('role_id', [Role::STUDENT, ROLE::ADMIN])->count(),
            'collegeCount' => User::where('role_id', Role::ADMIN)->count(),
            'studentCount' => User::where('role_id', Role::STUDENT)->count(),
            'authorCount' =>  Author::count(),
            'thesisVerifiedCount' => Thesis::where('verified', true)->count(),
            'thesisNotVerifiedCount' => Thesis::where('verified', false)->count(),
            'thesisCount' => Thesis::count(),
        ]);

        return view('library.dashboard', compact('count'));
    }

    public function userList()
    {
        return view('library.users');
    }
}
