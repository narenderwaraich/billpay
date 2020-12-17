<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;
use Carbon\Carbon;
use App\User;
use App\GeneralSetting;
use Toastr;
use Redirect;
use Hash;
use Validator;
use App\Setting;
use App\Contact;
use App\Page;
use App\Clients;
use App\Invoice;
use App\InvoiceItem;

class AdminController extends Controller
{
    public function __construct(){
     $this->middleware('auth');
    }
    /// DashBorad Page
        public function homePage(){
                if(Auth::user()->role == 'admin'){
                    $activeUser =User::where('verified', '=', 1)->count();
                    $deActiveUser =User::where('verified', '=', 0)->count();
                    $newUser =User::whereMonth('created_at', '>=', Carbon::now()->subMonth(12))->count();
                    $userData =DB::table('users')
                         ->select(DB::raw('COUNT(*) as user_num'),DB::raw('DATE_FORMAT(created_at, "%Y-%m-01") as month'))
                         ->groupBy('month')
                         ->orderBy('month','asc')
                         ->get();
                    $totalUser = User::count();
                return view('Admin.index',compact('totalUser','activeUser','newUser','userData','deActiveUser'));
            }
            else{
                return view('login');
            }
        }

        public function index(){
      if(Auth::check()){
        if(Auth::user()->role == "admin"){
            $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
            $user = User::where('verified',1)->orderBy('created_at','desc')->paginate(10);
            return view('Admin.User.Show',compact('contacts'),['user' =>$user]);
          }
        }else{
              return redirect()->to('/login');
        }
    }

    public function userWithStatus($status){
          if(Auth::check()){
        if(Auth::user()->role == "admin"){
            
            $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
            $user = User::where('verified',$status)->orderBy('created_at','desc')->paginate(10);
            return view('Admin.User.Show',compact('contacts'),['user' =>$user]);
          }
          }else{
              return redirect()->to('/login');
          }
      }

    public function userWhatsapp($id){
       $user = User::find($id);
       $message = "Hey! I Can Help You";
       $num = "+91".$user->phone_no;
       $msg = $message;
       $opt = ['label' => 'Click to Chat', 'class' => 'btn btn-success'];
       $whatsappBtn = $this->make($num,$msg,$opt);

        return redirect($whatsappBtn);
    }

