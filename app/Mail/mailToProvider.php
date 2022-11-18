<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailToProvider extends Mailable
{
   /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $email_body = 'Dear '. $this->data['first_name']. ' '. $this->data['last_name'].',<br/><br/>Your account has been '. $this->data['status'] .'.';

        $subject = "Account has been ".$this->data['status'];

        
        return $this->to($this->data['email'])
            ->from(config('mail.from.address'))
            ->subject($subject)
            ->view('emails.testMail')
            ->with('email_body', $email_body);
        // return $this->view('view.name');

    }
}
