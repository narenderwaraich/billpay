<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentStatus extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $invData;
    public $clientData;
    public $userData;
    public $pay;

    public function __construct($invData, $clientData, $userData, $pay)
    {

        $this->invData = $invData;
        $this->clientData = $clientData;
        $this->userData = $userData;
        $this->pay = $pay;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

         $mail = $this->clientData->email;
         $subject = "Payment Status";
         return $this->from($mail)->subject($subject)->view('emails.payment-status');
    }
}
