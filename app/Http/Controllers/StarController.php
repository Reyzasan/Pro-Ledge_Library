<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Rating;
use Illuminate\Http\Request;

class StarController extends Controller
{
    public function rating(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            if(!Auth::check()){
                $message = "Login to rate this book";
                Session::flash('error', $message);
                return redirect()->back();
            }
            if (!isset($data['rating'])||empty($data['rating'])){
                $message = "Pick Minimun 1 star";
                Session::flash('gagal', $message);
                return redirect()->back();
            }
            
            $ratingCount = Rating::where(['user_id' => Auth::user()->id, "buku_id"=>$data['buku_id']])->count();
            if ($ratingCount>0) {
                $message = "Your Rating alredy exists for this product";
                Session::flash('gagal', $message);
                return redirect()->back();
            }else{
                $rating = new Rating;
                $rating->user_id = Auth::user()->id;
                $rating->buku_id = $data['buku_id'];
                $rating->review = $data['review'];
                $rating->rating = $data['rating'];
                $rating->status = 0;
                $rating->save();
                $message = "Thank You for your review";
                Session::flash('success',$message);
                return redirect()->back();
            }
        }
    }
}
