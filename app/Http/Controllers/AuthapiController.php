<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthapiController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        try {
            // Cek apakah ada token yang dapat dibuat menggunakan kredensial
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Email atau password salah!'], 401);
            }

            // Ambil data pengguna yang sedang login
            $user = Auth::user();

            // Cek apakah email sudah terverifikasi
            if (!$user->email_verified_at) {
                return response()->json(['message' => 'Akun belum diverifikasi!'], 403);
            }

            // Kembalikan respons sukses dengan data pengguna dan token
            return response()->json([
                'message' => 'Login berhasil',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Tidak dapat membuat token'], 500);
        }
    }

    public function register(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            // Membuat pengguna baru
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);

            // Token untuk pengguna baru
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'message' => 'Registrasi berhasil!',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat registrasi.'], 500);
        }
    }

    public function logout()
    {
        try {
            // Ambil token dari header Authorization
            $token = JWTAuth::parseToken(); // Mengambil token yang ada di header Authorization
    
            // Invalidasi token
            $token->invalidate();
    
            // Kirim respons sukses
            return response()->json(['message' => 'Logout berhasil'], 200);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            // Jika token tidak valid atau tidak ada
            return response()->json(['message' => 'Tidak dapat logout, token tidak valid atau telah kadaluarsa'], 500);
        }
    }
    
    

    
    


    
}