<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{
    public function auth()
    {
        return view('auth');    
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            ],[
                'email.required' => 'Email harus diisi',
                'email.email' => 'Email harus valid',
                'password.required' => 'Password harus diisi',
                'password.min' => 'Password minimal 6 karakter',
            ]);

            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();
    
                if ($user->email_verified_at) {
                    $request->session()->regenerate();
                    Log::info('Role ID User: ' . $user->role_id);
    
                    return redirect()->route('dashboard.index')->with('success', 'Selamat Datang ' . ($user->role_id === 1 ? 'Admin!' : 'User!'));
                } else {
                    Auth::logout();
                    return back()->with('error', 'Harap verifikasi akun Anda!');
                }
            }

        return redirect()->route('auth')->with('error', 'Kombinasi email dan password salah!');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            ],[
                'name.required' => 'Nama harus diisi',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Email harus valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password harus diisi',
                'password.min' => 'Password minimal 6 karakter',
            ]);
        
        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            //SMTP
            Notification::send($user, new VerifyEmail());

            return redirect()->route('auth')->with('success', 'Berhasil Mendaftar! Silahkan cek email untuk verifikasi akun anda!');

        }catch(\Exception $e){
            return redirect()->route('auth')->with('error', 'Gagal Mendaftar!' .$e);
        }
    }

    public function verify($id, $hash)
    {
        $user = user::findOrFail($id);

        if(sha1($user->getEmailForVerification()) !== $hash){
            return redirect()->route('auth')->with('error', 'Link verifikasi tidak valid!');
        }

        if($user->hasVerifiedEmail()){
            return redirect()->route('auth')->with('success', 'Akun anda sudah terverifikasi');
        }

        if($user->markEmailAsVerified()){
            return redirect()->route('auth')->with('success', 'Akun anda berhasil terverifikasi');
        }

        return redirect()->route('auth')->with('error', 'Gagal verifikasi email!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


}