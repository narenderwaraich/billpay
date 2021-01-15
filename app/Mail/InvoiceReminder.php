<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class InvoiceReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $invItem;
    public $inv;
    public $day;

    public function __construct($invItem, $inv, $day)
    {
        $this->invItem = $invItem;
        $this->inv = $inv;
        $this->day = $day; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         $userName = Auth::user()->company_name;  
         $subject = "Reminder for invoice (".$this->inv->invoice_number.") from ".$userName."(".$this->companyData->name.")"; //"Invoice (IN000211) from Username (company name)";
         return $this->subject($subject)->view('emails.invoice-reminder');
    }
}
