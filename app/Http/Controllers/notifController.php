<?php

namespace App\Http\Controllers;

use App\Models\User;
use DOKU\Common\Utils;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class notifController extends Controller
{
    //
    public function va(Request $req){
        $notifyHeaders = getallheaders();
        $notifyBody = json_decode(file_get_contents('php://input'), true); // You can use to parse the value from the notification body
        $targetPath = '/notif/va'; // Put this value with your payment notification path
        $secretKey = $_ENV["secretKey"]; // Put this value with your Secret Key
        // $notifyHeaders["Request-Target"]= $targetPath;
        // print_r($req->order["invoice_number"]);
        // print_r($req->transaction["status"]);
        $this->doku_log("notif" ,$notifyHeaders);
       

            if ($_ENV["clientId"] == $notifyHeaders['Client-Id']) {
                $trs = Transaksi::select("Transaksi.*" , "phone")->where("Trx_ID" ,$req->order["invoice_number"] )->join("users" , "userID" , "users.id")->where("status" , "!=" , "SUCCESS")->first();
                if($trs){
                    $user = User::where("id" , $trs->userID)->first();
                    $tambah =  $user->saldo + $trs->saldo-5000;
                    User::where("id" , $trs->userID)->update(["saldo" => $tambah]);
                    $this->watext($trs->phone , "Selamat Anda Berhasil melakukan topup sebesar *".($trs->saldo -5000)."* silahkan lakukan transaksi pembelian pulsa,token listrik ,data, dll di wa selamat menikmati");
                }else{
                    $this->doku_log("Notif ", 'TRANSAKSI BERULANG  200', 'Notification');
            
                }
                Transaksi::where("Trx_ID" ,$req->order["invoice_number"] )->update(["status" => $req->transaction["status"]]);
                $this->doku_log("Notif ", 'PHP-Library SIGNATURE MATCH 200', 'Notification');
                http_response_code(200); // Return 200 Success to Jokul if the Signature is match
              
            } else {
               http_response_code(401); // Return 401 Unauthorized to Jokul if the Signature is not match
               $this->doku_log("Notif ", 'PHP-Library SIGNATURE NOT MATCH 401', 'Notification');
            
                //TODO Do Not update transaction status on your end yetPHP-Library Notification digest
            }
            
    }
    public function watext($nomor , $pesan){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://graph.facebook.com/v20.0/282860681588432/messages',
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
            'Authorization: Bearer '.$_ENV["wakey"]
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
}
function doku_log($class, $log_msg, $invoice_number = '')
{
    $log_filename = "doku_log";
    $log_header = date(DATE_ATOM, time()) . ' ' . 'Notif ' . '---> ' . $invoice_number . " : ";
    if (!file_exists($log_filename)) {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename . '/log_' . date('d-M-Y') . '.log';
    // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
    file_put_contents($log_file_data, $log_header . json_encode($log_msg) . "\n", FILE_APPEND);
}
}
