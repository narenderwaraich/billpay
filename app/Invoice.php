<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;
use App\User;
use App\UserCompany;
use App\Clients;
use App\InvoiceItem;

class Invoice extends Model
{
    protected $fillable = ['tax_rate','deposit_amount','invoice_number','terms','client_id','payment_card_no','deposit_amount','notes','user_id','companies_id','due_date','discount','due_amount','sub_total','issue_date','invoice_number_token','is_deleted','taxInFlat','disInFlat','disInPer','taxInPer','payment_mode','payment_status'];

    public function user()
		{
		    return $this->belongsTo(User::class); //'App\Role'
		}

		public function client()
	{
    	return $this->belongsTo(Clients::class);
	}

	public function companies()
	{
    	return $this->belongsTo(UserCompany::class); 
	}

	// invoiceItems 
	public function invoiceItems()
	{
    	return $this->hasMany(InvoiceItem::class); 
	}
}
