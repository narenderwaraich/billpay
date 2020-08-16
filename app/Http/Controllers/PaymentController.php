<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserPayment;
use App\User;
use App\UserPaymentAccount;
use App\UserCard;
use App\UserPaymentDitail;
use Carbon\Carbon;
use Redirect;
use Toastr;
use App\Clients;

class PaymentController extends Controller
{


                  public function __construct()
                    {
                        \Stripe\Stripe::setApiKey(env("STRIPE_SECRET_KEY"));
                    }

                  //// Manage Payment managePayment
                 public function managePlan(){
                        if(!Auth::user()->is_activated == 'true'){
                          Toastr::error('Please first confirm your email to start using your Account!', 'Error', ["positionClass" => "toast-top-right"]);
                            return back();
                        }else{
                              $planList = \Stripe\Plan::all();
                              $plans = $planList->data; //dd($plans);
                              $id = Auth::id();
                              // user save card record
                              $card = UserCard::where('user_id', $id)->first();
                              // check user have plan or not 
                              $userPlan = UserPayment::where('user_id', $id)->first(); 
                              // if user have no any plan go to manage-plan view blade
                              if(!$userPlan){ 
                                 return view('manage-plan',compact('plans')); 
                              }
                              // $user = User::find($id);
                              // $endDate = date('m-d-Y', strtotime($user->access_date)); 
                              // // $startDate = date('m-d-Y', strtotime($user->access_date. ' - 30 day'));
                              
                              //// Check user payment details list
                              $tranfer = UserPaymentDitail::where('payment_id',$userPlan->id)->latest()->paginate(10);
                              return view('update-plan',compact('plans','card','userPlan','tranfer'));
                            }
                           
                    }


                    /// Manage Stripe Key
                public function manageStripeKey(){
                          $id = Auth::id();
                          if($key = UserPaymentAccount::where('user_id', '=', $id)->first()){
                             return view('manage-stripe-account', ['stripe_key' => $key->stripe_key]);  
                          }
                         return view('manage-stripe-account');
                      
                }

                

                public function stripeConnectConfirmation(Request $request){
                  if(isset($request->error)){
                    Toastr::error('Sorry!  denied your request', 'Error', ["positionClass" => "toast-top-right"]);
                    return view('manage-stripe-account');
                  }
                  
                  else{
                        $stripeCode = $request->code; 
                          $client = new \GuzzleHttp\Client();
                          $request = $client->request('POST', "https://connect.stripe.com/oauth/token", [
                              'form_params' => [
                                'client_secret'=>env('STRIPE_SECRET_KEY'),
                                'code'=>$stripeCode,
                                'grant_type'=>"authorization_code"
                                ],
                              ]);
              
                          $response = $request->getBody()->getContents();
                          $dataResponce = json_decode($response, true); 
                          $stripeId = $dataResponce['stripe_user_id'];

                          $id = Auth::id();
                        $data['stripe_key']   = $stripeId;
                        $data['user_id']    = $id;
                         UserPaymentAccount::updateOrCreate(['user_id' => $data['user_id']], ['stripe_key' => $data['stripe_key']]);
                         Toastr::success('Key Updated', 'Success', ["positionClass" => "toast-top-right"]);
                    return redirect()->to('/manage-stripe-account');
                         
                           
                  }
                  
                }

                /// Manage Stripe Key
                public function storeStripeKey(Request $request){
                    
                
                    $this->validate(request(),[
                                 'stripe_key'=>'required|string|max:50',
                             ]);
                    $url = "https://api.stripe.com/v1/charges?key=" . $request->stripe_key;  

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $res = curl_exec($ch);
                    $res = json_decode($res, true);
                    
                    if(isset($res['error'])){
                        Toastr::error('Sorry! your Key is Invalid', 'Error', ["positionClass" => "toast-top-right"]);
                        return redirect()->to('/manage-stripe-account');
                    }else{
                        
                    

                        $id = Auth::id();
                        $data   = request(['stripe_key']);
                        $data['user_id']    = $id;
                         UserPaymentAccount::updateOrCreate(['user_id' => $data['user_id']], ['stripe_key' => $data['stripe_key']]);
                         Toastr::success('Key Updated', 'Success', ["positionClass" => "toast-top-right"]);
                    return redirect()->to('/manage-stripe-account');
                }
                }


