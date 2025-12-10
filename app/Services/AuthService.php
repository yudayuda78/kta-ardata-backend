<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class AuthService
{
    public function register(array $data)
    {
        // Validasi
        $validator = Validator::make($data, [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'nomortelepon'  => 'nullable|string',
            'alamat'        => 'nullable|string',
            'role'          => 'nullable|in:anggota,umum,admin',
        ]);

        if ($validator->fails()) {
            return [
                'error' => true,
                'message' => $validator->errors()
            ];
        }

        // Create user
        $user = User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'nomortelepon'  => $data['nomortelepon'] ?? null,
            'alamat'        => $data['alamat'] ?? null,
            'role'          => $data['role'] ?? 'umum',
        ]);

        // Buat token Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'error' => false,
            'user'  => $user,
            'token' => $token
        ];
    }

    public function login(array $data){
    // Validasi
        $validator = Validator::make($data, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'error' => true,
                'message' => $validator->errors()
            ];
        }

        // Cek user
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return [
                'error' => true,
                'message' => 'Email atau password salah'
            ];
        }

        // Buat token baru
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'error' => false,
            'user'  => $user,
            'token' => $token
        ];
    }





}
