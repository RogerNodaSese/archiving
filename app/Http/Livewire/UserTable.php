<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class UserTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $role;

    public function render()
    {
        sleep(0.5);
        return view('livewire.user-table',
        [
            'users' => User::select('last_name','first_name','email','email_verified_at','role_id')->with(['role' => function($query){
                $query->select('id','description');
            }])
            ->whereHas('role', function(Builder $query){
                $query->where('description', 'LIKE', '%'.$this->search.'%');
            })
            // ->where(function($query){
            //     $query->where('first_name','like','%'.$this->search.'%')
            //     ->orWhere('last_name','like','%'.$this->search.'%')
            //     ->orWhere('email','like','%'.$this->search.'%');
            // })   
            ->orWhere(DB::raw("CONCAT(first_name, ' ' ,last_name)"), 'LIKE', '%'.$this->search.'%')
            ->orWhere('email', 'LIKE', '%'.$this->search.'%')
            ->paginate(15)
    ]);
    }
}
