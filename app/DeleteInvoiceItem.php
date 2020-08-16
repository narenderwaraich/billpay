<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeleteInvoiceItem extends Model
{
    protected $fillable = ['delete_invoices_id','item_id','item_name','item_description','qty','rate','total','invoice_id'];
}
