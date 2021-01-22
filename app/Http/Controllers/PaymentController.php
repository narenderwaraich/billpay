<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\UserPayment;
use App\User;
use Carbon\Carbon;
use Redirect;
use Toastr;
use App\Clients;
use Validator;
use App\Invoice;
use App\InvoicePlan;
use App\Item;

class PaymentController extends Controller
{

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $plans = InvoicePlan::all();
        return view('plans',compact('plans'));
    }

    public function invoiceCashPay($id){
        $invoice = Invoice::find($id);
        return view('cash-pay-invoice',compact('invoice'));
    }

    public function cashDepositPay($id){
       $invoice = Invoice::where('id',$id)->first();
       $amount = $invoice->deposit_amount;
       $this->cashPay($id, $amount);
       Toastr::success('Invoice Cash Deposit Paid', 'Success', ["positionClass" => "toast-top-right"]);
                return redirect()->to('/dashboard');
    }

    public function cashFullPay($id){
        $invoice = Invoice::where('id',$id)->first();
        $amount = $invoice->net_amount;
        $this->cashPay($id, $amount);
        Toastr::success('Invoice Cash Full Paid', 'Success', ["positionClass" => "toast-top-right"]);
                return redirect()->to('/dashboard');
    }

    public function cashPay($id, $amount){
                $invoice = Invoice::where('id',$id)->first();
                $order_id = uniqid();
                $order = new UserPayment();
                $order->order_id = $order_id;
                $order->transaction_date = Carbon::now();
                $order->transaction_status = 'Success';
                $order->payment_method = "Cash";
                $order->amount = $amount;
                $order->transaction_id = '';
                $order->invoice_id = $id;
                $order->user_id = $invoice->user_id;
                $order->created_at =  Carbon::now();
                $order->save();
                /// Update status
                if($amount == $invoice->net_amount){
                    $statusUpdate['status'] = "CASH";
                    $statusUpdate['due_amount'] = 0;
                    $statusUpdate['payment_date'] = Carbon::now();
                }else{
                    $pay = $invoice->deposit_amount; // pay amount
                    $totalAmount = $invoice->due_amount; /// total amount 
                    $pending = $totalAmount - $pay; // total - pay
                    $statusUpdate['status'] = "DEPOSIT_PAID";
                    $statusUpdate['deposit_date'] = Carbon::now();
                    $statusUpdate['payment_date'] = Carbon::now();
                    $statusUpdate['due_amount'] = $pending;
                }
                $statusUpdate['inventory'] = 0;
                
                //// item inventory
                if($invoice->inventory){
                    $invItem = $invoice->invoiceItems; 
                    foreach ($invItem as $key => $item) {
                          $invoiceItmSale = Item::where('id',$item->item_id)->first();
                          if($invoiceItmSale){
                            if($invoiceItmSale->qty > $item->qty){
                                $qty['qty'] = $invoiceItmSale->qty - $item->qty;
                              }
                              if($invoiceItmSale->qty == $item->qty){
                                $qty['qty'] = 0;
                                $qty['in_stock'] = 0;
                              }
                              $invoiceItmSale->update($qty);
                          }  
                    }
                }
                $invoice->update($statusUpdate);
                return;
                
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Paytem Via Payments Recived all function

    public function paytmPay($id)
    {
                $invoice = Invoice::find($id); //dd($invoice);
                if($invoice->deposit_amount > 0){
                	$amount = $invoice->deposit_amount;
                }else{
                	$amount = $invoice->net_amount;
                }
                $order_id = uniqid();
                $order = new UserPayment();
                $order->order_id = $order_id;
                $order->transaction_date = Carbon::now();
                $order->transaction_status = 'Pending';
                $order->amount = $amount;
                $order->transaction_id = '';
                $order->invoice_id = $id;
                $order->user_id = $invoice->user_id;
                $order->save();
                $data_for_request = $this->handlePaytmRequest($order_id, $amount);
                $paytm_txn_url = env('PAYTM_TXN_URL');
                $paramList = $data_for_request['paramList'];
                $checkSum = $data_for_request['checkSum'];

                return view('paytm-merchant-form',compact( 'paytm_txn_url', 'paramList', 'checkSum' ));
    }


    public function handlePaytmRequest( $order_id, $amount ) {
        // Load all functions of encdec_paytm.php and config-paytm.php
        $this->getAllEncdecFunc();
        $this->getConfigPaytmSettings();

        $checkSum = "";
        $paramList = array();

        ///if user have own paytem account
        $userPaytm = User::find(Auth::id());
        if($userPaytm){
          $paytmId = Crypt::decryptString($userPaytm->paytm_id);
          $paytmKey = Crypt::decryptString($userPaytm->paytm_key);
        }else{
          $paytmId = env('PAYTM_MERCHANT_ID');
          $paytmKey = env('PAYTM_MERCHANT_KEY');
        }

        // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = $paytmId;
        $paramList["ORDER_ID"] = $order_id;
        $paramList["CUST_ID"] = $order_id;
        $paramList["INDUSTRY_TYPE_ID"] = env('PAYTM_INDUSTRY_TYPE');
        $paramList["CHANNEL_ID"] = env('PAYTM_CHANNEL');
        $paramList["TXN_AMOUNT"] = $amount;
        $paramList["WEBSITE"] = env('PAYTM_MERCHANT_WEBSITE');
        $paramList["CALLBACK_URL"] = url( env('CALL_BACK_URL') );  //env('CALLBACK_URL');
        $paytm_merchant_key = $paytmKey;

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
        $userPaytm = User::find(Auth::id());
        if($userPaytm){
          $paytmId = Crypt::decryptString($userPaytm->paytm_id);
          $paytmKey = Crypt::decryptString($userPaytm->paytm_key);
        }else{
          $paytmId = env('PAYTM_MERCHANT_ID');
          $paytmKey = env('PAYTM_MERCHANT_KEY');
        }
        define('PAYTM_ENVIRONMENT', env('PAYTM_ENVIRONMENT')); // PROD
        define('PAYTM_MERCHANT_KEY', $paytmKey); //Change this constant's value with Merchant key downloaded from portal
        define('PAYTM_MERCHANT_MID', $paytmId); //Change this constant's value with MID (Merchant ID) received from Paytm
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

        if ( 'TXN_SUCCESS' === $request['STATUS'] ) {
                    $order = UserPayment::where( 'order_id', $order_id )->first();
                    $order->transaction_status = 'Success';
                    $order->transaction_id = $transaction_id;
                    $order->payment_method = $payment_method;
                    $order->bank_transaction_id = $bank_transaction_id;
                    $order->bank_name = $bank_name;
                    $order->transaction_date =  Carbon::now();
                    $order->created_at =  Carbon::now();
                    $order->save();

                    $invoice = Invoice::where('id',$order->invoice_id)->first();
                    if($amount == $invoice->net_amount){
                    	$statusUpdate['status'] = "PAID";
                    }else{
                    	$statusUpdate['status'] = "DEPOSIT_PAID";
                    }
                    $invoice->update($statusUpdate);

                    Toastr::success('Payment Success', 'Success', ["positionClass" => "toast-top-right"]);
                    return redirect()->to('/');
        } else if( 'TXN_FAILURE' === $request['STATUS'] ){
                $order = UserPayment::where( 'order_id', $order_id )->first();
                $order->transaction_status = 'Fields';
                $order->transaction_id = $transaction_id;
                $order->payment_method = $payment_method;
                $order->bank_transaction_id = $bank_transaction_id;
                $order->bank_name = $bank_name;
                $order->created_at =  Carbon::now();
                $order->save();
                return view('payment-failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserPayment  $UserPayment
     * @return \Illuminate\Http\Response
     */
    public function showPayment()
    {
    	$id = Auth::id();
        $payments = UserPayment::where('user_id',$id)->where('transaction_status','=','Success')->orderBy('created_at','desc')->paginate(10); //dd($payments);
        foreach ($payments as $payment) {
        	$invoice = Invoice::find($payment->invoice_id);
            if($invoice){
                $client = Clients::where('id',$invoice->client_id)->first();
                $client_first_name = $client ? $client->fname : '';
                $client_last_name = $client ? $client->lname : '';
                $payment->user = $client_first_name.' '.$client_last_name;
            }
        }
        return view('payment-list',['payments' =>$payments]);
    }

    public function showPaymentStatus($status)
    {
    	$id = Auth::id();
        $payments = UserPayment::where('user_id',$id)->where('transaction_status',$status)->orderBy('created_at','desc')->paginate(10); //dd($payments);
        foreach ($payments as $payment) {
        	$invoice = Invoice::find($payment->invoice_id);
            if($invoice){
                $client = Clients::where('id',$invoice->client_id)->first();
                $client_first_name = $client ? $client->fname : '';
                $client_last_name = $client ? $client->lname : '';
                $payment->user = $client_first_name.' '.$client_last_name;
            }
        }
        return view('payment-list',['payments' =>$payments]);
    }

        
}
