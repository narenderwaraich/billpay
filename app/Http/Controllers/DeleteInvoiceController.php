<?php

namespace App\Http\Controllers;

use App\DeleteInvoice;
use App\DeleteInvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Clients;
use App\UserCompany;
use App\Invoice;
use App\InvoiceItem;
use Carbon\Carbon;
use Toastr;
use Redirect;

class DeleteInvoiceController extends Controller
{
      /// destroy Invoices in view
    public function deleteInvoicesData($id){
            $invoices =  Invoice::where('id',$id)->get();
            $invoiceIds = [];
            foreach ($invoices as $invoice) {
              $chkStatus = $invoice->status;
              if($chkStatus == "PAID-STRIPE" || $chkStatus == "DEPOSIT_PAID" || ($chkStatus == "OVERDUE" && $invoice->net_amount != $invoice->due_amount)){
                array_push($invoiceIds, $invoice->invoice_number);
                // return response()->json(['error'=>"Invoice can not Deleted"]);
              }else{
                    $delInvoiceId = $invoice->id;
                 $res = $this->destroyInvoiceStore($delInvoiceId);
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyInvoiceStore($delInvoiceId)
    {
          $inv = Invoice::find($delInvoiceId); 
          $userId = $inv->user_id;
          $invItem = InvoiceItem::where('invoice_id',$delInvoiceId)->get();
          $invo = new Invoice();

              $data['invoice_id'] = $delInvoiceId;
              $data['tax_rate'] = $inv->tax_rate;
              $data['notes'] = $inv->notes;
              $data['terms'] = $inv->terms;
              $data['net_amount'] = $inv->net_amount;
              $data['client_id'] = $inv->client_id;
              $data['discount'] = $inv->discount;
              $data['due_amount'] = $inv->due_amount;
              $data['sub_total'] = $inv->sub_total;
              $data['companies_id'] = $inv->companies_id;
              $data['invoice_number_token']= $inv->invoice_number_token;
              $data['invoice_number']= $inv->invoice_number; 
              $data['user_id'] = $inv->user_id;
              $data['due_date'] = $inv->due_date;
              $data['issue_date'] = $inv->issue_date; 
              $data['status'] = $inv->status;
              $data['payment_date'] = $inv->payment_date;
              $data['deposit_amount'] = $inv->deposit_amount;
              $data['disInPer']= $inv->disInPer; 
              $data['taxInPer']= $inv->taxInPer;
              $data['disInFlat']= $inv->disInFlat;
              $data['taxInFlat']= $inv->taxInFlat;
              $data['created_at']= now();
              $data['updated_at']= now();
              
             //dd($data);
             $time = now();
             $delete_invoice_id = DB::table('delete_invoices')->insertGetId($data);
             
              foreach ($invItem as  $itm){

            $details = array('invoice_id'=>$delInvoiceId,
                        'item_name'=>$itm->item_name,
                        'rate'=>$itm->rate,
                        'qty'=>$itm->qty,
                        'total'=>$itm->total,
                        'item_description'=>addslashes($itm->item_description),
                        'delete_invoices_id'=>$delete_invoice_id,
                        'created_at'=>$time,
                        'updated_at'=>$time
                        
        );

            
              DeleteInvoiceItem::insert($details);

        }
              Toastr::success('Invoice Move', 'Success', ["positionClass" => "toast-bottom-right"]);
              DB::table("invoice_items")->where('invoice_id',$delInvoiceId)->delete();
              DB::table("invoices")->where('id',$delInvoiceId)->delete();
              return redirect()->to('/invoice/view');
    }

   

    public function destroyMulti(Request $request){
            $ids = $request->ids;
            $id = explode(",",$ids);
            $invoices =  Invoice::whereIn('id',$id)->get();
            // return json_encode($invoices);
            $invoiceIds = [];
            foreach ($invoices as $invoice) {
              $chkStatus = $invoice->status;
              if($chkStatus == "PAID-STRIPE" || $chkStatus == "DEPOSIT_PAID" || ($chkStatus == "OVERDUE" && $invoice->net_amount != $invoice->due_amount)){
                array_push($invoiceIds, $invoice->invoice_number);
                // return response()->json(['error'=>"Invoice can not Deleted"]);
              }else{
                // DB::table("invoice_items")->whereIn('invoice_id',$id)->delete();
                //DB::table("invoices")->whereIn('id',$id)->delete();
                // $invoice->is_deleted = 1;
                // echo "here";
                //Invoice::where('id', $invoice->id)->update(['is_deleted' => 1]);
                //Invoice::where('id', $invoice->id)->delete();
                 $delInvoiceId = $invoice->id;
                 $res = $this->destroyMultiInvoiceStore($delInvoiceId);
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
               //('status', '=', 'DRAFT');
          // if(isset($request->id)){
          //      InvoiceItem::where('invoice_id',$request->id)->delete();
          //      Invoice::destroy($request->id);
          //       return response()->json();
          // }
    }
    /// destroy Invoices
    public function destroyMultiInvoiceStore($delInvoiceId){
            $inv = Invoice::find($delInvoiceId); 
          $userId = $inv->user_id;
          $invItem = InvoiceItem::where('invoice_id',$delInvoiceId)->get();
          $invo = new Invoice();

              $data['invoice_id'] = $delInvoiceId;
              $data['tax_rate'] = $inv->tax_rate;
              $data['notes'] = $inv->notes;
              $data['terms'] = $inv->terms;
              $data['net_amount'] = $inv->net_amount;
              $data['client_id'] = $inv->client_id;
              $data['discount'] = $inv->discount;
              $data['due_amount'] = $inv->due_amount;
              $data['sub_total'] = $inv->sub_total;
              $data['companies_id'] = $inv->companies_id;
              $data['invoice_number_token']= $inv->invoice_number_token;
              $data['invoice_number']= $inv->invoice_number; 
              $data['user_id'] = $inv->user_id;
              $data['due_date'] = $inv->due_date;
              $data['issue_date'] = $inv->issue_date; 
              $data['status'] = $inv->status;
              $data['payment_date'] = $inv->payment_date;
              $data['deposit_amount'] = $inv->deposit_amount;
              $data['disInPer']= $inv->disInPer; 
              $data['taxInPer']= $inv->taxInPer;
              $data['disInFlat']= $inv->disInFlat;
              $data['taxInFlat']= $inv->taxInFlat;
              $data['created_at']= now();
              $data['updated_at']= now();
              
             //dd($data);
             $time = now();
             $delete_invoice_id = DB::table('delete_invoices')->insertGetId($data);
             
              foreach ($invItem as  $itm){

            $details = array('invoice_id'=>$delInvoiceId,
                        'item_name'=>$itm->item_name,
                        'rate'=>$itm->rate,
                        'qty'=>$itm->qty,
                        'total'=>$itm->total,
                        'item_description'=>addslashes($itm->item_description),
                        'delete_invoices_id'=>$delete_invoice_id,
                        'created_at'=>$time,
                        'updated_at'=>$time
                        
        );

            
              DeleteInvoiceItem::insert($details);

        }
              
              DB::table("invoice_items")->where('invoice_id',$delInvoiceId)->delete();
              DB::table("invoices")->where('id',$delInvoiceId)->delete();
              return response()->json(['success' => "Invoice Deleted"]);
        }


          public function showDeleteInvoice(){
                  $id = Auth::id();
                  $invoices = DeleteInvoice::where('user_id', $id)->latest()->paginate(10);
                  foreach($invoices as $invoice){
                    $clintData = Clients::select('email','fname','lname')->where('id', $invoice->client_id)->first();
                    $invoice->clientEmail = $clintData->email;
                    $invoice->clientFname = $clintData->fname;
                    $invoice->clientLname = $clintData->lname;
                    $invoice->companyName = DB::table("user_companies")->where('id',$invoice->companies_id)->first()->name;
                  }

                return view ('show-delete-invoice')->withInvoices($invoices);
                //->with('i', (request()->input('page', 1) - 1) * 5);    

                  }

            // public function invoiceView($id){
            //       if(Auth::check()){
            //          $inv = DeleteInvoice::find($id); //dd($inv);
            //          $invItem = DeleteInvoiceItem::where('delete_invoices_id', $id)->get();
            //          $companies_id = ($inv->companies_id);
            //          $clientsId = ($inv->client_id);
            //          $companyData = UserCompany::find($companies_id);
            //          $clientData = Clients::find($clientsId);
            //          $userId = $inv->user_id;
            //          $user = User::find($userId);
                     
            //         return view('delete-invoice-view',['invItem' => $invItem, 'inv' => $inv, 'clientData' => $clientData, 'companyData' => $companyData, 'user' =>$user]);
            //       }else{
            //         return redirect()->to('/');
            //       }
            //   }

            public function searchInvData(Request $request){
                                    $id = Auth::id();
                                    $q = Input::get ( 'q' );
                                    $CountName = str_word_count($q);
                                    // if($q != ""){ /// if1
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
                                        $invoices =  DeleteInvoice::where('user_id',$id)->whereIn('client_id',$clientFind)->where('created_at', '>=',$start)->where('created_at', '<=', $end)->latest()->paginate(10)->setPath ( '' );
                                                    $pagination = $invoices->appends ( array (
                                                    'q' => Input::get ( 'q' ), "fromDate" => Input::get('start') 
                                                    ) );
                                                foreach($invoices as $invoice){
                                                $clintData = Clients::select('fname','lname','email')->where('id', $invoice->client_id)->first();
                                                $invoice->clientFname = $clintData->fname;
                                                $invoice->clientLname = $clintData->lname;
                                                $invoice->clientEmail = $clintData->email;
                                              } 
                                              if (count ( $invoices ) > 0){ 
                                                $total_row = $invoices->count();
                                                return view ('show-delete-invoice',compact('total_row'))->withInvoices( $invoices )->withQuery ( $q )->withQuery ( $q )->withMessage ($total_row.' '. 'Delete Invoice found match your search');
                                                }else{ 
                                                return view ('show-delete-invoice')->withMessage ( 'Delete Invoice not found match Your search !' );
                                                }            
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
                                               $invoices =  DeleteInvoice::where('user_id',$id)
                                                   ->where('invoice_number', 'like', '%'.$q.'%')
                                                   ->orderBy('created_at', 'desc')
                                                   ->paginate(10)->setPath ( '' );
                                                    $pagination = $invoices->appends ( array (
                                                    'q' => Input::get ( 'q' ) 
                                                    ) );
                                                foreach($invoices as $invoice){
                                                $clintData = Clients::select('fname','lname','email')->where('id', $invoice->client_id)->first();
                                                $invoice->clientFname = $clintData->fname;
                                                $invoice->clientLname = $clintData->lname;
                                                $invoice->clientEmail = $clintData->email;
                                              }
                                              if (count ( $invoices ) > 0){ 
                                                $total_row = $invoices->count();
                                                return view ('show-delete-invoice',compact('total_row'))->withInvoices( $invoices )->withQuery ( $q )->withQuery ( $q )->withMessage ($total_row.' '. 'Delete Invoice found match your search');
                                                }else{ 
                                                return view ('show-delete-invoice')->withMessage ( 'Delete Invoice not found match Your search !' );
                                                }
                                            }else{
                                             $invoices =  DeleteInvoice::where('user_id',$id)->whereIn('client_id',$clientFind)->paginate(10)->setPath ( '' );
                                                    $pagination = $invoices->appends ( array (
                                                    'q' => Input::get ( 'q' ) 
                                                    ) );
                                                foreach($invoices as $invoice){
                                                $clintData = Clients::select('fname','lname','email')->where('id', $invoice->client_id)->first();
                                                $invoice->clientFname = $clintData->fname;
                                                $invoice->clientLname = $clintData->lname;
                                                $invoice->clientEmail = $clintData->email;
                                              }
                                              if (count ( $invoices ) > 0){ 
                                                $total_row = $invoices->count();
                                                return view ('show-delete-invoice',compact('total_row'))->withInvoices( $invoices )->withQuery ( $q )->withQuery ( $q )->withMessage ($total_row.' '. 'Delete Invoice found match your search');
                                                }else{ 
                                                return view ('show-delete-invoice')->withMessage ( 'Delete Invoice not found match Your search !' );
                                                }
                                          }
                                    }
                               // }         

                           } 


                public function destroySingleInvoice($id){
                  DB::table("delete_invoice_items")->where('delete_invoices_id',$id)->delete();
                  DB::table("delete_invoices")->where('id',$id)->delete();
                Toastr::success('Invoice Deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
                return redirect()->to('/delete/invoice/view');
             }

                
                public function destroyMultiInvoice(Request $request){
                  $ids = $request->ids;
                  $id = explode(",",$ids);
                  DB::table("delete_invoice_items")->whereIn('delete_invoices_id',$id)->delete();
                  DB::table("delete_invoices")->whereIn('id',$id)->delete();
                return response()->json(['success' => "Invoice Deleted"]);
          }

          public function restoreInvoice($id)
              {
                $inv = DeleteInvoice::find($id); 
                $userId = $inv->user_id; 
                $invItem = DeleteInvoiceItem::where('delete_invoices_id',$id)->get(); //dd($invItem);
                $invo = new Invoice();

                    $data['tax_rate'] = $inv->tax_rate;
                    $data['notes'] = $inv->notes;
                    $data['terms'] = $inv->terms;
                    $data['net_amount'] = $inv->net_amount;
                    $data['client_id'] = $inv->client_id;
                    $data['discount'] = $inv->discount;
                    $data['due_amount'] = $inv->due_amount;
                    $data['sub_total'] = $inv->sub_total;
                    $data['companies_id'] = $inv->companies_id;
                    $data['invoice_number_token']= $inv->invoice_number_token;
                    $data['invoice_number']= $inv->invoice_number; 
                    $data['user_id'] = $inv->user_id;
                    $data['due_date'] = $inv->due_date;
                    $data['issue_date'] = $inv->issue_date; 
                    $data['status'] = $inv->status;
                    $data['payment_date'] = $inv->payment_date;
                    $data['deposit_amount'] = $inv->deposit_amount;
                    $data['disInPer']= $inv->disInPer; 
                    $data['taxInPer']= $inv->taxInPer;
                    $data['disInFlat']= $inv->disInFlat;
                    $data['taxInFlat']= $inv->taxInFlat;
                    $data['created_at']= now();
                    $data['updated_at']= now();
                    
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
                              'created_at'=>$time,
                              'updated_at'=>$time
                              
              );

                  
                    InvoiceItem::insert($details);

              }
                    Toastr::success('Invoice Restore', 'Success', ["positionClass" => "toast-bottom-right"]);
                    DB::table("delete_invoice_items")->where('delete_invoices_id',$id)->delete();
                    DB::table("delete_invoices")->where('id',$id)->delete();
                    return redirect()->to('/delete/invoice/view');
          }

          public function restoreMultiData(Request $request){
            $ids = $request->ids;
            $getid = explode(",",$ids);
            $invoices =  DeleteInvoice::whereIn('id',$getid)->get();
            //return json_encode($invoices);
            foreach ($invoices as $invoice) {
                 $InvId = $invoice->id;
                 $res = $this->restoreMultiInvoice($InvId);
            }
            return response()->json(['success' => "Invoice Retore"]);
            
          }

          public function restoreMultiInvoice($InvId)
              {
                $inv = DeleteInvoice::find($InvId); 
                $userId = $inv->user_id; 
                $invItem = DeleteInvoiceItem::where('delete_invoices_id',$InvId)->get(); //dd($invItem);
                $invo = new Invoice();

                    $data['tax_rate'] = $inv->tax_rate;
                    $data['notes'] = $inv->notes;
                    $data['terms'] = $inv->terms;
                    $data['net_amount'] = $inv->net_amount;
                    $data['client_id'] = $inv->client_id;
                    $data['discount'] = $inv->discount;
                    $data['due_amount'] = $inv->due_amount;
                    $data['sub_total'] = $inv->sub_total;
                    $data['companies_id'] = $inv->companies_id;
                    $data['invoice_number_token']= $inv->invoice_number_token;
                    $data['invoice_number']= $inv->invoice_number; 
                    $data['user_id'] = $inv->user_id;
                    $data['due_date'] = $inv->due_date;
                    $data['issue_date'] = $inv->issue_date; 
                    $data['status'] = $inv->status;
                    $data['payment_date'] = $inv->payment_date;
                    $data['deposit_amount'] = $inv->deposit_amount;
                    $data['disInPer']= $inv->disInPer; 
                    $data['taxInPer']= $inv->taxInPer;
                    $data['disInFlat']= $inv->disInFlat;
                    $data['taxInFlat']= $inv->taxInFlat;
                    $data['created_at']= now();
                    $data['updated_at']= now();
                    
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
                              'created_at'=>$time,
                              'updated_at'=>$time
                              
              );

                  
                    InvoiceItem::insert($details);

              }
                    
                    DB::table("delete_invoice_items")->where('delete_invoices_id',$InvId)->delete();
                    DB::table("delete_invoices")->where('id',$InvId)->delete();
                   
          }

          

}
