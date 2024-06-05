<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public static function getAllDataKategori(){
        $data = kategori::all();
        return response([
            'message' => "Succes Get Data",
            'data' => $data
        ], 200);
    }
}
