<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pengguna;

class akunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('akun.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session()->flash('id', $request->id);
        Session()->flash('username', $request->username);
        Session()->flash('password', $request->password);
        $request->validate([
            'id'=>'required|numeric|unique:pengguna,id',
            'username'=>'required',
            'password'=>'required',
        ],[
            'id.required'=>'ID wajib diisi!',
            'id.numeric'=>'ID hanya berupa angka!',
            'id.unique'=>'ID tidak ditemukan!',
            'username.required'=>'Username wajib diisi!',
            'password.required'=>'Password wajib diisi!',
        ]);
        $data = [
            'id'=>$request->id,
            'username'=>$request->username,
            'password'=>$request->password,
        ];
        pengguna::create($data);
        return redirect()->to('pengguna')->with('success', 'Data Berhasil Ditambahkan!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
