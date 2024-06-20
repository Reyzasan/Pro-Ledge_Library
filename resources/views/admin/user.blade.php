@extends('desain.sidebaradmin')

@section('konten')
@if (Session::has('success'))
    <div class="pt-3">
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    </div>
@endif
@if (Session::has('error'))
    <div class="pt-3">
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    </div>
@endif

<div class="container mt-4">
    <div class="pb-3">
        <form class="d-flex" action="{{ url('buku') }}" method="get">
            <input class="form-control me-1" type="search" name="katakunci" value="{{ Request::get('katakunci') }}" placeholder="Masukkan kata kunci" aria-label="Search">
            <button class="btn btn-secondary" type="submit">Cari</button>
        </form>
    </div>
    <div>
        <h4 style="margin-top: 20px; margin-bottom: 20px; text-align:center">Data Pengguna</h4>
        {{-- <div class="pb-1">
            <a href="{{route('pinjam-print')}}?export=pdf" class="btn btn-primary mb-3">Print</a>
            <a href='{{ url('tambahpengguna/create') }}' class="btn btn-primary mb-3">Tambah Data</a>
        </div> --}}
        <div class="pb-3">
            <a href='{{ route('pengguna.status') }}' class="btn btn-success mb-3">All</a>
            <a href='{{ route('user.status') }}' class="btn btn-success mb-3">Pengguna</a>
            <a href='{{ route('petugas.status') }}' class="btn btn-success mb-3">Petugas</a>
            <a href='{{ route('admin.status') }}' class="btn btn-success mb-3">Admin</a>
        </div>
    </div>

    <table class="table table-hover table-striped table-bordered">
        <thead class="table-success">
            <tr>
                <th class="col-md-1">No</th>
                <th class="col-md-2">Email</th>
                <th class="col-md-2">Username</th>
                <th class="col-md-2">Role</th>
            </tr>
        </thead>
        <tbody>
           {{-- {{dd($data)}} --}}
            @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->role }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
