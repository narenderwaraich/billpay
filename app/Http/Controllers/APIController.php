<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
class APIController extends Controller
{
    
    public function getStateList(Request $request)
    {   
        $countryName = $request->country_id;
        $id = DB::table("countries")->where("name",$countryName)->pluck("id");
        $states = DB::table("states")
                    ->where("country_id",$id)
                    ->pluck("name","id");
        return response()->json($states);
    }
    public function getCityList(Request $request)
    {
        $stateName =$request->state_id;
        $id = DB::table("states")->where("name",$stateName)->pluck("id");
        $cities = DB::table("cities")
                    ->where("state_id",$id)
                    ->pluck("name","id");
        return response()->json($cities);
    }
}