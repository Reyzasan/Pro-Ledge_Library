<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Session;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        Session::put('page','ratings');
        $ratings = Rating::with(['users_r','buku_r','pinjam_r'])->where('user_id',  (Auth::user()->id))->get();
        // dd($ratings);
        return view('admin.rating')->with(compact('ratings'));
    }
}
