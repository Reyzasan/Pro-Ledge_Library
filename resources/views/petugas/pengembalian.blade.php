@extends('desain.sidebarPetugas')

@section('konten')
<div class="container mt-4">
    <div class="pb-3">
        <form class="d-flex" action="{{ url('pengembalian') }}" method="get">
            <input class="form-control me-1" type="search" name="katakunci" value="{{ Request::get('katakunci') }}"
                placeholder="Masukkan kata kunci" aria-label="Search">
            <button class="btn btn-secondary" type="submit">Cari</button>
        </form>
        </div>
        <table class="table table-hover">
            <thead>
            <a href="{{route('print-balik')}}?export=pdf" class="btn btn-primary mb-3">Print</a>
            <tr>
                <th class="col-md-1">No</th>
                <th class="col-md-1">ID</th>
                <th class="col-md-2">Username</th>
                <th class="col-md-2">Buku</th>
                <th class="col-md-1">Pengajuan</th>
                <th class="col-md-1">Peminjaman</th>
                <th class="col-md-1">Pengembalian</th>
                <th class="col-md-1">Kembali</th>
                <th class="col-md-2">Denda</th>
                <th class="col-md-2">Status</th>
            </tr>
        </thead>
        <tbody>
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
                <td>{{ $item->denda }}</td>
                <td>
                    @if($item->detailstatus == '-')
                        <span class="badge bg-primary">Peminjaman Selesai</span>
                    @elseif ($item->status == 'terlambat')
                        <span class="badge bg-danger">Terlambat</span>
                    @endif
                    @if ($item->detailstatus == 'rusak')
                        <span class="badge bg-danger">Rusak</span>
                    @elseif ($item->detailstatus == 'hilang')
                        <span class="badge bg-danger">Hilang</span>
                    @endif
                    {{-- {{dd($item->detailstatus)}} --}}
                </td>
                <td>
                    <form action="{{ route('detail.selesai', $item->id) }}" method="POST">
                    @csrf
                    @if ($item->detailstatus == 'rusak')
                        <a href="{{ route('detail.selesai', $item->id) }}" class="btn btn-success btn-sm">
                            <i class="fa fa-times"></i> Selesai
                        </a>
                    @elseif ($item->detailstatus == 'hilang')
                        <a href="{{ route('detail.selesai', $item->id) }}" class="btn btn-success btn-sm">
                            <i class="fa fa-times"></i> Selesai
                        </a>
                    @elseif ($item->status == '-')
                        <span class="badge bg-success">Selesai Terpinjam</span>
                    @endif
                </td>
                {{-- <td>
                    @if ($item->denda = 0)
                        retur
                    @endif
                </td> --}}
                {{-- <td>
                    <a href="{{url('pengembalian-buku/'.$item->id)}}" class="btn btn-primary">Kembalikan</a>
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
