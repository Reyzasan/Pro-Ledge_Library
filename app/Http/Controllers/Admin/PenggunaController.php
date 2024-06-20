<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;

class PenggunaController extends Controller
{
    public function data(Request $request)
    {
        $data = User::where('role', 'pengguna')->whereIn('status', ['blokir', 'ajukan pemblokiran'])->get();
        return view('admin.pengguna', compact('data'));
    }

    // public function print(Request $request)
    // {
    //     $data = User::whereIn('status', ['disetujui', 'batalkan','tolak'])->orWhereNull('status')->get();
    //     if($request->get('export') == 'pdf'){
    //         $pdf = Pdf::loadView('pdf.assets', ['data' => $data]);
    //         return $pdf->stream('Laporan_Peminjaman.pdf');
    //     }
    // }

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
    public function petugas(Request $request)
    {
        $data = User::where('role', 'petugas', 'status')->whereNull('status')->get();
        return view('admin.petugas', compact('data'));
    }
    public function admin(Request $request)
    {
        $data = User::where('role', 'admin')->whereNull('status')->get();
        return view('admin.admin', compact('data'));
    }
    public function user(Request $request)
    {
        $data = User::where('role', 'pengguna')
            ->where(function ($query) {
                $query->whereNull('status')
                      ->orWhereIn('status', ['tolak', 'ajukan pemblokiran']);
            })
            ->get();
        return view('admin.user', compact('data'));
    }
}
