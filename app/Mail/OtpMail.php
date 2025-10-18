<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Your OTP Code')
            ->html('<h1>Your OTP Code</h1><p>Your OTP for password reset is: <strong>' . $this->otp . '</strong></p><p>This code will expire in 10 minutes.</p>');
    }
}