                     //// choose plan page
                    public function getPayment(){
                        $planList = \Stripe\Plan::all();
                        $plan = $planList->data;
                      return view('manage-plan', compact('plan'));
                    }

                    //// buy plan function with stripe
                    public function storePlanPayment(Request $request){
                                $this->validate(request(),[
                                'card_number'=>'required|string|max:20',
                                ]);
                                $number = ($request->card_number);
                                $data   = request(['card_number','month','year','cvv',]);
                                $data['card_number'] = str_replace(" ", "", $data['card_number']);

                                $number = substr($number,-4,4);
                                $plan = ($request->plan);
                                        
                                $planId = explode(",", $plan)[0];
                                $planNickName = explode(",", $plan)[4];
                                $planName = explode(",", $plan)[1];
                                $clients = explode('_', $planNickName)[0];
                                $planTime = explode(",", $plan)[2];
                                $planAmount = explode(",", $plan)[3];
                                $netAmount = $planAmount / 100;
                                $data['amount']    = $netAmount;
                                $data['plan_id']        = $planId;
                                $data['plan']        = $planName;
                                $cardNumber['card_number'] = $number;
                                $data['user_id']     = Auth::id(); 
                                $data['interval']    = $planTime;
                                $data['clients']    = $clients;
                                $res = $this->createCardToken($data,$cardNumber);      
                                if($res){
                                  Toastr::error(addslashes($res), 'Error', ["positionClass" => "toast-top-right"]);
                                }else{
                                  Toastr::success('Your plan created successfully. Your active plan will show shortly on this page', 'Success', ["positionClass" => "toast-top-right", "timeOut" => 9800]);
                                }
                                return redirect()->to('/manage-plan');
                    }

                        public function createCardToken($data, $cardNumber){
                            
                                        $mail = Auth::user()->email;
                                        $amount = ($data['amount'] * 100);  
                            

                            try{
                              
                              $card = \Stripe\Token::create([
                                "card" => [
                                  "number" => $data['card_number'],
                                  "exp_month" => $data['month'],
                                  "exp_year" => $data['year'],
                                  "cvc" => $data['cvv']
                                ]
                            ]);
                                $token = $card->id;
                                
                                        $cardData = \Stripe\Customer::create([
                                          "description" => $mail,
                                          "source" => $token, // obtained with Stripe.js
                                        ]);
                                        $number = $data['card_number']; 

                                        $number = substr($number,-4,4);
                                        $CustomerId = $cardData->id;
                                        $cardStore['customer_id'] = $CustomerId;
                                        $cardStore['card_number'] = $number;
                                        $cardStore['user_id']     = Auth::id();
                                        UserCard::create($cardStore);

                            $SubData = \Stripe\Subscription::create([
                              "items" => [
                                        [
                                          "plan" => $data['plan_id'],
                                        ],
                                      ],
                              "customer" => $CustomerId, // obtained with Stripe.js
                            ]); //dd($SubData);
                                        $subscriptionId = $SubData->id;
                                        $data['subscription_id'] = $subscriptionId;
                                        $data['card_number'] = $number;
                                        $data['payment_date'] = Carbon::now();

                                    UserPayment::create($data);
                                    return "";
                            }
                            catch(\Exception $e){
                              $message = $e->getMessage(); 
                              return $message;
                            }
                        }
                        
                    
                   
                    public function updatePlan(Request $request){
                            $id = Auth::id();
                            //$UserClient = Clients::where('user_id', $id)->get();
                            //$clientCount = $UserClient->count();
                            $usCard = UserPayment::where('user_id',$id)->first();
                            $status = $usCard->status;
                            $oldClient = $usCard->clients;
                            $paymentUserId = $usCard->id;
                            //$checkClient = $oldClient - $clientCount;
                        
                                  $data   = request(['month','year','cvv',]);
                                
                                  $plan = ($request->plan);

                                  $planId = explode(",", $plan)[0];
                                  $planNickName = explode(",", $plan)[4];
                                  $planName = explode(",", $plan)[1];
                                  $clients = explode('_', $planNickName)[0];
                                  $planTime = explode(",", $plan)[2];
                                  $planAmount = explode(",", $plan)[3];
                                  $netAmount = $planAmount / 100;
                                  $newClient = $oldClient + $clients;
                                  $data['amount']      = $netAmount;
                                  $customerId = $request->customer_id; 
                                  $data['plan']        = $planName;
                                  $data['plan_id']        = $planId;
                                  $data['interval']    = $planTime;
                                  $data['clients']    = $newClient; 
                                    if($status == 0){
                                          $upd = $this->addSubscription($data,$customerId,$usCard);
                                        }else{
                                          $res = $this->updateSubscription($data,$customerId);
                                          // if($checkClient == 0){
                                    
                                          //   }else{
                                          //     $res = $this->updateSubscription($data,$customerId);
                                          //   }
                                        }

                            
                                    return response()->json(['success' => 'Plan Updated!']);
                       
                    }

