<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pengarang;

class APIPengarangController extends Controller
{
    public static function getAllDataPengarang(){
        $data = pengarang::all();
        return response([
            'message' => "Succes Get Data",
            'data' => $data
        ], 200);
    }

    public static function GetDataName($name = ""){
        $namas = pengarang::where('pengarang', 'LIKE', '%'.$name.'%')->get();
        return response([
            'message' => 'Succes',
            'data' => $namas,
        ], 200);
    }
}
