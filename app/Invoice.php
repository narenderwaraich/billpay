<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;
use App\User;
use App\Clients;
use App\InvoiceItem;

class Invoice extends Model
{
    protected $fillable = ['tax_rate','deposit_amount','invoice_number','terms','client_id','notes','user_id','due_date','discount','due_amount','sub_total','issue_date','invoice_number_token','is_deleted','taxInFlat','disInFlat','disInPer','taxInPer','payment_mode','payment_status','status'];

    public function user()
		{
		    return $this->belongsTo(User::class); //'App\Role'
		}

		public function client()
	{
    	return $this->belongsTo(Clients::class);
	}

	// invoiceItems 
	public function invoiceItems()
	{
    	return $this->hasMany(InvoiceItem::class); 
	}
}
