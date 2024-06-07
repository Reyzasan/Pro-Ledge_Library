<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PenggunaPetugasController extends Controller
{
    public function data(Request $request)
    {
        // $data = User::all();
        $data = User::where('role', 'pengguna')->get();
        $item = User::where('role', 'pengguna')
                ->where(function ($query) {
                    $query->where('status', 'ajukan pemblokiran')
                          ->orWhereNull('status');
                })
                ->get();

        return view('petugas.pengguna', compact('data','item'));
    }

    public function status($id)
{
    // Temukan pengguna berdasarkan ID
    $blokir = User::findOrFail($id);

    // Update status pengguna menjadi 'ajukan pemblokiran'
    $blokir->status = 'ajukan pemblokiran';
    $blokir->save();

    // // Ambil semua pengguna dengan status 'ajukan pemblokiran' atau status null
    $data = User::where('role', 'pengguna')
                ->where(function ($query) {
                    $query->where('status', 'ajukan pemblokiran')
                          ->orWhereNull('status');
                })
                ->get();

    // // Ambil semua pengguna dengan peran 'pengguna'
    // $status = User::where('role', 'pengguna')->get();

    // Kembalikan ke view dengan data yang diperlukan
    return redirect()->route('StatusPetugas');
    // return view('petugas.pengguna', compact('blokir','data'));
}

}
