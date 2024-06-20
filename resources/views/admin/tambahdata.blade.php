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
@if (Session::has('success'))
    <div class="pt-3">
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    </div>
@endif
    <form action='{{ route('tambahpengguna.store') }}' method="POST" enctype="multipart/form-data">
        @csrf
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <a href="{{ route('admin.tampilan')}}" class="btn btn-secondary"><< Kembali</a>
            <h4 style="margin-top: 20px; margin-bottom: 30px; text-align:center">Tambah Data User</h4>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="email" value="{{ Session::get('email') }}"
                        id="email">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-sm-2 col-form-label">Usename</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" value="{{ Session::get('name') }}"
                        id="name">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="password" value="{{ Session::get('password') }}"
                        id="password">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="role" class="col-sm-2 col-form-label">Jabatan</label>
                <div class="col-sm-10">
                    <select class="form-select" name="role" id="role">
                        <option value="admin" {{ Session::get('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ Session::get('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="kategori" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">Tambah Data</button></div>
            </div>
        </div>
    </form>
    <!-- AKHIR FORM -->
@endsection
