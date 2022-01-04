<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Keyword;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
class KeywordSearch extends Component
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
       
        return view('livewire.keyword-search',
        [
            'keywords' => Keyword::select('description',DB::raw('COUNT(*) as total'))->leftJoin('keyword_thesis', 'keywords.id', '=', 'keyword_thesis.keyword_id')->leftJoin('theses', 'theses.id', '=', 'keyword_thesis.thesis_id')->where('theses.verified', true)->where('description', 'LIKE', '%'.$this->search.'%')->groupBy('description')->paginate(5)
        ]);
    }
}
