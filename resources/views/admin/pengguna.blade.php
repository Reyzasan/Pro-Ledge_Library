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
        <div class="pb-3">
            <a href="{{route('pinjam-print')}}?export=pdf" class="btn btn-primary mb-3">Print</a>
            <a href='{{ url('pengarang/create') }}' class="btn btn-primary mb-3">Tambah Data</a>
        </div>
    </div>

    <table class="table table-hover table-striped table-bordered">
        <thead class="table-success">
            <tr>
                <th class="col-md-1">No</th>
                <th class="col-md-2">Email</th>
                <th class="col-md-2">Username</th>
                <th class="col-md-2">Role</th>
                <th class="col-md-2">Status</th>
                <th class="col-md-2">Aksi</th>
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
                {{-- <td>{{ $item->status }}</td> --}}
                <td>
                    @if ($item->status == 'ajukan pemblokiran')
                        <span class="badge bg-warning">Pengajuan Pemblokiran</span>
                    @elseif ($item->status == 'tolak')
                        <span class="badge bg-success">Pemblokiran Ditolak</span>
                    @elseif ($item->status == 'blokir')
                        <span class="badge bg-success">Pemblokiran Diterima</span>
                    @endif
                </td>
                <td>
                    @if ($item->status == 'ajukan pemblokiran')
                        <a href="{{ route('penggunaStatus', $item->id) }}" class="btn btn-danger btn-sm">
                            <i class="fa fa-check"></i> Blokir
                        </a>
                        <a href="{{ route('penggunaStatusTolak', $item->id) }}" class="btn btn-success btn-sm">
                            <i class="fa fa-check"></i> Tolak
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
