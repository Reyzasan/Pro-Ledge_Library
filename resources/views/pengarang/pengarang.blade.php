@extends('desain.sidebaradmin')

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
    <form action='{{ url('pengarang') }}' method='post'>
        @csrf
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <a href="{{url('pengarang')}}" class="btn btn-secondary"><< Kembali</a>
            <div class="mb-3 row">
                <label for="pengarang" class="col-sm-2 col-form-label">pengarang</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='pengarang' value="{{ Session::get('pengarang') }}"
                        id="pengarang">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-10">
                    <select class="form-select" name="jk" id="jk">
                        <option value="Laki-laki" {{ Session::get('jk') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ Session::get('jk') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        <option value="Tidak Diketahui" {{ Session::get('jk') == 'null' ? 'selected' : '' }}>-</option>
                    </select>
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
