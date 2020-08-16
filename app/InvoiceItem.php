<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;
use App\Invoice;

class InvoiceItem extends Model
{
    protected $fillable = ['item_name','item_description','qty','rate','total','invoice_id'];

    public function invoice()
	{
    	return $this->belongsTo(Invoice::class); 
	}
}
