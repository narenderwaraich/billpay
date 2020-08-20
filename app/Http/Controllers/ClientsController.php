<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Clients;
use App\UserCompany;
use App\User;
use App\UserPayment;
use App\Invoice;
use Carbon\Carbon;
use Redirect;
use Illuminate\Support\Facades\Input;
use Toastr;

class ClientsController extends Controller
{
   // public function __construct(){
   //   $this->middleware('auth');
   // }

  public function findClient(){
     return view('find-client');
  }
  public function findClientData(Request $request){
    $phone = $request->phone;
    $route = "/find-client/".$phone; //dd($route);
    return redirect()->to($route);
  }

  public function findClientDataDetails($phone){
    $client = Clients::where('phone',$phone)->first();
    $country_data =DB::table('countries')->select('id','name')->get();
    $state_data = DB::table("states")->select('id','name')->get();
    $city_data = DB::table("cities")->select('id','name')->get();
    if($client){
      return view('client',compact('client','phone','country_data','state_data','city_data'));
    }else{
      return view('new-client',compact('phone','country_data','state_data','city_data'));
    }
  }

  public function newClient(){
     return view('new-client');
  }

    public function addClient(){
      if(Auth::user()->role == 'user'){
        if(!Auth::user()->is_activated == 'true'){
          Toastr::error('Please first confirm your email to start using your Account!', 'Error', ["positionClass" => "toast-top-right"]);
            return back();
        }else{

        $id = Auth::id(); //dd($id);

        if($id === 2 || $id === 3){ // special check for gerry user to skip payment
          // $id = Auth::id();
          $companies = UserCompany::where('user_id', $id)->get();
          $country_data =DB::table('countries')->select('id','name')->get();
          $state_data = DB::table("states")->select('id','name')->get();
          return view('Add-Client', compact('country_data','state_data'), ['id' => $id , 'companies' => $companies,]);
        }

        $user = User::find($id);
            // get the current time
        $current = Carbon::now(); /// Now Date
        $nowDate = $current->toDateTimeString(); // change now date to string value
        $nowD = strtotime(str_replace('/', '-', $nowDate)); 
        
        $trialDate = $user->access_date;  // create time add trail 30 days date       
        //$trial = $trialDate->toDateTimeString();
        $trialD = strtotime(str_replace('/', '-', $trialDate));
        $trialExpires = $trialD - $nowD; /// show total seconds 
        //dd($trialExpires);
        $client = Clients::where('user_id', $id)->get();
        $clientCount = $client->count();
        $userPlan = UserPayment::where('user_id', '=', $id)->first();
        //$plan = $userPlan->clients; dd($plan); /// user choose plan 
        $bool = true;
        $message = "";
        if(!$userPlan){
              if($trialExpires <= 0){// if trial not ended ///1if
            
                $message = 'Sorry your Package Date Expires';
                $bool = false;                  
              }else{
                if($clientCount <= 0){
                        $bool = true; /// 3f 
                    }
                    else{ ///3f
                        $bool = false;
                        $message = 'Sorry first Activate Package in trial add only 1 client';
                    }
              }
            }else{

                  if(!$userPlan->status == 1){ /// Check User Subscription Status 
                    $bool = false;
                    $message = 'Sorry you have not any Subscription Plan';
                  }else{
                    if($clientCount <= $userPlan->clients){  //f5
                                $bool = true;
                              }else{
                                $bool = false;
                                $message = 'Sorry first Activate Another Package';
                                                                                                                                   
                              }
                    }
            }
                      if($bool){
                                // $id = Auth::id();
                                $companies = UserCompany::where('user_id', $id)->get();
                                $country_data =DB::table('countries')->select('id','name')->get();
                                $state_data = DB::table("states")->select('id','name')->get();
                                return view('Add-Client', compact('country_data','state_data'), ['id' => $id , 'companies' => $companies,]);
                      }else{
                            Toastr::error($message, 'Error', ["positionClass" => "toast-top-right"]);
                            return redirect()->to('/dashboard');
                      }
                  }

                    }else{
                      return redirect()->to('/dashboard');
                    }
            
         
    }

    

