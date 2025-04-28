<?php

namespace App\Jobs;

use App\Mail\SendOralCodeEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOralCodeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     */

    public $tries = 3;      
    public $timeout = 120;

    public $assignedoral;
    public $candidate;

    public function __construct($assignedoral, $candidate)
    {
        $this->assignedoral = $assignedoral;
        $this->candidate = $candidate;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->candidate->email)
            ->send(new SendOralCodeEmail($this->assignedoral, $this->candidate));

    }
}
