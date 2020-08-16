<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Input;

class Search extends Controller
{
   public function find(){
    $q = Input::get ( 'q' );
    $user = User::where('fname','LIKE','%'.$q.'%')->orWhere('email','LIKE','%'.$q.'%')->get();
    if(count($user) > 0)
        return view('index')->withDetails($user)->withQuery ( $q );
    else return view ('index')->withMessage('No Details found. Try to search again !');
}
}
