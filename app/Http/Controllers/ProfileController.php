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
    public function profileedit(Request $request, $id)
    {
        $user = Auth::user()->id;
        // $users = User::all();
        $userprofile = Profile::where('user_id', $id)->first();
        // Validasi input jika perlu
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // dd($user);
        // Update user data
        $user->name = $request->name;
        $user->save();

        // Update user profile data
        $userprofile->bio = $request->bio;
        $userprofile->phone = $request->phone;
        $userprofile->address = $request->address;

        // Handle file upload
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto'), $filename);
            $userprofile->picture = $filename;
        }

        $userprofile->save();

        Session::flash('success', 'Profile updated successfully');
        return redirect()->route('profile');
    }
}