      public function SearchData(Request $request){
            $q = Input::get ( 'q' );
            /// Start user search by Name or email
            $user = User::where('name', 'like', '%'.$q.'%')
                 ->orWhere('email', 'like', '%'.$q.'%')
                 ->orWhere('phone_no', 'like', '%'.$q.'%')
                 ->orderBy('created_at', 'desc')
                 ->paginate(10)->setPath ( '' );
                  $pagination = $user->appends ( array (
                  'q' => Input::get ( 'q' )
                  ) );
                if (count ($user) > 0){ //by user name data view
                      $total_row = $user->total(); //dd($total_row);
                    return view ('Admin.User.Show',compact('total_row','user'))->withQuery ( $q )->withMessage ($total_row.' '. 'User found match your search');
                 }else{ 
                    return view ('Admin.User.Show')->withMessage ( 'User not found match Your search !' );
                 }
        }       

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.User.Add',compact('contacts'));
      }
        }else{
            return redirect()->to('/login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|string|max:50',
            'email'=>'required|string|email:unique|max:255',
            'password'=> 'required|string|min:6',
        ]);

        $user = User::create($request->all()); 
        Toastr::success('User Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        if($id == 1){
            Toastr::error('Admin Can not be edit', 'Error', ["positionClass" => "toast-top-right"]);
                        return back();
        }else{
        $user = User::find($id);
        
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.User.Edit',compact('contacts'),['user' =>$user]);
        }
      }
  }else{
      return redirect()->to('/login');
  }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $this->validate(request(),[
                  'name'=>'required|string|max:50',
                ]);
        if(!$validate){
          Redirect::back()->withInput();
        }
        $user = User::find($id);
        $data = request(['name','phone_no','gender','role']);
        $password = $request->password;
        $email =  $request->email;
        if ($email) {
          $checkEmail = User::where('email','=',$email)->first();
          if($checkEmail){
            Toastr::error('Email id already exit', 'Error', ["positionClass" => "toast-bottom-right"]);
            return back();
          }else{
            $data['email'] = $email;
          }
        }
        
        if($password){
          $data['password'] = Hash::make($password);
        }
        $user->update($data);
        Toastr::success('User Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/user');
    }

    public function changePassGet(){
      if(Auth::check()){
        if(Auth::user()->role == "administrator" || Auth::user()->role == "admin"){
            //$id = Auth::id();
            
            $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
            return view('Admin.ChangePassword',compact('contacts'));
          }
      }else{
          return redirect()->to('/login');
      }
    }

    public function changePass(Request $request){
        $validate = $this->validate(request(),[
                        'current_password' => 'required',
                        'new_password' => 'required|confirmed|string|min:6',
                    ]);
                 if(!$validate){ 
                  Redirect::back()->withInput();
                }
              $data = $request->all();
              $user = User::find(auth()->user()->id);
              if(!Hash::check($data['current_password'], $user->password)){
                Toastr::error('The specified password does not match the database password', 'Error', ["positionClass" => "toast-top-right"]);
                        return back();
              }else{
                  $password = $request->new_password;
                  $user->update(['password' => Hash::make($password)]);
                 Toastr::success('Password Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
                                     return redirect()->to('/admin');
              }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        if($id == 1){
            Toastr::error('Admin Can not be deleted', 'Error', ["positionClass" => "toast-top-right"]);
                        return back();
        }else{
        $user = User::find($id);
        $user->delete();
      Toastr::success('User Deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/admin');
        }
      }
}else{
    return redirect()->to('/login');
}
    }

     public function verifyUser($id){
      if(Auth::check()){
        if(Auth::user()->role == "admin"){
            $user = User::find($id);
            $user->verified = !$user->verified;
            $data['email_token'] = "";
            $user->update($data);
            Toastr::success('User Verified', 'Success', ["positionClass" => "toast-bottom-right"]);
                return back();
          }
        }else{
            return redirect()->to('/login');
        }
        }

    public function verifyMailReminder($id){
      if(Auth::check()){
        if(Auth::user()->role == "admin"){
           $user = User::find($id);
           Mail::to($user->email)->send(new EmailVerification($user));
           Toastr::success('Verify mail reminder sent', 'Success', ["positionClass" => "toast-bottom-right"]);
              return back();
          }
        }else{
            return redirect()->to('/login');
        }
    }
    
    public function enableDisableUser($id){
      if(Auth::check()){
          if(Auth::user()->role == "admin"){
            $user = User::find($id);
            $user->suspend = !$user->suspend;
            $user->save();
            Toastr::success('User Suspend', 'Success', ["positionClass" => "toast-bottom-right"]);
                return back();
          }
      }else{
          return redirect()->to('/login');
      }
        }

    // Web Setting 
    public function settingPage()
    {
      if(Auth::check()){
        if(Auth::user()->role == "admin"){
        
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        $id =1;
        $data = Setting::find($id);
        return view('Admin.settings',compact('contacts'),['data' =>$data]);
        }
}else{
    return redirect()->to('/login');
}
    }
    public function settingUpdate(Request $request)
    {
        $id =1;
        $setting = Setting::find($id);
        $data = $request->all();
        $coupanExpTime = $request->coupan_exp_time;
        if($coupanExpTime){
          $data['coupan_exp_time'] = $coupanExpTime; 
        }
        $setting->update($data);
        Toastr::success('Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
        return back();
    }


    //// Page Setup All function

    public function pageIndex()
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $pageSetup = BanerSlide::orderBy('created_at','desc')->paginate(8);
        return view('Admin.PageSetup.Show',['pageSetup' =>$pageSetup]);
      }
    }else{
        return redirect()->to('/login');
    }
    }
    
    public function pageCreate()
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $pages = Page::All();
        return view('Admin.PageSetup.Add',['pages' => $pages]);
      }
    }else{
        return redirect()->to('/login');
    }
    }

    public function pageStore(Request $request)
    {
        $validate = $this->validate($request, [
            'page_name' => 'required',
        ]);
        if(!$validate){
            Redirect::back()->withInput();
        }
        $data = request(['title','description','heading','sub_heading','button_text','button_link','page_name']);
        if($request->file('uploadFile')){
            foreach ($request->file('uploadFile') as $key => $value) {

                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('images/banner'), $imageName);
                $data['image'] =$imageName;
            }
        }
        if($request->page_name == "home"){
            $pageSetup = BanerSlide::create($data);
        Toastr::success('Banner Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/page-setup/show');
        }else{
          $pageNameCheck = BanerSlide::where('page_name', '=', $request->page_name)->first();
          if($pageNameCheck){
            Toastr::error('Page Banner Already Make', 'Sorry', ["positionClass" => "toast-bottom-right"]);
           return redirect()->back(); 
         }else{
           $pageSetup = BanerSlide::create($data);
            Toastr::success('Banner Add', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/page-setup/show'); 
         }   
        }
        
    }
    public function pageEdit($id)
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $pageSetup = BanerSlide::find($id);
        $pages = Page::All();
        return view('Admin.PageSetup.Edit',['pageSetup' =>$pageSetup, 'pages' => $pages]);
      }
}else{
    return redirect()->to('/login');
}
    }
    public function pageUpdate(Request $request, $id)
    {
        $validate = $this->validate($request, [
            'page_name' => 'required',

        ]);
        if(!$validate){
            Redirect::back()->withInput();
        }
        $pageSetup = BanerSlide::find($id);
        $data = request(['title','description','heading','sub_heading','button_text','button_link','page_name']);
        if($request->file('uploadFile')){
            foreach ($request->file('uploadFile') as $key => $value) {

                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('images/banner'), $imageName);
                $data['image'] = $imageName;
            }
            $pageSetup->update($data);
            Toastr::success('Banner updated', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/page-setup/show');
        }else{
            $pageSetup->update($request->all());
            Toastr::success('Banner updated', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/page-setup/show');
        }
 
    }
    public function pageDestroy($id)
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $pageSetup = BanerSlide::find($id);
        $pageSetup->delete();
        Toastr::success('Banner Deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/page-setup/show');
        }
}else{
    return redirect()->to('/login');
}
    }

    public function openMySql(){
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $tables = DB::select('SHOW TABLES'); //dd($tables);
        return view('Admin.mysql',compact('tables'));
        }
}else{
    return redirect()->to('/login');
}
    }
    
    public function openQueryMySql(Request $request)
    {
      $queryData = $request->all(); 
      $query = $queryData['query']; //dd($query);
      $result = DB::select($query);
      echo "<pre>";
          print_r($result);
      echo "</pre>";
    }

    public function userView($id){
      $user = User::find($id);
      $userAddress = UserAddress::where('user_id',$id)->first();
      return view('Admin.User.View',compact('user','userAddress'));
    }

    public function envData(){
        if(Auth::user()->role == 'admin'){
            return view('Admin.env-file');
        }else{
                return view('login');
            }
     }

     public function changeEnvData(Request $request){
        if(Auth::user()->role == 'admin'){
            $key = $request->key; //"MAIL_FROM_ADDRESS";
            $value = $request->value; //"info@maplelabs.com";
            $this->setEnv($key, $value);
            Toastr::success('Value Changed', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/change-env-file-data');
        }else{
                return view('login');
            }
     }

        private function setEnv($key, $value)
        { 
            //echo env('MAIL_FROM_ADDRESS');
            file_put_contents(app()->environmentFilePath(), str_replace(
                    env($key),
                    $value,
            file_get_contents(app()->environmentFilePath())
            ));
        }

        public function clearCache(){

            \Artisan::call('cache:clear');
            Toastr::success('Cache clear successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/change-env-file-data');
        }

        public function clearConfig(){

            \Artisan::call('config:clear');
            Toastr::success('Config clear successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/change-env-file-data');
        }

        public function make($number, $message='', $options = array())
    {
        $options = array_replace($this->options,$options);
        $link = $this->link($number, $message);

        return  $link;

        // return  '<a href="'.$link.'">'.
        //             '<button type="button" class="'.$options['class'].'">'.
        //                 $options['label'] .
        //             '</button>'.
        //         '</a>';
    }
    public function link($number, $message=''){
        $final_url = $this->base_url . '/'.$this->filterNumber($number);
        return $final_url . "?" . http_build_query(['text' => $message]);
    }

    private function filterNumber($number){
        $number = str_replace(['(',')','-','/','+'],'',$number);
        $number = (int)$number;
        return $number;
    }

    public function allUserList(){
      $user = User::all();
      return view('Admin.all-users',['user' =>$user]);
    }

    public function subscribeUnsubscribe($id){
      if(Auth::check()){
          if(Auth::user()->role == "admin"){
            $user = User::find($id);
            $user->mail_subscribe = !$user->mail_subscribe;
            $user->save();
            Toastr::success('User Subscribe', 'Success', ["positionClass" => "toast-bottom-right"]);
                return back();
          }
      }else{
          return redirect()->to('/login');
      }
    }  

    public function SendNotificationMail(Request $request){
        if(Auth::user()->role == 'admin'){
            $ids = $request->ids; //dd($ids);
            $id = explode(",",$ids);
            $alluser = User::whereIn('id',$id)->where('mail_subscribe', '=', 1)->get(); //dd($alluser);
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
          }else{
                  return view('login');
                }
     }


     public function allClients(){
      $clients = Clients::orderBy('created_at','desc')->paginate(20);
      foreach ($clients as $client) {
        $user = User::where('id',$client->user_id)->first();
        $client->user = $user ? $user->fname : '';
      }
      return view('Admin.Client.Show',compact('clients'));
     }

     public function allInvoices(){
      $invoices = Invoice::orderBy('created_at','desc')->paginate(20);
      foreach ($invoices as $invoice) {
        $client = Clients::where('id',$invoice->client_id)->first();
        $user = User::where('id',$invoice->user_id)->first();
        $invoice->client = $client ? $client->fname : '';
        $invoice->user = $user ? $user->fname : '';
      }
      return view('Admin.Invoice.Show',compact('invoices'));
     }                                       

}
