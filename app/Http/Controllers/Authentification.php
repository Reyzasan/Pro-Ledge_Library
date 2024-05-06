<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class Authentification extends Controller
{
    function index()
    {
        return view("Autentifikasi/data");
    }
    function login(Request $request)
    {
        Session::flash('email', $request->email);
        Session::flash('password', $request->password);
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ],[
            'email.required'=>'Email Wajib Diisi',
            'password.required'=>'Password Wajib Diisi',
        ]);

        $login = [
            'email'=>$request->email,
            'password'=>$request->password,
        ];

        if (Auth::attempt($login)) {
            return redirect('buku')->with('Berhasil Masuk');
        }else{
            return redirect('authe')->withErrors('email dan password tidak valid');
        };
    }

    function logout(){
        Auth::logout();
        return redirect('authe')->with("Berhasil Logout");
    }

    function register()
    {
        return view('Autentifikasi/register');
    }
    function create(Request $request)
    {
        Session::flash('email', $request->email);
        Session::flash('password', $request->password);
        Session::flash('name', $request->name);
        $request->validate([
            'email'=>'required|email|unique:users',
            'name'=>'required',
            'password'=>'required|min:8|max:10',
        ],[
            'email.required'=>'Email Wajib Diisi',
            'email.email'=>'Masukan Email yang Valid',
            'email.unique'=>'Email sudah digunakan',
            'name.required'=>'Username Wajib Diisi',
            'password.required'=>'Password Wajib Diisi',
            'password.min'=>'Password Minimal 8 Karakter',
            'password.max'=>'Password Minimal 10 Karakter',
        ]);

        $data = [
            'email'=>$request->email,
            'name'=>$request->name,
            'password'=>Hash::make($request->password),
        ];

        User::create($data);

        $login = [
            'email'=>$request->email,
            'name'=>$request->name,
            'password'=>$request->password,
        ];

        if (Auth::attempt($login)) {
            return redirect('buku')->with('Success',  Auth::user()->name . 'Berhasil Register');
        }else{
            return redirect('authe')->withErrors('email dan password tidak valid');
        };
    }
}
