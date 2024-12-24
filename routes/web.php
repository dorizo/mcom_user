<?php

use App\Events\MessageCreated;
use App\Http\Controllers\Callback;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\digiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\notifController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\webhookController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\admin\AdminHomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get("admin/home",[AdminHomeController::class , "index"])->name("homeadmin");

Route::get("/" , [HomeController::class , "index"])->name("home")->middleware("auth");
Route::get("login" , [LoginController::class , "login"])->name("login");
Route::get("register" , [LoginController::class , "register"])->name("register");
Route::post("login" , [LoginController::class , "store"]);
Route::post("register",[LoginController::class , "registerstore"]);
Route::get("topup",[TopupController::class , "menutopup"]);
Route::get("bcamanual",[TopupController::class , "bcamanual"]);
Route::post("bcamanual",[TopupController::class , "bcamanualstore"]);
Route::get("pulsa",[TransaksiController::class , "pulsa"]);
Route::post("cektransaksi",[TransaksiController::class , "cektransaksi"]);
Route::post("cektransaksiwalet",[TransaksiController::class , "cektransaksiwalet"]);

Route::post("transaksi" , [TransaksiController::class , "transaksi"]);
Route::get("detailtransaksi/{trx_id}" , [TransaksiController::class , "detailtransaksi"]);
Route::get("internet",[TransaksiController::class , "internet"]);
Route::get("dana",[TransaksiController::class , "dana"]);
Route::get("shopee",[TransaksiController::class , "shopee"]);
Route::get("gopay",[TransaksiController::class , "gopay"]);
Route::get("ml",[TransaksiController::class , "ml"]);
Route::get("ff",[TransaksiController::class , "ff"]);
Route::get("pln",[TransaksiController::class , "pln"]);
Route::post("cektransaksiinternet",[TransaksiController::class , "cektransaksiinternet"]);
Route::post("cektransaksigame",[TransaksiController::class , "cektransaksigame"]);
Route::get("notif/notifnumber" , function(){
    event(new MessageCreated(array("ppspspsp" => "ssss")));
});

Route::get("notification" , [HomeController::class , "notification"])->name("notification")->middleware("auth");
Route::get("news" , [HomeController::class , "news"])->name("news")->middleware("auth");
Route::get("bantuan" , [HomeController::class , "bantuan"])->name("bantuan")->middleware("auth");
Route::get("webhook/whatsapp" , [webhookController::class , "whatsapp"]);
Route::post("webhook/whatsapp" , [webhookController::class , "whatsapp"]);

Route::get('/callback/notive', [Callback::class, 'notive']);
Route::post('/callback/notive', [Callback::class, 'notive']);

Route::get("digiflazz/webhook" , [digiController::class , "digiflazz"]);
Route::post("digiflazz/webhook" , [digiController::class , "digiflazz"]);

Route::post("digi/harga" , [digiController::class , "index"]);
Route::post('notif/va',[notifController::class ,'va']);

// Route::get('logout', [LoginController::class, 'register'])->name('logout');
Route::post('logout', [LoginController::class, 'register'])->name('logout');

Route::resource('menu', App\Http\Controllers\MenuController::class); 
Route::put('menu/{menu}/menucontent', [App\Http\Controllers\MenuController::class, 'menucontent'])->name('menu.menucontent');
