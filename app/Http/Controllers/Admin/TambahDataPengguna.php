<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class TambahDataPengguna extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.tambahdata');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tambahdata');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'email' => 'required',
        'name'=> 'required',
        'password' => 'required',
        'role' => 'required',
    ], [
        'email.required' => 'Email wajib diisi!',
        'name.required' => 'Username wajib diisi!',
        'password.required' => 'Password wajib diisi!',
        'role.required' => 'Jabatan wajib diisi!',
    ]);

    $data = [
        'email' => $request->email,
        'name' => $request->name,
        'password' => $request->password,
        'role' => $request->role,
    ];
    User::create($data);
    return redirect()->back()->with('success', 'Data Berhasil Ditambahkan!');
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
        $data = User::where('id',$id)->first();
        return view('admin.useredit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'role.required' => 'Jabatan Wajib Diisi',
        ],[
            'role.required' => 'Jabatan wajib diisi!',
        ]);
        $data = [
            'role'=>$request->role,
        ];
        User::where('id',$id)->update($data);
        return redirect()->back()->with('success', 'Data Berhasil Terupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $data = buku::where('id',$id)->first();
    //     File::delete(public_path('foto').'/'.$data->foto);
    //     buku::where('id',$id)->delete();
    //     return redirect()->route('admin.tampilan')->with('success','Data Berhasil Dihapus!');
    // }
}
