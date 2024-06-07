<?php

namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
    public function index()
    {
        $title = 'Halaman Peminjaman Buku';
        $data = Peminjaman::whereIn('status', ['disetujui', 'batalkan','tolak'])->orWhereNull('status')->get();
        return view('petugas.peminjaman', compact('title', 'data'));
    }

    public function print(Request $request)
    {
        $data = Peminjaman::whereIn('status', ['disetujui', 'batalkan','tolak'])->orWhereNull('status')->get();
        if($request->get('export') == 'pdf'){
            $pdf = Pdf::loadView('pdf.assets', ['data' => $data]);
            return $pdf->stream('Laporan_Peminjaman.pdf');
        }
    }

    private function checkActiveLoans()
    {
        return Peminjaman::where('user', Auth::user()->id)
            ->whereIn('status', ['disetujui'])
            ->orWhereNull('status')
            ->count();
    }

    public function store($id)
    {
        if (!Auth::check()) {
            return redirect()->route('account.login')->with('error', 'Anda harus login untuk meminjam buku');
        }

        // Cek jumlah peminjaman aktif pengguna
        $BukuBatas = $this->checkActiveLoans();

        if ($BukuBatas == 5) {
            return redirect()->back()->with('gagal', 'Anda tidak dapat meminjam lebih dari 5 buku sekaligus.');
        }

        // dd($data);
        //membatasi peminjaman 1 akun 1 buku
        $BukuBatas = Peminjaman::where('user', Auth::user()->id)
            ->where('buku', $id)
            ->where(function ($query) {
                $query->whereIn('status', ['disetujui', 'batalkan', 'tolak'])
                      ->orWhereNull('status');
            })
            ->first();
        if ($BukuBatas) {
            return redirect()->back()->with('gagal', 'Anda sudah meminjam buku ini.');
        }
        // Cek ketersediaan stok buku
        $cek = DB::table('buku')->where('id', $id)->where('stock', '>', 0)->count();
        if ($cek > 0) {
            DB::table('table_peminjaman')->insert([
                'buku' => $id,
                'user' => Auth::user()->id,
                'denda' => 0,
                'tangal_peminjaman' => null,
                'pengajuan' => Carbon::now(),
                'tanggal_pengembalian' => null,
                'kembali' => null,
            ]);

            $buku = DB::table('buku')->where('id', $id)->first();
            $stock_baru = $buku->stock - 1;

            DB::table('buku')->where('id', $id)->update(['stock' => $stock_baru]);
            return redirect()->back()->with('success', 'Anda berhasil meminjam');
        } else {
            return redirect()->back()->with('gagal', 'Buku Tidak Tersedia');
        }
    }

    public function accept($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $item = Peminjaman::find($id);
        $peminjaman->status = 'disetujui';
        $peminjaman->tangal_peminjaman = Carbon::now()->toDateString();
        $peminjaman->tanggal_pengembalian = Carbon::now()->addDays(10);
        $peminjaman->save();

        //pengembalian
        $peminjaman->kembali = Carbon::now();
        $item->status = 'kembali';

        return redirect()->route('pinjam-buku')->with('success', 'Peminjaman disetujui');
    }


    public function remove($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'batalkan';
        $peminjaman->save();

        return redirect()->route('pinjam-buku')->with('error', 'Peminjaman Dibatalkan');
    }

    public function tolak($id)
    {
        $item = Peminjaman::find($id);

        if (!$item) {
            return redirect()->back()->with('error', 'Peminjaman tidak ditemukan');
        }

        $id_buku = $item->buku;

        $buku = Buku::find($id_buku);

        if (!$buku) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan');
        }

        $buku->stock += 1;
        $buku->save();

        $item->status = 'tolak';
        $item->save();

        return redirect()->route('pinjam-buku')->with('error', 'Peminjaman ditolak');
    }

    public function batal($id)
    {
        $item = Peminjaman::find($id);

        if (!$item) {
            return redirect()->back()->with('error', 'Peminjaman tidak ditemukan');
        }

        $id_buku = $item->buku;

        $buku = Buku::find($id_buku);

        if (!$buku) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan');
        }

        $buku->stock += 1;
        $buku->save();

        $item->status = 'batal';
        $item->save();

        return redirect()->route('PeminjamanUser')->with('error', 'Peminjaman Dibatalkan');
    }

    public function PeminjamanUser()
    {
        $data = Peminjaman::with(['userss', 'bukus'])->where('user',  (Auth::user()->id))->get();
        // dd($data);
        return view('user.peminjaman', ['data' => $data]);
    }
}