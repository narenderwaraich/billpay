<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Clients;
use App\User;
use App\UserPayment;
use App\Invoice;
use Carbon\Carbon;
use Redirect;
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
    $userId = Auth::id();
    $client = Clients::where('phone',$phone)->where('user_id',$userId)->first(); //dd($client);
    $country_data =DB::table('countries')->select('id','name')->get();
    $state_data = DB::table("states")->select('id','name')->get();
    $city_data = DB::table("cities")->select('id','name')->get();
    if($client){
      return view('update-client',compact('client','phone','country_data','state_data','city_data'));
    }else{
      return view('new-client',compact('phone','country_data','state_data','city_data'));
    }
  }

  public function newClient(){
     return view('new-client');
  }

    public function store(Request $request){
        $validate = $this->validate(request(),[
        'fname'=>'required|string|max:50',
        'email'=>'required|string|email|max:255',
        'phone' => 'required|min:10|max:10',
      ]);
        if(!$validate){
            Redirect::back()->withInput();
                      } 

          $data = request(['fname','lname','email','phone','address','zipcode','city','country','state']);
          
          $data['user_id'] = Auth::id(); //dd($data);
          $client=Clients::create($data);
          Toastr::success('Client Add', 'Success', ["positionClass" => "toast-bottom-right"]);
          $route ="/invoice/".$client->id;
          return redirect()->to($route);
          
    }
       public function showClient(){
            $id = Auth::id();
            $user = User::find($id);
            $clients = $user->clients()->latest()->paginate(10); //dd($clients);
            foreach($clients as $index => $client){
                    $query = Invoice::where('client_id', $client->id)->where('user_id',$id)->where('is_deleted','=',0);
                    $invoiceData = $query->latest()->first();
                    $client->invoiceAmount = $invoiceData ? DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','!=','DRAFT')->where('is_deleted','=',0)->sum('net_amount') : '';
                    $client->totalInvoices = $query->count();
                  }
              return view ( 'show-client')->withClients($clients);                         
   }


   public function getClient(Request $request){
          $client = Clients::find($request->client_id);

          return response()->json(['client' => $client]);
      }


  /// Update Clients data
      ///update company data
  public function editClient($id){ 
      $client = Clients::find($id); //dd($client);      
      $country_data =DB::table('countries')->select('id','name')->get();
      $state_data = DB::table("states")->select('id','name')->get();
      $city_data = DB::table("cities")->select('id','name')->get();
      return view('update-client',compact('client','country_data','state_data','city_data'));
  }

 public function updateClient(Request $request, $id){
    $validate = $this->validate(request(),[
    'fname'=>'required|string|max:50',
    'email'=>'required|string|email|max:255',
    'phone' => 'required|min:10|max:10',
    ]);

    if(!$validate){
            Redirect::back()->withInput();
      }  
    
     $userId = Auth::id();
        
    $data = request(['fname','lname','email','phone','address','zipcode','city','country','state']); //dd($data);
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
    
}

public function searchClients(Request $request){
      //return $request;
      $id = Auth::id();
      $q = Input::get ( 'q' );
      $CountName = str_word_count($q);
      if ($q != "") {
        /// if search any data
         if ($request->start) {
          /// if search by date
            $s = $request->start; //dd($s);
            $start = Carbon::createFromFormat('m/d/Y', $s)->format('Y-m-d 00:00:00');
            // check end date
            if($request->end){
              $e = $request->end;
              $end = Carbon::createFromFormat('m/d/Y', $e)->format('Y-m-d 00:00:00');
            }else{ 
              $end = Carbon::now();
            }

            /// Start Clients search by Name or email
            $clients = Clients::where('fname', 'like', '%'.$q.'%')
                 ->orWhere('lname', 'like', '%'.$q.'%')
                 ->orWhere('email', 'like', '%'.$q.'%')
                 ->orWhere('phone', 'like', '%'.$q.'%')
                 ->whereBetween('created_at', [$start,$end])
                 //->where('created_at', '>=', $start)
                 //->where('created_at', '<=', $end)
                 ->orderBy('created_at', 'desc')
                 ->paginate(10)->setPath ( '' );
                  $pagination = $clients->appends ( array (
                  'q' => Input::get ( 'q' ), "start" => Input::get('start'), "end" => Input::get('end')
                  ) );
                foreach($clients as $index => $client){
                  $query = Invoice::where('client_id', $client->id)->where('is_deleted','=',0);
                  $invoiceData = $query->latest()->first();
                  $client->invoiceAmount = $invoiceData ? DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','!=','DRAFT')->where('is_deleted','=',0)->sum('net_amount') : '';
                  $client->totalInvoices = $query->count();
                }
                //dd($clients);
                if (count ($clients) > 0){ //by user name data view
                      $total_row = $clients->total(); //dd($total_row);
                    return view ('show-client',compact('total_row','clients'))->withQuery ( $q )->withMessage ($total_row.' '. 'Clients found match your search');
                 }else{ 
                    return view ('show-client')->withMessage ( 'Clients not found match Your search !' );
                 }

          /// end if search by date
         }else{
          /// else search by date
              $clients = Clients::where('fname', 'like', '%'.$q.'%')
               ->orWhere('lname', 'like', '%'.$q.'%')
               ->orWhere('email', 'like', '%'.$q.'%')
               ->orWhere('phone', 'like', '%'.$q.'%')
               ->orderBy('created_at', 'desc')
               ->paginate(10)->setPath ( '' );
                $pagination = $clients->appends ( array (
                'q' => Input::get ( 'q' )
                ) );
              foreach($clients as $index => $client){
                    $query = Invoice::where('client_id', $client->id)->where('is_deleted','=',0);
                    $invoiceData = $query->latest()->first();
                    $client->invoiceAmount = $invoiceData ? DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','!=','DRAFT')->where('is_deleted','=',0)->sum('net_amount') : '';
                    $client->totalInvoices = $query->count();
                  }
              if (count ($clients) > 0){ //by user name data view
                    $total_row = $clients->total(); //dd($total_row);
                  return view ('show-client',compact('total_row','clients'))->withQuery ( $q )->withMessage ($total_row.' '. 'Clients found match your search');
               }else{ 
                  return view ('show-client')->withMessage ( 'Clients not found match Your search !' );
               }
          /// end else search by date
         } 
        /// end if search any data
       }else{
        /// else search any data
            $user = User::find($id);
            $clients = $user->clients()->latest()->paginate(10); //dd($clients);
            foreach($clients as $index => $client){
                    $query = Invoice::where('client_id', $client->id)->where('is_deleted','=',0);
                    $invoiceData = $query->latest()->first();
                    $client->invoiceAmount = $invoiceData ? DB::table("invoices")->where('user_id',$id)->where('client_id','=',$client->id)->where('status','!=','DRAFT')->where('is_deleted','=',0)->sum('net_amount') : '';
                    $client->totalInvoices = $query->count();
                  }
              return view ( 'show-client')->withClients($clients);
        /// end else search any data
       } 
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
                      
                            


                          
                              

}
