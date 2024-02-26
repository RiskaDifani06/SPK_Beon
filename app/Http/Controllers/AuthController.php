<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\AuthMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    function index(){
        return view('halaman_auth/login');
    }
    function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],[
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            if (Auth::user()->email_verified_at != null) {
                if (Auth::user()->role === 'admin') {
                    return redirect()->route('admin')->with('success', 'Halo Admin, Anda Berhasil Login');
                } else if (Auth::user()->role === 'user') {
                    return redirect()->route('user')->with('success', 'Berhasil Success');
                }
            } else {
                Auth::logout();
                return redirect()->route('auth')->withErrors('Email anda belum di verifikasi');
            }
        }else{
            return redirect()->route('auth')->withErrors('Email atau Password anda tidak sesuai');
        }
    }
    function create(){
        return view('halaman_auth/register');
    }
    function register(Request $request){
        $str = Str::random(100);
        $request->validate([
            'fullname' => 'required|min:5',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
            'gambar' => 'required|image|file',
        ],[
            'fullname.required' => 'Fullname harus diisi',
            'fullname.min' => 'Fullname minimal 5 karakter',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email telah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'gambar.required' => 'Gambar wajib di upload',
            'gambar.image' => 'Gambar yang di upload harus image',
            'gambar.file' => 'Gambar berupa file',
        ]);
        //Menyimpan gambar ke database
        $gambar_file = $request->file('gambar');
        $gambar_ekstensi = $gambar_file->extension();
        $nama_gambar = date('ymdhis').".".$gambar_ekstensi;//agar tidak terjadi penyamaan nama gambar
        $gambar_file->move(public_path('picture/accounts'), $nama_gambar);

        $inforegister = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => $request->password,
            'gambar' => $nama_gambar,
            'verify_key' => $str
        ];
        //Menmbah data diatas ke database
        User::create($inforegister);

        $details = [
            'name' => $inforegister['fullname'],
            'role' => 'user',
            'datetime' => date('d-m-Y H:i:s'), //datetime
            'website' => 'SPK PT Beon',
            'url' => 'http://' . request()->getHttpHost() . "/" . "verify/" . $inforegister['verify_key'],
        ];

        Mail::to($inforegister['email'])->send(new AuthMail($details));
        
        return redirect()->route('auth')->with('success', 'Registrasi berhasil, silahkan cek email anda');
    }

    function verify($verify_key){
        $keyCheck = User::select('verify_key')
        ->where('verify_key', $verify_key)
        ->exists();

        
        if ($keyCheck) {
            $user = User::where('verify_key', $verify_key)->update(['email_verified_at' => now()]);
            
            return redirect()->route('auth')->with('success', 'Verifikasi email berhasil, akun anda sudah aktif');
        } else {
            return redirect()->route('auth')->withErrors('Keys tidak valid, pastikan anda telah melakukan registrasi')->withInput();
        }
    }

    function logout(){
        Auth::logout();
        return redirect('/');
    }
}