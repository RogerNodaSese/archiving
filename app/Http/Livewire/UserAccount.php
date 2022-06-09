<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\College;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class UserAccount extends Component
{
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $password_confirmation;
    // public $college;
    // public $colleges;

    protected function rules()  {
        return [
            'firstname' => ['required','min:3'],
            'lastname' => ['required','min:2'],
            'email' => ['email','unique:users,email','regex:/^[A-Za-z0-9\.]*@(neu)[.](edu)[.](ph)$/'],
            // 'college' => ['required'],
            'password' => ['required','confirmed', Password::min(8)],
        ];
    }

    // public function mount()
    // {
    //     $this->colleges = College::all();
    // }

    public function create()
    {
       $this->validate();
       DB::transaction(function () {
       $user = User::create([
           'first_name' => $this->firstname,
           'last_name' =>  $this->lastname,
           'email' => $this->email,
           'password' => \Illuminate\Support\Facades\Hash::make($this->password),
        //    'college_id' => $this->college,
           'role_id' => 3,
       ]);
       $user->markEmailAsVerified();
    }, 3);
    
    $this->dispatchBrowserEvent('toastr:created', [
        'icon' => 'success',
        'title' => 'Created Successfully!',
    ]);
    $this->reset(['firstname','lastname','email','password','password_confirmation']);
    
    }

    public function render()
    {
        return view('livewire.user-account');
    }
}
