<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Program;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class ProgramSearch extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function authorized()
    {
        if(auth()->user()->role_id == \App\Models\Role::SUPER_ADMIN)
        {
            return Program::select('id','description','slug','college_id')
            ->withCount('theses')
            ->with(['college:id,description,slug'])
            ->whereHas('college', function(Builder $query){
                $query->where('description', 'LIKE', '%'.$this->search.'%')
                ->orWhere('slug', 'LIKE', '%'.$this->search.'%');
            })
            ->orWhere('description', 'LIKE', '%'.$this->search.'%')
            ->orWhere('slug', 'LIKE', '%'.$this->search.'%')
            ->orderBy('theses_count','desc')
            ->paginate(10);
        }else
        {

        }
    }

    public function render()
    {

        return view('livewire.program-search', [
            'programs' => Program::select('id','description','slug','college_id')
            ->withCount(['theses' => function(Builder $query){
                $query->where('verified', true);
            }])
            ->with(['college:id,description,slug'])
            ->whereHas('college', function(Builder $query){
                $query->where('description', 'LIKE', '%'.$this->search.'%')
                ->orWhere('slug', 'LIKE', '%'.$this->search.'%');
            })
            ->orWhere('description', 'LIKE', '%'.$this->search.'%')
            ->orWhere('slug', 'LIKE', '%'.$this->search.'%')
            ->orderBy('theses_count','desc')
            ->paginate(10)
        ]);
    }
}
