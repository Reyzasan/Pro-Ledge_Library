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

<div class="container" style="margin-left: 20px">
    @csrf
    <div class="d-flex justify-content-between align-items-center mt-4" style="margin-bottom: 40px">
        <div class="d-flex">
            <a href="{{ route('account.dashboard') }}" class="btn btn-secondary">Kembali</a>
            <div class="box" style="margin-left: 10px;">
                @if ($data->stock == 0)
                    <span class="badge bg-danger" style="padding: 10px; font-size: 16px">Persediaan habis</span>
                @else
                    <span class="badge bg-success" style="padding: 10px; font-size: 16px">Persediaan Ada</span>
                @endif
            </div>
        </div>
        <div>
            <?php $star = 1; ?>
            @while ($star <= $avgStarRating)
                <span>&#9733;</span>
                <?php $star++; ?>
            @endwhile
            ({{$avgRating}})
        </div>
    </div>

    <div class="row mt-3">
        @if ($data->foto)
            <div class="col-md-4 mt-4 mb-7" >
                <img style="max-height: 250px; max-width: 250px; border-radius: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.342); margin-left: 50px;" src="{{ url('foto') . '/' . $data->foto }}" alt="">
                <div class="col-sm-11" style="margin-top: 5px; text-align: center; font-weight: bold; font-size: 18px">
                    {{ $data->penerbits->penerbit }}
                </div>
                <div class="col-sm-11" style="margin-top: 2px; text-align: center;  font-size: 18px; color: green">
                    {{ $data->tahun_terbit }}
                </div>
            </div>
        @endif
        <div class="col-md-8">
            <div class="mb-3 row">
                <div class="col-sm-12" style="font-size: 16px; font-weight: 150; color: green">
                    {{ $data->pengarangs->pengarang}}
                </div>
                <div class="col-sm-12" style="font-size: 2rem; font-weight: 500">
                    {{ $data->nama_buku }}
                </div>
                <div class="col-sm-12" style="font-size: 2rem; font-weight: 500">
                    @if ($data->kategoris->kategori == 'Horor')
                        <div class="box mb-3" style="width: 80px; height: 22px; background-color: rgb(34, 28, 29); border-radius: 10px; margin-top: 2px">
                            <div class="book-box text-center" style="font-size: 16px; color: rgb(225, 210, 213); line-height: 17px; padding: 2px">
                                {{ $data->kategoris->kategori }}
                            </div>
                        </div>
                    @elseif ($data->kategoris->kategori == 'Romance')
                        <div class="box mb-3" style="width: 80px; height: 22px; background-color: pink; border-radius: 10px; margin-top: 2px">
                            <div class="book-box text-center" style="font-size: 16px; color: rgb(172, 40, 62); line-height: 17px; padding: 2px">
                                {{ $data->kategoris->kategori }}
                            </div>
                        </div>
                    @elseif ($data->kategoris->kategori == 'Drama')
                        <div class="box mb-3" style="width: 80px; height: 22px; background-color: rgb(19, 183, 224); border-radius: 10px; margin-top: 2px">
                            <div class="book-box text-center" style="font-size: 16px; color: rgb(255, 255, 255); line-height: 17px; padding: 2px">
                                {{ $data->kategoris->kategori }}
                            </div>
                        </div>
                    @elseif ($data->kategoris->kategori == 'Fantasi')
                        <div class="box mb-3" style="width: 80px; height: 22px; background-color: rgb(50, 19, 224); border-radius: 10px; margin-top: 2px">
                            <div class="book-box text-center" style="font-size: 16px; color: rgb(255, 255, 255); line-height: 17px; padding: 2px">
                                {{ $data->kategoris->kategori }}
                            </div>
                        </div>
                    @endif
                </div>
                {{-- {{dd($data)}} --}}
                <div class="deskripsi" style="width: 90%; height: 150px; background-color: rgba(253, 253, 253, 0); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0); overflow: auto;">
                    <div class="text-start" style="font-size: 1rem; color: rgb(0, 0, 0); overflow: hidden; margin: 0; padding: 0; text-align: start">
                        <div style="white-space: pre-wrap">{{ $data->deskripsi }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-4 d-flex align-items-center">
                @php
                    $koleksiPinjam = $pinjam->firstWhere('buku', $data->id);
                @endphp
                @if (is_null($koleksiPinjam) || in_array($koleksiPinjam->status, ['kembali', 'batal']))
                    <a href="{{ route('account.peminjaman', $data->id) }}" class="badge bg-success" style="padding: 9px; font-size: 16px; text-decoration: none; width: 130px; height: 35px">Pinjam</a>
                @elseif ($koleksiPinjam->status == 'disetujui')
                    <span class="badge bg-success" style="font-weight:900; color: white; padding: 9px; font-size: 16px; text-decoration: none; width: 130px; height: 35px">Disetujui</span>
                @elseif ($koleksiPinjam->status == 'batalkan')
                    <span class="badge bg-danger" style="font-weight:900; color: white; padding: 9px; font-size: 16px; text-decoration: none; width: 130px; height: 35px">Dibatalkan</span>
                @elseif ($koleksiPinjam->status == 'tolak')
                    <span class="badge bg-danger" style="font-weight:900; color: white; padding: 9px; font-size: 16px; text-decoration: none; width: 130px; height: 35px">Ditolak</span>
                @elseif (is_null($koleksiPinjam->status))
                    <span class="badge bg-warning" style="font-weight:900; color: white; padding: 9px; font-size: 16px; text-decoration: none; width: 130px; height: 35px">Belum Disetujui</span>
                @endif

                <div style="margin-left: 10px">
                    @php
                        $koleksiItem = $kolek->firstWhere('nama_buku', $data->id);
                    @endphp
                    @if (is_null($koleksiItem) || $koleksiItem->status == 'hapus')
                        <form action="{{ route('account.post', $data->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success" style="font-weight:900; color: white; padding: 5px; font-size: 16px; text-decoration: none; width: 130px; height: 35px">
                                Koleksi
                            </button>
                        </form>
                    @elseif ($koleksiItem->status == 'koleksi')
                        <form action="{{ route('account.post-batal', $data->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger" style="font-weight:900; color: white; padding: 5px; font-size: 16px; text-decoration: none; width: 130px; height: 35px">
                                Hapus Koleksi
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3" style="box-shadow: inset 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px; padding: 15px; width: 100%; margin-top: 40px">
        <h4>Users Review</h4>
        <div class="form-group" style="padding: 15px; width: 100%; margin-top: 40px; border-radius: 10px;">
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
