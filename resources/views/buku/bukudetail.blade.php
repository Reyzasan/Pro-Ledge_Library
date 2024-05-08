@extends('buku.desain')

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
    <form action='{{ url('buku/'.$data->id) }}' method='get' enctype="multipart/form-data">
        @csrf
        @method('get')
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <a href="{{url('buku')}}" class="btn btn-secondary"><< Kembali</a>
            <div class="mb-3 row">
                <label for="id" class="col-sm-2 col-form-label">ID</label>
                <div class="col-sm-10">
                    {{ $data->id }}
                </div>
            </div>
            @if ($data->foto)
                <div class="mb-3">
                    <img style="max-height: 50px;max-width: 50px" src="{{url('foto').'/'.$data->foto}}" alt="" srcset="">
                </div>
            @endif
            <div class="mb-3 row">
                <label for="foto" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" name='foto' id="foto" value="{{$data->foto}}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="nama_buku" class="col-sm-2 col-form-label">Judul</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='nama_buku' value="{{$data->nama_buku}}"
                        id="nama_buku">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="kategori" class="col-sm-2 col-form-label">kategori</label>
                <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%" name="kategori" id="kategori">
                        <option disabled value>Pilih Kategori</option>
                        @foreach ($kategori as $item)
                        <option value="{{$item->id}}">{{$item->kategori}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="tahun_terbit" class="col-sm-2 col-form-label">Tahun Terbit</label>
                <div class="col-sm-10" >
                    <select name="tahun_terbit" id="tahun_terbit" class="form-control">
                        <option value="">Tahun Terbit</option>
                        @for ($tahun = date('Y'); $tahun >= 1900; $tahun--)
                            <option value="{{$tahun}}" {{  $data->tahun_terbit == $tahun ? 'selected' : '' }}>{{ $tahun}}</option>
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
                <label for="jurusan" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button></div>
            </div>
    </form>
    </div>
    <!-- AKHIR FORM -->
@endsection
