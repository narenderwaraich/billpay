<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Redirect;
use Toastr;
use App\Contact;

class ContactUsController extends Controller
{
   public function contactUs(Request $request){
   	$validate = $this->validate(request(),[
            'name'=>'required|string|max:50',
            'email'=>'required|string|email|max:255',
            'message'=>'required|string|max:255',
          ]);
          if(!$validate){
            Redirect::back()->withInput();
          }
          Contact::create(request(['name','message','email','phone']));
   	Toastr::success('Message Sent', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/');
   } 
}
