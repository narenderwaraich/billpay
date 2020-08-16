<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\UserCompany;
use App\Invoice;

class Clients extends Model
{
     protected $fillable = ['fname','lname','email','email2','country','city','state','address','zipcode','user_id','companies_id',];

     public function user()
		{
		    return $this->belongsTo(User::class); //'App\Role'
		}

		// clients 
	public function companies()
	{
    	return $this->belongsTo(UserCompany::class); 
	}

	// invoice 
	public function invoices()
	{
    	return $this->hasMany(Invoice::class); 
	}

}


