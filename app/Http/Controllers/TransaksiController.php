<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\harga;
use App\Models\Pulsa;
use App\Models\Paramnomor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TransaksiController extends Controller
{
    //
    public function pulsa(Request $request){
       return Inertia::render("pulsa" , []);
    }
    
    public function internet(Request $request){
        return Inertia::render("internet" , []);
     }
    
     public function dana(Request $request){
         return Inertia::render("dana" , []);
      }
     
    
    public function shopee(Request $request){
        return Inertia::render("shopee" , []);
     }
     
    
    public function gopay(Request $request){
        return Inertia::render("gopay" , []);
     }
     
    public function ml(Request $request){
        return Inertia::render("gameml" , []);
     }
     
    public function ff(Request $request){
        return Inertia::render("gameff" , []);
     }
      
    public function pln(Request $request){
        return Inertia::render("pln" , []);
     }
     
    public function cektransaksiwalet(Request $request){
        $this->validate($request, [
            'phone'     => 'required',
        ]);
        
        $param = Str::limit($request->phone , 4,''); 
        $p = Paramnomor::select("provider")->where("param" , $param)->first();
        // print_r($request->all());
        if(!$p){
            return  Redirect::back()->withErrors(["phone" => "nomor tidak terdaftar"]);
        }
        return Redirect::back()->with([
            'message' => $p->provider,
            'body' => harga::where(["brand" => $request->brand ,"type" => $request->type,"category" => $request->category ])->get(),
        ]);
    }
    public function cektransaksigame(Request $request){
        
        return Redirect::back()->with([
            'message' => "GAME",
            'body' => harga::where(["brand" => $request->brand ,"type" => $request->type,"category" => $request->category ])->get(),
        ]);
    }
    public function cektransaksi(Request $request){
        $this->validate($request, [
            'phone'     => 'required',
        ]);
        
        $param = Str::limit($request->phone , 4,''); 
        $p = Paramnomor::select("provider")->where("param" , $param)->first();
        // print_r($request->all());
        if(!$p){
            return  Redirect::back()->withErrors(["phone" => "nomor tidak terdaftar"]);
        }
        return Redirect::back()->with([
            'message' => $p->provider,
            'body' => harga::where(["brand" => $p->provider ,"type" => $request->type,"category" => $request->category ])->get(),
        ]);
    }
    public function cektransaksiinternet(Request $request){
        $this->validate($request, [
            'phone'     => 'required',
        ]);
        
        $param = Str::limit($request->phone , 4,''); 
        $p = Paramnomor::select("provider")->where("param" , $param)->first();
        // print_r($request->all());
        if(!$p){
            return  Redirect::back()->withErrors(["phone" => "nomor tidak terdaftar"]);
        }
        return Redirect::back()->with([
            'message' => $p->provider,
            'body' => harga::where(["brand" => $p->provider ,"category" => $request->category ])->get(),
        ]);
    }
    
    
    public function transaksi(Request $request){
        $opration = Auth::user();
        if($request->price <=  $opration->saldo){
            $memberid = Str::uuid();
            $s = $this->isipulsa($request->kode,$request->phone,$memberid);
            $resdata = json_decode($s , true);
            print_r($resdata["data"]);
            Pulsa::create([
            'nomor' => $opration->phone,
            'trx_id' => $memberid,
            'userID' => $opration->id ,
            'code'=> $request->kode,
            'price'=> $request->price,
            'hargadasar'=> $request->hargadasar,
            'response' => "",
            'callback'=>"",
            'kategori' => "REGULER"
        ]);
        $saldoasli = $opration->saldo - $request->price;
        User::where("id" , $opration->id )->update(["saldo" => $saldoasli]);
        return redirect("/detailtransaksi"."/".$memberid)->withErrors(["success" =>"success"]);
        // return  Redirect::back()->withErrors(["error" => "nomor tidak terdaftar"]);
        }else{
        $saldonumber = number_format($opration->saldo, 0, ',', '.');
        $pesandata = "Saldo Anda tidak cukup lakukan topup terlebih dahulu karena saldo anda sekarang *$saldonumber*";
        return  Redirect::back()->withErrors(["error" =>$pesandata]);
        }
    }
    

        public function isipulsa($kode , $nomor , $refid){
                $curl = curl_init();
                // echo $_ENV["digiusername"]."+".$_ENV["digikey"]."+".$refid;
                $digikeys = md5(env("digiusername").env("digikey").$refid);
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.digiflazz.com/v1/transaction',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST =>  false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "username": "xoyajiDakOdg",
                    "buyer_sku_code": "'.$kode.'",
                    "customer_no": "'.$nomor.'",
                    "ref_id": "'.$refid.'",
                    "sign": "'.$digikeys.'"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                $this->digi_log("class" , $response);
                return $response;
        }
        
    function digi_log($class, $log_msg, $invoice_number = '')
    {
        $log_filename = "digi_log";
        $log_header = date(DATE_ATOM, time()) . ' ' . 'Notif ' . '---> ' . $invoice_number . " : ";
        if (!file_exists($log_filename)) {
            // create directory/folder uploads.
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename . '/log_' . date('d-M-Y') . '.log';
        // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
        file_put_contents($log_file_data, $log_header . json_encode($log_msg) . "\n", FILE_APPEND);
    }
    function detailtransaksi(Request $request){
        return Inertia::render("detailtransaksi" , [
            "detail" => Pulsa::select("hargas.*","pulsas.*")->JOIN("hargas" , "pulsas.code" , "hargas.buyer_sku_code")->where("trx_ID" ,$request->trx_id )->first()
        ]);
    }
}
