<?php

namespace App\Livewire\Candidate;

use Livewire\Component;
use App\Models\Candidate;
use App\Models\AssignedAssessment;
use Illuminate\Support\Facades\Session;

class Login extends Component
{
    public $fullname, $inputcode;

    public function login()
    {
        $assigned = AssignedAssessment::where('access_code', $this->inputcode)->first();

        if ($assigned) {
            $candidate = $assigned->candidate;

            Session::put('candidate_id', $candidate->id);
            Session::put('candidate_name', $candidate->fullname);

            return redirect()->route('candidate.home');
        }

        session()->flash('error', 'Invalid Code');
    }

    public function render()
    {
        return view('livewire.candidate.login')->layout('layouts.candidate');
    }
}
