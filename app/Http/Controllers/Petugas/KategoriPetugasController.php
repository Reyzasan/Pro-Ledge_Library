<?php

namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use App\Models\kategori;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KategoriPetugasController extends Controller
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
        return view('petugas.kategori.kategori')->with('data', $data);
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
        return view('petugas.kategori.createkategori');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session()->flash('kategori', $request->kategori);
        Session()->flash('deskripsi', $request->deskripsi);
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
        kategori::create($data);
        return redirect()->to('kategoris')->with('success', 'Data Berhasil Ditambahkan!');
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
        return view('petugas.kategori.kategoriedit')->with('data',$data);
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
        return redirect()->to('kategoris')->with('success', 'Data Berhasil Terupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        kategori::where('id',$id)->delete();
        return redirect()->to('kategoris')->with('success','Data Berhasil Dihapus!');
    }
}
