<?php

namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use App\Models\pengarang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PengarangPetugasController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        if(strlen($katakunci)){
            $data = pengarang::where('id','like',"%$katakunci%")->orwhere('pengarang','like',"%$katakunci%")->paginate();
        }else{
            $data = pengarang::orderBy('id','desc',)->paginate();
        }
        return view('petugas.pengarang.pengarang')->with('data', $data);
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
        return view('petugas.pengarang.createpengarang');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session()->flash('id', $request->id);
        Session()->flash('pengarang', $request->pengarang);
        $request->validate([
            'pengarang'=>'required',
            'jk'=>'required',
        ],[
            'pengarang.required'=>'pengarang wajib diisi!',
            'jk.required'=>'jk wajib diisi!',
        ]);
        $data = [
            'pengarang' => $request->pengarang,
            'jk' => $request->jk,
        ];
        pengarang::create($data);
        return redirect()->to('pengarangs')->with('success', 'Data Berhasil Ditambahkan!');
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
        $data = pengarang::where('id',$id)->first();
        return view('petugas.pengarang.pengarangedit')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'pengarang'=>'required',
            'jk'=>'required',
        ],[
            'pengarang.required'=>'pengarang wajib diisi!',
            'jk.required'=>'enis Kelamin wajib diisi!',
        ]);
        $data = [
            'pengarang'=>$request->pengarang,
            'jk'=>$request->jk,
        ];
        pengarang::where('id',$id)->update($data);
        return redirect()->to('pengarangs')->with('success', 'Data Berhasil Terupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        pengarang::where('id',$id)->delete();
        return redirect()->to('pengarangs')->with('success','Data Berhasil Dihapus!');
    }
}

