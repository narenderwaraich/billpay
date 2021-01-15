<?php

namespace App\Http\Controllers;

use App\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use Toastr;
use Carbon\Carbon;
use Auth;
use Mail;
use App\Mail\PaymentNotification;
use App\User;
use App\Setting;
use App\InvoicePlan;
use App\UserPlanPayment;
use App\UserPayment;
use App\Clients;

class UserPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function showPayment()
    {
        $id = Auth::id();
        $payments = UserPlanPayment::where('transaction_status','=','Success')->orderBy('created_at','desc')->paginate(10); //dd($payments);
        foreach ($payments as $payment) {
            $user = User::where('id',$payment->user_id)->first();
            $payment->user = $user ? $user->fname.' '. $user->lname : '';
            $payment->user_mail = $user ? $user->email : '';
        }
        return view('Admin.Payments.paytm',['payments' =>$payments]);
    }

    public function showPaymentStatus($status)
    {
        $id = Auth::id();
        $payments = UserPlanPayment::where('transaction_status',$status)->orderBy('created_at','desc')->paginate(10); //dd($payments);
        foreach ($payments as $payment) {
            $user = User::where('id',$payment->user_id)->first();
            $payment->user = $user ? $user->fname.' '. $user->lname : '';
            $payment->user_mail = $user ? $user->email : '';
        }
        return view('Admin.Payments.paytm',['payments' =>$payments]);
    }

    public function userPaymentMarkSuccess($id){
          $payment = UserPlanPayment::where('id',$id)->first();
          $data['transaction_status'] = 'Success';
          $payment->update($data);
          Toastr::success('Payment mark successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return back();
        }

    public function userPaymentManual($id){
          $payment = UserPlanPayment::where('id',$id)->first();
          $data['transaction_status'] = 'Success';
          $payment->update($data);

            $userPlan = UserPlan::where('user_id', $payment->user_id)->first();

            $plan = InvoicePlan::where('id',$payment->plan_id)->first();
            $current = Carbon::now();
            $expireDate = $current->addDays($plan->access_day);

            $userPlanData['amount'] = $payment->amount;
            $userPlanData['user_id'] = $payment->user_id;
            $userPlanData['plan_id'] = $plan->id;
            $userPlanData['access_date'] = $current;
            $userPlanData['is_activated'] = 1;
            $userPlanData['expire_date'] = $expireDate;
            $userPlanData['get_invoice'] = $plan->invoices;

            if($userPlan){
                $userPlan->update($userPlanData);
            }else{
                UserPlan::create($userPlanData);
            }
          Toastr::success('Payment manual received successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return back();
        }



    public function showUserPayment()
    {
        $id = Auth::id();
        $payments = UserPayment::where('transaction_status','=','Success')->orderBy('created_at','desc')->paginate(10); //dd($payments);
        foreach ($payments as $payment) {
            $client = Clients::where('user_id',$payment->user_id)->first();
            $payment->user_client = $client ? $client->fname.' '. $client->lname : '';
            $payment->user_client_mail = $client ? $client->email : '';
        }
        return view('Admin.Payments.user',['payments' =>$payments]);
    }

    public function showUserPaymentStatus($status)
    {
        $id = Auth::id();
        $payments = UserPayment::where('transaction_status',$status)->orderBy('created_at','desc')->paginate(10); //dd($payments);
        foreach ($payments as $payment) {
            $client = Clients::where('user_id',$payment->user_id)->first();
            $payment->user_client = $client ? $client->fname.' '. $client->lname : '';
            $payment->user_client_mail = $client ? $client->email : '';
        }
        return view('Admin.Payments.user',['payments' =>$payments]);
    }

    public function buyPlan($id){
        if (Auth::check()) {
            $invoicePlan = InvoicePlan::find($id);
            $amount = $invoicePlan->amount;
            $order_id = uniqid();
            $userPlanPayment = new UserPlanPayment();
            $userPlanPayment->order_id = $order_id;
            $userPlanPayment->transaction_status = 'Pending';
            $userPlanPayment->amount = $amount;
            $userPlanPayment->plan_id = $id;
            $userPlanPayment->user_id = Auth::id();
            $userPlanPayment->transaction_id = '';
            $userPlanPayment->payment_method = "Paytm";
            $userPlanPayment->transaction_date = Carbon::now();
            $userPlanPayment->save();
            $data_for_request = $this->handlePaytmRequest($order_id, $amount);
            $paytm_txn_url = env('PAYTM_TXN_URL');
            $paramList = $data_for_request['paramList'];
            $checkSum = $data_for_request['checkSum'];

            return view('paytm-merchant-form',compact( 'paytm_txn_url', 'paramList', 'checkSum' ));
        }else{
            Toastr::error('Please login first', 'Error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/login');
        }
            
    }

    public function handlePaytmRequest( $order_id, $amount ) {
        // Load all functions of encdec_paytm.php and config-paytm.php
        $this->getAllEncdecFunc();
        $this->getConfigPaytmSettings();

        $checkSum = "";
        $paramList = array();


       

        // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = env('PAYTM_MERCHANT_ID');
        $paramList["ORDER_ID"] = $order_id;
        $paramList["CUST_ID"] = $order_id;
        $paramList["INDUSTRY_TYPE_ID"] = env('PAYTM_INDUSTRY_TYPE');
        $paramList["CHANNEL_ID"] = env('PAYTM_CHANNEL');
        $paramList["TXN_AMOUNT"] = $amount;
        $paramList["WEBSITE"] = env('PAYTM_MERCHANT_WEBSITE');
        $paramList["CALLBACK_URL"] = url( env('PAYMENT_CALL_BACK_URL') );  //env('PAYMENT_CALL_BACK_URL');
        $paytm_merchant_key = env('PAYTM_MERCHANT_KEY');

        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray( $paramList, $paytm_merchant_key );

        //dd($checkSum);

        return array(
            'checkSum' => $checkSum,
            'paramList' => $paramList
        );
    }

    /**
     * Get all the functions from encdec_paytm.php
     */
    function getAllEncdecFunc() {
        function encrypt_e($input, $ky) {
            $key   = html_entity_decode($ky);
            $iv = "@@@@&&&&####$$$$";
            $data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, $iv );
            return $data;
        }

        function decrypt_e($crypt, $ky) {
            $key   = html_entity_decode($ky);
            $iv = "@@@@&&&&####$$$$";
            $data = openssl_decrypt ( $crypt , "AES-128-CBC" , $key, 0, $iv );
            return $data;
        }

        function pkcs5_pad_e($text, $blocksize) {
            $pad = $blocksize - (strlen($text) % $blocksize);
            return $text . str_repeat(chr($pad), $pad);
        }

        function pkcs5_unpad_e($text) {
            $pad = ord($text{strlen($text) - 1});
            if ($pad > strlen($text))
                return false;
            return substr($text, 0, -1 * $pad);
        }

        function generateSalt_e($length) {
            $random = "";
            srand((double) microtime() * 1000000);

            $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
            $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
            $data .= "0FGH45OP89";

            for ($i = 0; $i < $length; $i++) {
                $random .= substr($data, (rand() % (strlen($data))), 1);
            }

            return $random;
        }

        function checkString_e($value) {
            if ($value == 'null')
                $value = '';
            return $value;
        }

        function getChecksumFromArray($arrayList, $key, $sort=1) {
            if ($sort != 0) {
                ksort($arrayList);
            }
            $str = getArray2Str($arrayList);
            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }
        function getChecksumFromString($str, $key) {

            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }

        function verifychecksum_e($arrayList, $key, $checksumvalue) {
            $arrayList = removeCheckSumParam($arrayList);
            ksort($arrayList);
            $str = getArray2StrForVerify($arrayList);
            $paytm_hash = decrypt_e($checksumvalue, $key);
            $salt = substr($paytm_hash, -4);

            $finalString = $str . "|" . $salt;

            $website_hash = hash("sha256", $finalString);
            $website_hash .= $salt;

            $validFlag = "FALSE";
            if ($website_hash == $paytm_hash) {
                $validFlag = "TRUE";
            } else {
                $validFlag = "FALSE";
            }
            return $validFlag;
        }

        function verifychecksum_eFromStr($str, $key, $checksumvalue) {
            $paytm_hash = decrypt_e($checksumvalue, $key);
            $salt = substr($paytm_hash, -4);

            $finalString = $str . "|" . $salt;

            $website_hash = hash("sha256", $finalString);
            $website_hash .= $salt;

            $validFlag = "FALSE";
            if ($website_hash == $paytm_hash) {
                $validFlag = "TRUE";
            } else {
                $validFlag = "FALSE";
            }
            return $validFlag;
        }

        function getArray2Str($arrayList) {
            $findme   = 'REFUND';
            $findmepipe = '|';
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                $pos = strpos($value, $findme);
                $pospipe = strpos($value, $findmepipe);
                if ($pos !== false || $pospipe !== false)
                {
                    continue;
                }

                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }

        function getArray2StrForVerify($arrayList) {
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }

        function redirect2PG($paramList, $key) {
            $hashString = getchecksumFromArray($paramList, $key);
            $checksum = encrypt_e($hashString, $key);
        }

        function removeCheckSumParam($arrayList) {
            if (isset($arrayList["CHECKSUMHASH"])) {
                unset($arrayList["CHECKSUMHASH"]);
            }
            return $arrayList;
        }

        function getTxnStatus($requestParamList) {
            return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
        }

        function getTxnStatusNew($requestParamList) {
            return callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
        }

        function initiateTxnRefund($requestParamList) {
            $CHECKSUM = getRefundChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY,0);
            $requestParamList["CHECKSUM"] = $CHECKSUM;
            return callAPI(PAYTM_REFUND_URL, $requestParamList);
        }

        function callAPI($apiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($postData))
            );
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }

        function callNewAPI($apiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($postData))
            );
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }
        function getRefundChecksumFromArray($arrayList, $key, $sort=1) {
            if ($sort != 0) {
                ksort($arrayList);
            }
            $str = getRefundArray2Str($arrayList);
            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }
        function getRefundArray2Str($arrayList) {
            $findmepipe = '|';
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                $pospipe = strpos($value, $findmepipe);
                if ($pospipe !== false)
                {
                    continue;
                }

                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }
        function callRefundAPI($refundApiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $refundApiURL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }
    }

    /**
     * Config Paytm Settings from config_paytm.php file of paytm kit
     */
    function getConfigPaytmSettings() {
        define('PAYTM_ENVIRONMENT', env('PAYTM_ENVIRONMENT')); // PROD
        define('PAYTM_MERCHANT_KEY', env('PAYTM_MERCHANT_KEY')); //Change this constant's value with Merchant key downloaded from portal
        define('PAYTM_MERCHANT_MID', env('PAYTM_MERCHANT_ID')); //Change this constant's value with MID (Merchant ID) received from Paytm
        define('PAYTM_MERCHANT_WEBSITE', env('PAYTM_MERCHANT_WEBSITE')); //Change this constant's value with Website name received from Paytm

        $PAYTM_STATUS_QUERY_NEW_URL= env('PAYTM_STATUS_QUERY_URL');
        $PAYTM_TXN_URL= env('PAYTM_TXN_URL');
        if (PAYTM_ENVIRONMENT == 'PROD') {
            $PAYTM_STATUS_QUERY_NEW_URL= env('PAYTM_STATUS_QUERY_URL');
            $PAYTM_TXN_URL= env('PAYTM_TXN_URL');
        }
        define('PAYTM_REFUND_URL', env('PAYTM_REFUND_URL'));
        define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
        define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
        define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
    }

    public function paytmCallback( Request $request ) {
                //return $request;
                $order_id = $request['ORDERID'];
                $transaction_id = $request['TXNID'];
                $amount = $request['TXNAMOUNT'];
                $payment_method = $request['PAYMENTMODE'];
                $transaction_date = $request['TXNDATE'];
                $transaction_status = $request['STATUS'];
                $bank_transaction_id = $request['BANKTXNID'];
                $bank_name = $request['BANKNAME'];
                $userId = Auth::id();

        if ( 'TXN_SUCCESS' === $request['STATUS'] ) {
                    // get the current time
                    $current = Carbon::now();
                    $nowDate = $current->toDateTimeString();

                    $userPlanPayment = UserPlanPayment::where( 'order_id', $order_id )->first();
                    $userPlanPayment->transaction_status = 'Success';
                    $userPlanPayment->transaction_id = $transaction_id;
                    $userPlanPayment->payment_method = $payment_method;
                    $userPlanPayment->bank_transaction_id = $bank_transaction_id;
                    $userPlanPayment->transaction_date = $transaction_date;
                    $userPlanPayment->bank_name = $bank_name;
                    $userPlanPayment->transaction_date =  $current;
                    $userPlanPayment->created_at =  $current;
                    $userPlanPayment->save();

                    $userPlan = UserPlan::where('user_id', $userId)->first();

                    $plan = InvoicePlan::where('id',$userPlanPayment->plan_id)->first();
                    $expireDate = $current->addDays($plan->access_day);

                    $userPlanData['amount'] = $amount;
                    $userPlanData['user_id'] = $userId;
                    $userPlanData['plan_id'] = $plan->id;
                    $userPlanData['access_date'] = $current;
                    $userPlanData['is_activated'] = 1;
                    $userPlanData['expire_date'] = $expireDate;
                    $userPlanData['get_invoice'] = $plan->invoices;

                    if($userPlan){
                        $userPlan->update($userPlanData);
                    }else{
                        UserPlan::create($userPlanData);
                    }

                    $order = $userPlanPayment;
                    $user = User::where('id',$userId)->first();
                    $setting = Setting::find(1);
                    $adminMail = $setting->admin_mail;
                    Mail::to($adminMail)->send(new PaymentNotification($user,$order));
                Toastr::success('Your Plan Activated', 'Success', ["positionClass" => "toast-bottom-right"]);
                return redirect()->to('/dashboard');
        } else if( 'TXN_FAILURE' === $request['STATUS'] ){
            //return $request;
                    $userPlanPayment = UserPlanPayment::where( 'order_id', $order_id )->first();
                    $userPlanPayment->transaction_status = 'Failed';
                    $userPlanPayment->transaction_id = $transaction_id;
                    $userPlanPayment->payment_method = $payment_method;
                    $userPlanPayment->bank_transaction_id = $bank_transaction_id;
                    $userPlanPayment->transaction_date = $transaction_date;
                    $userPlanPayment->bank_name = $bank_name;
                    $userPlanPayment->transaction_date =  Carbon::now();
                    $userPlanPayment->created_at =  Carbon::now();
                    $userPlanPayment->save();
            return view( 'payment-failed' );
        }
    }
}
