<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\GeneralSetting;
use Auth;
use Validator;
use Redirect;
use Mail;
use Hash;
use App\Mail\ResetPassword;
use App\Mail\ForgetPassword;
use App\Mail\ConfirmAccount;
use App\Mail\UserNotify;
use Carbon\Carbon;
use Toastr;
use App\UserPayment;
use App\UserPlan;
use App\InvoicePlan;
use App\Invoice;

class RegistrationsController extends Controller
      {   

            public function signUpPage(){
                return view('signup');
            }

            public function signUpStore(Request $request){
                $validate = $this->validate(request(),[
                  'fname'=>'required|string|max:50',
                  'lname'=>'required|string|max:50',
                  'email'=>'required|string|email:unique|max:255',
                  'password'=> 'required|string|min:6',
                ]);
                if(!$validate){
                  Redirect::back()->withInput();
                }
                $email = $request->email;
                /// Check email record in database already exists or not
                if(sizeof(User::where('email','=',$email)->get()) > 0){
                  Toastr::error('Sorry User email exists!', 'Error', ["positionClass" => "toast-top-right"]);
                    return back();
                }
                
                $user=User::create(request(['fname','lname','email']));
                $user->password = Hash::make($request->password);
                $token = $this->sendActivateEmail($user);
                $user->token = $token;
                $createDate = $user->created_at;
                $userCreateDate = $createDate->toDateTimeString(); 
                // add 1 days to the create date
                $trialAddDate = $createDate->addDays(1);        //addMinutes(30);
                $trial = $trialAddDate->toDateTimeString();
                $user->access_date = $trial;
                $user->save();

                //// Send Notification to Admin
                $getAdminMail = GeneralSetting::where('id','=',1)->first();
                if($getAdminMail){
                    $adminMail = $getAdminMail->value; //singh4narender@gmail.com Admin Email
                    Mail::to($adminMail)->send(new UserNotify($user));
                }
                
                Toastr::success('Thank You for Singing Up!. We have sent you an confirmation email. You can now login to your account, But please confirm your email to start using your account.', 'Success',['timeOut' => 20000, "positionClass" => "toast-top-right"]);
                return Redirect::back();
                
            }

            public function sendActivateEmail($user)
              {
                // Generate a new reset password token
                $token = app('auth.password.broker')->createToken($user);
                $data = ['user' => $user, 'token' => $token];
                Mail::to($user->email)->send(new ConfirmAccount($data));
                return $token;
              }

              public function reSendConfirmMail(){
                $user =Auth::user();
                $token = $user->token;
                $data = ['user' => $user, 'token' => $token];
                Mail::to($user->email)->send(new ConfirmAccount($data));
                Toastr::success('We have sent again you an confirmation email. please confirm your email to start using your account.', 'Success', ["positionClass" => "toast-top-right"]);
                return Redirect::back();
              }

            public function showLoginForm(User $user, $token)
            { 
              $tokenData = User::where('token','=', $token)->first();
              if ( !$tokenData ){
                Toastr::error('The Link has been expired!', 'Error', ["positionClass" => "toast-top-right"]);
               return redirect()->to('/'); //redirect them anywhere you want if the token does not exist.
             }else{
                  $id = $tokenData->id;
                  $data["verified"] = 1;
                  $data["token"] = "";
                  $user=User::where('id',$id)->update($data);
                  auth()->logout();
                  Toastr::success('Thank you for Signing up! your email verify, Please Login Now', 'Success', ["positionClass" => "toast-top-right"]);
               return view('login');
             }
                
           }


            public function storeUser(Request $request){
                $validate = $this->validate(request(),[
                'fname'=>'required|string|max:50',
                'lname'=>'required|string|max:50',
                'email'=>'required|string|email|max:255',
                ]);
               
                if(!$validate){
                  Redirect::back()->withInput();
                }
                $email = $request->email;
                if(sizeof(User::where('email','=',$email)->get()) > 0){
                  Toastr::error('Sorry User email exists!', 'Error', ["positionClass" => "toast-top-right"]);
                    return back();
                }
                
        //generate a password for the new users
              $pw = User::generatePassword();
              //add new user to database
              $user=User::create(request(['fname','lname','email','phone_no','city','country','state','address','zipcode','company_name','gstin_number']));
              $user->password = $pw;
              if($request->avatar){
                $imageName = time().'.'.request()->avatar->getClientOriginalExtension();

                request()->avatar->move(public_path('images/companies-logo'), $imageName);
                $user->avatar=$imageName;
              }
              $token = $this->sendWelcomeEmail($user);
              $user->token = $token;
              $createDate = $user->created_at;
              $userCreateDate = $createDate->toDateTimeString(); 
              // add 30 days to the create date
              $trialAddDate = $createDate->addDays(1);        //addMinutes(30);
              $trial = $trialAddDate->toDateTimeString();
              $user->access_date = $trial;
              $user->save();
              Toastr::success('Congratulations! your account is registered, you will shortly receive an email with Password your account.', 'Success', ["positionClass" => "toast-bottom-right"]);
          return redirect()->to('/admin');
                }

              //// send token with reset password form
          public function sendWelcomeEmail($user)
              {
                // Generate a new reset password token
                $token = app('auth.password.broker')->createToken($user);
                $data = ['user' => $user, 'token' => $token];
                Mail::to($user->email)->send(new ResetPassword($data));
                return $token;
              }

              /////////After Send Reset Token Show user mail
          public function showPasswordResetForm(User $user, $token)
           {
              
               $tokenData = User::where('token','=', $token)->first(); 
               if ( !$tokenData ){
                 Toastr::error('Sorry link Expired', 'Error', ["positionClass" => "toast-top-right"]);
                return redirect()->to('/'); //redirect them anywhere you want if the token does not exist.
              }else{
                return view('Password_Reset',['user'=>$tokenData]);
              }   
               
           }

             //// After get Token in mail redirect on Reset Form

             public function resetPassword(Request $request, $token)
             {
                 //some validation
                 $validate = $this->validate(request(),[
                  'password' => 'required|confirmed|string|min:6',
                   ]);
                 if(!$validate){
                    Redirect::back()->withInput();
                  }
                 $password = $request->password;
                 $user = User::where('token','=', $token)->first();
                if(!$user){
                  Toastr::error('The Link has been expired!', 'Error', ["positionClass" => "toast-top-right"]);
                  Redirect::back();
                } 
                 
                 $user->password = Hash::make($password);
                 $user->is_activated = 1;
                 $user->token ="";
                 $user->update(); //or $user->save();
                 
                 //do we log the user directly or let them login and try their password for the first time ? if yes 
                
                // If the user shouldn't reuse the token later, delete the token 
               Toastr::success('Password Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/login');
                //redirect where we want according to whether they are logged in or not
             }


            /// Show User Data
              public function profileView(){
                  if(Auth::check()){
                    if(!Auth::user()->verified == 'true'){
                        Toastr::error('Please first confirm your email to start using your Account!', 'Error', ["positionClass" => "toast-top-right"]);
                          return back();
                      }else{
                            $userId = Auth::id();
                            $country_data =DB::table('countries')->select('id','name')->get();
                            $state_data = DB::table("states")->select('id','name')->get();
                            $city_data = DB::table("cities")->select('id','name')->get();
                            $userPlan = UserPlan::where('user_id', $userId)->first();
                            $plan = InvoicePlan::where('id', $userPlan->plan_id)->first();
                            $invoice = Invoice::where('user_id', $userId)->get(); //dd($invoice);
                            $totalInvoice = $invoice ? $invoice->count() : 0; //dd($totalInvoice);
                            return view('user_profile',compact('country_data','state_data','city_data','userPlan','plan','totalInvoice'));
                          }
              }
               else{
                  return redirect('/login');
              }
          }


                  

                //// Update user profile data
                public function userUpdate(Request $request, $id)
                {   
              /////check validate
                     $validate = $this->validate(request(),[
                    'fname'=>'required|string|max:50',
                    'lname'=>'required|string|max:50',
                    'email' => 'required|email|unique:users,email,'.$request->id,
                  ]);
                  if(!$validate){
                    toster::error('this email already taken','Error',["positionClass" => "toast-bottom-right"]);
                    Redirect::back();
                  }
                      $data = request(['fname','lname','email','phone_no','address','zipcode','company_name','city','country','state','gstin_number']);
                        if($request->avatar){
                      $imageName = time().'.'.request()->avatar->getClientOriginalExtension();

                      request()->avatar->move(public_path('images/companies-logo'), $imageName);
                      $data["avatar"] = $imageName;
                      }

                      if($request->paytm_id){
                        $data["paytm_id"] = Crypt::encryptString($request->paytm_id);
                      }
                      if($request->paytm_key){
                        $data["paytm_key"] = Crypt::encryptString($request->paytm_key );
                      }
                        
                  //update user to database
                    $user=User::where('id',$id)->update($data);
                  Toastr::success('Account Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
                  return redirect()->to('/dashboard');

                }
                //// Update user data by admin
                public function update(Request $request, $id)
                {   
              /////check validate
                     $validate = $this->validate(request(),[
                    'fname'=>'required|string|max:50',
                    'lname'=>'required|string|max:50',
                  ]);
                  if(!$validate){
                    toster::error('this email already taken','Error',["positionClass" => "toast-bottom-right"]);
                    Redirect::back();
                  }
                      $data = request(['fname','lname','email','phone_no','address','zipcode','company_name','city','country','state','gstin_number']);
                        if($request->avatar){
                      $imageName = time().'.'.request()->avatar->getClientOriginalExtension();

                      request()->avatar->move(public_path('images/avatar'), $imageName);
                      $data["avatar"] = $imageName;
                      }
                        
                  $user=User::where('id',$id)->update($data);
                  Toastr::success('Account Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
                        return redirect()->to('/admin');

                }


                          /// Change Password

                       /// Update Data
                          public function Pass(){
                              if(\Auth::check()){
                              return view('change-password');
                          }
                           else{
                              return redirect('/login');
                          }
                      }

                    public function updatePass(Request $request)
                    {
                      /////check validate
                            $validate = $this->validate(request(),[
                                'old_password' => 'required',
                                'password' => 'required|confirmed|string|min:6',
                            ]);
                             if(!$validate){ 
                              Redirect::back()->withInput();
                            }
                      $data = $request->all();
                      $user = User::find(auth()->user()->id);
                      if(!Hash::check($data['old_password'], $user->password)){
                        Toastr::error('The specified password does not match the database password', 'Error', ["positionClass" => "toast-top-right"]);
                                return back();
                      }else{
                          $password = $request->password;
                          $user->update(['password' => Hash::make($password)]);
                         Toastr::success('Password Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
                                             return redirect()->to('/dashboard');
                      }
                          
        
                      
                         //   /// find Auth
                         //    $id = Auth::id();
                         //  //add new user to database
                         // $user=User::find($id)->update(request(['password' => Hash::make('password')] ));
                         // Toastr::success('Congratulations! your Password is updated', 'Success', ["positionClass" => "toast-bottom-right"]);
                         //  return redirect()->to('/');

                        }

                      //// Forget Password...
                          public function forgetPassForm(){
                              return view('password_forget');
                          }

                          public function forgetPassword(Request $request)
                            {
                                $this->validate(request(),[
                                    'email'=>'required|string|email|max:255',
                                    ]);
                                $email = ($request->email);
                                 $user = User::where('email', '=', $email)->first();
                                 if ( !$user ){
                                  Toastr::error('The email is not exist, please try again', 'Error', ["positionClass" => "toast-top-right"]);
                                 return back(); //redirect them anywhere you want if the token does not exist.
                                        //add new user to database
                               }else{
                                 $token = app('auth.password.broker')->createToken($user);
                                  $data = ['user' => $user, 'token' => $token]; 
                                  
                                    $updateToken['token'] =  $token;
                                   User::where('id',$user->id)->update($updateToken);
                                  Mail::to($email)->send(new ForgetPassword($data));
                                   ///pending redirect nd msg 
                                  Toastr::success('Your Password reset link send in mail', 'Success', ["positionClass" => "toast-bottom-right"]); 
                              return redirect()->to('/login');
                               }                  

                            }



                                     ////Remove Account

                          public function postDestroy(User $user) {

                              $user=User::find(Auth::user()->id);
                                Auth::logout();
                                if ($user->delete()) {
                                      Toastr::success('Your Account Deleted!', 'Success', ["positionClass" => "toast-bottom-right"]); 
                                     return Redirect();
                                }        
                            }
                              /// Show All User Data
                               
                   public function showUser(){
                      if(Auth::user()->role == 'admin'){
                              $totalUsers = User::count();
                              $users = User::orderBy('created_at','desc')->paginate(10); //dd($users);
                              foreach ($users as $user) {
                                  $userPlan = UserPayment::where('user_id',$user->id)->first(); //dd($userPlan);
                                  $user->plan = $userPlan ? $userPlan->plan : "";
                                  $user->plan_status = $userPlan ? $userPlan->status : 2;
                              }
                          return view('Admin.Show_user',['totalUsers' => $totalUsers, 'users' =>$users]);
                      }
                      else{
                          return view('login');
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
                                return view ('Admin.Show_user',compact('total_row','users'))->withQuery ( $q )->withMessage ($total_row.' '. 'User found match your search');
                             }else{ 
                                return view ('Admin.Show_user')->withMessage ( 'User not found match Your search !' );
                             }

                    }     

                               /**
                                   * Display the specified resource.
                                   *
                                   * @param  int  $id
                                   * @return \Illuminate\Http\Response
                                   */
                                  public function show($id)
                                  {
                                      
                                       $user = User::find($id);

                                      return view('Admin.show')->with(['user' => $user]);
                                  }
                                  /**
                                   * Show the form for editing the specified resource.
                                   *
                                   * @param  int  $id
                                   * @return \Illuminate\Http\Response
                                   */
                                  public function edit($id)
                                  {
                                      $user = User::find($id);
                                      $country_data =DB::table('countries')->select('id','name')->get();
                                      $state_data = DB::table("states")->select('id','name')->get();
                                  return view('Admin.edit',compact('country_data','state_data'))->with(['user' => $user]);
                                  }

                               public function destroy($id)
                                  {
                                    $client = "yes";
                                    if(!$client){
                                      User::destroy($id);
                                      Toastr::success('Member Deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
                                      return redirect()->to('/Show_User');
                                                      
                                    }else{
                                      Toastr::error('Sorry user can not delete', 'Error', ["positionClass" => "toast-top-right"]);
                                      return redirect()->to('/Show_User');
                                    }
                      
                                  }

                                  public function enableDisableUser($id){
                                    $user = User::find($id);
                                    $user->suspend = !$user->suspend;
                                    $user->save();
                                    Toastr::success('Member Suspend', 'Success', ["positionClass" => "toast-bottom-right"]);
                                      return back();
                                  }
 
                 }


