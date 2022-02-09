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
            'subjects' => Subject::whereRelation('theses', 'verified', true)->where('description', 'LIKE', '%'.$this->search.'%')->withCount(['theses' => function($query){
                $query->where('verified', true);
            }])->paginate(5)
        ]);
    }
}
