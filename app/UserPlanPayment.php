<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPlanPayment extends Model
{
    protected $fillable = ['amount','user_id','plan_id','order_id','transaction_id','transaction_status','transaction_date','payment_method'];
}
