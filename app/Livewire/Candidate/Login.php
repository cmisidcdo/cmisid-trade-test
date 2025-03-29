<?php

namespace App\Livewire\Candidate;

use Livewire\Component;
use App\Models\Candidate;
use Illuminate\Support\Facades\Session;

class Login extends Component
{
    public $fullname;

    public function login()
    {
        $candidate = Candidate::whereRaw('LOWER(fullname) = ?', [strtolower($this->fullname)])->first();

        if ($candidate) {

            Session::put('candidate_id', $candidate->id);
            Session::put('candidate_name', $candidate->fullname);
            
            return redirect()->route('candidate.home');
        }

        session()->flash('error', 'Invalid Name');
    }

    public function render()
    {
        return view('livewire.candidate.login')->layout('layouts.candidate');
    }
}
