<?php

namespace App\Jobs;

use App\Mail\SendAssessmentCodeEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAssessmentCodeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;      
    public $timeout = 120;

    public $assignedassessment;
    public $candidate;

    /**
     * Create a new job instance.
     */
    public function __construct($assignedassessment, $candidate)
    {
        $this->assignedassessment = $assignedassessment;
        $this->candidate = $candidate;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->candidate->email)
            ->send(new SendAssessmentCodeEmail($this->assignedassessment, $this->candidate));
    }
}
