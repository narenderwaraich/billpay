<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserInvoiceNotification;
use App\User;
use App\Clients;
use App\UserCompany;
use App\Invoice;
use App\InvoiceItem;
use Mail;
use App\Mail\InvoiceReminder;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Toastr;
use Redirect;
use Response;

class InvoiceNotification extends Controller
{
    		  public function sendReminder(){
                    $allinvoice = Invoice::where('status','=','OVERDUE')->get();
                    foreach ($allinvoice as $key => $inv) {
                       $this->SendAutoReminder($inv->id);
                      }
                  }

              public function SendAutoReminder($id){
                         $inv = Invoice::find($id);
                         $userId = $inv->user_id;
                         $invItem = InvoiceItem::where('invoice_id', $id)->get();
                         $companies_id = $inv->companies_id;
                         $clientsId = $inv->client_id;
                         $companyData = UserCompany::find($companies_id);
                         $clientData = Clients::find($clientsId);
                         $mail = $clientData->email;
                         $userData = User::find($userId);
                         /// Days get old overdue 
                         $dueDate = Carbon::parse($inv->due_date);
                         $nowDate = Carbon::now();
                         $day =  $nowDate->diffInDays($dueDate);
                         Mail::to($mail)->send(new InvoiceReminder($invItem, $inv, $clientData, $companyData, $userData, $day));                      
              }
}
