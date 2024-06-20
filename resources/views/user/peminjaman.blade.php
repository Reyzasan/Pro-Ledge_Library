@extends('desain.sidebar')

@section('konten')
@if (Session::has('success'))
    <div class="pt-3">
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    </div>
@endif
@if (Session::has('gagal'))
    <div class="pt-3">
        <div class="alert alert-danger">
            {{ Session::get('gagal') }}
        </div>
    </div>
@endif

<div class="container mt-4">
    <div class="text" style="margin-top: 20px; margin-left: 10px; margin-bottom: 20px">
        <h4>Peminjaman {{Auth::user()->name}}</h4>
    </div>
    <table class="table table-hover table-striped table-bordered">
        <thead class="table-success">
            <tr>
                <th class="col-md-1">No</th>
                <th class="col-md-1">ID</th>
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
                    @elseif ($item->detailstatus == '-')
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}" style="width: 100px; margin-top: 20px">
                                Review
                            </button>
                        </div>
                        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    {{-- {{dd($item      --}}
                                    <form action="{{ route('account.rating', $item->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Review</h5>
                                            <button type="button" class="btn-close" item-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        {{-- {{dd($item)}} --}}
                                        <div class="modal-body">
                                            {{-- <p><strong>Username:</strong> {{ $item->userss->name }}</p> --}}
                                            <form method="POST" action="{{ route('account.rating') }}" name="ratingForm" id="ratingForm">
                                                <p><strong>Buku:</strong> {{ $item->nama_buku }}</p>
                                                {{-- <p><strong>Pengarang:</strong> {{ $item->pengarangs->pengarang }}</p> --}}
                                                @csrf
                                                <input type="hidden" name="peminjaman_id" value="{{ $item->id }}">
                                                <input type="hidden" name="buku_id" value="{{ $item->buku_id}}">
                                                <div class="form-group">
                                                    <label style="color: rgb(145, 145, 36)">Rating:</label>
                                                    <span class="star-rating">
                                                        <label for="rate-1" style="--i:1"><i class="fa-solid fa-star"></i></label>
                                                        <input type="radio" name="rating" id="rate-1" value="1">
                                                        <label for="rate-2" style="--i:2"><i class="fa-solid fa-star"></i></label>
                                                        <input type="radio" name="rating" id="rate-2" value="2">
                                                        <label for="rate-3" style="--i:3"><i class="fa-solid fa-star"></i></label>
                                                        <input type="radio" name="rating" id="rate-3" value="3">
                                                        <label for="rate-4" style="--i:4"><i class="fa-solid fa-star"></i></label>
                                                        <input type="radio" name="rating" id="rate-4" value="4">
                                                        <label for="rate-5" style="--i:5"><i class="fa-solid fa-star"></i></label>
                                                        <input type="radio" name="rating" id="rate-5" value="5">
                                                    </span>
                                                </div>
                                                <div class="form-group">
                                                    <label style="margin-top: 30px">Your Review</label>
                                                    <textarea name="review" class="form-control" placeholder="Write Your Review" style="width: 100%; height: 100px"></textarea>
                                                </div>
                                                {{-- <div class="form-group mt-2">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div> --}}
                                            </form>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Kirim</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>



<style>
    .star-rating {
        white-space: nowrap;
    }
    .star-rating [type="radio"] {
        appearance: none;
    }
    .star-rating i {
        font-size: 1.2em;
        transition: 0.3s;
    }

    .star-rating label:is(:hover, :has(~ :hover)) i {
        transform: scale(1.35);
        color: #fffdba;
        animation: jump 0.5s calc(0.3s + (var(--i) - 1) * 0.15s) alternate infinite;
    }
    .star-rating label:has(~ :checked) i {
        color: #faec1b;
        text-shadow: 0 0 2px #ffffff, 0 0 10px #ffee58;
    }

    @keyframes jump {
        0%, 50% {
            transform: translateY(0) scale(1.35);
        }
        100% {
            transform: translateY(-15%) scale(1.35);
        }
    }
</style>
@endsection

