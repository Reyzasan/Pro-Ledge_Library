<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\jenisbuku;
use Barryvdh\DomPDF\Facade\Pdf;

class JenisBukuController extends Controller
{
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        if(strlen($katakunci)){
            $data = jenisbuku::where('id','like',"%$katakunci%")->orwhere('jenisbuku','like',"%$katakunci%")->paginate();
        }else{
            $data = jenisbuku::orderBy('id','desc',)->paginate();
        }
        return view('Admin.jenisbuku.user')->with('data', $data);
    }

    public function print(Request $request)
    {
        $data = jenisbuku::whereIn('status', ['disetujui', 'batalkan','tolak'])->orWhereNull('status')->get();
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
        return view('Admin.jenisbuku.jenisbuku');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session()->flash('jenisbuku', $request->jenisbuku);
        Session()->flash('deskripsi', $request->deskripsi);
        $request->validate([
            'jenisbuku'=>'required',
            'deskripsi'=>'required',
        ],[
            'jenisbuku.required'=>'jenisbuku wajib diisi!',
            'deskripsi.required'=>'deskripsi wajib diisi!',
        ]);
        $data = [
            'jenisbuku'=>$request->jenisbuku,
            'deskripsi'=>$request->deskripsi,
        ];
        jenisbuku::create($data);
        return redirect()->to('jenisbuku')->with('success', 'Data Berhasil Ditambahkan!');
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
        $data = jenisbuku::where('id',$id)->first();
        return view('Admin.jenisbuku.jenisbukuedit')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jenisbuku'=>'required',
            'deskripsi'=>'required',
        ],[
            'jenisbuku.required'=>'jenisbuku wajib diisi!',
            'deskripsi.required'=>'deskripsi wajib diisi!',
        ]);
        $data = [
            'jenisbuku'=>$request->jenisbuku,
            'deskripsi'=>$request->deskripsi,
        ];
        jenisbuku::where('id',$id)->update($data);
        return redirect()->to('jenisbuku')->with('success', 'Data Berhasil Terupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        jenisbuku::where('id',$id)->delete();
        return redirect()->to('jenisbuku')->with('success','Data Berhasil Dihapus!');
    }
}
