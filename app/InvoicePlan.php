<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoicePlan extends Model
{
    protected $fillable = ['name','amount','invoices','access_day'];
}
