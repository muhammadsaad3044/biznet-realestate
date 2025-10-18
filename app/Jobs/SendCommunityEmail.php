<?php

namespace App\Jobs;

use App\Mail\CoummunityMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCommunityEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user; // Declare the property here
    /**
     * Create a new job instance.
     */
     
     
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      
        // Mail::to($this->user->email)->send(new CommunityEmail($this->user));
        
         // Send email to the user's email address
        Mail::to($this->user->email)->send(new CoummunityMail(['user' => $this->user]));
    }
}
