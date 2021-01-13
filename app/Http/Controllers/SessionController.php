<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Auth;
use Hash;
use App\User;
use App\UserPayment;
use Redirect;
use App\Invoice;
use App\Clients;
use Carbon\Carbon;
use Toastr;
use App\UserCompany;
use App\Page;

class SessionController extends Controller
{
    public function HomePage(Request $request){
        if(Auth::check()){
        if(Auth::user()->role == 'user'){
            $id = Auth::id();
            $nowDate = date("Y-m-d", time());
            $lastMonth = array(date('m')-1);
            $cruentYear = array(date('Y'));
            $lastYear = array(date('Y')-1);

            $todayDepositInvoiceAmount = DB::table("invoices")->where('user_id',$id)->where('status','=','DEPOSIT_PAID')->where('is_deleted','=',0)->whereRaw('date(`created_at`) = ?', $nowDate)->sum('deposit_amount'); //dd($todayDepositInvoiceAmount);
            $todayPaidInvoiceAmount = DB::table("invoices")->where('user_id',$id)->whereIn('status',['ONLINE','CASH'])->where('is_deleted','=',0)->whereRaw('date(`created_at`) = ?', $nowDate)->sum('net_amount'); //dd($todayPaidInvoiceAmount);

            $lastMonthDepositInvoiceAmount = DB::table("invoices")->where('user_id',$id)->where('status','=','DEPOSIT_PAID')->where('is_deleted','=',0)->whereRaw('month(`created_at`) = ?', $lastMonth)->sum('deposit_amount'); //dd($lastMonthDepositInvoiceAmount);
            $lastMonthPaidInvoiceAmount = DB::table("invoices")->where('user_id',$id)->whereIn('status',['ONLINE','CASH'])->where('is_deleted','=',0)->whereRaw('month(`created_at`) = ?', $lastMonth)->sum('net_amount'); //dd($lastMonthPaidInvoiceAmount);

            $lastYearDepositInvoiceAmount = DB::table("invoices")->where('user_id',$id)->where('status','=','DEPOSIT_PAID')->where('is_deleted','=',0)->whereRaw('year(`created_at`) = ?', $lastYear)->sum('deposit_amount'); //dd($lastYearDepositInvoiceAmount);
            $lastYearPaidInvoiceAmount = DB::table("invoices")->where('user_id',$id)->whereIn('status',['ONLINE','CASH'])->where('is_deleted','=',0)->whereRaw('year(`created_at`) = ?', $lastYear)->sum('net_amount'); //dd($lastMonthPaidInvoiceAmount);

            $totalDepositInvoiceAmount = DB::table("invoices")->where('user_id',$id)->where('status','=','DEPOSIT_PAID')->where('is_deleted','=',0)->sum('deposit_amount'); //dd($totalDepositInvoiceAmount);
            $totalPaidInvoiceAmount = DB::table("invoices")->where('user_id',$id)->whereIn('status',['ONLINE','CASH'])->where('is_deleted','=',0)->sum('net_amount'); //dd($totalPaidInvoiceAmount);

            ///sale
            $todaySale = $todayDepositInvoiceAmount + $todayPaidInvoiceAmount;
            $lastMonthSale = $lastMonthDepositInvoiceAmount + $lastMonthPaidInvoiceAmount;
            $lastYearSale = $lastYearDepositInvoiceAmount + $lastYearPaidInvoiceAmount;
            $totalSale = $totalDepositInvoiceAmount + $totalPaidInvoiceAmount;

            /// clients
            $todayClient = DB::table("clients")->where('user_id',$id)->whereRaw('date(`created_at`) = ?', $nowDate)->count(); //dd($todayClient);
            $lastMonthClient = DB::table("clients")->where('user_id',$id)->whereRaw('month(`created_at`) = ?', $lastMonth)->count(); //dd($lastMonthClient);
            $lastYearClient = DB::table("clients")->where('user_id',$id)->whereRaw('year(`created_at`) = ?', $lastYear)->count(); //dd($lastYearClient);
            $totalClient = DB::table("clients")->where('user_id',$id)->count(); //dd($totalClient);

            ///invoices
            $todayInvoice = DB::table("invoices")->where('user_id',$id)->where('is_deleted','=',0)->whereRaw('date(`created_at`) = ?', $nowDate)->count(); //dd($todayInvoice);
            $lastMonthInvoice = DB::table("invoices")->where('user_id',$id)->where('is_deleted','=',0)->whereRaw('month(`created_at`) = ?', $lastMonth)->count(); //dd($lastMonthInvoice);
            $lastYearInvoice = DB::table("invoices")->where('user_id',$id)->where('is_deleted','=',0)->whereRaw('year(`created_at`) = ?', $lastYear)->count(); //dd($lastYearInvoice);
            $totalInvoice = DB::table("invoices")->where('user_id',$id)->where('is_deleted','=',0)->count(); //dd($totalInvoice);


            $overdueInvoices = Invoice::where('user_id',$id)->where(function($q){
                $q->where('status','=','SENT')->orWhere('status','=','DEPOSIT_PAID');
            })->where('due_date', '<',$nowDate)->update(['status' => 'OVERDUE']);
            $sentAmount = DB::table("invoices")->where('user_id',$id)->where('status','=','SENT')->where('is_deleted','=',0)->sum('net_amount');
            $onlyDepositAmount = DB::table("invoices")->where('user_id',$id)->where('status','=','DEPOSIT_PAID')->where('is_deleted','=',0)->sum('deposit_amount');
            $overdueInDepositAmount = DB::table("invoices")->where('user_id',$id)->where('status','=','OVERDUE')->where('net_amount','!=','due_amount')->where('is_deleted','=',0)->sum('deposit_amount'); 
            $totalDeposit = $onlyDepositAmount + $overdueInDepositAmount;
            $cancelInvoice = DB::table("invoices")->where('user_id',$id)->where('status','=','CANCEL')->where('is_deleted','=',0)->sum('net_amount');
            $piChart = [0,0,0,0,0];
            $paids = DB::table('invoices')
                     ->select(DB::raw('sum(net_amount) as amount'),DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as day'))
                     ->groupBy('day')
                     ->orderBy('day','asc')
                     ->whereIn('status',['ONLINE','CASH'])
                     ->where('is_deleted','=',0)
                     ->where('user_id', '=', $id)
                     // ->whereRaw('year(`created_at`) = ?', $cruentYear)
                     ->get();
                   //dd($paids);
                    foreach($paids as $paidInv){
                            $piChart[0] += $paidInv->amount;
                    }
            $OverDueInvAmount=DB::table('invoices')
                     ->select(DB::raw('sum(net_amount) as OverDueInvAmount'),DB::raw('DATE_FORMAT(created_at, "%Y-%m-01") as month'))
                     ->groupBy('month')
                     ->orderBy('month','asc')
                     ->where('status', '=', 'OVERDUE')
                     ->where('is_deleted','=',0)
                     ->where('user_id', '=', $id)
                      ->get();
                      //dd($OverDueInvAmount);
                      foreach($OverDueInvAmount as $OvInvAmount){
                        $piChart[2] += $OvInvAmount->OverDueInvAmount;
                      }
            $piChart[1] += $totalDeposit;
            $piChart[3] += $sentAmount;
            $piChart[4] += $cancelInvoice;
            $finalPiData = [];
          foreach($piChart as $key => $PiData){
              $finalPiData[$key]['type'] = ($key == 0 ? "Paid" : ($key  == 1 ? "Deposit" : ($key  == 2 ? "Overdue" : ($key  == 3 ? "Sent" : "Cancel"))));
              $finalPiData[$key]['amount'] = $PiData;
            }
          return view('index',compact('paids','finalPiData','todaySale','lastMonthSale','lastYearSale','totalSale','todayClient','lastMonthClient','lastYearClient','totalClient','todayInvoice','lastMonthInvoice','lastYearInvoice','totalInvoice'));
    }else{
        return redirect()->to('/admin');
    }
    }
    else{
        //redirect()->to('/login');
        return view('login');
    }
}

      // public function Home(){
      //   return view('index');
      // }

    public function create(){
        $pageName = "login";
        $page = Page::where('page_name',$pageName)->first(); //dd($page);
        $title = $page ? $page->title : '' ;
        $description = $page ? $page->description : '';
        return view('login',compact('title','description'));
    }
    public function store(Request $request)
    {
        // set the remember me cookie if the user check the box
        $remember = (Input::has('remember')) ? true : false;
            //dd($remember);
        $auth = Auth::attempt(
            [
                'email'  => strtolower(Input::get('email')),
                'password'  => Input::get('password')    
            ], $remember
        );
        
            $email = $request['email'];
            $userFind = User::where('email', '=', $email)->count() > 0; 
            if (!$userFind) { // Find User
              Toastr::error('Sorry this email not exists!', 'Error', ["positionClass" => "toast-top-right"]);
                return back()->withInput();
            }
            $userSuspend = User::where('email', '=', $email)->first();
            if($userSuspend->suspend == 1){ // check account Suspend or not 
              Toastr::warning('Your Account is suspend please contact Admin', 'Account Suspend', ["positionClass" => "toast-top-right"]);
            return back();
            }
            // $userSelect = User::where('email', '=', $email)->first();
            // if(!$userSelect->is_activated == 'true'){ // check account active or not 
            //   Toastr::error('Your account is not activated!', 'Error', ["positionClass" => "toast-top-right"]);
            // return back()->withInput();
            // }    
            if (!$auth) { /// check user id or password match with data base connections 
              Toastr::error('The email or password is incorrect, please try again', 'Error', ["positionClass" => "toast-top-right"]);
            return back()->withInput();
            
            }
            
        if(Auth::user()->role == 'admin')
        {
            return redirect()->to('/admin');
        }
        
        else{
            //// save user id or Password request by Remember button
            // if($request->remember){
            //     // code here 
            // }
            return redirect()->to('/dashboard');
        }
 
    }
    public function destroy(){
        auth()->logout();
        return redirect()->to('/login');

    }               

public function SearchData(Request $request){
          $id = Auth::id();
          $q = Input::get ( 'q' );
          $CountName = str_word_count($q);
          $requestYear = ""; 
          if($request->start){
            // if search invoice by date
            $s = $request->start;  
            $start = Carbon::createFromFormat('m/d/Y', $s)->format('Y-m-d 00:00:00'); //dd($start);
                if($request->end){
                  $e = $request->end;
                $end = Carbon::createFromFormat('m/d/Y', $e)->format('Y-m-d 00:00:00');
              }else{
                $end = Carbon::now();
              } 
              if($CountName > 1){ // if find full name run this with date search
                     $fname = explode(' ', $q)[0];
                     $lname = explode(' ', $q)[1];
                     $clientFind =  Clients::where('user_id',$id)
                             ->where('fname', 'like', '%'.$fname.'%')
                             ->where('lname', 'like', '%'.$lname.'%')
                             ->pluck('id');
                  }else{ /// single name search  with date search
                      $clientFind =  Clients::where('user_id',$id)
                             ->where('fname', 'like', '%'.$q.'%')
                             ->pluck('id');
                    if(count($clientFind) <= 0){ /// if not found first name with date search
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
                      $total_row = $invoices->total();
                      return view ('index',compact('total_row','requestYear'))->withInvoices( $invoices )->withQuery ( $q )->withMessage ($total_row.' '. 'Invoice found match your search');
                      }else{ /// Search invoive by status with date
                        $invoices =  Invoice::where('user_id',$id)->where('status', 'like', '%'.$q.'%')->where('created_at', '>=',$start)->where('created_at', '<=', $end)->where('is_deleted','=',0)->latest()->paginate(10)->setPath ( '' );
                          $pagination = $invoices->appends ( array (
                          'q' => Input::get ( 'q' ), "fromDate" => Input::get('start')
                          ) );
                      
                    if (count ( $invoices ) > 0){ 
                      $total_row = $invoices->total();
                      return view ('index',compact('total_row','requestYear'))->withInvoices( $invoices )->withQuery ( $q )->withMessage ($total_row.' '. 'Invoice found match your search');
                      }else{ 
                      return view ('index')->withMessage ( 'Invoice not found match Your search !' );
                      }
                      } 
                  // end search invoice by date           
          }else{
            /// Start invoice search by Client Name or Invoice Number
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
                      $total_row = $invoices->total();
                      return view ('index',compact('total_row','requestYear'))->withInvoices( $invoices )->withQuery ( $q )->withMessage ($total_row.' '. 'Invoice found match your search');
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
                          $total_row = $invoices->total(); //dd($total_row);
                          return view ('index',compact('total_row','requestYear'))->withInvoices( $invoices )->withQuery ( $q )->withMessage ($total_row.' '. 'Invoice found match your search');
                          }else{ // end search by invoice status
                          return view ('index')->withMessage ( 'Invoice not found match Your search !' );
                        } 
                      }
                  }else{
                   $invoices =  Invoice::where('user_id',$id)->whereIn('client_id',$clientFind)->where('is_deleted','=',0)->latest()->paginate(10)->setPath ( '' );
                          $pagination = $invoices->appends ( array (
                          'q' => Input::get ( 'q' ) 
                          ) );

                          //dd($pagination);
                      
                    if (count ( $invoices ) > 0){ //by client name data view
                      $total_row = $invoices->total(); //dd($total_row);
                      return view ('index',compact('total_row','requestYear'))->withInvoices( $invoices )->withQuery ( $q )->withMessage ($total_row.' '. 'Invoice found match your search');
                      }else{ 
                      return view ('index')->withMessage ( 'Invoice not found match Your search !' );
                      }
                }
          }       

 }          

          // public function SearchData(Request $request){
          //         $id = Auth::id();
          //         $netOverdue = DB::table("invoices")->where('user_id',$id)->sum('due_amount');
          //         $netPaid = DB::table("invoices")->where('user_id',$id)->sum('net_amount');
          //         $name = $request->q;
          //         if($request->start){
          //           $s = $request->start; 
          //           $start = Carbon::createFromFormat('d/m/Y', $s)->format('Y-m-d H:i:s');
          //               if($request->end){
          //                 $e = $request->end;
          //               $end = Carbon::createFromFormat('d/m/Y', $e)->format('Y-m-d H:i:s');
          //             }else{
          //               $end = Carbon::now();
          //             } 
          //             $clientFind = Clients::where('user_id',$id)
          //                        ->where('fname', 'like', '%'.$name.'%')
          //                        ->orWhere('lname', 'like', '%'.$name.'%')
          //                        ->pluck('id');
          //             $invoices =  Invoice::where('user_id',$id)->whereIn('client_id',$clientFind)->where('created_at', '>=', $start)->where('created_at', '<=', $end)->latest()->paginate(10);
          //                     foreach($invoices as $invoice){
          //                     $clintData = Clients::select('fname','lname','email')->where('id', $invoice->client_id)->first();
          //                     $invoice->clientFname = $clintData->fname;
          //                     $invoice->clientLname = $clintData->lname;
          //                     $invoice->clientEmail = $clintData->email;
          //                   }
          //                   $total_row = $invoices->count();
          //           return view('index',compact('invoices',,'netPaid','total_row'));
          //         }else{
          //           $clientFind = Clients::where('user_id',$id)
          //                        ->where('fname', 'like', '%'.$name.'%')
          //                        ->orWhere('lname', 'like', '%'.$name.'%')
          //                        ->pluck('id');
          //           if(count($clientFind) <= 0){
          //                    $invoices =  Invoice::where('user_id',$id)
          //                        ->where('invoice_number', 'like', '%'.$name.'%')
          //                        ->orderBy('created_at', 'desc')
          //                        ->latest()->paginate(10);
          //                              foreach($invoices as $invoice){
          //                           $clintData = Clients::select('fname','lname','email')->where('id', $invoice->client_id)->first();
          //                           $invoice->clientFname = $clintData->fname;
          //                           $invoice->clientLname = $clintData->lname;
          //                           $invoice->clientEmail = $clintData->email;
          //                         }
          //                         $total_row = $invoices->count();
          //                 return view('index',compact('invoices',,'netPaid','total_row'));
          //                 }else{
          //                  $invoices =  Invoice::where('user_id',$id)->whereIn('client_id',$clientFind)->latest()->paginate(10);
          //                     foreach($invoices as $invoice){
          //                           $clintData = Clients::select('fname','lname','email')->where('id', $invoice->client_id)->first();
          //                           $invoice->clientFname = $clintData->fname;
          //                           $invoice->clientLname = $clintData->lname;
          //                           $invoice->clientEmail = $clintData->email;
          //                         }
          //                         $total_row = $invoices->count();
          //                 return view('index',compact('invoices',,'netPaid','total_row'));
          //                   }
          //               }         
          //         }          


// public function SearchInvoiceData(Request $request){
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
//                            <td scope="row" class="td-inv-name"><input type="checkbox" class="sub_chk" data-id='.$row->id.' email-id='.$row->clientEmail.'>&nbsp <a href="/inv-view/'.$row->id.'">'.$row->clientFname. '&nbsp' .$row->clientLname.  '<br>
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
