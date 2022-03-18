<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Thesis;
use Livewire\WithPagination;

class TitleSearch extends Component
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
        return view('livewire.title-search', [
            'theses' => Thesis::select('id','title','program_id')->with(['program' => function($query){
                $query->with(['college']);
            }])
            ->where('title', 'LIKE', '%'.$this->search.'%')->orderBy('title')->simplePaginate(10)
        ]);
    }
}
