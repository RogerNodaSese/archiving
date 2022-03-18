<?php

namespace App\Http\Controllers;

use App\Exports\ThesesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ThesisExportController extends Controller
{
    public function export()
    {
        return Excel::download(new ThesesExport, 'archives-template.xlsx');
    }
}
