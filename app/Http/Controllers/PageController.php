<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Validator;
use Redirect;
use Toastr;
use Carbon\Carbon;
use App\Page;
use Auth;


class PageController extends Controller
{
    public function index()
    {if(Auth::check()){
            if(Auth::user()->role == "admin"){
        $page = Page::orderBy('created_at','asc')->paginate(10);
        return view('Admin.Page.Show',['page' =>$page]);
        }
    }else{
        return redirect()->to('/login');
    }
    }

    public function create()
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        return view('Admin.Page.Add');
        }
    }else{
        return redirect()->to('/login');
    }
    }

    public function store(Request $request)
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

          $pageNameCheck = Page::where('page_name', '=', $request->page_name)->first();
          if($pageNameCheck){
            Toastr::error('Page Already Make', 'Sorry', ["positionClass" => "toast-bottom-right"]);
           return redirect()->back(); 
         }else{
           $pageSetup = Page::create($data);
            Toastr::success('Page Add', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/page/show'); 
         }   

    }

    public function edit($id)
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $page = Page::find($id);
        return view('Admin.Page.Edit',['page' =>$page]);
        }
    }else{
        return redirect()->to('/login');
    }
    }

    public function update(Request $request, $id)
    {
        $validate = $this->validate($request, [
            'page_name' => 'required',

        ]);
        if(!$validate){
            Redirect::back()->withInput();
        }
        $pageSetup = Page::find($id);
        $data = request(['title','description','heading','sub_heading','button_text','button_link','page_name']);
        if($request->file('uploadFile')){
            foreach ($request->file('uploadFile') as $key => $value) {

                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('images/banner'), $imageName);
                $data['image'] = $imageName;
            }
            $pageSetup->update($data);
            Toastr::success('Page updated', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/page/show');
        }else{
            $pageSetup->update($request->all());
            Toastr::success('Page updated', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/page/show');
        }

    }

    public function destroy($id)
    {
        if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $page = Page::find($id);
        $page->delete();
        Toastr::success('Page deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/page/show');
        }
    }else{
        return redirect()->to('/login');
    }
    }
}
