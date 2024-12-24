<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pulsa;
use App\Models\pulsaTrx;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class digiController extends Controller
{
    //
    public function index(Request $request){
        
            $wa = $request->all();
            $curl = curl_init();
            $refid="idku120";
            // echo $_ENV["digiusername"]."+".$_ENV["digikey"]."+".$refid;
            $digikeys = md5($_ENV["digiusername"].$_ENV["digikey"].$refid);
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.digiflazz.com/v1/transaction',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "username": "xoyajiDakOdg",
                "buyer_sku_code": "tsel2",
                "customer_no": "082310777783",
                "ref_id": "'.$refid.'",
                "sign": "'.$digikeys.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;

            

    }
    public function digiflazz(Request $request){
        $SSS = $request->getContent();
        $datapayload  = json_decode($SSS)->data;
        $MMMM =  Pulsa::select("users.*","pulsas.*")->where("trx_id" ,$datapayload->ref_id )->join("users" , "users.id", "userID")->first();
        
        if($datapayload->status =="Gagal"){
            $gagal =  $MMMM->saldo + $MMMM->price;
            User::where("phone" , $MMMM->phone)->update(["saldo" => $gagal ]);
        }
        $this->pesantext($MMMM->phone ,$datapayload->message."\\nDengan nomor \\n".$datapayload->sn);
        $this->digi_log("wa",$SSS);
        pulsaTrx::create(["trx_id" =>$datapayload->ref_id,"sn" =>$datapayload->sn ,"response"=>$SSS]);

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

    function digi_log($class, $log_msg, $invoice_number = '')
    {
        $log_filename = "digi_log";
        $log_header = date(DATE_ATOM, time()) . ' ' . 'Notif ' . '---> ' . $invoice_number . " : ";
        if (!file_exists($log_filename)) {
            // create directory/folder uploads.
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename . '/callbacklog_' . date('d-M-Y') . '.log';
        // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
        
        file_put_contents($log_file_data, $log_header . json_encode($log_msg) . "\n", FILE_APPEND);
    }
}
