<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\UserCompany;
use App\Clients;
use App\Invoice;
use Redirect;
use Toastr;
use App\User;

class CompanyController extends Controller
{
    public function __construct()
          {
              $this->middleware('auth');
          }
  
  public function create(){
    if(Auth::user()->role == 'user'){
    $id = Auth::id();
        return view('Add-Company', ['id' => $id]);
        }else{
        return redirect()->to('/dashboard');
      }
    }

    public function store(Request $request){

        $data = request(['name']);
        
        $data['user_id'] = Auth::id();

        $this->validate(request(),[
        'name'=>'required|string|max:50',
  
        ]);
         
        
        $user = UserCompany::create($data);
        if($request->logo){
           $imageName = time().'.'.request()->logo->getClientOriginalExtension();

        request()->logo->move(public_path('company_logo'), $imageName);
        $user->logo=$imageName; 
        }
        
        $user->save();
        Toastr::success('Company Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/ShowCompany');
        
    }
    public function showCompany(){
       $id = Auth::id();
    //$companies = User::find($id)->userCompany;
 $companies = UserCompany::where('user_id', $id)->latest()->paginate(10);
        return view('show-company',compact('companies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
       
  
 }

    public function getCompany(Request $request){
        $company = UserCompany::find($request->company_id);

        return response()->json(['logo' => $company->logo, 'name' => $company->name]);
    }

    ///update company data
    public function editCompany($id){
        $company = UserCompany::find($id);
        return view('update-company',compact('company', 'id'));
    }

     public function updateCompany(Request $request, $id){

        $this->validate(request(),[
        'name'=>'required|string|max:50',
        ]); 

        $CompanyData = request(['name']);
        if($request->logo){
            $imageName = time().'.'.request()->logo->getClientOriginalExtension();
            request()->logo->move(public_path('company_logo'), $imageName);
            $CompanyData['logo'] = $imageName;
        }
        
         UserCompany::where('id',$id)->update($CompanyData);
        Toastr::success('Company Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/ShowCompany');
                       
     }

     /// in clients page with add company

     public function storeCompany(){

        $data = request(['name']);
        
        $data['user_id'] = Auth::id();

        $this->validate(request(),[
        'name'=>'required|string|max:50',
  
        ]);
        $user = UserCompany::create($data);
        if(request()->logo){
            $imageName = time().'.'.request()->logo->getClientOriginalExtension();
            request()->logo->move(public_path('company_logo'), $imageName);
            $user->logo=$imageName;
        }        
        $user->save();
        return response()->json(['id'=>$user->id,'name'=>$user->name,'logo'=>$user->logo]);
    }

                public function destroy($id)
                  {
                    $checkInvoice = Invoice::where('companies_id', '=', $id)->first();
                    if(!$checkInvoice){
                      $checkClient = Clients::where('companies_id', '=', $id)->first();
                    if(!$checkClient){
                      UserCompany::destroy($id);
                      Toastr::success('Company deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
                      return redirect()->to('/ShowCompany');
                                        
                      }else{
                        return redirect()->to('/ShowCompany')->withErrors([
                                                                    'Company can not delete first delete client  this company'
                                                                    ]);
                      }  
                  }else{
                    return redirect()->to('/ShowCompany')->withErrors([
                                                                    'Sorry company can not delete'
                                                                    ]);
                  }
                    
                      
                  }
       
}