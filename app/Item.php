<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Item extends Model
{
    protected $fillable = ['item_name','item_description','price','sale','qty','user_id','in_stock'];

    public function user()
		{
		    return $this->belongsTo(User::class); //'App\Role'
		}
}

