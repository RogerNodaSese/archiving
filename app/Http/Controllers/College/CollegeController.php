<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\College;
use App\Models\Program;
use App\Models\Thesis;
use App\Models\User;

class CollegeController extends Controller
{
    public function index()
    {
        $college = User::find(Auth::id())->college->firstOrFail();
        $programCount = Program::whereRelation('college', 'id', auth()->user()->college_id)->count();
        return view('college.dashboard',compact('college','programCount'));
    }

    public function collegeArchives($slug)
    {
        $college = College::with('programs')->where('slug',$slug)->firstOrFail();
        return view('student.college-archives')->with('college',$college);
    }

    public function programArchive($slug,$program)
    {
        $college = College::select('slug','description')->where('slug',$slug)->firstOrFail();
        $program = Program::select('id','description','slug')->where('slug',$program)->firstOrFail();
        $theses = Thesis::with(['authors' => function($query){
            $query->select('last_name','first_name');
        }])->where('program_id',$program->id)->where('verified', true)->orderBy('date_of_issue','desc')->get();
        return view('student.program-archive',compact('college','program','theses'));
    }

    public function keywordArchive($slug)
    {
        $theses = \App\Models\Thesis::with(['authors','program' => function($query){
            $query->with('college');
        }])->whereHas('keywords',function(\Illuminate\Database\Eloquent\Builder $query) use ($slug){
            $query->where('description', $slug);
        })->where('verified', true)->paginate(20);
        return view('student.keyword-archives', compact('theses','slug'));
    }
}
