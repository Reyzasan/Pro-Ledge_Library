<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pengguna;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        if(strlen($katakunci)){
            $data = pengguna::where('nim','like',"%$katakunci%")->orwhere('nama','like',"%$katakunci%")->orwhere('jurusan','like',"%$katakunci%")->paginate();
        }else{
            $data = pengguna::orderBy('nim','desc',)->paginate();
        }
        return view('pengguna.user')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengguna.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session()->flash('nim', $request->nim);
        Session()->flash('nama', $request->nama);
        Session()->flash('jurusan', $request->jurusan);
        $request->validate([
            'nim'=>'required|numeric|unique:pengguna,nim',
            'nama'=>'required',
            'jurusan'=>'required',
        ],[
            'nim.required'=>'NIM wajib diisi!',
            'nim.numeric'=>'NIM hanya berupa angka!',
            'nim.unique'=>'NIM sudah terdaftar!',
            'nama.required'=>'Nama wajib diisi!',
            'jurusan.required'=>'Jurusan wajib diisi!',
        ]);
        $data = [
            'nim'=>$request->nim,
            'nama'=>$request->nama,
            'jurusan'=>$request->jurusan,
        ];
        pengguna::create($data);
        return redirect()->to('pengguna')->with('success', 'Data Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = pengguna::where('nim',$id)->first();
        return view('pengguna.edit')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama'=>'required',
            'jurusan'=>'required',
        ],[
            'nama.required'=>'Nama wajib diisi!',
            'jurusan.required'=>'Jurusan wajib diisi!',
        ]);
        $data = [
            'nama'=>$request->nama,
            'jurusan'=>$request->jurusan,
        ];
        pengguna::where('nim',$id)->update($data);
        return redirect()->to('pengguna')->with('success', 'Data Berhasil Terupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        pengguna::where('nim',$id)->delete();
        return redirect()->to('pengguna')->with('success','Data Berhasil Dihapus!');
    }
}
