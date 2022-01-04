<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\College;

class StudentController extends Controller
{
    public function index()
    {
        $colleges = College::all();

        return view('student.dashboard')->with('colleges', $colleges);
    }

    
}
