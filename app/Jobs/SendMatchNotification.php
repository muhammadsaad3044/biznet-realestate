<?php

namespace App\Jobs;
use App\Mail\MatchNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMatchNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $matchedUsers;
    
    /**
     * Create a new job instance.
     */
    public function __construct($email, $matchedUsers)
    {
        $this->email = $email;
        $this->matchedUsers = $matchedUsers;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        Mail::to($this->email)->send(new MatchNotification($this->matchedUsers));

    }
}
