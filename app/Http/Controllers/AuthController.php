<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\PayUService\Exception;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','check_email']]);
    }

    public function check_email(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'=>'required|email|unique:users'
            ]);

            if($validator->fails()){
                return response()->json($validator->messages());
            }else{
                return response()->json(['email' => ['The email ready .']]);
            }
        } catch (\Throwable $th) {
            // return response()->json(['message'=> $th->getMessage()]);
            return response()->json(['message'=> 'Cek Service DB']);
        }
    }

    public function register()
    {
        try {
            // $this->buildXMLHeader();
            $validator = Validator::make(request()->all(),[
                'name' => 'required',
                'email' =>'required|email|unique:users',
                'username' =>'required',
                'password' =>'required',
                'profile_picture' =>'required',
                'ktp' =>'required',
            ]);
    
            if($validator->fails()){
                // return response()->json(['message' => 'pendaftaran gagal']);
                return response()->json($validator->messages());
            }
    
            $user = User::create([
                'name' => request('name'),
                'email' => request('email'),
                'username' => request('username'),
                'password' => Hash::make(request('password')),
                'profile_picture' => request('profile_picture'),
                'ktp' => request('ktp'),
            ]);

            //generate show token
            $credentials = request(['email', 'password']);

            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $res = ([
                'message' => 'Pendaftaran Berhasil',
                'name' => request('name'),
                'email' => request('email'),
                'username' => request('username'),
                'password' => Hash::make(request('password')),
                'profile_picture' => request('profile_picture'),
                'ktp' => request('ktp'),
                'token' => $token,
                'token_expires_in'=> auth()->factory()->getTTL() * 60,
                'token_type' => 'bearer',
            ]);
    
    
            if($user){
                // return response()->json($user->messages());
                return response()->json($res);
            }else{
                return response()->json(['message' => 'Pendaftaran Gagal']);
            }

        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage()]);
             return response()->json(['message'=> 'Cek Service DB']);
        }
        // if ($e instanceof \Illuminate\Database\QueryException) {
        //     dd($e->getMessage());
        //     //return response()->view('custom_view');
        // } elseif ($e instanceof \PDOException) {
        //     dd($e->getMessage());
        //     return response()->json(['message' => 'else kondisi']);
        //     //return response()->view('custom_view');
        // }

       
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        try {
            $credentials = request(['email', 'password']);

            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $res = ([
                'message' => 'Pendaftaran Berhasil',
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'username' => auth()->user()->username,
                'profile_picture' => auth()->user()->profile_picture,
                'ktp' => auth()->user()->ktp,
                'token' => $token,
                'token_expires_in'=> auth()->factory()->getTTL() * 60,
                'token_type' => 'bearer',
            ]);
    
            // return $this->respondWithToken($token);    
            return response()->json($res);
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage()]);
            // return response()->json(['message'=> 'Cek Service DB']); 
        }
        
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            return response()->json(auth()->user());
        } catch (\Throwable $th) {
            return response()->json(['message'=> 'Cek Service DB']);
        }
        
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            auth()->logout();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Throwable $th) {
            return response()->json(['message'=> 'Cek Service DB']);
        }
        
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 //expaid 60 menit
        ]);
    }

}
