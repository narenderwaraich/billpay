<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use App\User;
use App\Clients;
use App\Invoice;
use App\InvoiceItem;
use App\UserInvoiceNotification;
use Mail;
use App\Mail\SendInvoice;
use App\Mail\InvoiceReminder;
use App\UserPayment;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Toastr;
use Redirect;
use PDF;
use Response;
use App\DeleteInvoice;
use File;
use ZipArchive;
use App\Item;
use App\UserPlan;
use App\InvoicePlan;
use App\UserInvoiceSetting;

class InvoiceController extends Controller
{
      public function addInvoice($clientId){
          if(Auth::check()){ //// check user login or not
            if(Auth::user()->role == 'user'){ //// check user admin or user
              if(!Auth::user()->verified == 'true'){ //// check user verified or not
                Toastr::error('Please first confirm your email to start using your Account!', 'Error', ["positionClass" => "toast-top-right"]);
                return back();
              }else{ //// end check user verified or not

                $userId = Auth::id();
                $user = User::find($userId);
                $client = Clients::find($clientId);
                $allItem = Item::where('user_id',$userId)->where('in_stock','=',1)->get();
                // if($userId === 1 || $userId === 2){ // special check for our user to skip payment
                //     return view('new-invoice',['client' => $client, 'allItem' => $allItem]);
                //   }
                $userPlan = UserPlan::where('user_id', $userId)->first();
                if($userPlan){
                  if(Auth::user()->company_name == ''){
                    Toastr::error('Please first update your company details!', 'Error', ["positionClass" => "toast-top-right"]);
                    return redirect()->to('/profile');
                  }

                  // get the current time
                $current = Carbon::now(); /// Now Date
                $nowDate = $current->toDateTimeString(); // change now date to string value
                $nowD = strtotime(str_replace('/', '-', $nowDate)); 
                
                $trialDate = $userPlan->expire_date;  // create time add trail 30 days date       
                //$trial = $trialDate->toDateTimeString();
                $trialD = strtotime(str_replace('/', '-', $trialDate));
                $packExpires = $trialD - $nowD; /// show total seconds 
                //dd($packExpires);

                $invoices = Invoice::where('user_id', $userId)->get();
                $invoicesCount = $invoices->count();

                $getInvoice = $userPlan->get_invoice;

                $bool = true;
                $message = "";

                    if($userPlan->is_activated){ /// Check User plan active or not Status 
                            if($packExpires <= 0){// if pack not ended ///1if
                                $message = 'Sorry your Package Date Expires';
                                $bool = false;                  
                            }else{
                                if($invoicesCount == $getInvoice){
                                    $bool = false;
                                    $message = 'Sorry first Activate Other Package in this pack add only '.$getInvoice.' invoices';
                                }else{ ///3f
                                    $bool = true; /// 3f  
                                }
                            } 
                      }else{
                          $bool = false;
                          $message = 'Sorry you have not any Invoice Plan';
                      }
     
                if($bool){
                      return view('new-invoice',['user' => $user,'client' => $client, 'allItem' => $allItem]);
                }else{
                      Toastr::error($message, 'Error', ["positionClass" => "toast-top-right"]);
                      return redirect()->to('/dashboard');
                }

                // end check
              
                }else{
                  Toastr::error('Please first choose any invoice plan!', 'Error', ["positionClass" => "toast-top-right"]);
                      return redirect()->to('/invoice/plans');
                }
                 
              }
            }else{ //// end check user admin or user
                return redirect()->to('/dashboard');
              } 
          }else{ //// end check user login or not
            return redirect()->to('/login');
          }
      }


    //// Send or Save Invoice data
      public function storeInvoice(Request $request){ 
    //dd(Input::all());
        $this->validate(request(),[
          'tax_rate'=>'required|string|max:16',
          'client_id'=>'required|string|max:50',
        ]);

        $invo = new Invoice();

        $userId = Auth::id(); 
        $lastInvoiceID = Invoice::where('user_id', $userId)->orderBy('id', 'DESC')->pluck('invoice_number')->first();
        //dd($lastInvoiceID);
        if($lastInvoiceID){
          $getNumber = explode('INV', $lastInvoiceID)[1];  
        //$newInvoiceID = 'INV000'.($getNumber + 1);
          $newInvoiceID = 'INV'.str_pad($getNumber + 1, 5, "0", STR_PAD_LEFT);  //dd($newInvoiceID);
            $newInvNumber = explode('INV', $newInvoiceID)[1]; //dd($checkNewNumber); 

        }else{
          $newInvoiceID = "INV00001";
          $newInvNumber = "";
        } 


        $data = request(['tax_rate','notes','terms','net_amount','client_id','discount','due_amount','sub_total','taxInFlat','disInFlat','disInPer','taxInPer','payment_mode']);


        $InvoiceNo = $newInvoiceID; 
        $str = $newInvoiceID;
        $invoiceToken = md5($str);
        $data['invoice_number_token']= $invoiceToken;
        $data['invoice_number']= $InvoiceNo;
        $data['user_id'] = Auth::id();
        $due = $request->due_date;
        $dueDate = Carbon::createFromFormat('m/d/Y', $due)->format('Y-m-d'); //dd($dueDate);
        $data['due_date'] = $dueDate;
        $isu = $request->issue_date; 
        $isuDate = Carbon::createFromFormat('m/d/Y', $isu)->format('Y-m-d');
        $data['issue_date'] = $isuDate;
        $data['created_at']= now();
        $data['updated_at']= now();

        if($request->deposit_amount){
          $data['deposit_amount'] = $request->deposit_amount;
        }else{
          $data['deposit_amount'] = 0;
        }
        $time = now(); 
        $invoice_id = DB::table('invoices')->insertGetId($data);

        foreach ($request->item_name as $key => $itm){

          $details = array('invoice_id'=>$invoice_id,
            'item_name'=>$itm,
            'rate'=>$request->rate [$key],
            'qty'=>$request->qty [$key],
            'total'=>$request->total [$key],
            'item_description'=>addslashes($request->item_description [$key]),
            'item_id'=>$request->item_id [$key],
            'created_at'=>$time,
            'updated_at'=>$time
          );


      InvoiceItem::insert($details);

    }

      Toastr::success('Invoice Add', 'Success', ["positionClass" => "toast-bottom-right"]);
      if($request->payment_mode == "Cash"){
        $route = "/invoice/cash/pay/".$invoice_id;
        return redirect()->to($route);
      }else{
        return redirect()->to('/invoice/view');
      }
    }


