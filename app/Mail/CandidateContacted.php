<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Lib\EmailAddresses;

class CandidateContacted extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(EmailAddresses::$EMAIL_COMPANY_CONTACT_CANDIDATE)->view('emails.generic');
    }
}
