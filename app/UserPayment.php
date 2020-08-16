<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserPayment extends Model
{
    protected $fillable = ['card_number','user_id','plan_id','subscription_id','plan','payment_date','amount','interval','clients','status'];

    public function user()
		{
		    return $this->belongsTo(User::class); //'App\Role'
		}
}
