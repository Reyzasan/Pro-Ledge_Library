@extends('desain.sidebarPetugas')

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
    <form action="{{ route('pinjam-buku') }}" method="GET">
        @csrf
        <div class="mb-3 row">
            <label for="katakunci" class="col-sm-2 col-form-label">Search</label>
            {{-- <div class="col-sm-10">
                <input type="text" name="katakunci" class="form-control" placeholder="Search..." value="{{ $katakunci }}">
            </div> --}}
        </div>
        <div class="mb-3 row">
            <label for="bulan" class="col-sm-2 col-form-label">Filter by Month</label>
            <div class="col-sm-10">
                <select name="bulan" class="form-select" id="bulan">
                    <option value="">-- Select Month --</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>
    </form>
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
            @foreach ($data as $item)
            {{-- {{dd($item)}} --}}
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
                    @elseif ($item->status == '-')
                        <span class="badge bg-danger">Kembali</span>
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                            <i class="fa fa-info-circle"></i> Kembali
                        </button>
                    @endif
                </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('pengembalian-buku-baru', $item->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Pengembalian</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Username:</strong> {{ $item->userss->name }}</p>
                            <p><strong>Buku:</strong> {{ $item->bukus->nama_buku }}</p>
                            <p><strong>Pengajuan:</strong> {{ $item->pengajuan }}</p>
                            <p><strong>Peminjaman:</strong> {{ $item->tangal_peminjaman }}</p>
                            <p><strong>Pengembalian:</strong> {{ $item->tanggal_pengembalian }}</p>
                            <p><strong>Status:</strong>
                                @if ($item->status == 'disetujui')
                                    Disetujui
                                @elseif ($item->status == 'tolak')
                                    Ditolak
                                @endif
                            </p>
                            <div class="mb-3 row">
                                <label for="detailstatus" class="col-sm-4 col-form-label">Detail Status</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="detailstatus" id="detailstatus" required>
                                        <option value="rusak">Rusak</option>
                                        <option value="hilang">Hilang</option>
                                        <option value="-">Kondisi Baik</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="catatan" class="col-sm-4 col-form-label">Catatan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="catatan" id="catatan" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Kembali</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

