<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\ThesesImport;
use Maatwebsite\Excel\Facades\Excel;

class Import extends Component
{
    use WithFileUploads;
    
    public $file;

    protected function rules() : array
    {
        return [
            'file' => 'required|file|mimes:xlsx'
        ];
    }

    public function store()
    {

        $this->validate();

        $import = new ThesesImport;
        $import->import($this->file);
        if($import->failures()->isNotEmpty())
        {
            return session()->flash('failure', $import->failures());
        }

        return session()->flash('success', 'Imported Successfully');
    }

    public function render()
    {
        return view('livewire.import');
    }
}
