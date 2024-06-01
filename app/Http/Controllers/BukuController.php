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

        //Rating and Comment
        $ratings = Rating::with('users_r')->where('buku_id', $id)->orderBy('id','asc')->get()->toArray();
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

        return view('buku.bukudetailuser', compact('data', 'ratings', 'ratingSum', 'ratingCount', 'avgRating', 'avgStarRating'));
    }

    public function koleksi()
    {
        $data = Koleksi::with(['userss', 'bukus','kategoris','penerbits'])->where('user',  (Auth::user()->id))->get();
        // dd($data);
        return view('user.koleksi', compact('data'));
    }

    public function postkoleksi(string $id)
    {
        $BatasKoleksi = Koleksi::where('user', Auth::user()->id)
            ->where('nama_buku', $id)->first();

        if ($BatasKoleksi) {
            return redirect()->back()->with('gagal', 'Buku Sudah di Koleksi.');
        }
        if (!Auth::check()) {
            return redirect()->route('account.login')->with('error', 'Anda harus login untuk mengkoleksi buku');
        }

        $buku = Buku::with(['kategoris', 'penerbits'])->find($id);
        DB::table('koleksis')->insert([
            'nama_buku' => $id,
            'user' => Auth::user()->id,
            'foto' => $buku->foto,
            'kategori' => $buku->kategoris->id,
            'penerbit' => $buku->penerbits->id,
            'deskripsi' => $id,
        ]);
        return redirect()->back();
    }

}
