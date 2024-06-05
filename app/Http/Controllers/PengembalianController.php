<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        $data = Peminjaman::whereIn('status',['kembali', 'terlambat'])->get();
        return view('buku.pengembalian', compact('data'));
    }

    public function pengembalian($id)
    {
        $item = Peminjaman::find($id);
        $id_buku = $item->buku;
        $buku = Buku::find($id_buku);

        // Pastikan peminjaman ditemukan
        if (!$item) {
            return redirect()->back()->with('error', 'Peminjaman tidak ditemukan');
        }
        if ($item->status != 'disetujui') {
            return redirect()->back()->with('error', 'Pengembalian hanya bisa dilakukan untuk peminjaman yang disetujui');
        }
        $peminjaman = Peminjaman::findOrFail($id); // memiliki objek peminjaman yang benar
        $tanggal_pengembalian = $peminjaman->tanggal_pengembalian;
        $kembali = Carbon::now()->toDateString();
        // dd($kembali);

        if (Carbon::create($peminjaman->tanggal_pengembalian)->lessThan($kembali)) {
            $hari_terlambat = Carbon::create($tanggal_pengembalian)->diffInDays($kembali);
            $denda = $hari_terlambat * 1000;
            $item->status = $denda > 0 ? 'terlambat' : 'kembali';
            $item->denda = $denda;
        } else {
            //kalau tidak telat
            $item->status = 'kembali';
            $item->denda = 0;
        }
        $item->kembali = $kembali;
       
        // Update stock buku
        $buku->stock += 1;
        $buku->save();

        // Update status peminjaman, tanggal pengembalian, dan denda
        $item->save();

        if (!$buku) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan');
        }

        return redirect()->back()->with('success', 'Pengembalian berhasil dilakukan');
    }
}