                      public function updateSubscription($data, $customerId){
                              $id = Auth::id();
                              $mail = Auth::user()->email;
                              $amount = ($data['amount'] * 100);  


                      try{
                          //$CustomerId = $data['customer_id'];
                          $usCard = UserPayment::where('user_id',$id)->first();
                          $subId = $usCard->subscription_id;
                            /// get user card add or change latest number
                          $userCard = UserCard::where('user_id', $id)->first();
                          $number = $userCard->card_number;

                              $subscription = \Stripe\Subscription::retrieve($subId);
                                  \Stripe\Subscription::update($subId, [
                                    'cancel_at_period_end' => false,
                                    'items' => [
                                          [
                                              'id' => $subscription->items->data[0]->id,
                                              'plan' => $data['plan_id'],
                                          ],
                                      ],
                                  ]);


                                // $sub = \Stripe\Subscription::retrieve($subId);
                                // $sub->cancel();
                                  
                                // $SubData = \Stripe\Subscription::create([
                                //   "items" => [
                                //     [
                                //       "plan" => $data['plan_id'],
                                //     ],
                                //   ],
                                //   "customer" => $customerId, // obtained with Stripe.js
                                //   // "description" => "Charge for " .$mail,
                                // ]);
                                //     $subscriptionId = $SubData->id;
                                //     $data['subscription_id'] = $subscriptionId;
                                  $data['payment_date'] = Carbon::now();
                                  $data['card_number'] = $number;
                               UserPayment::where('user_id',$id)->update($data);
                            }
                            catch(\Exception $e){
                                $message = $e->getMessage();
                                return response()->json(['error' => $message]);
                            }
                    }

                //// Cancel Subcription after again update plan
                public function addSubscription($data, $customerId, $usCard){
                        $id = Auth::id();
                      // $getEmail = User::find($id);
                      // $mail = $getEmail->email;
                      try{
                            $SubData = \Stripe\Subscription::create([
                            "items" => [
                              [
                                "plan" => $data['plan_id'],
                              ],
                            ],
                            "customer" => $customerId, // obtained with Stripe.js
                            // "description" => "Charge for " .$mail,
                          ]);
                                /// get user card add or change latest number
                                $userCard = UserCard::where('user_id', $id)->first();
                                $number = $userCard->card_number;
                                $data['subscription_id'] = $SubData->id; /// again add new subscription_id
                                $data['status'] = 1;
                                $data['card_number'] = $number;
                                $data['payment_date'] = Carbon::now();
                                $usCard->update($data);
                                return "";
                        }
                        catch(\Exception $e){
                            $message = $e->getMessage();
                            return response()->json(['error' => $message]);
                        }

                }

