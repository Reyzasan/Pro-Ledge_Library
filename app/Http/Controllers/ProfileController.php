<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        $current_userid = Auth::user()->id;

        $userinfo = User::find($current_userid);
        $userprofile = Profile::where('user_id', $current_userid)->first();

        return view('user.profile',compact('userprofile','userinfo'));
    }
    public function profileedit()
    {
        $current_userid = Auth()->user()->id;
        $userinfo = User::where('id', '=', $current_userid)->first();
        $userprofile = Profile::where('user_id', '=', $current_userid)->first();
        dd($userprofile);
        return view()->back()->compact('userprofile','userinfo');
    }
}
