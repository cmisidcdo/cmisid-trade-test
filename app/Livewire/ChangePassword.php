<?php

// App\Livewire\ChangePassword.php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Component
{
    public $old_password, $new_password, $new_password_confirmation;

    protected $rules = [
        'old_password' => 'required|current_password', 
        'new_password' => 'required|min:8|confirmed', 
    ];

    public function changePassword()
    {
        $this->validate();

        Auth::user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        session()->flash('message', 'Password changed successfully.');

        $this->reset(['old_password', 'new_password', 'new_password_confirmation']);

       
        $this->dispatch('hide-change-password-modal');
        $this->dispatch('success', 'Successfully Changed Password');


    }

    public function render()
    {
        return view('livewire.change-password');
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function showModal()
    {
        // dd('yawa');
        $this->clear();
        $this->dispatch('show-change-password-modal');
    }
}