                public function addNewCard(Request $request){
                       
                        $data   = request(['card_number','month','year','cvv',]);
                        
                        $mail = Auth::user()->email;

                        try{
                        
                        $card = \Stripe\Token::create([
                            "card" => [
                                "number" => $data['card_number'],
                                "exp_month" => $data['month'],
                                "exp_year" => $data['year'],
                                "cvc" => $data['cvv']
                            ]
                        ]);
                            $token = $card->id;
                            
                            $cardData = \Stripe\Customer::create([
                              "description" => $mail,
                              "source" => $token, // obtained with Stripe.js
                            ]);
                            
                            $CustomerId = $cardData->id;
                            $data['customer_id'] = $CustomerId;
                            
                             $number = ($request->card_number);
                             $data['card_number'] = str_replace(" ", "", $data['card_number']);

                            $number = substr($number,-4,4);
                            $data['card_number'] = $number;
                            $data['user_id']     = Auth::id();
                            
                            UserCard::create($data);
                          

                    }
                    catch(\Exception $e){
                        $message = $e->getMessage();
                        return response()->json(['error' => $message]);
                    }

                        return response()->json(['success' => 'Card Updated!']);
                    }
                //// update card exititing customer
                public function updateCard(Request $request){
                        $data   = request(['card_number','month','year','cvv',]);
                        $mail = Auth::user()->email;
                        $userId = Auth::id();
                        $userCard = UserCard::where('user_id',$userId)->first();
                        try{
                        
                        $card = \Stripe\Token::create([
                            "card" => [
                                "number" => $data['card_number'],
                                "exp_month" => $data['month'],
                                "exp_year" => $data['year'],
                                "cvc" => $data['cvv']
                            ]
                        ]);
                            $cardToken = $card->id;
                            $customerId = $userCard->customer_id;

                            $customer = \Stripe\Customer::update(
                                  $customerId,
                                  [
                                      'source' => $cardToken
                                  ]
                              );
                            
                             $number = ($request->card_number);
                             $data['card_number'] = str_replace(" ", "", $data['card_number']);

                            $number = substr($number,-4,4);
                            $data['card_number'] = $number;
                            $data['user_id']     = $userId;
                            
                            $userCard->update($data);
                    }
                    catch(\Exception $e){
                        $message = $e->getMessage();
                        //Toastr::error(addslashes($message), 'Error', ["positionClass" => "toast-top-right"]); 
                        //return $message;
                        return response()->json(['error' => $message]);
                    }

                    return response()->json(['success' => 'Card Updated!']);
                }

                // Delete Card 
                public function deleteCard(Request $request){
                        $id = Auth::id();
                        $userCard = UserCard::where('user_id', $id)->first();
                        $subData = UserPayment::where('user_id',$id)->first();
                      /// Check Subscription First Cancel or not
                    if($subData == 1){
                        return response()->json(['error' =>'Sorry Card can not deleted']);                  
                      }

                      else{                 
                            $customerId = $userCard->customer_id;
                            $cardId = "";
                            $customer = \Stripe\Customer::deleteSource(
                                  $customerId,
                                  $cardId,
                                  []
                            );
                            if($customer){
                              $userCard->delete();
                              return response()->json(['success' => 'Card Deleted']);    
                            }else{
                              return response()->json(['error' => 'Card not Deleted']);    
                            }
                                       
                          }

                }


