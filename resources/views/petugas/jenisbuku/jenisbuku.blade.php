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
    <form action='{{ url('jenisbuku') }}' method='post'>
        @csrf
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <a href="{{url('jenisbuku')}}" class="btn btn-secondary"><< Kembali</a>
            <h4 style="margin-top: 20px; margin-bottom: 30px; text-align:center">Tambah Data Jenis Buku</h4>
            <div class="mb-3 row">
                <label for="jenisbuku" class="col-sm-2 col-form-label">Jenis Buku</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='jenisbuku' value="{{ Session::get('jenisbuku') }}"
                        id="jenisbuku">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='deskripsi' value="{{ Session::get('deskripsi') }}"
                        id="deskripsi">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="deskripsi" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button></div>
            </div>
    </form>
    </div>
    <!-- AKHIR FORM -->
@endsection