    public function editInvoices($id){
      if(Auth::check()){
        $userId = Auth::id();
        $user = User::find($userId);
        $inv = Invoice::find($id); //dd($inv);
        $invItem = InvoiceItem::where('invoice_id',$id)->get();
        $client = Clients::where('id', $inv->client_id)->first();
        $allItem = Item::where('in_stock','=',1)->get(); 
        return view('invoice-edit',compact('invItem','id'),['user' => $user,'client'=>$client, 'inv'=>$inv, 'allItem' => $allItem]);
      }else{
        return redirect()->to('/');
      }
    }


    //// Update Invoice Data

    public function updateInvoices(Request $request, $id){
      $this->validate(request(),[
        'client_id'=>'required',
      ]);
      $data = request(['tax_rate','deposit_amount','notes','terms','net_amount','discount','client_id','due_amount','sub_total','taxInFlat','disInFlat','disInPer','taxInPer','payment_mode']);
      $due = $request->due_date; 
      $dueDate = Carbon::createFromFormat('m/d/Y', $due)->format('Y-m-d');
      $data['due_date'] = $dueDate;
      $isu = $request->issue_date; 
      $isuDate = Carbon::createFromFormat('m/d/Y', $isu)->format('Y-m-d');
      $data['issue_date'] = $isuDate;
      $clientsId = ($request->client_id);
      $invoiceData = Invoice::find($id);
      $invNumber = $invoiceData->invoice_number;          
      if($invoiceData->invoice_number_token ==""){
        $invoiceToken = md5($invNumber);
        $data['invoice_number_token']= $invoiceToken;
      }
      if($request->deposit_amount){
        $data['deposit_amount'] = $request->deposit_amount;
      }else{
        $data['deposit_amount'] = 0;
      } 
    //dd($data);
      $check =  Invoice::where('id',$id)->update($data);

      if($request->delete_id){
        $ids = $request->delete_id;
        $itemIds = explode(",",$ids);
        DB::table("invoice_items")->whereIn('id',$itemIds)->where('invoice_id', $id)->delete();
      }


    /// Add New Items
      if($request->item_name){
        $time = now();
        foreach ($request->item_name as $key => $itm){

          $details = array('invoice_id'=>$id,
            'item_name'=>$itm,
            'rate'=>$request->rate [$key],
            'qty'=>$request->qty [$key],
            'total'=>$request->total [$key],
            'item_description'=>addslashes($request->item_description [$key]),
            'item_id'=>$request->item_id [$key],
            'created_at'=>$time,
            'updated_at'=>$time
          );


          InvoiceItem::insert($details);
        }

      }


    //// Invoices Item Data Update
      if($request->arr){
        foreach($request->arr as $item){
          if(isset($item['item_id'])){
            InvoiceItem::where('id',(int)$item['item_id'])->update(['item_name'=>$item['item_name'],'qty'=>(float)$item['qty'],'rate'=>(float)$item['rate'],'total'=>(float)$item['total'],'item_description'=>$item['item_description'],'invoice_id'=>(int)$item['invoice_id']]);
          }else{

            $invdata = InvoiceItem::create($item);      
          }
        }
      }

      Toastr::success('Invoice Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
      if($request->payment_mode == "Cash"){
        $route = "/invoice/cash/pay/".$id;
        return redirect()->to($route);
      }else{
        return redirect()->to('/invoice/view');
      }

    }


    public function invoiceView($id){
      if(Auth::check()){
          $inv = Invoice::find($id); //dd($inv);
          $invItem = $inv->invoiceItems; /// Relation with invoice has many function
          $client = Clients::where('id',$inv->client_id)->first(); //dd($client);
      return view('invoice-view',['invItem' => $invItem, 'inv' => $inv, 'client' => $client]);
      }else{
        return redirect()->to('/');
      }
    }

    public function viewAndPay($id,$invoice_number_token){
      $inv = Invoice::findOrFail($id);
      if($inv->is_deleted ==0){
        $token = $inv->invoice_number_token; 
        if($token != $invoice_number_token){
          Toastr::error('Sorry link not exists!', 'Error', ["positionClass" => "toast-top-right"]);
          return back();
        }
        $invItem = $inv->invoiceItems;
    $client = Clients::where('id',$inv->client_id)->first(); //dd($client);
    if($inv->is_deleted ==0){
      return view('view-and-pay',['client' => $client, 'invItem' => $invItem, 'inv' => $inv]);
    }else{
      Toastr::error('Sorry link not exists!', 'Error', ["positionClass" => "toast-top-right"]);
      return redirect()->to('/');
    }
    }else{
      Toastr::error('Sorry link not exists!', 'Error', ["positionClass" => "toast-top-right"]);
      return redirect()->to('/');
    }


    }

    public function showInvoiceList(){
      $id = Auth::id();
    //$invoices = User::find($id)->invoices; 
    $invoices = Invoice::with('user')->where('user_id', $id)->where('is_deleted','=',0)->latest()->paginate(10); //dd($invoices);
    return view ('show-invoice',compact('invoices')); 
    }


    /// Send Invoice in mail 
    public function SendInvoiceMail(Request $request, $id){
      $inv = Invoice::find($id);
      $userId = $inv->user_id;
      $mail = ($request->email);
      $other_mails = ($request->additional_email);
      if($request->additional_email){
        $allMail = array($mail, $other_mails);
      }else{
        $allMail = $mail;
      }

      $invItem = $inv->invoiceItems; 
      $maill = Mail::to($allMail)->send(new SendInvoice($invItem, $inv));
      if($inv->status =="DRAFT"){
        $status['status'] = "SENT";
        $chk =  Invoice::where('id',$id)->update($status);
      }
      return response()->json(['success'=>"Mail Sent successfully."]);

    } 

    public function SendInvoiceReminder(Request $request, $id){
      $inv = Invoice::find($id);
      $userId = $inv->user_id;
      $mail = ($request->email);
      $other_mails = ($request->additional_email);
      if($request->additional_email){
        $allMail = array($mail, $other_mails);
      }else{
        $allMail = $mail;
      }
    // first check status OVERDUE 
      if($inv->status =="OVERDUE"){
        $invItem = $inv->invoiceItems;
    /// Days get old overdue 
        $dueDate = Carbon::parse($inv->due_date);
        $nowDate = Carbon::now();
        $day =  $nowDate->diffInDays($dueDate);
        Mail::to($allMail)->send(new InvoiceReminder($invItem, $inv, $day));
        return response()->json(['success'=>"Mail Sent successfully."]);
      }else{

        return response()->json();
      }



    }

    /// Copy invoice data

    public function copyData($id){
    //dd($id);
      if(Auth::check()){
          $userId = Auth::id();
          $userPlan = UserPlan::where('user_id', $userId)->first();
             // get the current time
                $current = Carbon::now(); /// Now Date
                $nowDate = $current->toDateTimeString(); // change now date to string value
                $nowD = strtotime(str_replace('/', '-', $nowDate)); 
                
                $trialDate = $userPlan->expire_date;  // create time add trail 30 days date       
                //$trial = $trialDate->toDateTimeString();
                $trialD = strtotime(str_replace('/', '-', $trialDate));
                $packExpires = $trialD - $nowD; /// show total seconds 
                //dd($packExpires);

                $invoices = Invoice::where('user_id', $userId)->get();
                $invoicesCount = $invoices->count();

                $getInvoice = $userPlan->get_invoice;

                $bool = true;
                $message = "";

                    if($userPlan->is_activated){ /// Check User plan active or not Status 
                            if($packExpires <= 0){// if pack not ended ///1if
                                $message = 'Sorry your Package Date Expires';
                                $bool = false;                  
                            }else{
                                if($invoicesCount == $getInvoice){
                                    $bool = false;
                                    $message = 'Sorry first Activate Other Package in this pack add only '.$getInvoice.' invoices';
                                }else{ ///3f
                                    $bool = true; /// 3f  
                                }
                            } 
                      }else{
                          $bool = false;
                          $message = 'Sorry you have not any Invoice Plan';
                      }
                
          if($bool){
                $inv = Invoice::find($id); 
              $userId = $inv->user_id;
              $invItem = $inv->invoiceItems;
              $invo = new Invoice();

              $lastInvoiceID = Invoice::where('user_id', $userId)->orderBy('id', 'DESC')->pluck('invoice_number')->first(); 
              $getNumber = explode('INV', $lastInvoiceID)[1];  
              $newInvoiceID = 'INV'.str_pad($getNumber + 1, 5, "0", STR_PAD_LEFT);

              $data['tax_rate'] = $inv->tax_rate;
              $data['notes'] = $inv->notes;
              $data['terms'] = $inv->terms;
              $data['net_amount'] = $inv->net_amount;
              $data['client_id'] = $inv->client_id;
              $data['discount'] = $inv->discount;
              $data['due_amount'] = $inv->net_amount;
              $data['sub_total'] = $inv->sub_total;
              $data['payment_mode'] = $inv->payment_mode;
              $str = $newInvoiceID;
              $invoiceToken = md5($str);
              $data['invoice_number_token']= $invoiceToken;
              $data['invoice_number']= $newInvoiceID; 
              $data['user_id'] = $inv->user_id;
              $dueDate = now()->addDays(7);
              $data['due_date'] = $dueDate->format('Y-m-d');
              $data['issue_date'] = now()->format('Y-m-d'); 
          // $data['status'] = $inv->status;
              $data['payment_date'] = $inv->payment_date;
              $data['created_at']= now();
              $data['updated_at']= now();
              $data['deposit_amount'] = $inv->deposit_amount;
              $data['disInPer']= $inv->disInPer; 
              $data['taxInPer']= $inv->taxInPer;
              $data['disInFlat']= $inv->disInFlat;
              $data['taxInFlat']= $inv->taxInFlat;

          //dd($data);
              $time = now(); 
              $invoice_id = DB::table('invoices')->insertGetId($data);


              foreach ($invItem as  $itm){

                $details = array('invoice_id'=>$invoice_id,
                  'item_name'=>$itm->item_name,
                  'rate'=>$itm->rate,
                  'qty'=>$itm->qty,
                  'total'=>$itm->total,
                  'item_description'=>addslashes($itm->item_description),
                  'item_id'=>$itm->item_id,
                  'created_at'=>$time,
                  'updated_at'=>$time
                );


                InvoiceItem::insert($details);
              }
              Toastr::success('Invoice Copy', 'Success', ["positionClass" => "toast-bottom-right"]);
              return redirect()->to('/invoice/view');
          }else{
                Toastr::error($message, 'Error', ["positionClass" => "toast-top-right"]);
                return redirect()->to('/dashboard');
          }

          // end check
      }else{
        return redirect()->to('/');
      }

    }

    /// Download PDF file
    public function downloadPDF($id,$invoice_number_token){
      $inv = Invoice::findOrFail($id);
      if($inv->is_deleted ==0){
        $token = $inv->invoice_number_token; 
        if($token != $invoice_number_token){
          Toastr::error('Sorry link not exists!', 'Error', ["positionClass" => "toast-top-right"]);
          return back();
        }
        $invItem = $inv->invoiceItems;
    //return view('invoice-pdf', ['invItem' => $invItem, 'inv' => $inv]);
    //exit();
        $invDate = $inv->created_at;
        $invoiceDate = $invDate->format('mdY');
        $invNumber = $inv->invoice_number;

        ///invoice pdf setting
        $userInvoiceSetting = UserInvoiceSetting::where('user_id',$inv->user_id)->first();
        $printPaper = $userInvoiceSetting ? $userInvoiceSetting->setPaper : 'A4';

        $pdf = PDF::loadView('invoice-pdf', ['userInvoiceSetting' => $userInvoiceSetting,'invItem' => $invItem, 'inv' => $inv])->setPaper($printPaper);
    //return $pdf->stream();
    //exit();
        return $pdf->download($invNumber.'-'.$invoiceDate.'.pdf');

      }else{
        Toastr::error('Sorry link not exists!', 'Error', ["positionClass" => "toast-top-right"]);
        return redirect()->to('/');
      }

    }


        /// print html view PDF file
    public function printHTMLPagePDF($id,$invoice_number_token){
      $inv = Invoice::findOrFail($id);
      if($inv->is_deleted ==0){
        $token = $inv->invoice_number_token; 
        if($token != $invoice_number_token){
          Toastr::error('Sorry link not exists!', 'Error', ["positionClass" => "toast-top-right"]);
          return back();
        }
        $invItem = $inv->invoiceItems;
    //return view('invoice-pdf', ['invItem' => $invItem, 'inv' => $inv]);
    //exit();
        $invDate = $inv->created_at;
        $invoiceDate = $invDate->format('mdY');
        $invNumber = $inv->invoice_number;

        ///invoice pdf setting
        $userInvoiceSetting = UserInvoiceSetting::where('user_id',$inv->user_id)->first();
        $printPaper = $userInvoiceSetting ? $userInvoiceSetting->setPaper : 'A4';

        return view('invoice-pdf', ['userInvoiceSetting' => $userInvoiceSetting,'invItem' => $invItem, 'inv' => $inv]);

      }else{
        Toastr::error('Sorry link not exists!', 'Error', ["positionClass" => "toast-top-right"]);
        return redirect()->to('/');
      }

    }   


    /// print PDF file
    public function printPDF($id,$invoice_number_token){
      $inv = Invoice::findOrFail($id);
      if($inv->is_deleted ==0){
        $token = $inv->invoice_number_token; 
        if($token != $invoice_number_token){
          Toastr::error('Sorry link not exists!', 'Error', ["positionClass" => "toast-top-right"]);
          return back();
        }
        $invItem = $inv->invoiceItems;
    //return view('invoice-pdf', ['invItem' => $invItem, 'inv' => $inv]);
    //exit();
        $invDate = $inv->created_at;
        $invoiceDate = $invDate->format('mdY');
        $invNumber = $inv->invoice_number;

        ///invoice pdf setting
        $userInvoiceSetting = UserInvoiceSetting::where('user_id',$inv->user_id)->first();
        $printPaper = $userInvoiceSetting ? $userInvoiceSetting->setPaper : 'A4';

        $pdf = PDF::loadView('invoice-pdf', ['userInvoiceSetting' => $userInvoiceSetting,'invItem' => $invItem, 'inv' => $inv])->setPaper($printPaper);
        return $pdf->stream();
        exit();
    //return $pdf->download($invNumber.'-'.$invoiceDate.'.pdf');

      }else{
        Toastr::error('Sorry link not exists!', 'Error', ["positionClass" => "toast-top-right"]);
        return redirect()->to('/');
      }

    }  

    /// Download PDF file by multi 
    // public function downloadPDFfile($id,$invoice_number_token){
    //      $inv = Invoice::findOrFail($id);
    //      $invItem = $inv->invoiceItems;
    //      $invDate = $inv->created_at;
    //      $invoiceDate = $invDate->format('mdY');
    //      $invNumber = $inv->invoice_number;
    //       $pdf = PDF::loadView('invoice-pdf', ['invItem' => $invItem, 'inv' => $inv])->setPaper('A4');
    //      return $pdf->download($invNumber.'-'.$invoiceDate.'.pdf');
    //   }


    /// Download PDF file
    public function downloadMultiPDF(Request $request){
      $ids = $request->ids; 
      $id = explode(",",$ids); 
    $invoices = Invoice::whereIn('id',$id)->get(); //dd($invoices);

    foreach ($invoices as $invoice) {
      $inv = Invoice::where('id',$invoice->id)->first();
      $invItem = $inv->invoiceItems;
      $invDate = $inv->created_at;
      $invoiceDate = $invDate->format('mdY');
      $invNumber = $inv->invoice_number;

      ///invoice pdf setting
      $userInvoiceSetting = UserInvoiceSetting::where('user_id',$inv->user_id)->first();
      $printPaper = $userInvoiceSetting ? $userInvoiceSetting->setPaper : 'A4';

      $pdf = PDF::loadView('invoice-pdf', ['userInvoiceSetting' => $userInvoiceSetting,'invItem' => $invItem, 'inv' => $inv])->setPaper($printPaper);

    // If you want to store the generated pdf to the server then you can use the store function
      $pdf_name = $invNumber.'-'.$invoiceDate.'.pdf';
      $path = public_path('pdf/file/' . $pdf_name);
      $pdf->save($path);
    // Finally, you can download the file using download function
    // return $pdf->download($invNumber.'-'.$invoiceDate.'.pdf');
    }
    $userID = Auth::id(); 
    $fileNewName = $this->zip_file_name($userID);
    $fileName = $fileNewName.'.zip';
    $files = File::files(public_path('pdf/file'));
    $res = $this->downloadZip($fileName,$files);
    if($res){
      return response()->json(['success' => $fileName]);
    }else{
      return response()->json(['error'=>"Invoice zip not created"]);
    }
    }

    function zip_file_name($userID){ 
    $time = time(); //dd($time);
    $name = "INVOICES_".$time.$userID; //dd($name);
    return $name; 
    } 

    public function downloadZip($fileName,$files){
    $zip = new ZipArchive; //dd($zip);

    if ($zip->open(public_path('zip/'.$fileName), ZipArchive::CREATE) === TRUE)
    {
      foreach ($files as $key => $value) {
        $relativeNameInZipFile = basename($value);
        $zip->addFile($value, $relativeNameInZipFile);
      }

      $zip->close();
    }
    //File::deleteDirectory(public_path('pdf/file/'));
    $file = new Filesystem;
    $file->cleanDirectory('pdf/file');
    //return response()->download(public_path($fileName));
    return $fileName;

    }
    ///download zip file
    public function downloadZipFile($fileName){
      return response()->download(public_path('zip/'.$fileName.'.zip'));
    }
    /// remove zip file
    function unlink_on_shutdown($fileName) {
    $filepath = public_path('zip/'.$fileName); //dd($filepath); 
    register_shutdown_function(function($filepath) {
      if (file_exists($filepath)) { @unlink($filepath); } 
    }, $filepath);
    return redirect()->to('/dashboard');
    }


    public function whatsappPDF($id){
        $inv = Invoice::find($id); 
        // $client = Clients::find($inv->client_id);
        $whatsappNumber = $inv->client->phone;
        if($whatsappNumber){
          //$message = "Hi".' '.$inv->client->fname.' '.$inv->client->lname.' '; 
          $message =$inv->user->fname.' '.$inv->user->lname.' '.$inv->user->company_name.' '.'sent you an invoice ('.$inv->invoice_number.') for'.' ';
          if($inv->status =="CASH"){
            $amount = 0;
          }else{
            if($inv->status =="OVERDUE" && $inv->net_amount != $inv->due_amount){
              $amount = $inv->due_amount;
            }elseif ((!empty($inv->deposit_amount))&& $inv->status !="DEPOSIT_PAID") {
              $amount = $inv->deposit_amount;
            }else{
              $amount = $inv->due_amount;
            }        
          }
          $message .='Rs'.'.'.$amount.' '."that's due on".' '.date('m/d/Y', strtotime($inv->due_date)).'.';
          $num = "+91".$whatsappNumber;
          $whatsappLink = "https://wa.me/".$num."/?text=".$message;

        return redirect($whatsappLink);
        }else{
          Toastr::error('Sorry number not exists!', 'Error', ["positionClass" => "toast-top-right"]);
          return back();
        }
        
    }
    // public function removeZipFile(){
    //         // $file = new Filesystem; dd(File::isDirectory('zip'));
    //         // $file->cleanDirectory('zip');
    //         // Toastr::success('All invoice zip file removed', 'Success', ["positionClass" => "toast-bottom-right"]);
    //         // return redirect()->to('/dashboard');

    //   $path = public_path('zip'); //dd(opendir($path));
    //     if ($handle = opendir($path)) {

    //       while (false !== ($file = readdir($handle))) {
    //         echo time()."<br>";
    //          echo filectime($path.'/'.$file);
    //          exit();
    //           if ((time()-filectime($path.'/'.$file)) > 60) {  // 86400 = 60*60*24
    //             // if (preg_match('/\.txt$/i', $file)) {
    //             //   unlink($path.'/'.$file);
    //             // }
    //             $file = new Filesystem;
    //             $file->cleanDirectory('zip');
    //           }
    //       }
    //     }
    // }  

    public function cancelInvoice($id){
      $inv = Invoice::find($id);
      $status = $inv->status;
      if ($status =="PAID") {
        $data['is_cancelled'] = 1;
      }
      if ($status =="OVERDUE" && $inv->net_amount != $inv->due_amount) {
        $data['is_cancelled'] = 2;
      }
      if ($status =="DEPOSIT_PAID") {
        $data['is_cancelled'] = 2;
      }
      $data['refund_date'] = now()->format('Y-m-d');
      $data['status'] = "CANCEL";
      Invoice::where('id',$id)->update($data);
      Toastr::success('Cancel Invoice', 'Success', ["positionClass" => "toast-bottom-right"]);
      return back(); 
    }

     public function billTimeCancelInvoice($id){
      $inv = Invoice::find($id);
      $data['status'] = "CANCEL";
      Invoice::where('id',$id)->update($data);
      Toastr::success('Cancel Invoice', 'Success', ["positionClass" => "toast-bottom-right"]);
      return redirect()->to('/dashboard'); 
    }


    /// destroy invoice item 
    public function destroy(Request $request){
      if(isset($request->id)){
        $item = InvoiceItem::destroy($request->id);

        return response()->json(['success' => 'Invoice Item Deleted!']);
      }
    }
    /// destroy Invoices
    public function deleteInvoices(Request $request){
      $ids = $request->ids;
      $id = explode(",",$ids);
      $invoices =  Invoice::whereIn('id',$id)->get();
    // return json_encode($invoices);
      $invoiceIds = [];
      foreach ($invoices as $invoice) {
        $chkStatus = $invoice->status;
        if($chkStatus == "PAID" || $chkStatus == "DEPOSIT_PAID" || ($invoice->net_amount != $invoice->due_amount) || $chkStatus == "CANCEL"){
          array_push($invoiceIds, $invoice->invoice_number);
        }else{
          DB::table("invoice_items")->where('invoice_id',$invoice->id)->delete();
          DB::table("invoices")->where('id',$invoice->id)->delete(); 
        }
      }
      if(count($invoiceIds)){
        $errorTxt = "invoice cannot be deleted because it has been paid";
        $errorTxt =  count($invoiceIds) > 1 ? 'invoices cannot be deleted because these invoices have been paid' : $errorTxt;

        $invs = implode(", ", $invoiceIds) . " $errorTxt";
        return response()->json(['error' => $invs]);
      }else{
        return response()->json(['success' => "Invoice Deleted"]);
      }
    }

    /// destroy Invoices in view
    public function deleteInvoicesData($id){
      $invoices =  Invoice::where('id',$id)->get();
      $invoiceIds = [];
      foreach ($invoices as $invoice) {
        $chkStatus = $invoice->status;
        if($chkStatus == "PAID" || $chkStatus == "DEPOSIT_PAID" || ($chkStatus == "OVERDUE" && $invoice->net_amount != $invoice->due_amount) || $chkStatus == "CANCEL"){
          array_push($invoiceIds, $invoice->invoice_number);
        }else{
          DB::table("invoice_items")->where('invoice_id',$invoice->id)->delete();
          DB::table("invoices")->where('id',$invoice->id)->delete(); 
        }
      }
      if(count($invoiceIds)){
        $errorTxt = "invoice cannot be deleted because it has been paid";
        $errorTxt =  count($invoiceIds) > 1 ? 'invoices cannot be deleted because these invoices have been paid' : $errorTxt;

        Toastr::error($errorTxt, 'Error', ["positionClass" => "toast-top-right"]);
        return back();
      }else{
        Toastr::success('Invoice Deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/invoice/view'); 
      }
    }

    public function markInvoices(Request $request){
      $ids = $request->ids;
      $id = explode(",",$ids);
      $chkData =  Invoice::where('id',$id)->first();
      $chkStatus = $chkData->status;
      if($chkStatus == "DRAFT"){
        $status['status'] = "SENT";
        $chk =  Invoice::whereIn('id',$id)->update($status);
        return response()->json(['success'=>"Invoice Mark as Sent"]);
      }else{
        return response()->json(['error'=>"Invoice Mark as not Sent"]);
    }   //('status', '=', 'DRAFT');
    //DB::table("invoices")->whereIn('id',$id)->update();

    }

    ///// invoice mark deposit paid
    public function depositPaid(Request $request){
      $ids = $request->ids;
      $id = explode(",",$ids);
      $chkData =  Invoice::where('id',$id)->first();
      $chkStatus = $chkData->status;
    $pay = $chkData->deposit_amount; // pay amount
    $totalAmount = $chkData->due_amount; /// total amount 
    $pending = $totalAmount - $pay; // total - pay
    if($chkStatus != "PAID"){
      $status['status'] = "DEPOSIT_PAID";
      $status['deposit_date'] = Carbon::now();
      $status['payment_date'] = Carbon::now();
      $status['due_amount'] = $pending;
      $chk =  Invoice::whereIn('id',$id)->update($status);
      return response()->json(['success'=>"Mark Offline Deposit successfully"]);
    }else{
      return response()->json(['error'=>"Sorry Invoice Mark as not Offline Deposit"]);
    }  

    }


    ///// invoice mark Stripe Paid
    public function markOnlinePaid(Request $request){
      $ids = $request->ids;
      $id = explode(",",$ids);
      $chkData =  Invoice::where('id',$id)->first();
      if($chkData){
    /// check first any deposit pending
    $depositAmount = $chkData->deposit_amount; // pay amount
    if($depositAmount > 0 && $chkData->net_amount == $chkData->due_amount){
    $totalAmount = $chkData->due_amount; /// total amount 
    $pending = $totalAmount - $depositAmount; // total - pay
    $status['status'] = "DEPOSIT_PAID";
    $status['deposit_date'] = Carbon::now();
    $status['payment_date'] = Carbon::now();
    $status['due_amount'] = $pending;
    $status['payment_mode'] = "PAID";
    }else{
      $status['status'] = "PAID";
      $status['payment_date'] = Carbon::now();
      $status['due_amount'] = 0;
      $status['payment_mode'] = "PAID";
    }
    $chk =  Invoice::whereIn('id',$id)->update($status);
    return response()->json(['success'=>"Mark Online Paid successfully"]);
    }else{
      return response()->json(['error'=>"Sorry Invoice Mark as not Online Paid"]);
    } 

    }



    ///// invoice mark Cash Paid
    public function markCashPaid(Request $request){
      $ids = $request->ids;
      $id = explode(",",$ids);
      $invoice = Invoice::where('id',$id)->first();
      if($invoice->deposit_amount > 0){
        $amount = $invoice->deposit_amount;
      }else{
        $amount = $invoice->net_amount;
      }

    /// Update status

      $ids = $request->ids;
      $id = explode(",",$ids);
      $chkData =  Invoice::where('id',$id)->first();
      if($chkData){
    /// check first any deposit pending
    $depositAmount = $chkData->deposit_amount; // pay amount
    if($depositAmount > 0 && $chkData->net_amount == $chkData->due_amount){
    $totalAmount = $chkData->due_amount; /// total amount 
    $pending = $totalAmount - $depositAmount; // total - pay
    $status['status'] = "DEPOSIT_PAID";
    $status['deposit_date'] = Carbon::now();
    $status['payment_date'] = Carbon::now();
    $status['due_amount'] = $pending;
    $status['payment_mode'] = "CASH";

    $order_id = uniqid();
    $order = new UserPayment();
    $order->order_id = $order_id;
    $order->transaction_date = Carbon::now();
    $order->payment_method = "Cash";
    $order->transaction_status = 'Success';
    $order->amount = $depositAmount;
    $order->transaction_id = '';
    $order->invoice_id = $chkData->id;
    $order->user_id = $chkData->user_id;
    $order->created_at =  Carbon::now();
    $order->save();
    }else{
      $status['status'] = "CASH";
      $status['payment_date'] = Carbon::now();
      $status['due_amount'] = 0;
      $status['payment_mode'] = "CASH";

      $order_id = uniqid();
      $order = new UserPayment();
      $order->order_id = $order_id;
      $order->transaction_date = Carbon::now();
      $order->payment_method = "Cash";
      $order->transaction_status = 'Success';
      $order->amount = $chkData->net_amount;
      $order->transaction_id = '';
      $order->invoice_id = $chkData->id;
      $order->user_id = $chkData->user_id;
      $order->created_at =  Carbon::now();
      $order->save();
    }
    $chk =  Invoice::whereIn('id',$id)->update($status);
    return response()->json(['success'=>"Mark Cash Paid successfully"]);
    }else{
      return response()->json(['error'=>"Sorry Invoice Mark as not Cash Paid"]);
    } 

    }




    public function SearchData(Request $request){
      $id = Auth::id();
      $q = Input::get ( 'q' );
      $CountName = str_word_count($q);
      if($request->start){
        $s = $request->start; 
        $start = Carbon::createFromFormat('m/d/Y', $s)->format('Y-m-d 00:00:00');
        if($request->end){
          $e = $request->end;
          $end = Carbon::createFromFormat('m/d/Y', $e)->format('Y-m-d 00:00:00');
        }else{
          $end = Carbon::now();
        } 
    if($CountName > 1){ // if find full name run this
      $fname = explode(' ', $q)[0];
      $lname = explode(' ', $q)[1];
      $clientFind =  Clients::where('user_id',$id)
      ->where('fname', 'like', '%'.$fname.'%')
      ->where('lname', 'like', '%'.$lname.'%')
      ->pluck('id');
    }else{ /// single name search 
      $clientFind =  Clients::where('user_id',$id)
      ->where('fname', 'like', '%'.$q.'%')
      ->pluck('id');
    if(count($clientFind) <= 0){ /// if not found first name
      $clientFind =  Clients::where('user_id',$id)
      ->where('lname', 'like', '%'.$q.'%')
      ->pluck('id');
    }
    }
    $invoices =  Invoice::where('user_id',$id)->whereIn('client_id',$clientFind)->where('created_at', '>=',$start)->where('created_at', '<=', $end)->where('is_deleted','=',0)->latest()->paginate(10)->setPath ( '' );
    $pagination = $invoices->appends ( array (
      'q' => Input::get ( 'q' ), "fromDate" => Input::get('start') 
    ) );

    if (count ( $invoices ) > 0){ 
      $total_row = $invoices->count();
      return view ('show-invoice',compact('total_row'))->withInvoices( $invoices )->withQuery ( $q )->withQuery ( $q )->withMessage ($total_row.' '. 'Invoice found match your search');
    }else{/// Search invoive by status with date
      $invoices =  Invoice::where('user_id',$id)->where('status', 'like', '%'.$q.'%')->where('created_at', '>=',$start)->where('created_at', '<=', $end)->where('is_deleted','=',0)->latest()->paginate(10)->setPath ( '' );
      $pagination = $invoices->appends ( array (
        'q' => Input::get ( 'q' ), "fromDate" => Input::get('start')
      ) );

      if (count ( $invoices ) > 0){ 
        $total_row = $invoices->count();
        return view ('show-invoice',compact('total_row'))->withInvoices( $invoices )->withQuery ( $q )->withMessage ($total_row.' '. 'Invoice found match your search');
      }else{ 
        return view ('show-invoice')->withMessage ( 'Invoice not found match Your search !' );
      }
    } 
    // end search invoice by date      
    }else{
    if($CountName > 1){ // if find full name run this
      $fname = explode(' ', $q)[0];
      $lname = explode(' ', $q)[1];
      $clientFind =  Clients::where('user_id',$id)
      ->where('fname', 'like', '%'.$fname.'%')
      ->where('lname', 'like', '%'.$lname.'%')
      ->pluck('id');
    }else{ /// single name search 
      $clientFind =  Clients::where('user_id',$id)
      ->where('fname', 'like', '%'.$q.'%')
      ->pluck('id');
    if(count($clientFind) <= 0){ /// if not found first name
      $clientFind =  Clients::where('user_id',$id)
      ->where('lname', 'like', '%'.$q.'%')
      ->pluck('id');
    }
    } 
    if(count($clientFind) <= 0){
      $invoices =  Invoice::where('user_id',$id)
      ->where('invoice_number', 'like', '%'.$q.'%')
      ->where('is_deleted','=',0)
      ->orderBy('created_at', 'desc')
      ->paginate(10)->setPath ( '' );
      $pagination = $invoices->appends ( array (
        'q' => Input::get ( 'q' ) 
      ) );

      if (count ( $invoices ) > 0){ 
        $total_row = $invoices->count();
        return view ('show-invoice',compact('total_row'))->withInvoices( $invoices )->withQuery ( $q )->withQuery ( $q )->withMessage ($total_row.' '. 'Invoice found match your search');
      }else{
    // Search by invoice Status
        $invoices =  Invoice::where('user_id',$id)
        ->where('status', 'like', '%'.$q.'%')
        ->where('is_deleted','=',0)
        ->orderBy('created_at', 'desc')
        ->paginate(10)->setPath ( '' );
        $pagination = $invoices->appends ( array (
          'q' => Input::get ( 'q' )
        ) );

        if (count ( $invoices ) > 0){ 
          $total_row = $invoices->count();
          return view ('show-invoice',compact('total_row'))->withInvoices( $invoices )->withQuery ( $q )->withMessage ($total_row.' '. 'Invoice found match your search');
    }else{ // end search by invoice status
      return view ('show-invoice')->withMessage ( 'Invoice not found match Your search !' );
    } 
    }
    }else{
      $invoices =  Invoice::where('user_id',$id)->whereIn('client_id',$clientFind)->where('is_deleted','=',0)->latest()->paginate(10)->setPath ( '' );
      $pagination = $invoices->appends ( array (
        'q' => Input::get ( 'q' ) 
      ) );

      if (count ( $invoices ) > 0){ 
        $total_row = $invoices->count();
        return view ('show-invoice',compact('total_row'))->withInvoices( $invoices )->withQuery ( $q )->withQuery ( $q )->withMessage ($total_row.' '. 'Invoice found match your search');
      }else{ 
        return view ('show-invoice')->withMessage ( 'Invoice not found match Your search !' );
      }
    }
    }        

    } 



                            /// Search invoice

        //                     public function SearchInvData(Request $request){
        //                         $output = '';
        //                         $query = $request->get('query');
        //                         if($query != '')
        //                         {
        //                           $clientsFind = Clients::where('fname','LIKE','%'.$query.'%')->orWhere('lname', 'like', '%'.$query.'%')->pluck('id');
        //                            $id = Auth::id();
        //                           if(count($clientsFind) <= 0){
        //                                   $data =  Invoice::where('user_id',$id)
        //                                    ->where('invoice_number', 'like', '%'.$query.'%')
        //                                    ->orderBy('client_id', 'desc')
        //                                    ->get();
        //                               }else{
        //                                   $data = Invoice::where('user_id',$id)->whereIn('client_id',$clientsFind)->get();
        //                               }        
        //                         }
        //                         else
        //                         {
        //                          $data = DB::table('invoices')
        //                            ->orderBy('client_id', 'desc')
        //                            ->get();
        //                         }
        //                         $total_row = $data->count();
        //                         if($total_row > 0)
        //                         {
        //                          foreach($data as $row)
        //                          {
        //                           $clintData = Clients::select('fname','lname','email')->where('id', $row->client_id)->first();
        //                           $row->clientFname = $clintData->fname;
        //                           $row->clientLname = $clintData->lname;
        //                           $row->clientEmail = $clintData->email;
        //                           $output .= '
        //                           <tr id="tr_'.$row->id.'">
        //                            <td scope="row" class="td-inv-name"><input type="checkbox" class="sub_chk" data-id='.$row->id.' email-id='.$row->clientEmail.'>&nbsp<a href="/inv-view/'.$row->id.'">'.$row->clientFname. '&nbsp' .$row->clientLname.  '<br>
        //                            <span class="td-inv-no">'.$row->invoice_number.'</span></a></td>
        //                            <td class="td-inv-name">'.$row->created_at->format('d/m/Y').'</td>
        //                            <td class="td-inv-name">'.date('d/m/Y', strtotime($row->due_date)).'</td>
        //                            <td class="status_'.$row->status.'">'.$row->status.'</td>
        //                            <td class="td-inv-name">'.$row->net_amount.'</td>
                                   
                                   
        //                           </tr>
        //                           ';
                                  
        //                          }
        //                         }
        //                         else
        //                         {
        //                          $output = '
        //                          <tr>
        //                           <td align="center" colspan="5">No Data Found</td>
        //                          </tr>
        //                          ';
        //                         }
        //                         $data = array(
        //                          'table_data'  => $output,
        //                          'total_data'  => $total_row
        //                         );

        //                         echo json_encode($data);
        // }
         


}