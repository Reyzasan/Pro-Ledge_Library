<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\penerbit;

class APIPenerbitController extends Controller
{
    public static function getAllDataPenerbit(){
        $data = penerbit::all();
        return response([
            'message' => "Succes Get Data",
            'data' => $data
        ], 200);
    }

    public static function GetDataName($name = ""){
        $namas = penerbit::where('penerbit', 'LIKE', '%'.$name.'%')->get();
        return response([
            'message' => 'Succes',
            'data' => $namas,
        ], 200);
    }
}