                        public function store(Request $request){
                            $validate = $this->validate(request(),[
                            'fname'=>'required|string|max:50',
                            'email'=>'required|string|email|max:255',
                            //'companies_id'=>'required|string|max:50',
                          ]);
                            if(!$validate){
                                Redirect::back()->withInput();
                                          } 

                              $data = request(['fname','lname','email','phone','address','zipcode','city','country','state']);
                              
                              $data['user_id'] = Auth::id();
                              $client=Clients::create($data);
                              Toastr::success('Client Add', 'Success', ["positionClass" => "toast-bottom-right"]);

                              return redirect()->to('/client/view');
                              
                        }
                         public function showClient(){
                              $id = Auth::id();
                              $user = User::find($id);
                              $clients = $user->clients()->latest()->paginate(10); //dd($clients);
                              $recentClients = [];
                              foreach($clients as $index => $client){
                                      // $findClient = Clients::find($client->id); //dd($client->companies->name);
                                      // $companyData = UserCompany::select('name')->where('id', $client->companies_id)->first();
                                      $query = Invoice::where('client_id', $client->id)->where('is_deleted','=',0);
                                      $invoiceData = $query->latest()->first();
                                      // $client->companyName = $companyData->name;
                                      $client->invoiceAmount = $invoiceData ? DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','!=','DRAFT')->where('is_deleted','=',0)->sum('net_amount') : '';
                                      
                                      $client->totalInvoices = $query->count();
                                      if($index < 3){
                                        $recentClients[$index]['invPaid'] = DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','PAID-STRIPE')->sum('net_amount') + DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','DEPOSIT_PAID')->sum('deposit_amount') + DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','OVERDUE')->where('net_amount','!=', 'due_amount')->sum('deposit_amount');
                                        
                                        $recentClients[$index]['invAmt'] = DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','!=','DRAFT')->where('is_deleted','=',0)->sum('net_amount');
                                        // $recentClients[$index]['clientName'] = $client->fname.' '.$client->lname;
                                        // $recentClients[$index]['clientEmail'] = $client->email;
                                        $recentClients[$index]['clientCompany'] = DB::table("user_companies")->where('id',$client->companies_id)->first()->name;
                                      }
   
                                    }
                                  $invoices = Invoice::with('user')->where('user_id', $id)->where('is_deleted','=',0)->latest()->paginate(10);
                                  foreach($invoices as $invoice){
                                    $invoice->paidInvAmount = DB::table("invoices")->where('id',$invoice->id)->where('status','=','PAID-STRIPE')->sum('net_amount');
                                  }
                                    
