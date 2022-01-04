<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\College;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class CollegeSearch extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function render()
    {
        return view('livewire.college-search', [
            'colleges' => College::withCount(['programs'])
            ->with(['programs' => function($query){
                $query->withCount(['theses' => function(Builder $query){
                    $query->where('verified', true);
                }]);
            }])
            ->orWhere('description', 'LIKE', '%'.$this->search.'%')
            ->paginate(10)
        ]);
    }
}
