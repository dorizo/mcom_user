<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Pulsa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Events\MessageCreated;

class HomeController extends Controller
{
    //
    public function index(Request $request){
        return Inertia::render("mcom" ,[
            "transaksi" => Pulsa::JOIN("hargas" , "buyer_sku_code" , "code")->limit(10)->orderby("pulsas.id" , "desc")->get()
        ]);
    }
    
    public function notification(Request $request){
        return Inertia::render("notification" ,[
            "transaksi" => Pulsa::JOIN("hargas" , "buyer_sku_code" , "code")->limit(15)->get()
        ]);
    }
    
    public function news(Request $request){
        return Inertia::render("news" ,[
            "transaksi" => Pulsa::JOIN("hargas" , "buyer_sku_code" , "code")->limit(15)->get()
        ]);
    }
    
    public function bantuan(Request $request){
        return Inertia::render("bantuan" ,[
            "transaksi" => Pulsa::JOIN("hargas" , "buyer_sku_code" , "code")->limit(15)->get()
        ]);
    }
}
