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
    $request->validate([
        'id' => 'required|numeric|unique:buku,id',
        'nama_buku' => 'required',
        'kategori' => 'required',
        'tahun_terbit' => 'required|date_format:Y',
        'stock' => 'numeric',
    ], [
        'id.required' => 'ID wajib diisi!',
        'id.numeric' => 'ID hanya boleh berupa angka!',
        'id.unique' => 'ID sudah terdaftar!',
        'nama_buku.required' => 'Nama buku wajib diisi!',
        'kategori.required' => 'Kategori wajib diisi!',
        'tahun_terbit.required' => 'Tahun terbit wajib diisi!',
        'tahun_terbit.date_format' => 'Format tahun terbit tidak valid (Format yang diterima: YYYY)!',
        'stock.numeric' => 'Stock harus berupa angka!',
    ]);
    $tahun_terbit = Carbon::createFromFormat('Y', $request->tahun_terbit)->startOfYear()->format('Y-m-d');

    $data = [
        'id' => $request->id,
        'nama_buku' => $request->nama_buku,
        'kategori' => $request->kategori,
        'tahun_terbit' => $tahun_terbit, // Tidak perlu diproses tambahan, karena sudah dalam format yang benar
        'stock' => $request->stock,
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
            'foto'=>'required|mimes:jpeg,jpg,png,gif',
        ],[
            'nama_buku.required'=>'nama_buku wajib diisi!',
            'kategori.required'=>'kategori wajib diisi!',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi!',
            'tahun_terbit.date_format' => 'Format tahun terbit tidak valid (Format yang diterima: YYYY)!',
            'stock.numeric'=>'Stock wajib diisi!',
            'foto.required' => 'Foto wajib diisi',
            'foto.mimes' => 'Foto hanya bisa berekstensi jpeg,jpg,png,gif',
        ]);
        $foto_file = $request->file('foto');
        $foto_ekstensi = $foto_file->extension();
        $foto_nama = date('ymdhis').".". $foto_ekstensi;
        $foto_file->move(public_path('foto'),$foto_nama);

        $tahun_terbit = Carbon::createFromFormat('Y', $request->tahun_terbit)->startOfYear()->format('Y-m-d');
        $data = [
            'nama_buku'=>$request->nama_buku,
            'kategori'=>$request->kategori,
            'tahun_terbit'=>$tahun_terbit,
            'stock'=>$request->stock,
            'foto' => $foto_nama,
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