                                return view ( 'show-client',compact('recentClients','invoices'))->withClients($clients);    
                            // return view('show-client',compact('clients'),['id' => $id])
                            //     ->with('i', (request()->input('page', 1) - 1) * 5);                             
                     }


                       public function getClient(Request $request){
                              $client = Clients::find($request->client_id);
                              $companyId = $client->companies_id;
                              $company = UserCompany::find($companyId);

                              return response()->json(['fname' => $client->fname, 'lname' => $client->lname, 'email' => $client->email, 'country' => $client->country, 'state' => $client->state, 'city' => $client->city, 'address' => $client->address, 'logo' => $company->logo, 'name' => $company->name]);
                          }


                          /// Update Clients data
                              ///update company data
                          public function editClient($id){ 
                              $clients = Clients::find($id);
                              $country_data =DB::table('countries')->select('id','name')->get();
                              $state_data = DB::table("states")->select('id','name')->get();
                              return view('edit-client',compact('clients', 'id','country_data','state_data'));
                          }

                           public function updateClient(Request $request, $id){
                              $this->validate(request(),[
                              'fname'=>'required|string|max:50',
                              'email'=>'required|string|email|max:255',
                              //'companies_id'=>'required|string|max:50',
                              ]); 
                              
                               $userId = Auth::id();
                                  
                              $data = request(['fname','lname','email','phone','address','zipcode','city','country','state']);
                              $data = Clients::where('id',$id)->update($data);
                              Toastr::success('Client Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
                              return redirect()->to('/client/view');
                                 
                                              

                           }

                           public function destroy(Request $request)
                                { 
                            $ids = $request->ids;
                            $checkInvoice = DB::table("invoices")->whereIn('client_id',explode(",",$ids))->first();
                                if(!$checkInvoice){
                                  
                                DB::table("clients")->whereIn('id',explode(",",$ids))->delete();
                              return response()->json(['success'=>"Clients Deleted successfully."]);
                                }else{
                                    return response()->json(['error'=>"Clients can not Deleted"]);
                                  }


                            // $checkInvoice = Invoice::where('client_id', '=', $id)->first();
                            //       if(!$checkInvoice){
                            //         Clients::destroy($id);
                            //           return redirect()->to('/client/view')
                            //                   ->with('success','Client deleted successfully');
                            //       }else{
                            //         return redirect()->to('/client/view')
                            //                   ->withErrors(['Sorry Client can not delete']);
                            //       }
                              
                          }

                            public function SearchData(Request $request){
                                  $id = Auth::id();

                                  $q = Input::get ( 'q' );
                                  $CountName = str_word_count($q); 
                                    // if($q != ""){ /// if1
                                        if($request->start){ /// if request to search by date if2
                                        $s = $request->start; 
                                        $start = Carbon::createFromFormat('m/d/Y', $s)->format('Y-m-d 00:00:00');
                                            // check end date
                                              if($request->end){
                                                $e = $request->end;
                                                $end = Carbon::createFromFormat('m/d/Y', $e)->format('Y-m-d 00:00:00');
                                              }else{ 
                                                $end = Carbon::now();
                                              } 
                                              $companyFind = UserCompany::where('user_id',$id)->where('name','LIKE','%'.$q.'%')->pluck('id'); // find company Name with Date
                                              if(count($companyFind) <= 0){ // if not match company name if3
                                                /// Check search full name with date
                                            if($CountName > 1){ // if find full name run this
                                               $fname = explode(' ', $q)[0];
                                               $lname = explode(' ', $q)[1];
                                               $clients =  Clients::where('user_id',$id)->where('fname', 'like', '%'.$fname.'%')->where('lname', 'like', '%'.$lname.'%')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->paginate(10)->setPath ( '' );
                                                      $pagination = $clients->appends ( array (
                                                            'q' => Input::get ( 'q' ), "fromDate" => Input::get('start') 
                                                        ) );
                                            }else{ /// single name search 
                                              $clients =  Clients::where('user_id',$id)->where('fname', 'like', '%'.$q.'%')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->paginate(10)->setPath ( '' );
                                                      $pagination = $clients->appends ( array (
                                                            'q' => Input::get ( 'q' ), "fromDate" => Input::get('start') 
                                                        ) );
                                              if(count($clients) <= 0){ /// if not found first name
                                                $clients =  Clients::where('user_id',$id)->where('lname', 'like', '%'.$q.'%')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->paginate(10)->setPath ( '' );
                                                      $pagination = $clients->appends ( array (
                                                            'q' => Input::get ( 'q' ), "fromDate" => Input::get('start') 
                                                        ) );
                                                    }
                                            } 

                                                      //// Collect Clients Information 
                                                        $recentClients = [];
                                                        foreach($clients as $index => $client){
                                                                $query = Invoice::where('client_id', $client->id);
                                                                $invoiceData = $query->latest()->first();
                                                                $client->invoiceAmount = $invoiceData ? DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','!=','DRAFT')->sum('net_amount') : '';
                                                                
                                                                $client->totalInvoices = $query->count();
                                                                if($index < 3){
                                                                  $recentClients[$index]['invPaid'] = DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','PAID-STRIPE')->sum('net_amount') + DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','DEPOSIT_PAID')->sum('deposit_amount') + DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','OVERDUE')->where('net_amount','!=', 'due_amount')->sum('deposit_amount');
                                                                  
                                                                  $recentClients[$index]['invAmt'] = DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','!=','DRAFT')->sum('net_amount');
                                                                  
                                                                }
                             
                                                              }
                                                          // end info
                                                              
                                                          if (count ( $clients ) > 0){ 
                                                            $total_row = $clients->count();
                                                            return view ('show-client',compact('total_row','recentClients'),['id' => $id])->withClients ( $clients )->withQuery ( $q )->withMessage ($total_row.' '. 'Client found match your search');
                                                          }else{ 
                                                            return view ('show-client')->withMessage ( 'Client not found match Your search !' );
                                                          }
                                                 }else{ //if3 ///  client find by company with date
                                                      $clients =  Clients::where('user_id',$id)->whereIn('companies_id',$companyFind)->where('created_at', '>=', $start)->where('created_at', '<=', $end)->latest()->paginate(10)->setPath ( '' );
                                                      $pagination = $clients->appends ( array (
                                                            'q' => Input::get ( 'q' ), "fromDate" => Input::get('start') 
                                                        ) );

                                                      //// Collect Clients Information 
                                                        $recentClients = [];
                                                        foreach($clients as $index => $client){
                                                                $query = Invoice::where('client_id', $client->id);
                                                                $invoiceData = $query->latest()->first();
                                                                $client->invoiceAmount = $invoiceData ? DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','!=','DRAFT')->sum('net_amount') : '';
                                                                
                                                                $client->totalInvoices = $query->count();
                                                                if($index < 3){
                                                                  $recentClients[$index]['invPaid'] = DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','PAID-STRIPE')->sum('net_amount') + DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','DEPOSIT_PAID')->sum('deposit_amount') + DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','OVERDUE')->where('net_amount','!=', 'due_amount')->sum('deposit_amount');
                                                                  
                                                                  $recentClients[$index]['invAmt'] = DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','!=','DRAFT')->sum('net_amount');
                                                                }
                             
                                                              }

                                                            // end info

                                                          if (count ( $clients ) > 0){
                                                            $total_row = $clients->count();
                                                            return view ('show-client',compact('total_row','recentClients'),['id' => $id])->withClients ( $clients )->withQuery ( $q )->withMessage ($total_row.' '. 'Client found match your search');
                                                          }else{
                                                            return view ('show-client')->withMessage ( 'Client not found match Your search !' );
                                                          }

                                                 }   /// end search by date

                                      }else{ ///find client name search if2 seach by company name 
                                          $companyFind = UserCompany::where('user_id',$id)->where('name','LIKE','%'.$q.'%')->pluck('id');
                                          if(count($companyFind) <= 0){ //Search by client name (error this query)
                                             /// Check search full name
                                            if($CountName > 1){ // if find full name run this
                                               $fname = explode(' ', $q)[0];
                                               $lname = explode(' ', $q)[1];
                                               $clients =  Clients::where('user_id',$id)
                                                       ->where('fname', 'like', '%'.$fname.'%')
                                                       ->where('lname', 'like', '%'.$lname.'%')
                                                       ->paginate(10)->setPath ( '' );
                                                      $pagination = $clients->appends ( array (
                                                            'q' => Input::get ( 'q' ) 
                                                        ) );
                                            }else{ /// single name search 
                                              $clients =  Clients::where('user_id',$id) /// search by First Name
                                                       ->where('fname', 'like', '%'.$q.'%')
                                                       // ->where('lname', 'like', '%'.$q.'%')
                                                       ->paginate(10)->setPath ( '' );
                                                      $pagination = $clients->appends ( array (
                                                            'q' => Input::get ( 'q' ) 
                                                        ) );
                                              if(count($clients) <= 0){ /// if not found first name
                                                $clients =  Clients::where('user_id',$id) /// search by Last Name
                                                       // ->where('fname', 'like', '%'.$q.'%')
                                                       ->where('lname', 'like', '%'.$q.'%')
                                                       ->paginate(10)->setPath ( '' );
                                                      $pagination = $clients->appends ( array (
                                                            'q' => Input::get ( 'q' ) 
                                                        ) );
                                                    }
                                            } 
                                            
                                                      //// Collect Clients Information 
                                                        $recentClients = [];
                                                        foreach($clients as $index => $client){
                                                                $query = Invoice::where('client_id', $client->id);
                                                                $invoiceData = $query->latest()->first();
                                                                $client->invoiceAmount = $invoiceData ? DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','!=','DRAFT')->sum('net_amount') : '';
                                                                
                                                                $client->totalInvoices = $query->count();
                                                                if($index < 3){
                                                                  $recentClients[$index]['invPaid'] = DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','PAID-STRIPE')->sum('net_amount') + DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','DEPOSIT_PAID')->sum('deposit_amount') + DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','OVERDUE')->where('net_amount','!=', 'due_amount')->sum('deposit_amount');
                                                                  
                                                                  $recentClients[$index]['invAmt'] = DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','!=','DRAFT')->sum('net_amount');
                                                                }
                             
                                                              }

                                                              // end info

                                                          if (count ( $clients ) > 0){
                                                            $total_row = $clients->count();
                                                            return view ('show-client',compact('total_row','recentClients'),['id' => $id])->withClients ( $clients )->withQuery ( $q )->withMessage ($total_row.' '. 'Client found match your search');
                                                          }else{
                                                            return view ('show-client')->withMessage ( 'Client not found match Your search !' );
                                                          }
                                                    }else{ /// find Search by company name
                                                         $clients =  Clients::where('user_id',$id)->whereIn('companies_id',$companyFind)->paginate(10)->setPath ( '' );
                                                      $pagination = $clients->appends ( array (
                                                            'q' => Input::get ( 'q' ) 
                                                        ) );
                                                        $recentClients = [];
                                                        foreach($clients as $index => $client){
                                                                $query = Invoice::where('client_id', $client->id);
                                                                $invoiceData = $query->latest()->first();
                                                                $client->invoiceAmount = $invoiceData ? DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','!=','DRAFT')->sum('net_amount') : '';
                                                                
                                                                $client->totalInvoices = $query->count();
                                                                if($index < 3){
                                                                  $recentClients[$index]['invPaid'] = DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','PAID-STRIPE')->sum('net_amount') + DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','DEPOSIT_PAID')->sum('deposit_amount') + DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','=','OVERDUE')->where('net_amount','!=', 'due_amount')->sum('deposit_amount');
                                                                  
                                                                  $recentClients[$index]['invAmt'] = DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','!=','DRAFT')->sum('net_amount');
                                                                }
                             
                                                              }

                                                                      // end info

                                                          if (count ( $clients ) > 0){
                                                            $total_row = $clients->count();
                                                            return view ('show-client',compact('total_row','recentClients'),['id' => $id])->withClients ( $clients )->withQuery ( $q )->withMessage ($total_row.' '. 'Client found match your search');
                                                          }else{
                                                            return view ('show-client')->withMessage ( 'Client not found match Your search !' );
                                                          }
                                                    }         
                              
                                        }

                                    // }
                             }                          
                      
                            


                          // function SearchClientData(Request $request)
                          //     {
                               
                          //       $output = '';
                          //       $query = $request->get('query');
                          //       if($query != '')
                          //       {
                          //         $companyFind = UserCompany::where('name','LIKE','%'.$query.'%')->pluck('id');
                          //          $id = Auth::id();
                          //         if(count($companyFind) <= 0){
                          //                 $data =  Clients::where('user_id',$id)
                          //                    ->where('fname', 'like', '%'.$query.'%')
                          //                    ->orWhere('lname', 'like', '%'.$query.'%')
                          //                    ->orWhere('email', 'like', '%'.$query.'%')
                          //                    ->orWhere('country', 'like', '%'.$query.'%')
                          //                    ->orderBy('companies_id', 'desc')
                          //                    ->get();
                          //             }else{
                          //                 $data = Clients::where('user_id',$id)->whereIn('companies_id',$companyFind)->get();
                          //             }       
                                   
                          //       }
                          //       else
                          //       {
                          //        $data = DB::table('clients')
                          //          ->orderBy('companies_id', 'desc')
                          //          ->get();
                          //       }
                          //       $total_row = $data->count();
                          //       if($total_row > 0)
                          //       {
                          //        foreach($data as $row)
                          //        {
                          //         $companyData = UserCompany::select('name')->where('id', $row->companies_id)->first();
                          //                       $row->companyName = $companyData->name;
                          //         $output .= '
                          //         <tr id="tr_{{$row->id}}">
                          //          <td class="td-inv-name"><input type="checkbox" class="sub_chk" data-id="{{$row->id}}">'.$row->fname. '&nbsp' .$row->lname.  '<br>
                          //          <span class="td-inv-no">'.$row->email.'</span></td>
                          //          <td class="td-inv-name">'.$row->companyName.'</td>
                          //          <td class="td-inv-name">'.$row->created_at->format('d/m/Y').'</td>
                          //          <td class="td-inv-name">'.'</td>
                          //          <td class="td-inv-name">'.'</td>
                                   
                          //          <td class="td-inv-name">'.'</td>
                          //         </tr>
                          //         ';
                                  
                          //        }
                          //       }
                          //       else
                          //       {
                          //        $output = '
                          //        <tr>
                          //         <td align="center" colspan="5">No Data Found</td>
                          //        </tr>
                          //        ';
                          //       }
                          //       $data = array(
                          //        'table_data'  => $output,
                          //        'total_data'  => $total_row
                          //       );

                          //       echo json_encode($data);
                          //      }
                              

}
