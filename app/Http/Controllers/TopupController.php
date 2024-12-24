<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\topupmanual;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopupController extends Controller
{
    //
    public function menutopup(){
        return Inertia::render("Topupmenu" ,[]);
    }
    public function bcamanual(){
        
        return Inertia::render("bcamanual" , [
            "manual" => topupmanual::orderby("id" , "desc")->get()
        ]);
    }
    public function bcamanualstore(Request $request){
        $this->validate($request, [
            'jumlah'     => 'required',
        ]);
        $saldo =  substr($request->jumlah , 0, -3).rand(100,1000);
        $transaksiCode = 'INV-'.Str::uuid();
        $saldo = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $saldo);
        topupmanual::create([
            'userID' => Auth::user()->id,
            'Trx_ID' => $transaksiCode,
            'saldo' => $saldo,
            'responseData' =>"",
            'status' => "PENDING",
        ]);
    }
}
