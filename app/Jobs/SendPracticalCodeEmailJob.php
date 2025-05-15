<?php

namespace App\Jobs;

use App\Mail\SendPracticalCodeEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPracticalCodeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     */

    public $tries = 3;      
    public $timeout = 120;

    public $assignedpractical;
    public $candidate;

    public function __construct($assignedpractical, $candidate)
    {
        $this->assignedpractical = $assignedpractical;
        $this->candidate = $candidate;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->candidate->email)
            ->send(new SendPracticalCodeEmail($this->assignedpractical, $this->candidate));

    }
}
