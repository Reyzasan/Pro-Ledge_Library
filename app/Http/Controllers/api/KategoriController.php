<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    //dapat semua data
    public static function getAllDataKategori(){
        $data = kategori::all();
        return response([
            'message' => "Succes Get Data",
            'data' => $data
        ], 200);
    }

    //mencari data
    public static function GetDataName($name = ""){
        $namas = kategori::where('kategori', 'LIKE', '%'.$name.'%')->get();
        return response([
            'message' => 'Succes',
            'data' => $namas,
        ], 200);
    }
}
