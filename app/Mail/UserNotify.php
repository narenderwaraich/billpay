<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserNotify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    //// fech new user data
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $firstName = $this->user['fname']; /// User First Name
        $lastName = $this->user['lname']; /// User Last Name
        $userName = $firstName.' '.$lastName; /// User Full Name
        $subject = $userName.' '."has signed up for mapleebooks"; /// Mail Subject
        return $this->from('admin@mapleebooks.com')->subject($subject)->view('emails.UserNotification');
    }
}
