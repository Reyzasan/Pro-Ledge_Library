<?php

namespace App\Http\Controllers;
use App\Models\buku;
use App\Models\kategori;
use App\Models\penerbit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\Peminjaman;
use App\Models\Rating;
use App\Models\Koleksi;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $data = buku::with('kategori')->get();
        $kategori = kategori::all();
        $penerbit = penerbit::all();
        $katakunci = $request->katakunci;
        if(strlen($katakunci)){
            $data = buku::with('kategoris')->where('id','like',"%$katakunci%")->orwhere('nama_buku','like',"%$katakunci%")->orwhere('kategori','like',"%$katakunci%")->paginate();
            $data = buku::with('penerbits')->where('id','like',"%$katakunci%")->orwhere('nama_buku','like',"%$katakunci%")->orwhere('penerbit','like',"%$katakunci%")->paginate();
        }else{
            $data = buku::with('kategoris')->orderBy('id','desc',)->paginate();
            $data = buku::with('penerbits')->orderBy('id','desc',)->paginate();
        }
        return view('user.dashboard',compact('data','kategori','penerbit'))->with('data',$data);
    }

    /**
     * Display the specified resource.
     */
    public static function show(string $id)
    {
        $data = buku::find($id);
        $item = Peminjaman::find($id);
        $pinjam = Peminjaman::with(['userss', 'bukus'])->where('user',  (Auth::user()->id))->where('buku', $id)->get();
        $kolek = Koleksi::with(['userss', 'bukus','kategoris','penerbits'])->where('user',  (Auth::user()->id))->get();
        // dd($pinjam);
        // dd($kolek);
        //Rating and Comment
        $ratings = Rating::with('users_r')->where('buku_id', $id)->orderBy('id','asc')->get()->toArray();
        // dd($ratings);
        // $kolek = Koleksi::with(['userss', 'bukus','kategoris','penerbits'])->where('user',  (Auth::user()->id))->get();
        // dd($data);

        //Rata-rata
        $ratingSum = Rating::where('buku_id', $id)->sum('rating');
        $ratingCount = Rating::where('buku_id', $id)->count();
        if ($ratingCount > 0) {
            $avgRating = round($ratingSum / $ratingCount, 2);
            $avgStarRating = round($ratingSum / $ratingCount);
        } else {
            $avgRating = 0;
            $avgStarRating = 0;
        }

        return view('buku.bukudetailuser', compact('data', 'item','ratings', 'ratingSum', 'ratingCount', 'avgRating', 'avgStarRating','kolek','pinjam'));
    }

    public function koleksi()
    {
        $data = Koleksi::with(['userss', 'bukus','kategoris','penerbits'])->where('user',  (Auth::user()->id))->where('status', 'koleksi')->get();
        // $kolek = Koleksi::where('status', 'koleksi')
        //     ->where('user', Auth::user()->id)  // Assuming 'user' field exists in Peminjaman model
        //     ->get();
        // dd($data);
        return view('user.koleksi', compact('data'));
    }

    public function postkoleksi(string $id)
    {
        if (!Auth::check()) {
            return redirect()->route('account.login')->with('error', 'Anda harus login untuk mengkoleksi buku');
        }

        $BatasKoleksi = Koleksi::where('user', Auth::user()->id)
            ->where('nama_buku', $id)
            ->first();

        if ($BatasKoleksi) {
            return redirect()->back()->with('gagal', 'Buku Sudah di Koleksi.');
        }

        $buku = Buku::with(['kategoris', 'penerbits'])->find($id);

        if (!$buku) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan.');
        }

        DB::table('koleksis')->insert([
            'nama_buku' => $id,
            'user' => Auth::user()->id,
            'foto' => $buku->foto,
            'kategori' => $buku->kategoris->id,
            'penerbit' => $buku->penerbits->id,
            'deskripsi' => 'jhdjhdjhefj',
            'status' => 'koleksi'
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dikoleksi.');
    }

    public function batalkoleksi($id)
    {
        // Ambil data Koleksi dengan relasi terkait
        $data = Koleksi::with(['userss', 'bukus', 'kategoris', 'penerbits'])
            ->where('user', Auth::user()->id)
            ->get();

        // Ambil data Peminjaman dengan status 'koleksi'
        $kolek = Koleksi::where('status', 'koleksi')
            ->where('user', Auth::user()->id)
            ->get();

        // Cari item Koleksi berdasarkan user dan id buku
        $item = Koleksi::where('user', Auth::user()->id)
            ->where('nama_buku', $id)
            ->first();

        // Jika item tidak ditemukan, kembali dengan pesan error
        if (!$item) {
            return redirect()->back()->with('error', 'Koleksi tidak ditemukan.');
        }

        // Ubah status item menjadi 'hapus' dan simpan
        $item->status = 'hapus';
        $item->save();

        //hapus dari database
        $item->delete();
        // Kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Koleksi berhasil dihapus.');
    }

}
