<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePassword extends Component
{
    public $user;
    public $currentPassword;
    public $isCurrentPassword = false;
    public $password;
    public $password_confirmation;

    protected function rules(){ 
        return [
            'currentPassword' => 'required',
            'password' => ['required','confirmed', Password::min(8)]
        ];
    }

    public function mount()
    {
        $this->user = User::find(auth()->user()->id);
    }

    public function updatedCurrentPassword($value){
        // if(!Hash::check($value, $this->currentPassword))
        // {
        //     $this->isCurrentPassword = false;

        //     return session()->flash('error', 'Password is incorrect!');
        // }
        $this->isCurrentPassword = (Hash::check($value, $this->user->password)) ? true : false;

        if(!$this->isCurrentPassword)
        {
            return session()->flash('incorrect', 'Password is incorrect!');
        }     
        return session()->flash('correct', 'Password is correct');
    }

    public function changePassword()
    {
        $this->validate();

        if($this->isCurrentPassword)
        {
            $this->user->password = Hash::make($this->password);
            $this->user->save();
            
            $this->dispatchBrowserEvent('toastr:changed', [
                'icon' => 'success',
                'title' => 'Password Changed Successfully!',
            ]);
            $this->reset(['currentPassword','password','password_confirmation']);
        }
    }

    public function render()
    {
        return view('livewire.change-password');
    }
}
