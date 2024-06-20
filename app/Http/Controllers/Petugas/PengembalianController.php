<?php

namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Rating;
use Barryvdh\DomPDF\Facade\Pdf;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $user = User::all();

        $katakunci = $request->katakunci;
        $dataPeminjaman = collect(); // Inisialisasi variabel sebagai koleksi kosong
        $dataUser = collect(); // Inisialisasi variabel sebagai koleksi kosong

    if (strlen($katakunci)) {
        // Pencarian pada model Peminjaman
        $dataPeminjaman = Peminjaman::with('userss', 'bukus')
            ->where('id', 'like', "%$katakunci%")
            ->orWhereHas('userss', function($query) use ($katakunci) {
                $query->where('name', 'like', "%$katakunci%");
            })
            ->orWhereHas('bukus', function($query) use ($katakunci) {
                $query->where('nama_buku', 'like', "%$katakunci%");
            })
            ->paginate();

        // Pencarian pada model User
        $dataUser = User::where('id', 'like', "%$katakunci%")
            ->orWhere('name', 'like', "%$katakunci%")
            ->paginate();
    } else {
        // Mengambil semua data jika tidak ada kata kunci
        $dataPeminjaman = Peminjaman::with('userss', 'bukus')->orderBy('id', 'desc')->paginate();
        $dataUser = User::orderBy('id', 'desc')->paginate();
    }

    // Menggabungkan hasil dari dua model
    $data = $dataPeminjaman->merge($dataUser);
        $data = Peminjaman::whereIn('status', ['kembali', 'terlambat','selesai'])->whereIn('detailstatus', ['rusak', 'hilang','-'])->get();
        return view('petugas.pengembalian', compact('data', 'user', 'katakunci'))->with('data',$data);
    }

    public function print(Request $request)
    {
        $data = Peminjaman::whereIn('status', ['kembali', 'terlambat','selesai'])->whereIn('detailstatus', ['rusak', 'hilang','-'])->get();
        if($request->get('export') == 'pdf'){
            $pdf = Pdf::loadView('pdf.assets', ['data' => $data]);
            return $pdf->stream('Laporan_Peminjaman.pdf');
        }
    }

    public function pengembalian(Request $request, $id)
    {
        $item = Peminjaman::find($id);
        // dd($item);
        $id_buku = $item->buku;
        $buku = Buku::find($id_buku);
        // dd($buku);

        // Pastikan peminjaman ditemukan
        if (!$item) {
            return redirect()->back()->with('error', 'Peminjaman tidak ditemukan');
        }

        // Pastikan status peminjaman adalah 'disetujui'
        if ($item->status != 'disetujui') {
            return redirect()->back()->with('error', 'Pengembalian hanya bisa dilakukan untuk peminjaman yang disetujui');
        }

        $tanggal_pengembalian = $item->tanggal_pengembalian;
        $kembali = Carbon::now()->toDateString();

        // Tentukan status peminjaman dan denda
        if (Carbon::create($tanggal_pengembalian)->lessThan($kembali)) {
            $hari_terlambat = Carbon::create($tanggal_pengembalian)->diffInDays($kembali);
            $denda = $hari_terlambat * 1000;
            $item->status = 'terlambat';
            $item->denda = $denda;
        } else {
            $item->status = 'kembali';
            $item->denda = 0;
        }

        if($request->status == 'kembali'||$request->detailstatus == '-'){
            $buku->stock += 1;
            $item->save();
        }
        if ($request->detailstatus == 'rusak') {
            $denda = $buku->harga / 2;
            $item->denda += $denda; // denda rusak ke denda keterlambatan jika ada
        } elseif ($request->detailstatus == 'hilang') {
            $denda = $buku->harga;
            $item->denda += $denda; // denda hilang ke denda keterlambatan jika ada
        }

        // Update stock buku jika pengembalian bukan hilang
        if ($request->detailstatus != 'hilang') {
            // $buku->stock += 1;
            $buku->save();
        }
        $item->kembali = $kembali;

        // Update stock buku
        // $buku->stock += 1;
        // $buku->save();

        // Update status peminjaman, tanggal pengembalian, dan denda
        $request->validate([
            'catatan' => 'required',
            'detailstatus' => 'required',
        ], [
            'catatan.required' => 'Catatan wajib diisi!',
            'detailstatus.required' => 'Detail status wajib diisi!',
        ]);

        $item->catatan = $request->catatan;
        $item->detailstatus = $request->detailstatus;
        $item->status = 'kembali';
        // $buku->stock += 1;
        $item->save();

        return redirect()->back()->with('success', 'Pengembalian berhasil dilakukan');
    }

    public function selesai($id, Request $request)
    {
        $item = Peminjaman::find($id);
        $id_buku = $item->buku;
        $peminjaman = Peminjaman::findOrFail($id);
        $buku = Buku::find($id_buku);

        // Set detailstatus sesuai dengan kondisi yang sesuai
        if ($peminjaman->detailstatus == 'rusak') {
            $peminjaman->detailstatus = 'rusak';
        } elseif ($peminjaman->detailstatus == 'hilang') {
            $peminjaman->detailstatus = 'hilang';
        }

        // Set status peminjaman
        $peminjaman->status = 'kembali';
        $peminjaman->detailstatus = '-';
        $buku->stock += 1;
        $buku->save();

        // Set tanggal pengembalian
        $peminjaman->kembali = Carbon::now();

        $peminjaman->save();

        $ratings = Rating::with('pinjam_r')->where('peminjaman_id', $id)->orderBy('id','asc')->get()->toArray();

        //mengecek apakah sudah memberikan review
        $userHasReviewed = Rating::where('peminjaman_id', $id)->where('user_id', Auth::user()->id)->exists();
        $ratings = Rating::with('pinjam_r')->where('peminjaman_id',$id)->orderBy('id','asc')->get()->toArray();


        return redirect()->back()->with('success', 'Peminjaman Selesai');
    }

}
