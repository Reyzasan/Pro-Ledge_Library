@extends('desain.sidebarAdmin')

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
        <a href="{{route('pinjam-print')}}?export=pdf" class="btn btn-primary mb-3">Print</a>
    </div>

    <table class="table table-hover table-striped table-bordered">
        <thead class="table-success">
            <tr>
                <th class="col-md-1">No</th>
                <th class="col-md-1">ID</th>
                <th class="col-md-2">Username</th>
                <th class="col-md-2">Buku</th>
                <th class="col-md-1">Pengajuan</th>
                <th class="col-md-1">Peminjaman</th>
                <th class="col-md-1">Pengembalian</th>
                <th class="col-md-1">Kembali</th>
                <th class="col-md-2">Status</th>
                <th class="col-md-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- { ($data)}} --}}
            @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->userss->name }}</td>
                <td>{{ $item->bukus->nama_buku }}</td>
                <td>{{ $item->pengajuan }}</td>
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
                    @endif
                </td>
                <td>
                    @if ($item->status == 'disetujui')
                        <a href="{{ route('pinjam-buku.batal', $item->id) }}" class="btn btn-danger btn-sm">
                            <i class="fa fa-times"></i> Batal
                        </a>
                    @elseif (is_null($item->status))
                        <a href="{{ route('pinjam-buku.disetujui', $item->id) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-check"></i> Setujui
                        </a>
                    @endif
                    @if (Auth::check() && is_null($item->status))
                        <a href="{{ route('pinjam-buku-tolak',  $item->id) }}" class="btn btn-danger btn-sm">
                            <i class="fa fa-times"></i> Tolak
                        </a>
                    @endif
                    @if (Auth::check() && $item->status == 'disetujui')
                        <a href="{{ url('account/pengembalian-buku', $item->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-undo"></i> Kembali
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
