<?php

namespace App\Http\Controllers;
use App\Models\buku;
use App\Models\kategori;
use Illuminate\Http\Request;
use Carbon\Carbon;


class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $data = buku::with('kategori')->get();
        $kategori = kategori::all();
        $katakunci = $request->katakunci;
        if(strlen($katakunci)){
            $data = buku::with('kategoris')->where('id','like',"%$katakunci%")->orwhere('nama_buku','like',"%$katakunci%")->orwhere('kategori','like',"%$katakunci%")->paginate();
        }else{
            $data = buku::with('kategoris')->orderBy('id','desc',)->paginate();
        }
        return view('buku.user',compact('data','kategori'))->with('data',$data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = kategori::all();
        return view('buku.buku',compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session()->flash('id', $request->id);
        Session()->flash('nama_buku', $request->nama_buku);
        Session()->flash('kategori', $request->kategori);
        Session()->flash('tahun_terbit', $request->tahun_terbit);
        Session()->flash('stock', $request->stock);
        $request->validate([
            'id' => 'required|numeric|unique:buku,id',
            'nama_buku' => 'required',
            'kategori' => 'required',
            'tahun_terbit' => 'required|date_format:Y',
            'stock' => 'numeric',
        ],[
            'id.required' => 'ID wajib diisi!',
            'id.numeric' => 'ID hanya boleh berupa angka!',
            'id.unique' => 'ID sudah terdaftar!',
            'nama_buku.required' => 'Nama buku wajib diisi!',
            'kategori.required' => 'Kategori wajib diisi!',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi!',
            'tahun_terbit.date_format' => 'Format tahun terbit tidak valid (Format yang diterima: YYYY)!',
            'stock.numeric' => 'Stock harus berupa angka!',
        ]);


        $data = [
            'id'=>$request->id,
            'nama_buku'=>$request->nama_buku,
            'kategori'=>$request->kategori,
            'tahun_terbit'=>$request->tahun_terbit,
            'stock'=>$request->stock,
        ];
        buku::create($data);
        return redirect()->to('buku')->with('success', 'Data Berhasil Ditambahkan!');
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
        $kategori = kategori::all();
        $data = buku::where('id',$id)->first();
        return view('buku.bukuedit',compact('kategori'))->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_buku'=>'required',
            'kategori'=>'required',
            'tahun_terbit' => 'required|date_format:Y',
            'stock'=>'numeric',
        ],[
            'nama_buku.required'=>'nama_buku wajib diisi!',
            'kategori.required'=>'kategori wajib diisi!',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi!',
            'tahun_terbit.date_format' => 'Format tahun terbit tidak valid (Format yang diterima: YYYY)!',
            'stock.numeric'=>'Stock wajib diisi!',
        ]);
        $data = [
            'nama_buku'=>$request->nama_buku,
            'kategori'=>$request->kategori,
            'tahun_terbit'=>$request->tahun_terbit,
            'stock'=>$request->stock,
        ];
        buku::where('id',$id)->update($data);
        return redirect()->to('buku')->with('success', 'Data Berhasil Terupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        buku::where('id',$id)->delete();
        return redirect()->to('buku')->with('success','Data Berhasil Dihapus!');
    }
}
