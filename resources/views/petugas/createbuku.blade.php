@extends('desain.sidebarpetugas')

@section('konten')
@if ($errors->any())
<div class="pt-3">
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $item)
                <li>{{$item}}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
    <form action='{{ route('lihat.store') }}' method="POST" enctype="multipart/form-data">
        @csrf
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <a href="{{ route('petugas.lihat')}}" class="btn btn-secondary"><< Kembali</a>
            <h4 style="margin-top: 20px; margin-bottom: 30px; text-align:center">Tambah Data Buku</h4>
            <div class="mb-3 row">
                <label for="foto" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" name="foto" id="foto">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="nama_buku" class="col-sm-2 col-form-label">Judul</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama_buku" value="{{ Session::get('nama_buku') }}"
                        id="nama_buku">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jenisbuku" class="col-sm-2 col-form-label">Jenis Buku</label>
                <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%" name="jenisbuku" id="jenisbuku">
                        <option value>Pilih Jenis Buku</option>
                        @foreach ($jenisbuku as $item)
                        <option value="{{$item->id}}">{{$item->jenisbuku}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%" name="kategori" id="kategori">
                        <option value>Pilih Kategori</option>
                        @foreach ($kategori as $item)
                        <option value="{{$item->id}}">{{$item->kategori}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="pengarang" class="col-sm-2 col-form-label">Pengarang</label>
                <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%" name="pengarang" id="pengarang">
                        <option value>Pilih Pengarang</option>
                        @foreach ($pengarang as $item)
                        <option value="{{$item->id}}">{{$item->pengarang}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="penerbit" class="col-sm-2 col-form-label">penerbit</label>
                <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%" name="penerbit" id="penerbit">
                        <option value>Pilih penerbit</option>
                        @foreach ($penerbit as $item)
                        <option value="{{$item->id}}">{{$item->penerbit}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="tahun_terbit" class="col-sm-2 col-form-label">Tahun Terbit</label>
                <div class="col-sm-10">
                    <select name="tahun_terbit" id="tahun_terbit" class="form-control">
                        <option value="">Pilih Tahun Terbit</option>
                        @for ($tahun = date('Y'); $tahun >= 1900; $tahun--)
                            <option value="{{ $tahun }}" {{ old('tahun_terbit') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="stock" class="col-sm-2 col-form-label">Stock</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="stock" value="{{ Session::get('stock') }}"
                        id="stock">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="harga" value="{{ Session::get('harga') }}"
                        id="harga">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="deskripsi" class="col-sm-2 col-form-label">Blurb</label>
                <div class="col-sm-10">
                    {{-- <input type="text" class="form-control" name="deskripsi" value="{{ Session::get('deskripsi') }}"
                        id="deskripsi" style="width: 100%; height: 100px" placeholder="Deskripsi"> --}}
                    <textarea name="deskripsi" class="form-control" placeholder="Deskripsi" style="width: 100%; height: 100px"></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="kategori" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button></div>
            </div>
        </div>
    </form>
@endsection
