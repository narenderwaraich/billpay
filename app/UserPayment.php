<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserPayment extends Model
{
    protected $fillable = ['order_id','payment_method','amount','transaction_id','transaction_status','bank_transaction_id','transaction_date','user_id','bank_name','invoice_id','payment_date'];

    public function user()
		{
		    return $this->belongsTo(User::class); //'App\Role'
		}
}
