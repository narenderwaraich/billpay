<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Redirect;
use Toastr;
use App\Contact;
use App\Page;

class ContactUsController extends Controller
{
  public function contact(){
        $pageName = "contact_us";
        $page = Page::where('page_name',$pageName)->first(); //dd($page);
        $title = $page ? $page->title : '' ;
        $description = $page ? $page->description : '';
      return view('Contact-Us',compact('title','description'));
  }
   public function contactUs(Request $request){
   	$validate = $this->validate(request(),[
            'name'=>'required|string|max:50',
            'email'=>'required|string|email|max:255',
            'message'=>'required|string|max:255',
          ]);
          if(!$validate){
            Redirect::back()->withInput();
          }
          Contact::create(request(['name','message','email','phone']));
   	Toastr::success('Message Sent', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/');
   }


   public function getContact(){
    if(Auth::check()){
    if(Auth::user()->role == "admin" || Auth::user()->role == "administrator"){
          $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
          $getContacts = Contact::orderBy('created_at','desc')->paginate(10); //dd($contacts);
        return view('Admin.contact',compact('contacts'),['getContacts' =>$getContacts]);
        }
    }else{
        return redirect()->to('/login');
    }
   }
   
   public function contactReplyGet($id){
    if(Auth::check()){
    if(Auth::user()->role == "admin" || Auth::user()->role == "administrator"){
        $contact = Contact::find($id); //dd($contact);
        return view('Admin.contactReply',compact('contacts'),['contact' =>$contact]);
        }
    }else{
        return redirect()->to('/login');
    }
   }

   public function contactMarkReply($id){
    if(Auth::check()){
    if(Auth::user()->role == "admin" || Auth::user()->role == "administrator"){
        $status['status'] = "Reply";
        Contact::where('id',$id)->update($status);
        Toastr::success('Message mark reply', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/admin/contact-us');
        }
    }else{
        return redirect()->to('/login');
    }
   }

   public function contactReply(Request $request){
      $email = $request->email;
      $reply = $request->reply;
      $mesg_id = $request->id;
      $status['status'] = "Reply";
      $status['reply_message'] = $reply;
      Contact::where('id',$mesg_id)->update($status);
      Mail::to($email)->send(new ContactReply($reply));
      if (Mail::failures()) {
        // return response showing failed emails
        Toastr::error('Message not Send', 'Error', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/admin/contact-us');
      }
      Toastr::success('Message Reply', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/admin/contact-us');
   }

   public function sendMailView(){
    if(Auth::check()){
    if(Auth::user()->role == "admin" || Auth::user()->role == "administrator"){
          $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.send-Mail',compact('contacts'));
        }
    }else{
        return redirect()->to('/login');
    }
   }

   public function sendMail(Request $request){
      $email = $request->email;
      $subject = $request->subject;
      $message = $request->message;
      $document = $request->document;
      if($document){
        if ($document->getError() == 1) {
          $max_size = $document->getMaxFileSize() / 1024 / 1024;  // Get size in Mb
          $error = 'The document size must be less than ' . $max_size . 'Mb.';
          Toastr::error($error, 'Error', ["positionClass" => "toast-top-right"]);
          return redirect()->back();
        }
      }
      $data = [
        'subject' => $subject,
        'document' => $document,
        'message' => $message
      ];
      //dd($data);
      // $data = [];
      // $data['message'] = $message;
      // $data['subject'] = $subject;
      Mail::to($email)->send(new EMail($data));
      Toastr::success('Mail Send', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->to('/admin');
   }


   public function SendNotificationMail(Request $request){
          $ids = $request->ids; //dd($ids);
          $id = explode(",",$ids);
          $alluser = User::whereIn('id',$id)->where('verified', '=', 1)->get(); //dd($alluser);
          $subject = $request->subject;
          $message = $request->message;
          foreach ($alluser as $userNumber => $user) {
          $data = [];
          $data['name'] = $user->name;
          $data['email'] = $user->email;
          $data['user_id'] = $user->id;
          $data['message'] = $message;
          $data['subject'] = $subject;
          $data['created_at'] = Carbon::now();
          Mail::to($user->email)->send(new SendEMail($data));
          // $send = SendMail::create($data);
          }
          Toastr::success('Mail Send', 'Success', ["positionClass" => "toast-top-right"]);
          return redirect()->to('/user');
      
   }

   public function aboutUs(){
        $pageName = "about_us";
        $page = Page::where('page_name',$pageName)->first(); //dd($page);
        $title = $page ? $page->title : '' ;
        $description = $page ? $page->description : '';
      return view('about-us',compact('title','description'));
  }

  public function termOfServices(){
        $pageName = "term_of_services";
        $page = Page::where('page_name',$pageName)->first(); //dd($page);
        $title = $page ? $page->title : '' ;
        $description = $page ? $page->description : '';
      return view('term-of-services',compact('title','description'));
  }

  public function privacyPolicy(){
        $pageName = "privacy_policy";
        $page = Page::where('page_name',$pageName)->first(); //dd($page);
        $title = $page ? $page->title : '' ;
        $description = $page ? $page->description : '';
      return view('privacy-policy',compact('title','description'));
  }

  public function whatsapp(){
       $message = "Hey!";
       $num = env('WHATAPPS_NUMBER');
       $whatsappLink = "https://wa.me/".env('WHATAPPS_NUMBER')."/?text=".$message;

        return redirect($whatsappLink);
    }

}
