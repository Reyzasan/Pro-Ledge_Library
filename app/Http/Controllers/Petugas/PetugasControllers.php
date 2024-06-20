<?php

namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use App\Models\buku;
use App\Models\kategori;
use App\Models\penerbit;
use App\Models\pengarang;
use App\Models\peminjaman;
use App\Models\jenisbuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PetugasControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $data = buku::with('kategori')->get();
        // $data = buku::find($id);
        $kategori = kategori::all();
        $penerbit = penerbit::all();
        $jenisbuku = jenisbuku::all();
        $pengarang = pengarang::all();
        // dd($data);
        $katakunci = $request->katakunci;
        if(strlen($katakunci)){
            $data = buku::with('kategoris')->where('id','like',"%$katakunci%")->orwhere('nama_buku','like',"%$katakunci%")->orwhere('kategori','like',"%$katakunci%")->paginate();
            $data = buku::with('penerbits')->where('id','like',"%$katakunci%")->orwhere('nama_buku','like',"%$katakunci%")->orwhere('penerbit','like',"%$katakunci%")->paginate();
        }else{
            $data = buku::with('kategoris')->orderBy('id','desc',)->paginate();
            $data = buku::with('penerbits')->orderBy('id','desc',)->paginate();
        }
        return view('petugas.dashboard',compact('data','kategori','penerbit','pengarang','jenisbuku'))->with('data',$data);
    }

    public function print(Request $request)
    {
        $data = Peminjaman::whereIn('status', ['disetujui', 'batalkan','tolak'])->orWhereNull('status')->get();
        if($request->get('export') == 'pdf'){
            $pdf = Pdf::loadView('pdf.assets', ['data' => $data]);
            return $pdf->stream('Laporan_Peminjaman.pdf');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = kategori::all();
        $penerbit = penerbit::all();
        $pengarang = pengarang::all();
        $jenisbuku = jenisbuku::all();
        return view('petugas.createbuku',compact('kategori','penerbit','pengarang','jenisbuku'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_buku' => 'required',
            'kategori' => 'required',
            'jenisbuku' => 'required',
            'deskripsi' => 'required',
            'penerbit' => 'required',
            'pengarang' => 'required',
            'harga' => 'required',
            'tahun_terbit' => 'required|date_format:Y',
            'stock' => 'numeric',
            'foto'=>'required|mimes:jpeg,jpg,png,gif',
        ], [
            'nama_buku.required' => 'Nama buku wajib diisi!',
            'kategori.required' => 'Kategori wajib diisi!',
            'jenisbuku.required' => 'Kategori wajib diisi!',
            'deskripsi.required' => 'Kategori wajib diisi!',
            'penerbit.required' => 'Penerbit wajib diisi!',
            'pengarang.required' => 'pengarang wajib diisi!',
            'harga.required' => 'Harga wajib diisi!',
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
        // dd($request->all());
        $data = [
            'nama_buku' => $request->nama_buku,
            'kategori' => $request->kategori,
            'penerbit' => $request->penerbit,
            'jenisbuku' => $request->jenisbuku,
            'deskripsi' => $request->deskripsi,
            'pengarang' => $request->pengarang,
            'harga' => $request->harga,
            'tahun_terbit' => $tahun_terbit,
            'stock' => $request->stock,
            'foto' => $foto_nama,
        ];
        buku::create($data);
        return redirect()->route('petugas.lihat')->with('success', 'Data Berhasil Ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = buku::findOrFail($id);
        return view('petugas.bukudetail', compact('data'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = kategori::all();
        $penerbit = penerbit::all();
        $pengarang = pengarang::all();
        $data = buku::where('id',$id)->first();
        return view('petugas.bukuedit',compact('kategori','penerbit','pengarang'))->with('data',$data);
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
            'jenisbuku'=>'required',
            'deskripsi'=>'required',
            'pengarang'=>'required',
            'harga'=>'required',
            'tahun_terbit' => 'required|date_format:Y',
            'stock'=>'numeric',
            'foto'=>'required|mimes:jpeg,jpg,png,gif',
        ],[
            'nama_buku.required'=>'nama_buku wajib diisi!',
            'kategori.required'=>'kategori wajib diisi!',
            'jenisbuku.required'=>'jenisbuku wajib diisi!',
            'kategori.required'=>'kategori wajib diisi!',
            'penerbit.required'=>'penerbit wajib diisi!',
            'pengarang.required'=>'pengarang wajib diisi!',
            'harga.required'=>'Harga wajib diisi!',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi!',
            'tahun_terbit.date_format' => 'Format tahun terbit tidak valid (Format yang diterima: YYYY)!',
            'stock.numeric'=>'Stock wajib diisi!',
            'foto.required' => 'Foto wajib diisi',
            'foto.mimes' => 'Foto hanya bisa berekstensi jpeg,jpg,png,gif',
        ]);

        $tahun_terbit = Carbon::createFromFormat('Y', $request->tahun_terbit)->startOfYear()->format('Y');        $data = [
            'nama_buku'=>$request->nama_buku,
            'kategori'=>$request->kategori,
            'jenisbuku'=>$request->jenisbuku,
            'deskripsi'=>$request->deskripsi,
            'penerbit'=>$request->penerbit,
            'pengarang'=>$request->pengarang,
            'harga'=>$request->harga,
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
        return redirect()->route('petugas.lihat')->with('success', 'Data Berhasil Terupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = buku::where('id',$id)->first();
        File::delete(public_path('foto').'/'.$data->foto);
        buku::where('id',$id)->delete();
        return redirect()->route('petugas.lihat')->with('success','Data Berhasil Dihapus!');
    }
}
