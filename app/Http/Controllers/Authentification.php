<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Authentification extends Controller
{
    public function index()
    {
        return view("desain/login");
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        //admin
        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                if ($user->role == 'admin') {
                    return redirect()->route('admin.tampilan');
                } elseif ($user->role == 'petugas') {
                    return redirect()->route('petugas.lihat');
                }else {
                    return redirect()->route('account.dashboard');
                }
            } else {
                return redirect()->route('account.login')->with('error', 'Either Email or Password is incorrect');
            }
        } else {
            return redirect()->route('account.login')
                ->withInput()
                ->withErrors($validator);
        }
    }

    public function register()
    {
        return view('desain/register');
    }

    public function ProcessRegister(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed',
        ]);

        if($validator->passes()){
            $user = new User();
            $user->email = $request->email;

            $user->password = Hash::make($request->password);
            $user->name = $request->name;
            $user->role = 'pengguna';
            $user->save();

                // Profile creation logic
            $createprofile = new Profile();
            $createprofile->user_id = $user->id;
            $createprofile->save();


            return redirect()->route('account.login')->with('succes','Anda Berhasil Register');
        }else{
            // $post = Post::create([
            //     'name'     => $request->input('name'),
            //     'email'   => $request->input('email'),
            //     'email'   => $request->input('password')
            // ]);

            // if ($post) {
            //     return response()->json([
            //         'success' => true,
            //         'message' => 'Post Berhasil Disimpan!',
            //     ], 200);
            // } else {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Post Gagal Disimpan!',
            //     ], 401);
            // }
            // return redirect()->route('account.register')
            // ->withInput()
            // ->withErrors($validator);
        }
        // $getuserid = $user->id;
        // $createprofile = new Profile();
        // $createprofile->user_id = $getuserid;
        // $createprofile->save();

        // return response([
        //     'user' => $user,
        //     'token' =>$user->createToken('secret')->plainTextToken
        // ]);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }

}
