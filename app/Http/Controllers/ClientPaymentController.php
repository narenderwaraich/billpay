<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ClientPayment;
use App\Invoice;
use App\UserPaymentAccount;
use App\User;
use App\Clients;
use Carbon\Carbon;
use Toastr;
use Redirect;
use Mail;
use App\Mail\PaymentStatus;

class ClientPaymentController extends Controller
{

    public function __construct()
    {
        \Stripe\Stripe::setApiKey(env("STRIPE_SECRET_KEY"));
    }

    public function getPayPage($id, Request $request){
    	$payType = $request->pay_type;
    	if($payType == 'full'){
            $inv = Invoice::find($id);
            if($inv->status == 'PAID-STRIPE'){
                Toastr::error('Sorry you already Payment Paid!', 'Error', ["positionClass" => "toast-top-right"]);
                return redirect()->to('/dashboard');
            }else{
                $inv = Invoice::find($id);
                $fullPayment = $inv->due_amount;
                return view('PayPayment',['id' => $id,'fullPayment' => $fullPayment]);
            }	
    	}else{
            $inv = Invoice::find($id);
            if($inv->status == 'DEPOSIT_PAID'){
                Toastr::error('Sorry you already Payment Paid!', 'Error', ["positionClass" => "toast-top-right"]);
                return redirect()->to('/dashboard');
            }else{
                $inv = Invoice::find($id);
                $depositPayment = $inv->deposit_amount;
        		return view('Pay-deposit-Payment',['id' => $id, 'depositPayment' => $depositPayment]);
            }
    	}
    	
    }

    public function storePayPage(Request $request){ 
    		$validate = $this->validate(request(),[
                'card_number'=>'required|string|max:20',
                ]);
    		if(!$validate){
                           Redirect::back()->withInput();
                          } 
            $data  = request(['card_number','month','year','cvv','invoice_id']); //store ','amount','status'
            $invId = $request->invoice_id;
            $invData = Invoice::find($invId);
            $clientId = $invData->client_id;
            $data['client_id']     = $clientId;
            $data['payment_date']  = Carbon::now();
            if($request->deposit_amount){
                $pay = $request->deposit_amount; // pay amount
                $totalAmount = $invData->due_amount; /// total amount 
                $pending = $totalAmount - $pay; // total - pay
                $status['due_amount'] = $pending; // pending amount
                $status['deposit_amount'] = $pay;
                $status['deposit_date'] = Carbon::now();
                $status['payment_date'] = Carbon::now();
                $status['status'] = "DEPOSIT_PAID";
                $data['status'] = "DEPOSIT_PAID";
                $data['amount'] = $pay;
            }

            if($request->full_amount){
                $pay = $request->full_amount; // pay amount
                $totalAmount = $invData->due_amount; /// total amount 
                $pending = $totalAmount - $pay; // total - pay
                $status['due_amount'] = $pending; // pending amount
                $status['payment_date'] = Carbon::now();
                $status['status'] = "PAID-STRIPE";
                $data['status'] = "PAID-STRIPE";
                $data['amount'] = $pay; 
            }
            // $id = Auth::id();
            $findkey = UserPaymentAccount::where('user_id','=', $invData->user_id)->first();
            if(!$findkey){
                Toastr::error('Sorry first Connect Stripe Accounts!', 'Error', ["positionClass" => "toast-top-right"]);
                return back();
            }
            $key = $findkey->stripe_key;
            $res = $this->payPayment($data,$key);
            if($res){
                    return response()->json(["error"=>$res], 400);
                  //Toastr::error(addslashes($res), 'Error', ["positionClass" => "toast-top-right"]);
                  // return back();
                }else{
                  Invoice::where('id',$invId)->update($status);
                  $userID = $invData->user_id;
                  $userData = User::find($userID);
                  $clientData = Clients::find($clientId);
                  Mail::to($userData->email)->send(new PaymentStatus($invData, $clientData, $userData, $pay));
                  // Toastr::success('Payment Done', 'Success', ["positionClass" => "toast-bottom-right"]);
                  //   return redirect()->to('/'); 
                  return response()->json(["success"=>true], 200);  
                }    
    	
    }

    public function payPayment($data, $key){
        

        // \Stripe\Stripe::setApiKey($key); /// user kay
    	try{
          
          $card = \Stripe\Token::create([
            "card" => [
              "number" => $data['card_number'],
              "exp_month" => $data['month'],
              "exp_year" => $data['year'],
              "cvc" => $data['cvv']
            ]
        ]);
            $id = $data['client_id'];
            $getEmail = Clients::find($id);
            $mail = $getEmail->email; 
            $token = $card->id;
            $amount = ($data['amount'] * 100);
            $charge = \Stripe\Charge::create([
                        'amount' => $amount,
                        'currency' => 'usd',
                        'description' => $mail,
                        'source' => $token,
                    ], ["stripe_account" => $key]);
                $data['charge_id'] = $charge->id;
                ClientPayment::create($data);
                    return "";  
        }
        catch(\Exception $e){
          $message = $e->getMessage(); 
          return $message;
        }
    }

    // public function refundMoney($id){
    //     $inv = Invoice::find($id);
    //     $status = $inv->status;
    //     if($status == "DEPOSIT_PAID"){
    //         $amount = $inv->deposit_amount;
    //         $res = $this->refundStripe($id,$amount);
    //         if($res){
    //             Toastr::error($res, 'Error', ["positionClass" => "toast-top-right"]);
    //             return back();
    //         }else{
    //            Toastr::success('Payment Refund', 'Success', ["positionClass" => "toast-bottom-right"]);
    //             return back(); 
    //         }
            
    //     }
    //     if($status == "PAID"){
    //         $amount = $inv->net_amount;
    //         $res = $this->refundStripe($id,$amount);
    //         if($res){
    //             Toastr::error($res, 'Error', ["positionClass" => "toast-top-right"]);
    //             return back();
    //         }else{
    //            Toastr::success('Payment Refund', 'Success', ["positionClass" => "toast-bottom-right"]);
    //             return back(); 
    //         }
    //     }
    // }

    // public function refundStripe($id,$amount){
    //         $paymentData = ClientPayment::where('invoice_id',$id)->first();
    //         $chargeKey = $paymentData->charge_id;
    //         $netAmount =  $amount * 100;
    //         try{  
    //       $refund = \Stripe\Refund::create([
    //             'charge' => $chargeKey,
    //             'amount' => $netAmount,
    //         ]);
    //         $inv = Invoice::find($id);
    //         $data['refund_date'] = now()->format('Y-m-d');
    //         $data['status'] = "REFUND";
    //         $data['due_amount'] = $inv->net_amount;
    //         //dd($data);
    //         Invoice::where('id',$id)->update($data);
    //         return "";  
    //     }
    //     catch(\Exception $e){
    //       $message = $e->getMessage(); 
    //       return $message;
    //     }

            
    // }
}
