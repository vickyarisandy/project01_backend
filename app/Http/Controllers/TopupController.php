<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Midtrans\Config;

class TopupController extends Controller
{
    public function getPayment()
    {
        // $client = new Client();
        // try{
        //     $res = $client->request('GET','http://127.0.0.1:8080/coba', []);
        //     $data = json_decode($res->getBody()->getContents());
        //     dd($data);
        //     // return view('payment',['token'=> $data->token]);
        // }catch(Exception $e){
        //     dd($e->getMessage());
        // }
// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-qpjDbMx6K9HSy-XEwWig5J8y';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;
 $params = array(    
    'transaction_details' => array(        
    'order_id' => rand(),
            'gross_amount' => 10000,
    ),
        'customer_details' => array(        
            'first_name' => 'budi',
                'last_name' => 'pratama',        
                'email' => 'budi.pra@example.com',       
                 'phone' => '08111222333',    
                ),);
 $snapToken = \Midtrans\Snap::getSnapToken($params);
// return $snapToken;
return view('payment',['token'=>$snapToken]);
    }
}


