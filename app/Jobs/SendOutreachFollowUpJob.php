<?php

namespace App\Jobs;

use App\Mail\OutreachFollowUpMail;
use App\Models\FreeTestResult;
use App\Models\OutreachMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOutreachFollowUpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $testResult;

    /**
     * Create a new job instance.
     */
    public function __construct(FreeTestResult $testResult)
    {
        $this->testResult = $testResult;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Re-fetch user to make sure we have their email
        $user = $this->testResult->user;
        
        if (!$user || !$user->email) {
            return;
        }

        // Find the right outreach message
        $outreachMessage = OutreachMessage::with('program')
            ->where('test_type', $this->testResult->test_type)
            ->where('target_role', $user->role)
            ->where('min_score', '<=', $this->testResult->score)
            ->where('max_score', '>=', $this->testResult->score)
            ->first();

        if ($outreachMessage) {
            Mail::to($user->email)->send(new OutreachFollowUpMail($this->testResult, $outreachMessage));
        }
    }
}
