<?php

namespace App\Exports;

use App\Models\Thesis;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ThesisExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('export.template', [
            'theses' => Thesis::with(['subjects','authors'])->get()
        ]);
    }
}
