<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Session;

class AdminHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function berita()
     {
         $berita = Berita::get();
         return view('user.berita',[
             'berita' => $berita ,
         ]);
     }
     public function beritavideo()
     {
         $berita = beritavideo::get();
         return view('user.beritavideo',[
             'berita' => $berita ,
         ]);
     }
     
     public function beritavideodetail(beritavideo $berita)
     {
         //
         $berita = beritavideo::get();
         return view('user.beritavideoview',[
             'berita' => $berita ,
         ]);
     }

    public function index()
    {
        return view('admin.admin');
    }
}
