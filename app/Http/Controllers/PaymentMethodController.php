<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    protected $user;


    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        
    }

    public function index()
    {
        try {
            $datas = PaymentMethod::all();
            // dd($datas);
            return response()->json($datas);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message'=> $th->getMessage()]);

        }
    }
}
