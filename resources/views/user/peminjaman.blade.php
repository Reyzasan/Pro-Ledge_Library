{{-- @extends('desain.sidebar')

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
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="col-md-1">No</th>
                    <th class="col-md-2">User</th>
                    <th class="col-md-2">Buku</th>
                    <th class="col-md-2">Tanggal Peminjaman</th>
                    <th class="col-md-2">Tanggal Pengembalian</th>
                    <th class="col-md-1">Denda</th>
                    <th class="col-md-1">Status</th>
                    <th class="col-md-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->userss->name }}</td>
                        <td>{{ $item->bukus->nama_buku }}</td>
                        <td>{{ $item->tangal_peminjaman }}</td>
                        <td>{{ $item->tanggal_pengembalian }}</td>
                        <td>{{$item->denda}}</td>
                        <td>
                            @if ($item->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif ($item->status == 'batalkan')
                                <span class="badge bg-danger">Dibatalkan</span>
                            @elseif (is_null($item->status))
                                <span class="badge bg-warning">Belum Disetujui</span>
                            @elseif ($item->status == 'tolak')
                                    <span class="badge bg-danger">Ditolak</span>
                            @elseif ($item->status == 'kembali')
                                    <span class="badge bg-primary">Selesai</span>
                            @elseif ($item->status == 'batal')
                                    <span class="badge bg-danger">Dibatalkan</span>
                            @endif
                        </td>
                        <td>
                            @if (Auth::check() && is_null($item->status))
                                <a href="{{ route('pinjam-batal',  $item->id) }}" class="btn btn-danger">Batalkan</a>
                            @endif
                        </td>
                        {{-- <td>
                            @if ($item->status == 'kembali' && $item->rstatus == false)
                            <div class="col-sm-10">
                                <a href="#">Review</a>
                            </div>
                            @endif
                        </td> --}}
                    {{-- </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}
{{-- @endsection --}}

@extends('desain.sidebar')

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

    <div class="text" style="margin-top: 20px; margin-left: 10px; margin-bottom: 20px">
        <h4>Peminjaman {{Auth::user()->name}}</h4>
    </div>
    <table class="table table-hover table-striped table-bordered">
        <thead class="table-success">
            <tr>
                <th class="col-md-1">No</th>
                <th class="col-md-1">ID</th>
                {{-- <th class="col-md-2">Username</th> --}}
                <th class="col-md-2">Buku</th>
                <th class="col-md-2">Peminjaman</th>
                <th class="col-md-2">Pengembalian</th>
                <th class="col-md-2">Kembali</th>
                <th class="col-md-2">Status</th>
                <th class="col-md-2">Denda</th>
                <th class="col-md-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- {{dd($data)}} --}}
            @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->id }}</td>
                {{-- <td>{{ $item->userss->name }}</td> --}}
                <td>{{ $item->bukus->nama_buku }}</td>
                <td>{{ $item->tangal_peminjaman }}</td>
                <td>{{ $item->tanggal_pengembalian }}</td>
                <td>{{ $item->kembali }}</td>
                <td>
                    @if ($item->status == 'disetujui')
                        <span class="badge bg-success">Disetujui</span>
                    @elseif ($item->status == 'batal')
                        <span class="badge bg-danger">Dibatalkan</span>
                    @elseif (is_null($item->status))
                        <span class="badge bg-warning">Belum Disetujui</span>
                    @elseif ($item->status == 'tolak')
                        <span class="badge bg-danger">Ditolak</span>
                    @elseif ($item->status == 'kembali')
                        <span class="badge bg-success">Selesai</span>
                    @elseif ($item->status == 'terlambat')
                        <span class="badge bg-danger">Terlambat</span>
                    @endif
                </td>
                <td>{{ $item->denda }}</td>
                <td>
                    @if (Auth::check() && is_null($item->status))
                        <a href="{{ route('pinjam-batal',  $item->id) }}" class="btn btn-danger">Batalkan</a>
                    @endif
                </td>
                {{-- <td>
                    @if ($item->status == 'kembali' && $item->rstatus == false)
                    <div class="col-sm-10">
                        <a href="#">Review</a>
                    </div>
                    @endif
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

