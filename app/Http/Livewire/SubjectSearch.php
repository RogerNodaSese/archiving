<?php

namespace App\Http\Livewire;
use App\Models\Subject;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class SubjectSearch extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        return view('livewire.subject-search', 
        [
            'subjects' => Subject::select('description', DB::raw('count(*) as total'))->orWhere('description', 'LIKE', '%'.$this->search.'%')->groupBy('description')->paginate(5)
        ]);
    }
}
