<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\buku;

class BukuAPIController extends Controller
{
    public static function getAllDataBuku(){
        $data = buku::all();
        return response([
            'message' => "Succes Get Data",
            'data' => $data
        ], 200);
    }
}
