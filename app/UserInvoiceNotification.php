<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserInvoiceNotification extends Model
{
    use Notifiable;

   protected $fillable = [

       'text', 'user_id', 'invoice_id',

   ];
}
