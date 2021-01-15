<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Toastr;
use Redirect;
use Response;
use App\User;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $user = User::find($id);
        $items = $user->items()->latest()->paginate(10); //dd($items);
        return view ('show-items')->withItems($items);
    }

    public function allItems()
    {
        $items = Item::orderBy('created_at','desc')->paginate(20); //dd($items);
        return view ('Admin.Items.Show', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('add-item');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check()){
            $validate = $this->validate(request(),[
                      'item_name'=>'required|string|max:100',
                    ]);
            if(!$validate){
              Redirect::back()->withInput();
            }
            $userId = Auth::id();
            $itemName = $request->item_name;
                /// Check item_name record in database already exists or not
                if(sizeof(Item::where('user_id',$userId)->where('item_name','=',$itemName)->get()) > 0){
                  Toastr::error('Sorry Item already exists!', 'Error', ["positionClass" => "toast-top-right"]);
                    return back();
                }
            $item = request(['item_name','item_description','price','sale','qty']);
            $item['user_id'] = $userId;
            Item::create($item);

            Toastr::success('Item added', 'Success',["positionClass" => "toast-top-right"]);
            return redirect()->to('/items');
        }else{
                return redirect()->to('/login');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        return view ('edit-item',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::check()){
            $validate = $this->validate(request(),[
                      'item_name'=>'required|string|max:100',
                    ]);
            if(!$validate){
              Redirect::back()->withInput();
            }
            // $itemName = $request->item_name;
            //     /// Check item_name record in database already exists or not
            //     if(sizeof(Item::where('item_name','=',$itemName)->get()) > 0){
            //       Toastr::error('Sorry Item item name exists!', 'Error', ["positionClass" => "toast-top-right"]);
            //         return back();
            //     }
            $item = Item::find($id);    
            $itemData = request(['item_name','item_description','price','sale','qty']);
            $item->update($itemData);

            Toastr::success('Item Updated', 'Success',["positionClass" => "toast-top-right"]);
            return redirect()->to('/items');
        }else{
                return redirect()->to('/login');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->ids;
        DB::table("items")->whereIn('id',explode(",",$ids))->delete();
      return response()->json(['success'=>"Items Deleted successfully."]);
    }

    public function outInStockItem($id){
        $item = Item::find($id);
        $item->in_stock = !$item->in_stock;
        $item->save();
        Toastr::success('Item Stock Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
          return back();
    }

    public function dataAjax(Request $request)
    {
        $data = [];


        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("items")
                    ->select("id","item_name")
                    ->where('item_name','LIKE',"%$search%")
                    ->get();
        }


        return response()->json($data);
    }

    public function autocomplete(Request $request)
    {
        $data = Item::select("item_name")
                ->where("item_name","LIKE","%{$request->input('query')}%")
                ->get();
   
        return response()->json($data);
    }

}
