<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InvoicePlan;
use App\Page;

class HomeController extends Controller
{
    public function index()
    {
    	$pageName = "home";
    	$page = Page::where('page_name',$pageName)->first(); //dd($page);
        $title = $page ? $page->title : '' ;
        $description = $page ? $page->description : '';
        $plans = InvoicePlan::all();
        return view('home',compact('title','description','plans'));
    }
}
