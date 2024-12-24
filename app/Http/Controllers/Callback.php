<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\loger;
use App\Models\Pulsa;
use Illuminate\Http\Request;

class Callback extends Controller
{
    //
    public function index(){
            echo "callback";
            echo $_ENV['clientId'];
    }
    public function notive(){
        $res = json_decode($_POST['content']);
        $ip = (@$_SERVER['HTTP_X_FORWARDED_FOR']=='') ? $_SERVER['REMOTE_ADDR'] : @$_SERVER['HTTP_X_FORWARDED_FOR']; 
        if($ip=='154.41.240.26'){ // memastikan data terikirim dari server portalpulsa

            file_put_contents('save.txt', json_encode($_POST['content'])); // menyimpan dalam file save.txt
            }
            $pulsakembali = Pulsa::where("trx_id" ,  $res->trxid_api)->first();
            if($res->status ==2){
                $user = User::where("id" , $pulsakembali->userID)->first();
                $saldoback = $user->saldo + $pulsakembali->price;
                User::where("id" , $pulsakembali->userID)->update(["saldo"=>$saldoback]);
            }
            loger::create(["content" =>$_POST['content'] , "trx_id" => $res->trxid_api ]);
            file_put_contents('save.txt', json_encode($_POST['content']));
        }
}
