<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PenggunaController extends Controller
{
    public function data(Request $request)
    {
        $data = User::where('role', 'pengguna')->get();
        // dd($tampil);
        return view('admin.pengguna', compact('data'));
    }

    public function status($id)
    {
        $blokir = User::findOrFail($id);
        $data = User::whereIn('status', ['blokir', 'ajukan pemblokiran'])->orWhereNull('status')->get();
        $blokir->status = 'blokir';
        $blokir->save();
        // return view('admin.pengguna', compact('blokir','data'));
        return redirect()->route('pengguna.status')->with('error', 'Pemblokiran Diterima');
    }
    public function tolak($id)
    {
        $blokir = User::findOrFail($id);
        $data = User::whereIn('status', ['blokir', 'ajukan pemblokiran'])->orWhereNull('status')->get();
        $blokir->status = 'tolak';
        $blokir->save();
        return redirect()->route('pengguna.status')->with('success', 'Pemblokiran Ditolak');
    }
}
