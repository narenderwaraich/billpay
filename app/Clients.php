<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Invoice;

class Clients extends Model
{
     protected $fillable = ['fname','lname','email','phone','country','city','state','address','zipcode','user_id'];

     public function user()
		{
		    return $this->belongsTo(User::class); //'App\Role'
		}


	// invoice 
	public function invoices()
	{
    	return $this->hasMany(Invoice::class); 
	}

}


