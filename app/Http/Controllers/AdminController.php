<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;
use App\User;
use App\GeneralSetting;
use Toastr;
use Redirect;
use App\UserPayment;

class AdminController extends Controller
{
    public function __construct(){
     $this->middleware('auth');
    }

    /// DashBorad Page
        public function index(){
                if(Auth::user()->role == 'admin'){
                    $totalUsers = User::count();
                    $users = User::orderBy('created_at','desc')->paginate(10); //dd($users);
                    foreach ($users as $user) {
                        $userPlan = UserPayment::where('user_id',$user->id)->first(); //dd($userPlan);
                        $user->plan = $userPlan ? $userPlan->plan : "";
                        $user->plan_status = $userPlan ? $userPlan->status : 2;
                    }
                return view('Admin.Admin',['totalUsers' => $totalUsers, 'users' =>$users]);
            }
            else{
                return view('login');
            }
        }

        public function getChangePass(){
        return view('Admin.change-password');
        }

     public function AddUser(){
            if(Auth::user()->role == 'admin'){
                
                $country_data =DB::table('countries')->select('id','name')->get();
                $state_data = DB::table("states")->select('id','name')->get();
                return view('Admin.Add_User',compact('country_data','state_data'));
            }
            else{
                return view('login');
            }
        }

    public function addMail(){
        if(Auth::user()->role == 'admin'){
            $id = 1;
            $mail = GeneralSetting::where('id','=',$id)->first();
            return view('Admin.general-settings',compact('mail'));
        }else{
                return view('login');
            }
     }


     public function storeMail(Request $request){
        if(Auth::user()->role == 'admin'){
            $key = "ADMIN_MAIL";
            $id = 1;
            $mail = GeneralSetting::where('id','=',$id)->first();
            if($mail){
                $data['key'] = $key;
                $data['value'] = $request->value;
                $mail->update($data);
                Toastr::success('Admin mail Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
                return redirect()->to('/admin-mail');
            }else{
                $data['key'] = $key;
                $data['value'] = $request->value;
                GeneralSetting::create($data);
                Toastr::success('Admin mail Added', 'Success', ["positionClass" => "toast-bottom-right"]);
                return redirect()->to('/admin-mail');
            }
            
        }else{
                return view('login');
            }
     }


     public function activeUser(Request $request){
        $ids = $request->ids;
        $id = explode(",",$ids);
        $chkData =  User::where('id',$id)->first();
        $chkStatus = $chkData->is_activated;
        if($chkStatus == 0){
          $status['is_activated'] = 1;
          $chk =  User::whereIn('id',$id)->update($status);
          return response()->json(['success'=>"User Activated"]);
        }else{
          return response()->json(['error'=>"User not Activated"]);
        } 
    }

    public function deactiveUser(Request $request){
        $ids = $request->ids;
        $id = explode(",",$ids);
        $chkData =  User::where('id',$id)->first();
        $chkStatus = $chkData->is_activated;
        if($chkStatus == 1){
          $status['is_activated'] = 0;
          $chk =  User::whereIn('id',$id)->update($status);
          return response()->json(['success'=>"User Activated"]);
        }else{
          return response()->json(['error'=>"User not Activated"]);
        } 
    }


     /// destroy Users
    public function userDelete(Request $request){
            $ids = $request->ids;
            $id = explode(",",$ids);
            $users =  User::whereIn('id',$id)->get();
            foreach ($users as $user) {
                $invoice = DB::table("invoices")->where('user_id',$user->id)->first();
                if($invoice){
                  return response()->json(['error' => "User can not Deleted"]);
                }else{
                  DB::table("users")->where('id',$user->id)->delete();
                  return response()->json(['success' => "User Deleted"]);
                }
                
            }
        }


    public function SearchData(Request $request){
          $q = Input::get ( 'q' );
            /// Start user search by Name or email
            $users = User::where('fname', 'like', '%'.$q.'%')
                 ->orWhere('lname', 'like', '%'.$q.'%')
                 ->orWhere('email', 'like', '%'.$q.'%')
                 ->orWhere('phone_no', 'like', '%'.$q.'%')
                 ->orderBy('created_at', 'desc')
                 ->paginate(10)->setPath ( '' );
                  $pagination = $users->appends ( array (
                  'q' => Input::get ( 'q' )
                  ) );
                foreach ($users as $user) {
                        $userPlan = UserPayment::where('user_id',$user->id)->first(); //dd($userPlan);
                        $user->plan = $userPlan ? $userPlan->plan : "";
                        $user->plan_status = $userPlan ? $userPlan->status : 2;
                    }
                if (count ($users) > 0){ //by user name data view
                      $total_row = $users->total(); //dd($total_row);
                    return view ('Admin.Admin',compact('total_row','users'))->withQuery ( $q )->withMessage ($total_row.' '. 'User found match your search');
                 }else{ 
                    return view ('Admin.Admin')->withMessage ( 'User not found match Your search !' );
                 }

        }          

}
