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
<div class="my-3 p-3 bg-body rounded shadow-sm">
    @csrf
    <a href="{{ route('account.dashboard') }}" class="btn btn-secondary">
        << Kembali
    </a>
    <div class="row mt-3">
        @if ($data->foto)
            <div class="col-md-4 mt-4 mb-3">
                <img style="max-height: 200px; max-width: 200px" src="{{ url('foto') . '/' . $data->foto }}" alt="">
            </div>
        @endif
        <div class="col-md-8">
            <div class="mb-3 row">
                <div class="col-sm-12" style="font-size: 2rem; font-weight: 500">
                    {{ $data->nama_buku }}
                </div>
                <div class="col-sm-12 mt-2">
                    <?php
                    $star = 1;
                    while ($star <= $avgStarRating) {?>
                        <span>&#9733;</span>
                       <?php $star++;
                    }
                    ?> ({{$avgRating}})
                </div>
            </div>
            <div class="mb-3 row">
                <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                <div class="col-sm-10">
                    {{ $data->kategoris->kategori }}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                <div class="col-sm-10">
                    {{ $data->penerbits->penerbit }}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="tahun_terbit" class="col-sm-2 col-form-label">Tahun Terbit</label>
                <div class="col-sm-10">
                    {{ $data->tahun_terbit }}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="stock" class="col-sm-2 col-form-label">Stock</label>
                <div class="col-sm-10">
                    {{ $data->stock }}
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-4 d-flex justify-content-between">
            @php
                $koleksiPinjam = $pinjam->where('nama_buku', $item)->where('status', '!=', 'kembali')->first();
            @endphp

            @if (is_null($koleksiPinjam))
                <a href="{{ route('account.peminjaman', $data->id) }}" class="btn btn-success">Pinjam</a>
            @elseif ($koleksiPinjam->status == 'kembali')
                <a href="{{ route('account.peminjaman', $data->id) }}" class="btn btn-success">Pinjam</a>
            @elseif ($koleksiPinjam->status == 'disetujui')
                <span class="badge bg-success">Disetujui</span>
            @elseif ($koleksiPinjam->status == 'batal')
                <a href="{{ route('account.peminjaman', $data->id) }}" class="btn btn-success">Pinjam</a>
            @elseif ($koleksiPinjam->status == 'batalkan')
                <span class="badge bg-danger">Dibatalkan</span>
            @elseif ($koleksiPinjam->status == 'tolak')
                <span class="badge bg-danger">Ditolak</span>
            @elseif (is_null($data->status))
                <span class="badge bg-warning">Belum Disetujui</span>
            @endif
            {{-- @endforeach --}}
            {{-- {{dd($pinjam)}} --}}
            {{-- <a href="{{ route('account.peminjaman', $data->id) }}" class="btn btn-success">Pinjam</a>
                @if ($data->status == 'disetujui')
                    <span class="badge bg-success">Disetujui</span>
                @elseif ($data->status == 'batal')
                    <span class="badge bg-danger">Dibatalkan</span>
                @elseif (is_null($data->status))
                    <span class="badge bg-warning">Belum Disetujui</span>
                @elseif ($data->status == 'tolak')
                    <span class="badge bg-danger">Ditolak</span>
                @endif --}}
        </div>
        <div>
            {{-- {{dd($kolek)}} --}}
            @php
                $koleksiItem = $kolek->firstWhere('nama_buku', $data->id);
            @endphp
            {{-- {{dd($data)}} --}}
            @if (is_null($koleksiItem) || $koleksiItem->status == 'hapus')
                <form action="{{ route('account.post', $data->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        Koleksi
                    </button>
                </form>
            @elseif ($koleksiItem->status == 'koleksi')
                <form action="{{ route('account.post-batal', $data->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                        Hapus Koleksi
                    </button>
                </form>
            @endif
            {{-- <form action="{{ route('account.post', $data->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-success">
                    Koleksi
                </button>
            </form>
            @foreach ($kolek as $item)
                @if (is_null($kolek->status) || $kolek->status == 'hapus')
                    <form action="{{ route('account.post', $kolek->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            Koleksi
                        </button>
                    </form>
                @elseif ($kolek->status == 'koleksi')
                    <form action="{{ route('account.post-batal', $kolek->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                             Hapus Koleksi
                        </button>
                    </form>
                @endif
            @endforeach --}}

            {{-- {{dd($kolek)}} --}}

        </div>
    </div>
    <div class="mt-4">
        <ul class="nav nav-tabs" id="productDetail" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="true">Review</button>
            </li>
        </ul>
        <div class="tab-content" id="productDetailContent">
            <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h4>Write a Review</h4>
                                <form method="POST" action="{{ route('account.rating') }}" name="ratingForm" id="ratingForm">
                                    @csrf
                                    <input type="hidden" name="buku_id" value="{{ $data->id }}">
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
                                    <div class="form-group mt-2">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h4>Users Review</h4>
                                <div class="form-group">
                                    @if (count($ratings) > 0)
                                        @foreach ($ratings as $rating)
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <p style="color: green; font-weight: 500; font-size: 1.2rem">{{ $rating['users_r']['name'] }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    @for ($i = 0; $i < $rating['rating']; $i++)
                                                        <span>&#9733;</span>
                                                    @endfor
                                                </div>
                                                <div class="col-md-12 mt-2" style="border-bottom: 1px solid #ddd;">
                                                    <p style="font-size: 1rem; font-weight: 400">{{ $rating['review'] }}</p>
                                                    <p>{{ date("d-m-Y", strtotime($rating['created_at'])) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p><b>Belum Ada review</b></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
