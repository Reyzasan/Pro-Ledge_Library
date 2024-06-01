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
        $data = Peminjaman::where('status', 'kembali')->get();
        return view('buku.pengembalian', compact('data'));
        // dd($data);
    }

    public function pengembalian($id)
    {
        $item = Peminjaman::find($id);

        // Pastikan peminjaman ditemukan
        if (!$item) {
            return redirect()->back()->with('error', 'Peminjaman tidak ditemukan');
        }
        if ($item->status != 'disetujui') {
            return redirect()->back()->with('error', 'Pengembalian hanya bisa dilakukan untuk peminjaman yang disetujui');
        }
        $id_buku = $item->buku;

        // Cari peminjaman berdasarkan ID
        $peminjaman = Peminjaman::findOrFail($id);
        $buku = Buku::find($id_buku);

        // Tanggal saat ini
        $currentDate = Carbon::now();
        $peminjaman->kembali = $currentDate->toDateString(); // Set tanggal pengembalian ke tanggal saat ini
        // $dueDate = Carbon::parse($peminjaman->tanggal_peminjaman)->addDays(7);
        dd([
            'tanggal_peminjaman' => $peminjaman->tanggal_peminjaman,
            'currentDate' => $currentDate->toDateString(),
            'dueDate' => $dueDate->toDateString()
        ]);

        // // Periksa apakah pengembalian terlambat
        if ($currentDate->greaterThan($dueDate)) {
            // Hitung keterlambatan dalam hari
            $lateDays = $currentDate->diffInDays($dueDate);
            // Hitung denda
            $denda = $lateDays * 1000;
            $peminjaman->denda = $denda;
        } else {
            $peminjaman->denda = 0;
        }
        // Periksa apakah pengembalian terlambat
        $fine = $lateDays > 0 ? $lateDays * 1000 : 0;
        $item->status = 'kembali';
        // $item->kembali = $currentDate->toDateString();
        // $item->denda = $fine;


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
