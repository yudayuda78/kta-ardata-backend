<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Carbon\Carbon;
class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $result = $this->authService->register($request->all());

        if ($result['error']) {
            return response()->json([
                'status' => 'error',
                'message' => $result['message'],
            ], 422);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Register berhasil',
            'user'    => $result['user'],
            'token'   => $result['token'],
        ], 201);
    }

    public function login(Request $request){
        $result = $this->authService->login($request->all());

        if ($result['error']) {
            return response()->json([
                'message' => $result['message']
            ], 401);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $result['user'],
            'token' => $result['token']
        ]);
    }

    public function logout(Request $request)
{
    // Jika menggunakan Laravel Sanctum
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Logout berhasil',
    ]);
}


    public function me(Request $request)
    {
        $user = $request->user();

        $expired = true; // default

        if ($user->last_pay) {
            $lastPay = Carbon::parse($user->last_pay);
            $oneYearAgo = Carbon::now()->subYear();
            $expired = $lastPay->lt($oneYearAgo);
        }

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'nomortelepon' => $user->nomortelepon,
            'alamat' => $user->alamat,
            'role' => $user->role,
            'last_pay' => $user->last_pay,
            'expired' => $expired,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ]);
    }

}
