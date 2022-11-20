<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function register()
    {
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

        if($user){
            return response()->json(['message' => 'Pendaftaran Berhasil']);
        }else{
            return response()->json(['message' => 'Pendaftaran Gagal']);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
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
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 //expaid 60 menit
        ]);
    }

}
