@extends('desain.sidebaradmin')

@section('konten')
    @if ($errors->any())
        <div class="pt-3">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <form action='{{ route('book.update', $data->id) }}' method='post' enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <a href="{{ route('admin.tampilan')}}" class="btn btn-secondary"><< Kembali</a>
            <h4 style="margin-top: 20px; margin-bottom: 30px; text-align:center">Edit Data Buku</h4>
            <div class="mb-3 row">
                <label for="id" class="col-sm-2 col-form-label">ID</label>
                <div class="col-sm-10">
                    {{ $data->id }}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="foto" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    @if ($data->foto)
                        <input type="file" class="form-control" name='foto' id="foto">
                    @endif
                </div>
            </div>
            <div class="mb-3 row">
                <label for="nama_buku" class="col-sm-2 col-form-label">Judul</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='nama_buku' value="{{ $data->nama_buku }}"
                        id="nama_buku">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="kategori" class="col-sm-2 col-form-label">kategori</label>
                <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%" name="kategori" id="kategori">
                        <option disabled value>Pilih Kategori</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jenisbuku" class="col-sm-2 col-form-label">Jenis Buku</label>
                <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%" name="jenisbuku" id="jenisbuku">
                        <option disabled value>Pilih Jenis Buku</option>
                        @foreach ($jenisbuku as $item)
                        <option value="{{ $item->id }}">{{ $item->jenisbuku }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="pengarang" class="col-sm-2 col-form-label">Pengarang</label>
                <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%" name="pengarang" id="pengarang">
                        <option disabled value>Pilih pengarang</option>
                        @foreach ($pengarang as $item)
                            <option value="{{ $item->id }}">{{ $item->pengarang }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="penerbit" class="col-sm-2 col-form-label">penerbit</label>
                <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%" name="penerbit" id="penerbit">
                        <option disabled value>Pilih penerbit</option>
                        @foreach ($penerbit as $item)
                            <option value="{{ $item->id }}">{{ $item->penerbit }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="tahun_terbit" class="col-sm-2 col-form-label">Tahun Terbit</label>
                <div class="col-sm-10">
                    <select name="tahun_terbit" id="tahun_terbit" class="form-control">
                        <option value="">Tahun Terbit</option>
                        @for ($tahun = date('Y'); $tahun >= 1900; $tahun--)
                            <option value="{{ $tahun }}"
                                {{ $data->tahun_terbit == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="stock" class="col-sm-2 col-form-label">Stock</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='stock' value="{{ $data->stock }}"
                        id="stock">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='harga' value="{{ $data->harga }}"
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
                <label for="jurusan" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button>
                </div>
            </div>
    </form>
    </div>
    <!-- AKHIR FORM -->
@endsection