                // Delete Customer & card
                public function deleteCustomer($customerId){
                        $id = Auth::id();
                        $userCard = UserCard::where('customer_id','=', $customerId)->first();
                        $userData = UserPayment::where('user_id',$id)->first(); //dd($userData);
                        /// Check Subscription First Cancel or not
                        if($userData->status == 1){
                          Toastr::error('First Cancel Subscription', 'Error', ["positionClass" => "toast-bottom-right"]);
                            return back();                  
                        }else{
                            /// Check card first
                          if($userCard){
                                $customer = \Stripe\Customer::retrieve($customerId); //dd($customer);
                                $customer->delete();
                                $userCard->delete(); 
                                Toastr::success('Card Deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
                                return back();            
                            }else{                 
                                Toastr::error('User Card Not Found', 'Error', ["positionClass" => "toast-bottom-right"]);
                                return back();           
                            }
                          }

                }

                public function disconnectStripeAccount(){
                    $id = Auth::id();
                  $findId = UserPaymentAccount::where('user_id',$id)->first(); 
                  $account_id = $findId->stripe_key;
                  $client_id  = env('STRIPE_CLIENT_ID');  // put this into env
                  $stripe_key = env('STRIPE_SECRET_KEY');
                  $client = new \GuzzleHttp\Client();
                  $request = $client->request('POST', "https://connect.stripe.com/oauth/deauthorize", [
                  'form_params' => [
                    'client_id'=>$client_id,
                    'stripe_user_id'=>$account_id,
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $stripe_key,        
                    ]
                  ]);
                  $deleteId = UserPaymentAccount::where('user_id',$id)->where('stripe_key', $account_id)->delete();
                  Toastr::success('Disconnect Stripe Account', 'Success', ["positionClass" => "toast-bottom-right"]);
                  return back();
                }

                // cancel Subscription

                public function cancelSubscription(){
                        $id = Auth::id();
                        $usCard = UserPayment::where('user_id',$id)->first();
                        $subId = $usCard->subscription_id;
                        //$userPayId = $usCard->id;
                        try{
                            $subscription = \Stripe\Subscription::retrieve($subId);
                            $subscription->cancel();

                            /// Check User Client Add or Count
                            // $clientData = Clients::where('user_id',$id)->get();
                            // $clients = $clientData->count(); //dd($clients);

                            $clientUpd['status'] = 0;
                            //$clientUpd['clients'] = $clients;
                            $usCard->update($clientUpd);
                              //$dell = UserPayment::where('id', $userPayId)->where('subscription_id')->first();
                              //$dell->delete();
                          
                            Toastr::success('Subscription Cancel', 'Success', ["positionClass" => "toast-top-right"]);
                              return redirect()->to('/manage-plan');
                           }
                            catch(\Exception $e){
                                $message = $e->getMessage();
                                Toastr::error(addslashes($message), 'Error', ["positionClass" => "toast-top-right"]); 
                                return back();
                            } 
                    }


                        public function webhook(Request $request){
                          if(isset($request->data['object']['subscription'])){
                              $subscriptionId = $request->data['object']['subscription'];
                             $event_type = $request->type; 
                             $paid_amount = $request->data['object']['amount_paid'];
                             if($event_type == "invoice.payment_succeeded"){
                                $this->userDitail($subscriptionId, "Successfully",$paid_amount);
                             }
                            if($event_type == "invoice.payment_failed"){
                              $this->userDitail($subscriptionId, "Failed",$paid_amount);
                            }
                          }  
                        }           

                        public function userDitail($subscriptionId, $status, $paid_amount){
                          $userData =  UserPayment::where('subscription_id','=',$subscriptionId)->first();
                          if($userData){
                          $userId = $userData->user_id;
                          $paymentId = $userData->id;
                          $cardNumber = $userData->card_number;
                          $amount = $userData->amount;
                          $clients = $userData->clients;
                          $plan = $userData->plan;
                          $time = $userData->interval;

                          $dataIn['card_number']    = $cardNumber;
                          $dataIn['user_id']        = $userId;
                          $dataIn['payment_id']     = $paymentId;
                          $dataIn['plan']           = $plan;
                          $dataIn['payment_date']   = Carbon::now();
                          $dataIn['amount']         = $amount;
                          $dataIn['paid_amount']    = $paid_amount;
                          $dataIn['interval']       = $time;
                          $dataIn['clients']        = $clients;
                          $dataIn['status']         = $status;

                          $chk = UserPaymentDitail::create($dataIn);

                            if($status == "Successfully"){
                                $current = Carbon::now();
                                $nowDate = $current->toDateTimeString(); 
                                $AddDate = $current->addDays(30);
                                $updateDate = $AddDate->toDateTimeString();
                                $dateTime["access_date"] = $updateDate; 
                                User::find($userId)->update($dateTime);
                                  $subActive['status'] = 1;
                                UserPayment::where('id',$paymentId)->update($subActive);
                          }

                          if($status == "Failed"){
                                 $subActive['status'] = 0;
                                 //$subActive['error'] = "";
                                 UserPayment::where('id',$paymentId)->update($subActive);
                          }
                        } 
                          
                        }

              public function testMethod(){
                    $subId = "sub_HpGX56k9uB5MV1";
                    $customerId ="cus_HlwvFcJ0wBPaM1";
                    $cardId ="card_1HCP1zJVfCONulWkPC077Q9t";
                    $planId ="50_clients"; 
              // $result = \Stripe\Subscription::update($subId,
              //   ['customer' => $customerId]
              // );

              // $result = \Stripe\Customer::update($customerId,
              //   ['metadata' => ['order_id' => '6735']]
              // );

              // $result = \Stripe\Customer::delete(
       //          $customerId,
              //   []
              // );
              // $stripe = new \Stripe\StripeClient(
              //    'sk_test_vqsklnlv52MMicEtNx11Fg3N'
              //  );
              // dd($stripe);
              //  $stripe->customers->delete(
              //    'cus_HmIAsQJ4aCxQC2',
              //    []
              //  );

              //return $result;
              //$result = \Stripe\Customer::all(); dd($result);
              //$result = \Stripe\Customer::retrieve($customerId); //dd($result);
              //$result->delete();

              // $subscription = \Stripe\Subscription::retrieve($subId);
              //  $newUpdateplan =   \Stripe\Subscription::update($subId, [
              //       'cancel_at_period_end' => true,
              //       'items' => [
              //             [
              //                 'id' => $subscription->items->data[0]->id,
              //                 'plan' => $planId,
              //             ],
              //         ],
              //     ]);

              //     dd($newUpdateplan);
              }



              

        
}
