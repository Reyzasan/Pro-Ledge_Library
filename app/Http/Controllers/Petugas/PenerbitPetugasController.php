<?php

namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use App\Models\penerbit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PenerbitPetugasController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        if(strlen($katakunci)){
            $data = penerbit::where('id','like',"%$katakunci%")->orwhere('penerbit','like',"%$katakunci%")->paginate();
        }else{
            $data = penerbit::orderBy('id','desc',)->paginate();
        }
        return view('petugas.penerbit.penerbit')->with('data', $data);
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
        return view('petugas.penerbit.createpenerbit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session()->flash('penerbit', $request->penerbit);
        Session()->flash('alamat', $request->alamat);
        $request->validate([
            'penerbit'=>'required',
            'alamat'=>'required',
        ],[
            'penerbit.required'=>'penerbit wajib diisi!',
            'alamat.required'=>'alamat wajib diisi!',
        ]);
        $data = [
            'penerbit' => $request->penerbit,
            'alamat' => $request->alamat,
        ];
        penerbit::create($data);
        return redirect()->to('penerbits')->with('success', 'Data Berhasil Ditambahkan!');
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
        $data = penerbit::where('id',$id)->first();
        return view('petugas.penerbit.penerbitedit')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'penerbit'=>'required',
            'alamat'=>'required',
        ],[
            'penerbit.required'=>'penerbit wajib diisi!',
            'alamat.required'=>'alamat wajib diisi!',
        ]);
        $data = [
            'penerbit'=>$request->penerbit,
            'alamat'=>$request->alamat,
        ];
        penerbit::where('id',$id)->update($data);
        return redirect()->to('penerbits')->with('success', 'Data Berhasil Terupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        penerbit::where('id',$id)->delete();
        return redirect()->to('penerbits')->with('success','Data Berhasil Dihapus!');
    }
}

