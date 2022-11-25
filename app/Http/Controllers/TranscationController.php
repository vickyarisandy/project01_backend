<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use App\Models\Transaction;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Wallet;


class TranscationController extends Controller
{
    //top-up
    public function index(Request $request)
    {
        try {
            
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
                ),
            );

            // $cari = Wallet::find('user_id',$request->user_id);

            $user = ([
                'balance' => $request->amount,
                'user_id' => 1,
                'pin' => $request->pin,
                'payment_method_code' =>$request->payment_method_code,
            ]);

            $_upd = Wallet::create([
                'balance' => $request->amount,
                'user_id' => 1,
                'pin' => $request->pin,
                'payment_method_code' =>$request->payment_method_code,
            ]);
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = 'SB-Mid-server-qpjDbMx6K9HSy-XEwWig5J8y';
            // \Midtrans\Config::$clientKey = 'SB-Mid-server-qpjDbMx6K9HSy-XEwWig5J8y';
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;
            // Get Snap Payment Page URL
            $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
            $snapToken = \Midtrans\Snap::createTransaction($params);
            // $snapToken = \Midtrans\Snap::getSnapToken($params);

            $res = ([
                'redirect_url' => $paymentUrl,
                'token' => $snapToken,
            ]);
            // return response()->json($snapToken);
            return response()->json($user);
            // return response()->json(['err'=>'test']);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message'=> $th->getMessage()]);

        }
    }

    public function transfer()
    {
        # code...
    }

    public function getPayment()
    {
        $client = new Client();
	    try {
	    	$res = $client->request('GET','http://localhost:8000/coba', [

            ]);
			$data = json_decode($res->getBody()->getContents());
			return view('payment',['token'=> $data->token]);
	    } catch (Exception $e) {
	    	dd($e->getMessage());
	    }

    }

}
