<?php

namespace App\Http\Controllers;
use App\Models\kategori;

use Illuminate\Http\Request;

class KategoriBukuController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        if(strlen($katakunci)){
            $data = kategori::where('id','like',"%$katakunci%")->orwhere('kategori','like',"%$katakunci%")->paginate();
        }else{
            $data = kategori::orderBy('id','desc',)->paginate();
        }
        return view('kategori.user')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.kategori');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session()->flash('id', $request->id);
        Session()->flash('kategori', $request->kategori);
        Session()->flash('deskripsi', $request->deskripsi);
        $request->validate([
            'id'=>'required|string|unique:kategori,id',
            'kategori'=>'required',
            'deskripsi'=>'required',
        ],[
            'id.required'=>'id wajib diisi!',
            'id.unique'=>'id sudah terdaftar!',
            'kategori.required'=>'kategori wajib diisi!',
            'deskripsi.required'=>'deskripsi wajib diisi!',
        ]);
        $data = [
            'id'=>$request->id,
            'kategori'=>$request->kategori,
            'deskripsi'=>$request->deskripsi,
        ];
        kategori::create($data);
        return redirect()->to('kategori')->with('success', 'Data Berhasil Ditambahkan!');
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
        $data = kategori::where('id',$id)->first();
        return view('kategori.kategoriedit')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori'=>'required',
            'deskripsi'=>'required',
        ],[
            'kategori.required'=>'kategori wajib diisi!',
            'deskripsi.required'=>'deskripsi wajib diisi!',
        ]);
        $data = [
            'kategori'=>$request->kategori,
            'deskripsi'=>$request->deskripsi,
        ];
        kategori::where('id',$id)->update($data);
        return redirect()->to('kategori')->with('success', 'Data Berhasil Terupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        kategori::where('id',$id)->delete();
        return redirect()->to('kategori')->with('success','Data Berhasil Dihapus!');
    }
}
