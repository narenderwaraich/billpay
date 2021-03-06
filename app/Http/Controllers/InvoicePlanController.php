<?php

namespace App\Http\Controllers;

use App\InvoicePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use Toastr;
use App\Contact;
use Auth;

class InvoicePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            if(Auth::user()->role == "admin"){
            $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
            $plan = InvoicePlan::orderBy('created_at','desc')->paginate(5);
            return view('Admin.Plan.Show',compact('contacts'),['plan' =>$plan]);
            }
        }else{
            return redirect()->to('/login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check()){
            if(Auth::user()->role == "admin"){

                $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
                return view('Admin.Plan.Add',compact('contacts'));
                }
        }else{
            return redirect()->to('/login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'name' => 'required',
        ]);
        if(!$validate){
                            Redirect::back()->withInput();
                          }
        $plan = InvoicePlan::create($request->all());
        Toastr::success('Plan Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/plans');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InvoicePlan  $invoicePlan
     * @return \Illuminate\Http\Response
     */
    public function show(InvoicePlan $invoicePlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvoicePlan  $invoicePlan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()){
        if(Auth::user()->role == "admin"){
            $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
            $plan = InvoicePlan::find($id);
            return view('Admin.Plan.Edit',compact('contacts'),['plan' =>$plan]);
            }
        }else{
            return redirect()->to('/login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InvoicePlan  $invoicePlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $plan = InvoicePlan::find($id);

        $plan->update($request->all());
        Toastr::success('Plan updated', 'Success', ["positionClass" => "toast-bottom-right"]);

      return redirect()->to('/plans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InvoicePlan  $invoicePlan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check()){
        if(Auth::user()->role == "admin"){
            $plan = InvoicePlan::find($id);
            $plan->delete();
            Toastr::success('Plan deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/plans');
        }
        }else{
            return redirect()->to('/login');
        }
    }
}
