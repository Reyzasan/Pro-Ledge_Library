<?php

namespace App\Http\Controllers;
use App\Models\buku;
use App\Models\kategori;
use App\Models\penerbit;
use App\Models\pengarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class dashboardAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $data = buku::with('kategori')->get();
        $kategori = kategori::all();
        $penerbit = penerbit::all();
        $katakunci = $request->katakunci;
        if(strlen($katakunci)){
            $data = buku::with('kategoris')->where('id','like',"%$katakunci%")->orwhere('nama_buku','like',"%$katakunci%")->orwhere('kategori','like',"%$katakunci%")->paginate();
            $data = buku::with('penerbits')->where('id','like',"%$katakunci%")->orwhere('nama_buku','like',"%$katakunci%")->orwhere('penerbit','like',"%$katakunci%")->paginate();
        }else{
            $data = buku::with('kategoris')->orderBy('id','desc',)->paginate();
            $data = buku::with('penerbits')->orderBy('id','desc',)->paginate();
        }
        return view('admin.tampilan',compact('data','kategori','penerbit'))->with('data',$data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = kategori::all();
        $penerbit = penerbit::all();
        $pengarang = pengarang::all();
        return view('admin.buku',compact('kategori','penerbit','pengarang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nama_buku' => 'required',
        'kategori' => 'required',
        'penerbit' => 'required',
        'pengarang' => 'required',
        'tahun_terbit' => 'required|date_format:Y',
        'stock' => 'numeric',
        'foto'=>'required|mimes:jpeg,jpg,png,gif',
    ], [
        'nama_buku.required' => 'Nama buku wajib diisi!',
        'kategori.required' => 'Kategori wajib diisi!',
        'penerbit.required' => 'Penerbit wajib diisi!',
        'pengarang.required' => 'pengarang wajib diisi!',
        'tahun_terbit.required' => 'Tahun terbit wajib diisi!',
        'tahun_terbit.date_format' => 'Format tahun terbit tidak valid (Format yang diterima: YYYY)!',
        'stock.numeric' => 'Stock harus berupa angka!',
        'foto.required' => 'Foto wajib diisi',
        'foto.mimes' => 'Foto hanya bisa berekstensi jpeg,jpg,png,gif',
    ]);
    $tahun_terbit = Carbon::createFromFormat('Y', $request->tahun_terbit)->startOfYear()->format('Y');
    $foto_file = $request->file('foto');
    $foto_ekstensi = $foto_file->extension();
    $foto_nama = date('ymdhis').".". $foto_ekstensi;
    $foto_file->move(public_path('foto'),$foto_nama);

    $data = [
        // 'id' => $request->id,
        'nama_buku' => $request->nama_buku,
        'kategori' => $request->kategori,
        'penerbit' => $request->penerbit,
        'pengarang' => $request->pengarang,
        'tahun_terbit' => $tahun_terbit,
        'stock' => $request->stock,
        'foto' => $foto_nama,
    ];
    buku::create($data);
    return redirect()->route('admin.tampilan')->with('success', 'Data Berhasil Ditambahkan!');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = buku::findOrFail($id);
        return view('admin.bukudetail', compact('data'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = kategori::all();
        $penerbit = penerbit::all();
        $pengarang = penerbit::all();
        $data = buku::where('id',$id)->first();
        return view('admin.bukuedit',compact('kategori','penerbit'))->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_buku'=>'required',
            'kategori'=>'required',
            'penerbit'=>'required',
            'pengarang'=>'required',
            'tahun_terbit' => 'required|date_format:Y',
            'stock'=>'numeric',
            'foto'=>'required|mimes:jpeg,jpg,png,gif',
        ],[
            'nama_buku.required'=>'nama_buku wajib diisi!',
            'kategori.required'=>'kategori wajib diisi!',
            'penerbit.required'=>'penerbit wajib diisi!',
            'pengarang.required'=>'pengarang wajib diisi!',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi!',
            'tahun_terbit.date_format' => 'Format tahun terbit tidak valid (Format yang diterima: YYYY)!',
            'stock.numeric'=>'Stock wajib diisi!',
            'foto.required' => 'Foto wajib diisi',
            'foto.mimes' => 'Foto hanya bisa berekstensi jpeg,jpg,png,gif',
        ]);

        $tahun_terbit = Carbon::createFromFormat('Y', $request->tahun_terbit)->startOfYear()->format('Y');        $data = [
            'nama_buku'=>$request->nama_buku,
            'kategori'=>$request->kategori,
            'penerbit'=>$request->penerbit,
            'pengarang'=>$request->pengarang,
            'tahun_terbit'=>$tahun_terbit,
            'stock'=>$request->stock,
        ];
        if ($request->hasFile('foto')) {
            $request->validate([
                'foto'=>'mimes:jpeg,jpg,png,gif',
            ],[
                'foto.mimes' => 'Foto hanya bisa berekstensi jpeg,jpg,png,gif'
            ]);
            $foto_file = $request->file('foto');
            $foto_ekstensi = $foto_file->extension();
            $foto_nama = date('ymdhis').".". $foto_ekstensi;
            $foto_file->move(public_path('foto'),$foto_nama);

            $data_foto = buku::where('id',$id)->first();
            File::delete(public_path('foto').'/'.$data_foto->foto);

            $data['foto'] = $foto_nama;
        }
        buku::where('id',$id)->update($data);
        return redirect()->route('admin.tampilan')->with('success', 'Data Berhasil Terupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = buku::where('id',$id)->first();
        File::delete(public_path('foto').'/'.$data->foto);
        buku::where('id',$id)->delete();
        return redirect()->route('admin.tampilan')->with('success','Data Berhasil Dihapus!');
    }
}
