<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Rating;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class StarController extends Controller
{
    public function rating(Request $request)
    {
        if($request->isMethod('post'))
        {
            $ratingskeun = $request->all();
            // dd($ratingskeun);
            // echo "<pre>";print_r($ratingskeun);die;
            if(!Auth::check()){
                $message = "Login to rate this book";
                Session::flash('error', $message);
                return redirect()->back();
            }
            if (!isset($ratingskeun['rating']) || empty($ratingskeun['rating'])){
                $message = "Pick Minimum 1 star";
                Session::flash('gagal', $message);
                return redirect()->back();
            }
            $ratingCount = Rating::where([
                'user_id' => Auth::user()->id,
                'peminjaman_id' => $ratingskeun['peminjaman_id'],
                // 'buku_id' => $ratingskeun['buku_id']
            ])->count();
            if ($ratingCount > 0) {
                $message = "You have already rated this book";
                Session::flash('gagal', $message);
                return redirect()->back();
            } else {
                // Mengambil buku_id dari tabel Peminjaman
                $peminjaman = Peminjaman::find($ratingskeun['peminjaman_id']);
                if (!$peminjaman) {
                    $message = "Peminjaman not found";
                    Session::flash('gagal', $message);
                    return redirect()->back();
                }

                $buku_id = $peminjaman->buku;
                // dd($buku_id);

                $rating = new Rating;
                $rating->user_id = Auth::user()->id;
                $rating->peminjaman_id = $ratingskeun['peminjaman_id'];
                $rating->buku_id = $buku_id; // Menyimpan buku_id yang diambil dari peminjaman
                $rating->review = $ratingskeun['review'];
                $rating->rating = $ratingskeun['rating'];
                $rating->status = 0;
                $rating->save();

                $message = "Thank you for your review";
                Session::flash('success', $message);
                return redirect()->back();
                // return view('user.coba', compact('ratingskeun'));
            }
        }
    }
}
