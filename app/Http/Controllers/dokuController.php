<?php

namespace App\Http\Controllers;

use DOKU\Client;
use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class dokuController extends Controller
{
    //
    public function mandiriVa($nomor , $saldo){

        // $this->validate($request, [
        //     'saldo'      => 'required|not_in:0',
        //     'metode'      => 'required',
        // ]);
        $arr = User::where("phone" , $nomor)->first();
        $transaksiCode = 'INV-'.Str::uuid();
        $saldo = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $saldo);
        $DOKUClient = new Client;
        // Set your Client ID
        $DOKUClient->setClientID($_ENV["clientId"]);
        // Set your Shared Key
        $DOKUClient->setSharedKey($_ENV["secretKey"]);
        // Call this function for production use
        $DOKUClient->isProduction(true);
        $params = array(
            'customerEmail' => $arr->email,
            'customerName' => $arr->name,
            'amount' => $saldo,
            'invoiceNumber' => $transaksiCode,
            'expiryTime' => 60,
            'info1' => "",
            'info2' =>  "",
            'info3' =>  "",
            'reusableStatus' => false
        );
        $resoonsedoku = $DOKUClient->generateMandiriVa($params);
        // print_r($resoonsedoku);
        Transaksi::create([
            'userID' => $arr->id,
            'Trx_ID' => $transaksiCode,
            'saldo' => $saldo,
            'responseData' =>json_encode($resoonsedoku),
            'status' => "PENDING",
        ]);
        return 'Anda Berhasil Melakukan Request Virtual Account dengan No invoice\\n*'.$resoonsedoku["order"]["invoice_number"].'*\\nsilahkan bayar ke virtual account dibawah\\n*'.$resoonsedoku["virtual_account_info"]["virtual_account_number"].'*\\ncara pembayaran klik link dibawah\\n'.$resoonsedoku["virtual_account_info"]["how_to_pay_page"].'\\nBy https://rajajualan.com';
    }
    public function dokuvaa($nomor , $saldo){
        

        // $this->validate($request, [
        //     'saldo'      => 'required|not_in:0',
        //     'metode'      => 'required',
        // ]);
        $arr = User::where("phone" , $nomor)->first();
        $transaksiCode = 'INV-'.Str::uuid();
        $saldo = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $saldo);
        $DOKUClient = new Client;
        // Set your Client ID
        $DOKUClient->setClientID($_ENV["clientId"]);
        // Set your Shared Key
        $DOKUClient->setSharedKey($_ENV["secretKey"]);
        // Call this function for production use
        $DOKUClient->isProduction(true);
        $params = array(
            'customerEmail' => $arr->email,
            'customerName' => $arr->name,
            'amount' => $saldo,
            'invoiceNumber' => $transaksiCode,
            'expiryTime' => 60,
            'info1' => "",
            'info2' =>  "",
            'info3' =>  "",
            'reusableStatus' => false
        );
        $resoonsedoku = $DOKUClient->generateDokuVa($params);
        // print_r($resoonsedoku);
        Transaksi::create([
            'userID' => $arr->id,
            'Trx_ID' => $transaksiCode,
            'saldo' => $saldo,
            'responseData' =>json_encode($resoonsedoku),
            'status' => "PENDING",
        ]);
        return 'Anda Berhasil Melakukan Request Virtual Account dengan No invoice\\n*'.$resoonsedoku["order"]["invoice_number"].'*\\nsilahkan bayar ke virtual account dibawah\\n*'.$resoonsedoku["virtual_account_info"]["virtual_account_number"].'*\\ncara pembayaran klik link dibawah\\n'.$resoonsedoku["virtual_account_info"]["how_to_pay_page"].'\\nBy https://rajajualan.com';
    }
    public function briVa($nomor , $saldo){

        // $this->validate($request, [
        //     'saldo'      => 'required|not_in:0',
        //     'metode'      => 'required',
        // ]);
        $arr = User::where("phone" , $nomor)->first();
        $transaksiCode = 'INV-'.Str::uuid();
        $saldo = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $saldo);
        $DOKUClient = new Client;
        // Set your Client ID
        $DOKUClient->setClientID($_ENV["clientId"]);
        // Set your Shared Key
        $DOKUClient->setSharedKey($_ENV["secretKey"]);
        // Call this function for production use
        $DOKUClient->isProduction(true);
        $params = array(
            'customerEmail' => $arr->email,
            'customerName' => $arr->name,
            'amount' => $saldo,
            'invoiceNumber' => $transaksiCode,
            'expiryTime' => 60,
            'info1' => "",
            'info2' =>  "",
            'info3' =>  "",
            'reusableStatus' => false
        );
        $resoonsedoku = $DOKUClient->BRIVA($params);
        // print_r($resoonsedoku);
        Transaksi::create([
            'userID' => $arr->id,
            'Trx_ID' => $transaksiCode,
            'saldo' => $saldo,
            'responseData' =>json_encode($resoonsedoku),
            'status' => "PENDING",
        ]);
        return 'Anda Berhasil Melakukan Request Virtual Account dengan No invoice\\n*'.$resoonsedoku["order"]["invoice_number"].'*\\nsilahkan bayar ke virtual account dibawah\\n*'.$resoonsedoku["virtual_account_info"]["virtual_account_number"].'*\\ncara pembayaran klik link dibawah\\n'.$resoonsedoku["virtual_account_info"]["how_to_pay_page"].'\\nBy https://rajajualan.com';
    }
}
