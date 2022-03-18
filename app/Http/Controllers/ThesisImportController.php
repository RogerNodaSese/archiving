<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ThesesImport;
use Maatwebsite\Excel\Facades\Excel;

class ThesisImportController extends Controller
{
    public function index()
    {
        return view('library.import');
    }

    public function store(Request $request)
    {
        $file = $request->file('file');

        Excel::import(new ThesesImport, $file);
    }
}
