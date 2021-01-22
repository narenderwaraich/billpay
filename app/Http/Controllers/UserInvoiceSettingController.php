<?php

namespace App\Http\Controllers;

use App\UserInvoiceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;
use Carbon\Carbon;
use App\User;
use Toastr;
use Redirect;
use Validator;
use App\Invoice;
use App\InvoiceItem;

class UserInvoiceSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $userInvoiceSetting = UserInvoiceSetting::where('user_id',$userId)->first();
        return view('invoice-pdf-setting',compact('userInvoiceSetting'));
    }

    public function createOrUpdate(Request $request){
        $validate = $this->validate(request(),[
        'user_id'=>'required',
      ]);
        if(!$validate){
            Redirect::back()->withInput();
                      }
        $data = $request->all();
        if($request->logo){
            $data['logo'] = 1;
        }else{
            $data['logo'] = 0;
        }
        
        if($request->logo_bg){
            $data['logo_bg'] = 1;
            $data['logo_left'] = 0;
            $data['logo_right'] = 0;
            $data['logo_center'] = 0;
        }else{
            $data['logo_bg'] = 0;
        }

        if($request->logo_left){
            $data['logo_left'] = 1;
            $data['logo_bg'] = 0;
            $data['logo_right'] = 0;
            $data['logo_center'] = 0;
        }else{
            $data['logo_left'] = 0;
        }

        if($request->logo_right){
            $data['logo_right'] = 1;
            $data['logo_bg'] = 0;
            $data['logo_left'] = 0;
            $data['logo_center'] = 0;
        }else{
            $data['logo_right'] = 0;
        }

        if($request->logo_center){
            $data['logo_center'] = 1;
            $data['logo_bg'] = 0;
            $data['logo_left'] = 0;
            $data['logo_right'] = 0;
        }else{
            $data['logo_center'] = 0;
        }

        $userInvoiceSetting = UserInvoiceSetting::where('user_id',$request->user_id)->first();

        if($userInvoiceSetting){
            $userInvoiceSetting->update($data);
        }else{
           UserInvoiceSetting::create($data); 
        }

        Toastr::success('User Invoice Setting Changed', 'Success', ["positionClass" => "toast-bottom-right"]);
        return back(); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserInvoiceSetting  $userInvoiceSetting
     * @return \Illuminate\Http\Response
     */
    public function show(UserInvoiceSetting $userInvoiceSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserInvoiceSetting  $userInvoiceSetting
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserInvoiceSetting  $userInvoiceSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserInvoiceSetting $userInvoiceSetting)
    {

          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserInvoiceSetting  $userInvoiceSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $userId = auth()->user()->id;
        $userInvoiceSetting = UserInvoiceSetting::where('user_id',$userId)->first();
        if($userInvoiceSetting){
            $userInvoiceSetting->delete();
            Toastr::success('User Invoice Setting Reset', 'Success', ["positionClass" => "toast-bottom-right"]);
            return back();
        }else{
           Toastr::success('User Invoice Setting Default', 'Success', ["positionClass" => "toast-bottom-right"]);
            return back(); 
        }  
    }
}
