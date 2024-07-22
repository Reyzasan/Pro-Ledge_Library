<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\currentAccesToken;
use App\Models\User;

class APIAutentifikasiController extends Controller
{
    use ValidatesRequests;
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau Password Salah.'],
            ]);
        }

        return $user->createToken('user login')->plainTextToken;

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
    }

    public function akunlogin(Request $request)
    {
    //   $user = Auth::user();
    //   $post
      return response()->json(Auth::user());
    }

    public function register(Request $request)
    {
       $this->validate($request,[
            'name' => 'required|string|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed',
       ]);
       $data = $request->all();
       $user = User::create($data);

       if ($user) {
            return $user;
       }
       return $request->all();
    }
}
