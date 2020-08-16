<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class DeleteInvoice extends Model
{
    protected $fillable = ['invoice_id','tax_rate','invoice_number','terms','client_id','payment_card_no','deposit_amount','notes','user_id','companies_id','due_date','discount','due_amount','sub_total','issue_date','invoice_number_token','is_deleted','taxInFlat','disInFlat','disInPer','taxInPer','status'];

    public function user()
		{
		    return $this->belongsTo(User::class); //'App\Role'
		}
}
