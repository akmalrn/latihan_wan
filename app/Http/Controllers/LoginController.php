<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        // Cek apakah user sudah login
        if (Auth::check()) {
            return redirect('home'); // Jika sudah login, redirect ke halaman 'home'
        } else {
            return view('login'); // Jika belum login, tampilkan halaman login
        }
    }

    public function actionlogin(Request $request)
    {
        // Ambil data email dan password dari request
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        // Coba melakukan login dengan data yang diberikan
        if (Auth::attempt($data)) {
            $user = Auth::user();

            Session::put('user_id', $user);
            return redirect()->to('posts/index'); // Jika berhasil, redirect ke halaman 'home'
        } else {
            // Jika gagal, tampilkan pesan error
            Session::flash('error', 'Email atau Password Salah');
            return redirect('login'); // Redirect kembali ke halaman login
        }
    }

    public function actionlogout()
    {
        // Logout user
        Auth::logout();
        return redirect('/'); // Redirect ke halaman login setelah logout
    }
}
