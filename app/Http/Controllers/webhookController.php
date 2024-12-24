<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\harga;
use App\Models\Pulsa;
use App\Models\Paramnomor;
use App\Models\topupmanual;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class webhookController extends Controller
{
    public function whatsapp(Request $request){
        
        $mode  = $request->get('hub_mode');
        $token = $request->get('hub_verify_token');
        $challenge = $request->get('hub_challenge');

        if ($mode === "subscribe" &&  $token === "#Citm0029") {
            $this->doku_log("Notif ", 'TRANSAKSI BERULANG  200', 'Notification');
            return response($challenge,200);
        }
        // print_r($request->all());

        $wa = $request->all();
        if($wa["entry"][0]["id"] == 362127350317709){
        foreach ($wa["entry"] as $key => $entry) {
            foreach ($entry["changes"] as $key1 => $changes) {
                foreach ($changes["value"]["messages"] as $key2 => $messages) {
                    
                    $this->doku_log("walog" , $wa);
                    //jika belum terdaftar jadi member
                    if($this->daftar($messages["from"])==0){
                        if(isset($messages["interactive"])){
                            if(isset($messages["interactive"]["nfm_reply"])){
                                $json = json_decode($messages["interactive"]["nfm_reply"]["response_json"]);
                                $json->phone = $messages["from"];
                                $json->foto     = URL::to("profile/default.jpg");
                                $json->saldo     = 0;
                                $json->password  = bcrypt($messages["from"]+"123");
                                
                                $m =  User::where("email" , $json->email)->count();
                                if($m >=1){
                                    $this->pesantext($messages["from"] , "maaf *email anda sudah terdaftar* mohon daftar kembali dengan email yang belum terdaftar dan ketikan daftar");
                                }else{
                                    $json = (array)$json;
                                    User::create($json);
                                    $this->pesantext($messages["from"] , "anda berhasil terdaftar sebagai  *member baru di RajaJualan* Silahkan ketikan *menu* untuk memulai transaksi \\nstatus anda sekarang adalah member yuk tingkatkan transaksi anda agar bisa menjadi *AGEN* syarat menjadi agen \\ntransaksi minimal 20 per bulan \\nminimal saldo tertahan 100.000 \\nnikmatilah transaksi anda dengan ");                        
                                } ;
                                
                            }
                        }else{
                            // $this->pesantext($messages["from"] , "maaf *email anda sudah terdaftar* mohon daftar kembali dengan email yang belum terdaftar dan ketikan daftar");
                            
                            $this->pendaftaranwa($messages["from"]);
                        };
                        return;
                    };
                    //sudah terdaftar jadi member
                    if(isset($messages["text"])){
                        if(strtoupper($messages["text"]["body"]) == strtoupper("menu") ){
                            $this->menuutama($messages["from"]);
                        };
                        if(strtoupper($messages["text"]["body"]) == strtoupper("cek") ){
                            $userdata = User::where("phone" , $messages["from"])->first();
                            $pesandata = "akun dengan \\nnama :$userdata->name \\nnomor : $userdata->phone\\n*saldo : $userdata->saldo* \\n*Akun : $userdata->akun* \\n\\nuntuk tutorial deposit bisa cek link youtube dibawah:\\nhttps://youtu.be/RDDE_kd3e_I?si=6Nu051fFEMFKTSNW ";
                            $this->pesantext($messages["from"] , $pesandata);
                            return response()->json(['success' => 'success'], 200);
                        };
                       

                        $opration = User::select( "id","lastopration")->where("phone" ,$messages["from"] )->first();
                        if($opration){
                            //step ke 2 setelah memilih deposit apa
                            if($opration->lastopration == "bcamanual"){
                                if($messages["text"]["body"] <=10000){
                                    $pesandata = "Jumlah transfer harus lebih dari 10.000  ketikan jangan mengunakan *titik atau koma*";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return  response()->json(['success' => 'success'], 200);
                                }
                                $this->bcamanual($messages["from"] , $messages["text"]["body"],$opration->id);
                                return response()->json(['success' => 'success'], 200);
                            }
                            
                            if($opration->lastopration == "brimanual"){
                                if($messages["text"]["body"] <=10000){
                                    $pesandata = "Jumlah transfer harus lebih dari 10.000  ketikan jangan mengunakan *titik atau koma*";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return  response()->json(['success' => 'success'], 200);
                                }
                                $this->brimanual($messages["from"] , $messages["text"]["body"],$opration->id);
                                return response()->json(['success' => 'success'], 200);
                            }
                            if($opration->lastopration == "briva"){
                                if($messages["text"]["body"] < 100000){
                                    $pesandata = "Jumlah transfer harus lebih dari 100.000 / ketikan jangan mengunakan *titik atau koma*";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return  response()->json(['success' => 'success'], 200);
                                }
                                $doku = new dokuController();
                                $pesandata =  $doku->briVa($messages["from"], $messages["text"]["body"]);
                                $this->pesantext($messages["from"] , $pesandata);
                                return response()->json(['success' => 'success'], 200);
                            }
                            // deposit mandiri
                            if($opration->lastopration == "mandiriva"){
                                if($messages["text"]["body"] < 10000){
                                    $pesandata = "Jumlah transfer harus lebih dari 100.000 /  ketikan jangan mengunakan *titik atau koma*";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return  response()->json(['success' => 'success'], 200);
                                }
                                $doku = new dokuController();
                               $pesandata =  $doku->mandiriVa($messages["from"], $messages["text"]["body"]);
                                 $this->pesantext($messages["from"] , $pesandata);
                                 return response()->json(['success' => 'success'], 200);

                            }
                            // deposit bri
                            if($opration->lastopration == "dokuva"){
                                if($messages["text"]["body"] < 10000){
                                    $pesandata = "Jumlah transfer harus lebih dari 100.000 / ketikan jangan mengunakan *titik atau koma*";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return  response()->json(['success' => 'success'], 200);
                                }
                                $doku = new dokuController();
                                $pesandata =  $doku->dokuvaa($messages["from"], $messages["text"]["body"]);
                                $this->pesantext($messages["from"] , $pesandata);
                                return response()->json(['success' => 'success'], 200);
                            }
                            if($opration->lastopration == "pulsa"){
                                $this->pulsa($messages["from"] ,$messages["text"]["body"]);
                                return response()->json(['success' => 'success'], 200);

                            }
                            if($opration->lastopration == "internet"){
                                $this->internet($messages["from"] ,$messages["text"]["body"]);
                                return response()->json(['success' => 'success'], 200);

                            }
                            if($opration->lastopration == "dana"){
                                $this->dana($messages["from"] ,$messages["text"]["body"]);
                                return response()->json(['success' => 'success'], 200);

                            }
                            if($opration->lastopration == "gopay"){
                                $this->gopay($messages["from"] ,$messages["text"]["body"]);
                                return response()->json(['success' => 'success'], 200);

                            }
                            if($opration->lastopration == "shopee"){
                                $this->shopee($messages["from"] ,$messages["text"]["body"]);
                                return response()->json(['success' => 'success'], 200);

                            }
                            if($opration->lastopration == "pln"){
                                $this->pln($messages["from"] ,$messages["text"]["body"]);
                                return response()->json(['success' => 'success'], 200);

                            } 
                            if($opration->lastopration == "MOBILE LEGENDS"){
                                $this->game($messages["from"] ,$messages["text"]["body"] , "MOBILE LEGENDS");
                                return response()->json(['success' => 'success'], 200);

                            }
                            if($opration->lastopration == "FREE FIRE"){
                                $this->game($messages["from"] ,$messages["text"]["body"] , "FREE FIRE");
                                return response()->json(['success' => 'success'], 200);

                            }
                            
                            
                            
                        }

                    }else{
                        //fungsi untuk pendaftaran anggota baru
                        if(isset($messages["interactive"])){
                            if(isset($messages["interactive"]["nfm_reply"])){
                                print_r($messages["interactive"]["nfm_reply"]["response_json"]);
                            }
                            if(isset($messages["interactive"]["list_reply"])){
                                //hasil dari replay button yang dikirim jadi json disini ya
                                $idreplay = $messages["interactive"]["list_reply"]["id"];
                                
                                if($idreplay == "ceksaldo"){
                                    // $this->doku_log("walog" , $idreplay);
                                    $userdata = User::where("phone" , $messages["from"])->first();
                                    $pesandata = "akun dengan \\nnama :$userdata->name \\nnomor : $userdata->phone\\n*saldo : $userdata->saldo* \\n*Akun : $userdata->akun* \\n\\nuntuk tutorial deposit bisa cek link youtube dibawah:\\nhttps://youtu.be/RDDE_kd3e_I?si=6Nu051fFEMFKTSNW ";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                };
                                // isi saldo
                                if($idreplay == "topup"){
                                    // $this->doku_log("walog" , $idreplay);
                                    $pesandata = "Silahkan isi saldo anda\\n*Deposit Transfer manual*\\ntidak terkena biaya trasaksi tetapi membutuhkan verifikasi \\n!!nilai deposit harus sesuai dengan nilai yang kami kirimkan dan konfirmasi ke no https://wa.me/6282310777783\\n*Deposit virtual account*\\nsaldo akan masuk secara otomatis tanpa verifikasi dengan biaya admin sebesar *5.000* per deposit\\nuntuk tutorial deposit bisa cek link youtube dibawah:\\nhttps://youtu.be/RDDE_kd3e_I?si=6Nu051fFEMFKTSNW ";
                                    $this->depositemenu($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                };

                                //walet menu awal
                                if($idreplay=="wallet"){
                                    $pesandata = "Silahkan memilih menu2 untuk E-wallet yang ada di list dengan harga terbaik";
                                        $this->waletmenu($messages["from"] , $pesandata);
                                        return response()->json(['success' => 'success'], 200);
                                }
                                
                                //walet menu awal
                                if($idreplay=="game"){
                                    $pesandata = "Silahkan memilih menu2 untuk Game yang ada di list dengan harga terbaik";
                                        $this->gamemenu($messages["from"] , $pesandata);
                                        return response()->json(['success' => 'success'], 200);
                                }
                                //menu awal listrik
                                

                                // fungsi untuk triger proses selanjutnya
                                    //fungsi untuk merubah opration agar masuk ke fungsi saat user menginputkan nomor
                                    // start deposite
                                if($idreplay == "bcamanual"){
                                    $this->lastop($messages["from"] , $idreplay);
                                    $pesandata = "Silahkan ketikan total deposit anda  (minimal deposit 10.000) ⬇️";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                }
                                if($idreplay == "brimanual"){
                                    $this->lastop($messages["from"] , $idreplay);
                                    $pesandata = "Silahkan ketikan total deposit anda  (minimal deposit 10.000) ⬇️";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                }
                                // deposit vadoku
                                if($idreplay == "briva"){
                                    $this->lastop($messages["from"] , $idreplay);
                                    $pesandata = "Silahkan ketikan total deposit anda  (minimal deposit 100.000) deposit lebik kecil gunakan transfer manual ⬇️";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                }
                                // deposit mandiri
                                if($idreplay == "mandiriva"){
                                    $this->lastop($messages["from"] , $idreplay);
                                    $pesandata = "Silahkan ketikan total deposit anda  (minimal deposit 100.000) deposit lebik kecil gunakan transfer manual ⬇️";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                }
                                // deposit bri
                                if($idreplay == "dokuva"){
                                    $this->lastop($messages["from"] , $idreplay);
                                    $pesandata = "Silahkan ketikan total deposit anda  (minimal deposit 100.000) deposit lebik kecil gunakan transfer manual ⬇️";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                }
                                //end deposit
                                //mulai option pulsa
                                if($idreplay == "pulsa"){
                                    $this->lastop($messages["from"] , $idreplay);
                                    $pesandata = "Silahkan ketik no handphone yang akan diisi pulsa ⬇️";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                }
                                
                                if($idreplay == "internet"){
                                    $this->lastop($messages["from"] , $idreplay);
                                    $pesandata = "Silahkan ketik no handphone yang akan diisi internet ⬇️";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                }
                                if($idreplay == "dana"){
                                    $this->lastop($messages["from"] , $idreplay);
                                    $pesandata = "Silahkan ketik no handphone yang Akan diisi dana ⬇️";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                }
                                
                                if($idreplay == "shopee"){
                                    $this->lastop($messages["from"] , $idreplay);
                                    $pesandata = "Silahkan ketik no handphone yang Akan diisi shopee ⬇️";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                }
                                
                                if($idreplay == "gopay"){
                                    $this->lastop($messages["from"] , $idreplay);
                                    $pesandata = "Silahkan ketik no handphone yang Akan diisi gopay ⬇️";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                }
                                if($idreplay == "pln"){
                                    $this->lastop($messages["from"] , $idreplay);
                                    $pesandata = "Silahkan ketik no token PLN yang Akan diisi ⬇️";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                }
                                if($idreplay == "MOBILE LEGENDS"){
                                    $this->lastop($messages["from"] , $idreplay);
                                    $pesandata = "Silahkan ketik (ID + ZONE ID) contoh 137579441115667 ketikan diisi ⬇️";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                }
                                if($idreplay == "FREE FIRE"){
                                    $this->lastop($messages["from"] , $idreplay);
                                    $pesandata = "Silahkan ketik (ID + ZONE ID) contoh 137579441115667 ketikan diisi ⬇️";
                                    $this->pesantext($messages["from"] , $pesandata);
                                    return response()->json(['success' => 'success'], 200);
                                }
                                
                                //opration setelah semua proses terjadi mengambil dari user
                                $opration = User::select( "id","lastopration" , "saldo" , "phone")->where("phone" ,$messages["from"] )->first();
                                 if($opration){
                                        //step 3 setelah memilih pulsa.
                                    if($opration->lastopration=="pulsa"){
                                        $paramisipulsa = explode("#" , $idreplay);
                                        if($paramisipulsa[3] <=  $opration->saldo){
                                            $memberid = Str::uuid();
                                            $s = $this->isipulsa($paramisipulsa[2],$paramisipulsa[1],$memberid);
                                            $resdata = json_decode($s , true);
                                            print_r($resdata["data"]);
                                            Pulsa::create([
                                            'nomor' => $opration->phone,
                                            'trx_id' => $memberid,
                                            'userID' => $opration->id ,
                                            'code'=> $paramisipulsa[2],
                                            'price'=> $paramisipulsa[3],
                                            'hargadasar'=> $paramisipulsa[4],
                                            'response' => "",
                                            'callback'=>"",
                                            'kategori' => "REGULER"
                                        ]);
                                        $saldoasli = $opration->saldo - $paramisipulsa[3];
                                        User::where("id" , $opration->id )->update(["saldo" => $saldoasli]);
                                        $this->pesantext($messages["from"] , "transaksi sedang di proses mohon tunggu");
                                        }else{
                                        $saldonumber = number_format($opration->saldo, 0, ',', '.');
                                        $pesandata = "Saldo Anda tidak cukup lakukan topup terlebih dahulu karena saldo anda sekarang *$saldonumber*";
                                        $this->pesantext($messages["from"] , $pesandata);
                                        }
                                        
                                    }
                                    if($opration->lastopration=="internet"){
                                        $paramisipulsa = explode("#" , $idreplay);
                                        if($paramisipulsa[3] <=  $opration->saldo){
                                            $memberid = Str::uuid();
                                            $s = $this->isipulsa($paramisipulsa[2],$paramisipulsa[1],$memberid);
                                            $resdata = json_decode($s , true);
                                            print_r($resdata["data"]);
                                            Pulsa::create([
                                            'nomor' => $opration->phone,
                                            'trx_id' => $memberid,
                                            'userID' => $opration->id ,
                                            'code'=> $paramisipulsa[2],
                                            'price'=> $paramisipulsa[3],
                                            'hargadasar'=> $paramisipulsa[4],
                                            'response' => "",
                                            'callback'=>"",
                                            'kategori' => "INTERNET"
                                        ]);
                                        $saldoasli = $opration->saldo - $paramisipulsa[3];
                                        User::where("id" , $opration->id )->update(["saldo" => $saldoasli]);
                                        $this->pesantext($messages["from"] , "transaksi sedang di proses mohon tunggu");
                                        }else{
                                        $saldonumber = number_format($opration->saldo, 0, ',', '.');
                                        $pesandata = "Saldo Anda tidak cukup lakukan topup terlebih dahulu karena saldo anda sekarang *$saldonumber*";
                                        $this->pesantext($messages["from"] , $pesandata);
                                        }
                                    }
                                    
                                        if($opration->lastopration=="dana"){
                                            $paramisipulsa = explode("#" , $idreplay);
                                            if($paramisipulsa[3] <=  $opration->saldo){
                                                $memberid = Str::uuid();
                                                $s = $this->isipulsa($paramisipulsa[2],$paramisipulsa[1],$memberid);
                                                $resdata = json_decode($s , true);
                                                print_r($resdata["data"]);
                                                Pulsa::create([
                                                'nomor' => $opration->phone,
                                                'trx_id' => $memberid,
                                                'userID' => $opration->id ,
                                                'code'=> $paramisipulsa[2],
                                                'price'=> $paramisipulsa[3],
                                                'hargadasar'=> $paramisipulsa[4],
                                                'response' => "",
                                                'callback'=>"",
                                                'kategori' => "DANA"
                                            ]);
                                            $saldoasli = $opration->saldo - $paramisipulsa[3];
                                            User::where("id" , $opration->id )->update(["saldo" => $saldoasli]);
                                            $this->pesantext($messages["from"] , "transaksi sedang di proses mohon tunggu");
                                            }else{
                                            $saldonumber = number_format($opration->saldo, 0, ',', '.');
                                            $pesandata = "Saldo Anda tidak cukup lakukan topup terlebih dahulu karena saldo anda sekarang *$saldonumber*";
                                            $this->pesantext($messages["from"] , $pesandata);
                                            }
                                        }  
                                        if($opration->lastopration=="gopay"){
                                            $paramisipulsa = explode("#" , $idreplay);
                                            if($paramisipulsa[3] <=  $opration->saldo){
                                                $memberid = Str::uuid();
                                                $s = $this->isipulsa($paramisipulsa[2],$paramisipulsa[1],$memberid);
                                                $resdata = json_decode($s , true);
                                                print_r($resdata["data"]);
                                                Pulsa::create([
                                                'nomor' => $opration->phone,
                                                'trx_id' => $memberid,
                                                'userID' => $opration->id ,
                                                'code'=> $paramisipulsa[2],
                                                'price'=> $paramisipulsa[3],
                                                'hargadasar'=> $paramisipulsa[4],
                                                'response' => "",
                                                'callback'=>"",
                                                'kategori' => "DANA"
                                            ]);
                                            $saldoasli = $opration->saldo - $paramisipulsa[3];
                                            User::where("id" , $opration->id )->update(["saldo" => $saldoasli]);
                                            $this->pesantext($messages["from"] , "transaksi sedang di proses mohon tunggu");
                                            }else{
                                            $saldonumber = number_format($opration->saldo, 0, ',', '.');
                                            $pesandata = "Saldo Anda tidak cukup lakukan topup terlebih dahulu karena saldo anda sekarang *$saldonumber*";
                                            $this->pesantext($messages["from"] , $pesandata);
                                            }
                                        }
                                        if($opration->lastopration=="shopee"){
                                            $paramisipulsa = explode("#" , $idreplay);
                                            if($paramisipulsa[3] <=  $opration->saldo){
                                                $memberid = Str::uuid();
                                                $s = $this->isipulsa($paramisipulsa[2],$paramisipulsa[1],$memberid);
                                                $resdata = json_decode($s , true);
                                                print_r($resdata["data"]);
                                                Pulsa::create([
                                                'nomor' => $opration->phone,
                                                'trx_id' => $memberid,
                                                'userID' => $opration->id ,
                                                'code'=> $paramisipulsa[2],
                                                'price'=> $paramisipulsa[3],
                                                'hargadasar'=> $paramisipulsa[4],
                                                'response' => "",
                                                'callback'=>"",
                                                'kategori' => "DANA"
                                            ]);
                                            $saldoasli = $opration->saldo - $paramisipulsa[3];
                                            User::where("id" , $opration->id )->update(["saldo" => $saldoasli]);
                                            $this->pesantext($messages["from"] , "transaksi sedang di proses mohon tunggu");
                                            }else{
                                            $saldonumber = number_format($opration->saldo, 0, ',', '.');
                                            $pesandata = "Saldo Anda tidak cukup lakukan topup terlebih dahulu karena saldo anda sekarang *$saldonumber*";
                                            $this->pesantext($messages["from"] , $pesandata);
                                            }
                                        }
                                        
                                        if($opration->lastopration=="pln"){
                                            $paramisipulsa = explode("#" , $idreplay);
                                            if($paramisipulsa[3] <=  $opration->saldo){
                                                $memberid = Str::uuid();
                                                $s = $this->isipulsa($paramisipulsa[2],$paramisipulsa[1],$memberid);
                                                $resdata = json_decode($s , true);
                                                print_r($resdata["data"]);
                                                Pulsa::create([
                                                'nomor' => $opration->phone,
                                                'trx_id' => $memberid,
                                                'userID' => $opration->id ,
                                                'code'=> $paramisipulsa[2],
                                                'price'=> $paramisipulsa[3],
                                                'hargadasar'=> $paramisipulsa[4],
                                                'response' => "",
                                                'callback'=>"",
                                                'kategori' => "DANA"
                                            ]);
                                            $saldoasli = $opration->saldo - $paramisipulsa[3];
                                            User::where("id" , $opration->id )->update(["saldo" => $saldoasli]);
                                            $this->pesantext($messages["from"] , "transaksi sedang di proses mohon tunggu");
                                            }else{
                                            $saldonumber = number_format($opration->saldo, 0, ',', '.');
                                            $pesandata = "Saldo Anda tidak cukup lakukan topup terlebih dahulu karena saldo anda sekarang *$saldonumber*";
                                            $this->pesantext($messages["from"] , $pesandata);
                                            }
                                        }
                                        
                                        if($opration->lastopration=="MOBILE LEGENDS"){
                                            $paramisipulsa = explode("#" , $idreplay);
                                            if($paramisipulsa[3] <=  $opration->saldo){
                                                $memberid = Str::uuid();
                                                $s = $this->isipulsa($paramisipulsa[2],$paramisipulsa[1],$memberid);
                                                $resdata = json_decode($s , true);
                                                print_r($resdata["data"]);
                                                Pulsa::create([
                                                'nomor' => $opration->phone,
                                                'trx_id' => $memberid,
                                                'userID' => $opration->id ,
                                                'code'=> $paramisipulsa[2],
                                                'price'=> $paramisipulsa[3],
                                                'hargadasar'=> $paramisipulsa[4],
                                                'response' => "",
                                                'callback'=>"",
                                                'kategori' => "games"
                                            ]);
                                            $saldoasli = $opration->saldo - $paramisipulsa[3];
                                            User::where("id" , $opration->id )->update(["saldo" => $saldoasli]);
                                            $this->pesantext($messages["from"] , "transaksi sedang di proses mohon tunggu");
                                            }else{
                                            $saldonumber = number_format($opration->saldo, 0, ',', '.');
                                            $pesandata = "Saldo Anda tidak cukup lakukan topup terlebih dahulu karena saldo anda sekarang *$saldonumber*";
                                            $this->pesantext($messages["from"] , $pesandata);
                                            }
                                        }
                                        if($opration->lastopration=="FREE FIRE"){
                                            $paramisipulsa = explode("#" , $idreplay);
                                            if($paramisipulsa[3] <=  $opration->saldo){
                                                $memberid = Str::uuid();
                                                $s = $this->isipulsa($paramisipulsa[2],$paramisipulsa[1],$memberid);
                                                $resdata = json_decode($s , true);
                                                print_r($resdata["data"]);
                                                Pulsa::create([
                                                'nomor' => $opration->phone,
                                                'trx_id' => $memberid,
                                                'userID' => $opration->id ,
                                                'code'=> $paramisipulsa[2],
                                                'price'=> $paramisipulsa[3],
                                                'hargadasar'=> $paramisipulsa[4],
                                                'response' => "",
                                                'callback'=>"",
                                                'kategori' => "games"
                                            ]);
                                            $saldoasli = $opration->saldo - $paramisipulsa[3];
                                            User::where("id" , $opration->id )->update(["saldo" => $saldoasli]);
                                            $this->pesantext($messages["from"] , "transaksi sedang di proses mohon tunggu");
                                            }else{
                                            $saldonumber = number_format($opration->saldo, 0, ',', '.');
                                            $pesandata = "Saldo Anda tidak cukup lakukan topup terlebih dahulu karena saldo anda sekarang *$saldonumber*";
                                            $this->pesantext($messages["from"] , $pesandata);
                                            }
                                        }
                                        
                                        
                                    
                                    return response()->json(['success' => 'success'], 200);
                                }        

                                
                                $this->doku_log("walog" , $idreplay);
                            }
                            
                        };
                    }
                };
            }
        }


        };

        return response("", 200);
    }

    public function bcamanual($nomor , $deposit ,$userID){
        $saldo =  substr($deposit, 0, -3).rand(100,1000);
        $transaksiCode = 'INV-'.Str::uuid();
        $saldo = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $saldo);
        topupmanual::create([
            'userID' => $userID,
            'Trx_ID' => $transaksiCode,
            'saldo' => $saldo,
            'responseData' =>"",
            'status' => "PENDING",
        ]);

        echo $pesan  = "Deposit Berhasil dengan NO : $transaksiCode\\ntotal deposit *$saldo*\\nlakukan transfer sesuai nilai total deposit ke bank BCA\\n *0231124763*\\nDoris Hermawan\\nmanual copy https://wa.me/6282210073918?text=0231124763\\nkemudian konfirmasi pembayaran ke no +6282310777783";

        $this->pesantext($nomor,$pesan);
        $this->lastop($nomor,"mulai");
    }
    
    public function brimanual($nomor , $deposit ,$userID){
        $saldo =  substr($deposit, 0, -3).rand(100,1000);
        $transaksiCode = 'INV-'.Str::uuid();
        $saldo = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $saldo);
        topupmanual::create([
            'userID' => $userID,
            'Trx_ID' => $transaksiCode,
            'saldo' => $saldo,
            'responseData' =>"",
            'status' => "PENDING",
        ]);
        
        echo $pesan  = "Deposit Berhasil dengan NO : $transaksiCode\\ntotal deposit *$saldo*\\nlakukan transfer sesuai nilai total deposit ke bank Bank Rakyat Indonesia (BRI)\\n *788701001788505*\\nmanual copy https://wa.me/6282210073918?text=788701001788505 \\nDoris Hermawan\\nkemudian konfirmasi pembayaran ke no https://wa.me/6282310777783?text=$transaksiCode";

        $this->pesantext($nomor,$pesan);
        $this->lastop($nomor,"mulai");
    }



    public function menuutama($number){
            $this->lastop($number , "manu");
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v20.0/349217681611605/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'
            {
            "messaging_product": "whatsapp",
            "recipient_type": "individual",
            "to": "+'.$number.'",
            "type": "interactive",
            "interactive": {
                "type": "list",
                "header": {
                "type": "text",
                "text": "Menu Utama"
                },
                "body": {
                "text": "*Selamat Datang di RajaJualan*\\npembayaran sangat mudah dan cepat\\nuntuk cek list harga bisa kunjungi https://rajajualan.com"
                },
                "footer": {
                "text": "tekan Tombol Pilih Menu dibawah"
                },
                "action": {
                "button": "Pilih Menu",
                "sections": [
                    {
                    "title": "Info Akun",
                    "rows": [
                        {
                        "id": "topup",
                        "title": "Topup Saldo",
                        "description": "wajib di lakukan sebelum melakukan transaksi"
                        },
                        {
                        "id": "ceksaldo",
                        "title": "Cek saldo",
                        "description": "cek saldo anda sebelum melakukan transaksi"
                        }
                    ]
                    },
                    {
                    "title": "Transaksi",
                    "rows": [
                        {
                        "id": "pulsa",
                        "title": "Pulsa Reguler",
                        "description": "Pembelian pulsa reguler semua operator"
                        },
                        {
                        "id": "internet",
                        "title": "Paket Internet",
                        "description": "Pembelian Internet semua operator"
                        },
                        {
                        "id": "wallet",
                        "title": "Walet",
                        "description": "Pembelian gopay,dana,shoppe,dll"
                        },
                        {
                        "id": "game",
                        "title": "Game",
                        "description": "mobile lagend , Free Fire,dll"
                        },
                        {
                        "id": "pln",
                        "title": "PLN",
                        "description": "10,20,30 dll token listrik"
                        }
                    ]
                    }
                ]
                }
            }
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.env("wakey","")
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;


    }

    public function depositemenu($nomer , $body){

                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v20.0/349217681611605/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'
                {
                "messaging_product": "whatsapp",
                "recipient_type": "individual",
                "to": "+'.$nomer.'",
                "type": "interactive",
                "interactive": {
                    "type": "list",
                    "header": {
                    "type": "text",
                    "text": "Deposit "
                    },
                    "body": {
                    "text": "'.$body.'"
                    },
                    "footer": {
                    "text": "tekan Tombol di bawah untuk melihat list menu"
                    },
                    "action": {
                    "button": "Pilih Menu",
                    "sections": [
                        {
                        "title": "Topup Manual",
                        "rows": [
                            {
                            "id": "bcamanual",
                            "title": "Transfer BCA",
                            "description": "Deposit tanpa potongan"
                            },
                            {
                            "id": "brimanual",
                            "title": "Transfer BRI",
                            "description": "Deposit tanpa potongan"
                            }
                        ]
                        },
                        {
                        "title": "Deposit virtual account",
                        "rows": [
                            {
                            "id": "mandiriva",
                            "title": "Mandiri Va",
                            "description": "deposit mandiri VA admin 5.000"
                            },
                            {
                            "id": "briva",
                            "title": "bri Va",
                            "description": "Deposite bri VA admin 5.000"
                            },
                            {
                            "id": "dokuva",
                            "title": "VA Bank Lain2",
                            "description": "deposit mengunakan VA VA admin 5.000"
                            }
                        ]
                        }
                    ]
                    }
                }
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.env("wakey","")
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                echo $response;


    }

    
    public function waletmenu($nomer , $body){

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v20.0/349217681611605/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST =>  false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'
            {
            "messaging_product": "whatsapp",
            "recipient_type": "individual",
            "to": "+'.$nomer.'",
            "type": "interactive",
            "interactive": {
                "type": "list",
                "header": {
                "type": "text",
                "text": "Topup E-wallet "
                },
                "body": {
                "text": "'.$body.'"
                },
                "footer": {
                "text": "tekan Tombol di bawah untuk melihat list menu"
                },
                "action": {
                "button": "Pilih Menu",
                "sections": [
                    {
                    "title": "E-wallet topup",
                    "rows": [
                        {
                        "id": "dana",
                        "title": "Dana",
                        "description": "Topup dana dengan beragam harga"
                        },
                        {
                        "id": "shopee",
                        "title": "Shopee",
                        "description": "Topup Shopppy dengan berbagai harga"
                        },
                        {
                        "id": "gopay",
                        "title": "gopay",
                        "description": "Topup Gopay dengan berbagai harga"
                        }
                    ]
                    }
                ]
                }
            }
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.env("wakey","")
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;


    }
    public function gamemenu($nomer , $body){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://graph.facebook.com/v20.0/349217681611605/messages',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST =>  false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'
        {
        "messaging_product": "whatsapp",
        "recipient_type": "individual",
        "to": "+'.$nomer.'",
        "type": "interactive",
        "interactive": {
            "type": "list",
            "header": {
            "type": "text",
            "text": "Topup Game "
            },
            "body": {
            "text": "'.$body.'"
            },
            "footer": {
            "text": "tekan Tombol di bawah untuk melihat list menu"
            },
            "action": {
            "button": "Pilih Menu",
            "sections": [
                {
                "title": "GAME topup",
                "rows": [
                    {
                    "id": "MOBILE LEGENDS",
                    "title": "MOBILE LEGENDS",
                    "description": "Topup MOBILE LEGENDS dengan beragam harga"
                    },
                    {
                    "id": "FREE FIRE",
                    "title": "FREE FIRE",
                    "description": "Topup FREE FIRE dengan beragam harga"
                    },
                    
                ]
                }
            ]
            }
        }
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.env("wakey","")
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;


}
    public function daftar($nomor){
        return User::where("phone", $nomor)->count();
    }
    public function pesantext($nomor , $pesan){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v20.0/349217681611605/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST =>  false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'
                {
                "messaging_product": "whatsapp",
                "recipient_type": "individual",
                "to": "+'.$nomor.'",
                "type": "text",
                "text": {
                    "preview_url": true,
                    "body": "'.$pesan.'"
                }
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.env("wakey","")
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                echo $response;
    }
    public function pendaftaranwa($nomor){

                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v20.0/349217681611605/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                "recipient_type": "individual",
                "messaging_product": "whatsapp",
                "to": "+'.$nomor.'",
                "type": "interactive",
                "interactive": {
                    "type": "flow",
                    "header": {
                    "type": "text",
                    "text": "Daftar RajaJualan"
                    },
                    "body": {
                    "text": "No Ini Belum terdaftar sebagai member. Silahkan daftar terlebih dahulu sebelum melakukan transaksi :\\nklik tombol daftar sekarang\\njangan lewatkan kesempatan untuk menjadi member karena harga di kami sangat murah loh!"
                    },
                    "footer": {
                    "text": "Klik tombol di bawah untuk daftar"
                    },
                    "action": {
                    "name": "flow",
                    "parameters": {
                        "flow_message_version": "3",
                        "flow_token": "registertoken",
                        "flow_id": "1011754747130946",
                        "flow_cta": "Daftar",
                        "flow_action": "navigate",
                        "flow_action_payload": {
                        "screen": "SIGN_UP",
                        "data": { 
                            "product_name": "name",
                            "product_description": "description",
                            "product_price": 100
                        }
                        }
                    }
                    }
                }
                }',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.env("wakey","") ,
                    'Content-Type: application/json'
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                echo $response;

    }
    function doku_log($class, $log_msg, $invoice_number = '')
    {
        $log_filename = "wa_log";
        $log_header = date(DATE_ATOM, time()) . ' ' . 'Notif ' . '---> ' . $invoice_number . " : ";
        if (!file_exists($log_filename)) {
            // create directory/folder uploads.
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename . '/log_' . date('d-M-Y') . '.log';
        // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
        file_put_contents($log_file_data, $log_header . json_encode($log_msg) . "\n", FILE_APPEND);
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
    public function lastop($nomor , $last){
        User::where("phone" , $nomor)->update(["lastopration" => $last]);
    }
    //proses ke 3 setelah mengetikan no hp
    public function pulsa($nomor , $body){
        $param = Str::limit($body , 4,''); 
        $p = Paramnomor::select("provider")->where("param" , $param)->first();
        $harga  = User::where("phone" , $nomor)->first();
      
        if(empty($p)){
            $this->pesantext($nomor , "operator tidak terdaftar / no yang anda masukan salah");
            return true;
        }
        $brand = $p->provider;
            $akunquery = $harga->akun;
            $parameterquery = harga::select("id")->where(["brand" => $brand , "category" => "Pulsa" , "buyer_product_status" => true , "seller_product_status" => true])->orderby("price" , "asc")->get(); 
            $m =  ceil($parameterquery->count() / 10);
            $countterr =  $parameterquery->count();
            for($paramview = 0; $paramview < $m; $paramview++){
                
                $mainoptiondisini = array();
                $endss =  $countterr <  (($paramview+1) *10)?$countterr:(($paramview+1) *10);
                $startss =($paramview *10);
                $parameterquerymainwa = harga::where(["brand" => $brand , "category" => "Pulsa" , "buyer_product_status" => true , "seller_product_status" => true])->orderby("price" , "asc")->skip($startss)->take($endss)->get(); 
           
                foreach ($parameterquerymainwa as $key => $valuepul) {
                    $mainoptiondisini[] = array("id" => "isipulsa#".$body."#".$valuepul->buyer_sku_code."#".($valuepul->$akunquery - $harga->price)."#".$valuepul->price , "title" => substr($valuepul->product_name,0,24),"description" => $valuepul->desc." dengan harga : ".number_format(($valuepul->$akunquery - $harga->price), 0, ',', '.')); 
                
                }
                $paramoptionwa =  json_encode($mainoptiondisini);
                // dd($mainoptiondisini);
                $arrayVar = [
                    "messaging_product" => "whatsapp",
                    "recipient_type" => "individual",
                    "to" => "+".$nomor,
                    "type" => "interactive",
                    "interactive" => [
                        "type" => "list",
                        "header" => ["type" => "text", "text" => "Pilih Pulsa ".$brand],
                        "body" => [
                            "text" => "Anda Akan mengisi pulsa untuk nomor *".$body."* ".PHP_EOL."pastikan nomor yang anda akan isi sudah benar",
                        ],
                        "footer" => ["text" => "tekan Tombol Pilih Paket dibawah"],
                        "action" => [
                            "button" => "Pilih Paket",
                            "sections" => [
                                [
                                    "title" => "List Paket",
                                    "rows" => $paramoptionwa,
                                ],
                                
                            ],
                        ],
                    ],
                ];
    
    
    
                $paramoptionpulsa =  json_encode($arrayVar);
                // echo $paramoptionpulsa;
    
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v20.0/349217681611605/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST =>  false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$paramoptionpulsa,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.env("wakey","")
                ),
                ));
    
                $response = curl_exec($curl);
    
                curl_close($curl);
                echo $response;
            }
            


    }

    public function internet($nomor , $body){
        $param = Str::limit($body , 4,''); 
        $p = Paramnomor::select("provider")->where("param" , $param)->first();
        $harga  = User::where("phone" , $nomor)->first();
      
        if(empty($p)){
            $this->pesantext($nomor , "operator tidak terdaftar / no yang anda masukan salah");
            return true;
        }
        $brand = $p->provider;
            $akunquery = $harga->akun;
            $parameterquery = harga::select("id")->where(["brand" => $brand , "category" => "Data" , "buyer_product_status" => true , "seller_product_status" => true])->orderby("price" , "asc")->get(); 
            $m =  ceil($parameterquery->count() / 10);
            $countterr = $parameterquery->count();
            for($paramview = 0; $paramview < $m; $paramview++){
                
                $mainoptiondisini = array();
                $endss =  $countterr <  (($paramview+1) *10)?$countterr:(($paramview+1) *10);
                $startss =($paramview *10);
                $parameterquerymainwa = harga::where(["brand" => $brand , "category" => "Data" , "buyer_product_status" => true , "seller_product_status" => true])->orderby("price" , "asc")->skip($startss)->take($endss)->get(); 
           
                foreach ($parameterquerymainwa as $key => $valuepul) {
                    $mainoptiondisini[] = array("id" => "isipulsa#".$body."#".$valuepul->buyer_sku_code."#".($valuepul->$akunquery - $harga->price)."#".$valuepul->price , "title" => substr($valuepul->product_name,0,24),"description" => $valuepul->desc." dengan harga : ".number_format(($valuepul->$akunquery - $harga->price), 0, ',', '.')); 
                
                }
                $paramoptionwa =  json_encode($mainoptiondisini);
                $arrayVar = [
                    "messaging_product" => "whatsapp",
                    "recipient_type" => "individual",
                    "to" => "+".$nomor,
                    "type" => "interactive",
                    "interactive" => [
                        "type" => "list",
                        "header" => ["type" => "text", "text" => "Pilih Internet ".$brand],
                        "body" => [
                            "text" => "Anda Akan mengisi Paket Internet untuk nomor *".$body."* ".PHP_EOL."pastikan nomor yang anda akan isi sudah benar",
                        ],
                        "footer" => ["text" => "tekan Tombol Pilih Paket dibawah"],
                        "action" => [
                            "button" => "Pilih Paket",
                            "sections" => [
                                [
                                    "title" => "List Paket",
                                    "rows" => $paramoptionwa,
                                ],
                                
                            ],
                        ],
                    ],
                ];
    
    
    
                $paramoptionpulsa =  json_encode($arrayVar);
                // echo $paramoptionpulsa;
    
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v20.0/349217681611605/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST =>  false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$paramoptionpulsa,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.env("wakey","")
                ),
                ));
    
                $response = curl_exec($curl);
    
                curl_close($curl);
                echo $response;
            }

    }

    public function dana($nomor , $body){
        $param = Str::limit($body , 4,''); 
        $p = Paramnomor::select("provider")->where("param" , $param)->first();
        $harga  = User::where("phone" , $nomor)->first();
      
        if(empty($p)){
            $this->pesantext($nomor , "operator tidak terdaftar / no yang anda masukan salah");
            return true;
        }
        $brand = $p->provider;
            $akunquery = $harga->akun;
            $parameterquery = harga::select("id")->where(["brand" => "DANA" , "category" => "E-Money" , "buyer_product_status" => true , "seller_product_status" => true])->orderby("price" , "asc")->get(); 
            $m =  ceil($parameterquery->count() / 10);
            $countterr = $parameterquery->count();
            for($paramview = 0; $paramview < $m; $paramview++){
                
                $mainoptiondisini = array();
                $endss =  $countterr <  (($paramview+1) *10)?$countterr:(($paramview+1) *10);
                $startss =($paramview *10);
                $parameterquerymainwa = harga::where(["brand" => "DANA" , "category" => "E-Money" , "buyer_product_status" => true , "seller_product_status" => true])->orderby("price" , "asc")->skip($startss)->take($endss)->get(); 
           
                foreach ($parameterquerymainwa as $key => $valuepul) {
                    $mainoptiondisini[] = array("id" => "isipulsa#".$body."#".$valuepul->buyer_sku_code."#".($valuepul->$akunquery - $harga->price)."#".$valuepul->price , "title" => substr($valuepul->product_name,0,24),"description" => $valuepul->desc." dengan harga : ".number_format(($valuepul->$akunquery - $harga->price), 0, ',', '.')); 
                
                }
                $paramoptionwa =  json_encode($mainoptiondisini);
                $arrayVar = [
                    "messaging_product" => "whatsapp",
                    "recipient_type" => "individual",
                    "to" => "+".$nomor,
                    "type" => "interactive",
                    "interactive" => [
                        "type" => "list",
                        "header" => ["type" => "text", "text" => "Pilih DANA TOPUP "],
                        "body" => [
                            "text" => "Anda Akan mengisi Paket DANA untuk nomor *".$body."* ".PHP_EOL."pastikan nomor yang anda akan isi sudah benar",
                        ],
                        "footer" => ["text" => "tekan Tombol Pilih Paket dibawah"],
                        "action" => [
                            "button" => "Pilih Paket",
                            "sections" => [
                                [
                                    "title" => "List Paket",
                                    "rows" => $paramoptionwa,
                                ],
                                
                            ],
                        ],
                    ],
                ];
    
    
    
                $paramoptionpulsa =  json_encode($arrayVar);
                // echo $paramoptionpulsa;
    
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v20.0/349217681611605/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST =>  false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$paramoptionpulsa,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.env("wakey","")
                ),
                ));
    
                $response = curl_exec($curl);
    
                curl_close($curl);
                echo $response;
            }

    }

    public function gopay($nomor , $body){
        $param = Str::limit($body , 4,''); 
        $p = Paramnomor::select("provider")->where("param" , $param)->first();
        $harga  = User::where("phone" , $nomor)->first();
      
        if(empty($p)){
            $this->pesantext($nomor , "operator tidak terdaftar / no yang anda masukan salah");
            return true;
        }
        $brand = $p->provider;
            $akunquery = $harga->akun;
            $parameterquery = harga::select("id")->where(["brand" => "GO PAY" , "type" => "Customer" , "category" => "E-Money" , "buyer_product_status" => true , "seller_product_status" => true])->orderby("price" , "asc")->get(); 
            $m =  ceil($parameterquery->count() / 10);
            $countterr = $parameterquery->count();
            for($paramview = 0; $paramview < $m; $paramview++){
                
                $mainoptiondisini = array();
                $endss =  $countterr <  (($paramview+1) *10)?$countterr:(($paramview+1) *10);
                $startss =($paramview *10);
                $parameterquerymainwa = harga::where(["brand" => "GO PAY" , "type" => "Customer"  , "category" => "E-Money" , "buyer_product_status" => true , "seller_product_status" => true])->orderby("price" , "asc")->skip($startss)->take($endss)->get(); 
           
                foreach ($parameterquerymainwa as $key => $valuepul) {
                    $mainoptiondisini[] = array("id" => "isipulsa#".$body."#".$valuepul->buyer_sku_code."#".($valuepul->$akunquery - $harga->price)."#".$valuepul->price , "title" => substr($valuepul->product_name,0,24),"description" => $valuepul->desc." dengan harga : ".number_format(($valuepul->$akunquery - $harga->price), 0, ',', '.')); 
                
                }
                $paramoptionwa =  json_encode($mainoptiondisini);
                $arrayVar = [
                    "messaging_product" => "whatsapp",
                    "recipient_type" => "individual",
                    "to" => "+".$nomor,
                    "type" => "interactive",
                    "interactive" => [
                        "type" => "list",
                        "header" => ["type" => "text", "text" => "Pilih GO PAY TOPUP "],
                        "body" => [
                            "text" => "Anda Akan mengisi Paket GO PAY CUSTOMER untuk nomor *".$body."* ".PHP_EOL."pastikan nomor yang anda akan isi sudah benar",
                        ],
                        "footer" => ["text" => "tekan Tombol Pilih Paket dibawah"],
                        "action" => [
                            "button" => "Pilih Paket",
                            "sections" => [
                                [
                                    "title" => "List Paket",
                                    "rows" => $paramoptionwa,
                                ],
                                
                            ],
                        ],
                    ],
                ];
    
    
    
                $paramoptionpulsa =  json_encode($arrayVar);
                // echo $paramoptionpulsa;
    
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v20.0/349217681611605/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST =>  false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$paramoptionpulsa,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.env("wakey","")
                ),
                ));
    
                $response = curl_exec($curl);
    
                curl_close($curl);
                echo $response;
            }

    }
    
    public function shopee($nomor , $body){
        $param = Str::limit($body , 4,''); 
        $p = Paramnomor::select("provider")->where("param" , $param)->first();
        $harga  = User::where("phone" , $nomor)->first();
      
        if(empty($p)){
            $this->pesantext($nomor , "operator tidak terdaftar / no yang anda masukan salah");
            return true;
        }
        $brand = $p->provider;
            $akunquery = $harga->akun;
            $parameterquery = harga::select("id")->where(["brand" => "SHOPEE PAY" , "type" => "Umum" , "category" => "E-Money" , "buyer_product_status" => true , "seller_product_status" => true])->orderby("price" , "asc")->get(); 
            $m =  ceil($parameterquery->count() / 10);
            $countterr = $parameterquery->count();
            for($paramview = 0; $paramview < $m; $paramview++){
                
                $mainoptiondisini = array();
                $endss =  $countterr <  (($paramview+1) *10)?$countterr:(($paramview+1) *10);
                $startss =($paramview *10);
                $parameterquerymainwa = harga::where(["brand" => "SHOPEE PAY" , "type" => "Umum"  , "category" => "E-Money" , "buyer_product_status" => true , "seller_product_status" => true])->orderby("price" , "asc")->skip($startss)->take($endss)->get(); 
           
                foreach ($parameterquerymainwa as $key => $valuepul) {
                    $mainoptiondisini[] = array("id" => "isipulsa#".$body."#".$valuepul->buyer_sku_code."#".($valuepul->$akunquery - $harga->price)."#".$valuepul->price , "title" => substr($valuepul->product_name,0,24),"description" => $valuepul->desc." dengan harga : ".number_format(($valuepul->$akunquery - $harga->price), 0, ',', '.')); 
                
                }
                $paramoptionwa =  json_encode($mainoptiondisini);
                $arrayVar = [
                    "messaging_product" => "whatsapp",
                    "recipient_type" => "individual",
                    "to" => "+".$nomor,
                    "type" => "interactive",
                    "interactive" => [
                        "type" => "list",
                        "header" => ["type" => "text", "text" => "Pilih SHOPEE PAY TOPUP "],
                        "body" => [
                            "text" => "Anda Akan mengisi Paket SHOPEE PAY CUSTOMER untuk nomor *".$body."* ".PHP_EOL."pastikan nomor yang anda akan isi sudah benar",
                        ],
                        "footer" => ["text" => "tekan Tombol Pilih Paket dibawah"],
                        "action" => [
                            "button" => "Pilih Paket",
                            "sections" => [
                                [
                                    "title" => "List Paket",
                                    "rows" => $paramoptionwa,
                                ],
                                
                            ],
                        ],
                    ],
                ];
    
    
    
                $paramoptionpulsa =  json_encode($arrayVar);
                // echo $paramoptionpulsa;
    
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v20.0/349217681611605/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST =>  false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$paramoptionpulsa,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.env("wakey","")
                ),
                ));
    
                $response = curl_exec($curl);
    
                curl_close($curl);
                echo $response;
            }

    }

    
    public function pln($nomor , $body){
            $harga  = User::where("phone" , $nomor)->first();
            $akunquery = $harga->akun;
            $parameterquery = harga::select("id")->where(["brand" => "PLN" , "type" => "Umum" , "category" => "PLN" , "buyer_product_status" => true , "seller_product_status" => true])->orderby("price" , "asc")->get(); 
            $m =  ceil($parameterquery->count() / 10);
            $countterr = $parameterquery->count();
            for($paramview = 0; $paramview < $m; $paramview++){
                
                $mainoptiondisini = array();
                $endss =  $countterr <  (($paramview+1) *10)?$countterr:(($paramview+1) *10);
                $startss =($paramview *10);
                $parameterquerymainwa = harga::where(["brand" => "PLN" , "type" => "Umum"  , "category" => "PLN" , "buyer_product_status" => true , "seller_product_status" => true])->orderby("price" , "asc")->skip($startss)->take($endss)->get(); 
           
                foreach ($parameterquerymainwa as $key => $valuepul) {
                    $mainoptiondisini[] = array("id" => "isipulsa#".$body."#".$valuepul->buyer_sku_code."#".($valuepul->$akunquery - $harga->price)."#".$valuepul->price , "title" => substr($valuepul->product_name,0,24),"description" => $valuepul->desc." dengan harga : ".number_format(($valuepul->$akunquery - $harga->price), 0, ',', '.')); 
                
                }
                $paramoptionwa =  json_encode($mainoptiondisini);
                $arrayVar = [
                    "messaging_product" => "whatsapp",
                    "recipient_type" => "individual",
                    "to" => "+".$nomor,
                    "type" => "interactive",
                    "interactive" => [
                        "type" => "list",
                        "header" => ["type" => "text", "text" => "Pilih PLN TOKEN "],
                        "body" => [
                            "text" => "Anda Akan mengisi Paket PLN TOKEN untuk nomor *".$body."* ".PHP_EOL."pastikan nomor yang anda akan isi sudah benar",
                        ],
                        "footer" => ["text" => "tekan Tombol Pilih Paket dibawah"],
                        "action" => [
                            "button" => "Pilih Paket",
                            "sections" => [
                                [
                                    "title" => "List Paket",
                                    "rows" => $paramoptionwa,
                                ],
                                
                            ],
                        ],
                    ],
                ];
    
    
    
                $paramoptionpulsa =  json_encode($arrayVar);
                // echo $paramoptionpulsa;
    
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v20.0/349217681611605/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST =>  false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$paramoptionpulsa,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.env("wakey","")
                ),
                ));
    
                $response = curl_exec($curl);
    
                curl_close($curl);
                echo $response;
            }

    }
    public function game($nomor , $body , $katgame){
        $harga  = User::where("phone" , $nomor)->first();
        $akunquery = $harga->akun;
        $parameterquery = harga::select("id")->where(["brand" => $katgame , "type" => "Umum" , "category" => "Games" , "buyer_product_status" => true , "seller_product_status" => true])->orderby("price" , "asc")->get(); 
        $m =  ceil($parameterquery->count() / 10);
        $countterr = $parameterquery->count();
        for($paramview = 0; $paramview < $m; $paramview++){
            
            $mainoptiondisini = array();
            $endss =  $countterr <  (($paramview+1) *10)?$countterr:(($paramview+1) *10);
            $startss =($paramview *10);
            $parameterquerymainwa = harga::where(["brand" => $katgame  , "type" => "Umum"  , "category" => "Games" , "buyer_product_status" => true , "seller_product_status" => true])->orderby("price" , "asc")->skip($startss)->take($endss)->get(); 
       
            foreach ($parameterquerymainwa as $key => $valuepul) {
                $mainoptiondisini[] = array("id" => "isipulsa#".$body."#".$valuepul->buyer_sku_code."#".($valuepul->$akunquery - $harga->price)."#".$valuepul->price , "title" => substr($valuepul->product_name,0,24),"description" => $valuepul->desc." dengan harga : ".number_format(($valuepul->$akunquery - $harga->price), 0, ',', '.')); 
            
            }
            $paramoptionwa =  json_encode($mainoptiondisini);
            $arrayVar = [
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
                "to" => "+".$nomor,
                "type" => "interactive",
                "interactive" => [
                    "type" => "list",
                    "header" => ["type" => "text", "text" => "Pilih $katgame "],
                    "body" => [
                        "text" => "Anda Akan mengisi Paket $katgame untuk nomor *".$body."* ".PHP_EOL."pastikan nomor yang anda akan isi sudah benar",
                    ],
                    "footer" => ["text" => "tekan Tombol Pilih Paket dibawah"],
                    "action" => [
                        "button" => "Pilih Paket",
                        "sections" => [
                            [
                                "title" => "List Paket",
                                "rows" => $paramoptionwa,
                            ],
                            
                        ],
                    ],
                ],
            ];



            $paramoptionpulsa =  json_encode($arrayVar);
            // echo $paramoptionpulsa;

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v20.0/349217681611605/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST =>  false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$paramoptionpulsa,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.env("wakey","")
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
        }

}
    //ini untuk proses terakhir 
    public function isipulsa($kode , $nomor , $refid){
            $curl = curl_init();
            echo $_ENV["digiusername"]."+".$_ENV["digikey"]."+".$refid;
            $digikeys = md5($_ENV["digiusername"].$_ENV["digikey"].$refid);
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
            $this->lastop($nomor , "menu");
            $this->digi_log("class" , $response);
            return $response;
    }
}
