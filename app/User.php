<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;
use App\UserCompany;
use App\Clients;
use App\Invoice;
use App\UserPayment;
use App\DeleteInvoice;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname','lname','email','avatar','password','phone_no','country','city','state','address','zipcode','company_name','status',
    'is_activated','access_date','gstin_number'];
    
    // protected $casts = [
    //     'is_activated' => 'boolean'
    // ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = bcrypt($password);
    // }
        
        ///Password by mail id send

    public static function generatePassword()
    {
      // Generate random string and encrypt it. 
      return bcrypt(str_random(35));
    }
        // company
    public function company()
    {
        return $this->hasMany(UserCompany::class); 
    }
    
    //// clients
    public function clients()
    {
        return $this->hasMany(Clients::class); 
    }

    //// invoice
    public function invoices()
    {
        return $this->hasMany(Invoice::class); 
    }

    //user Payments
    public function payments()
    {
        return $this->hasMany(UserPayment::class); 
    }

    //user DeleteInvoice
    public function deleteInvoices()
    {
        return $this->hasMany(DeleteInvoice::class); 
    }
}
