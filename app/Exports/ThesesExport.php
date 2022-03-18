<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ThesesExport implements WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Contracts\View
    */
    public function headings() : array
    {
        return [
            'Title',
            'Authors',
            'Publisher',
            'Date of publication',
            'College program',
            'Subject',
            'Abstract'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 45,
            'B' => 45, 
            'C' => 45,
            'D' => 45,
            'E' => 45,
            'F' => 45,
            'G' => 45,        
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            'A1'    => ['font' => ['bold' => true]],
            'B1'    => ['font' => ['bold' => true]],
            'C1'    => ['font' => ['bold' => true]],
            'D1'    => ['font' => ['bold' => true]],
            'E1'    => ['font' => ['bold' => true]],
            'F1'    => ['font' => ['bold' => true]],
            'G1'    => ['font' => ['bold' => true]],
        ];
    }
}
