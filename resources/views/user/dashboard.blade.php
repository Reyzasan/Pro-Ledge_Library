@extends('desain.sidebar')

@section('konten')
    @if (Session::has('success'))
        <div class="pt-3">
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif
    <div class="search" style="margin-bottom: 20px">
        <form action="{{ url('buku') }}" method="get">
            <input type="text" placeholder="Search here....." name="katakunci" value="{{ Request::get('katakunci') }}">
            <a href="{{ route('profile') }}">
                <i class='bx bx-search-alt'></i>
            <span class="tooltip">Profile</span>
            </a>
            <div class="Profile">
            </div>
        </form>
    </div>
    <div class="user">
        <i class='bx bx-user'></i>
    </div>
    {{-- <div class="my-3 p-3 bg-body rounded shadow-sm" style="margin-left: 20px; padding: 20px">
        <div class="row" style="display: flex; gap: 10px;">
            {{-- @foreach (['Agama', 'Komik', 'Komik', 'Komik', 'Komik', 'Komik'] as $genre)
                <div class="col-md-2 mb-2">
                    <a href="#" style="text-decoration: none;">
                        <div class="box mb-3" style="width: 150px; height: 60px; background: linear-gradient(45deg, rgba(27, 47, 165, 0.637), rgba(165, 40, 40, 0.637)); border-radius: 10px; position: relative;">
                            <img src="{{ asset('asset/stars.png') }}" alt="" style="position: absolute; top: -60px; left: 50%; transform: translateX(-50%); width: 180px; height: 180px;">
                            <div class="book-box text-center" style="padding: 18px; font-size: 1.5rem; color: rgb(8, 8, 8); line-height: 17px;">
                                {{ $genre }}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach --}}
        {{-- </div>
    </div> --}}
{{--
    <div class="row genre-section" style="margin: 20px; margin-bottom: 60px; overflow-x: hidden; display: flex; white-space: nowrap;">
        <h4 style="margin: 10px;">Temukan Genre</h4>
        @foreach (['Petualangan', 'Fantasi', 'Drama', 'Horor', 'Thriller', 'Romansa', 'Science Fiction'] as $genre)
            <div class="col-md-1" style="margin: 35px;">
                <a href="#" style="text-decoration: none;">
                    <div class="box mb-3" style="width: 135px; height: 40px; background: linear-gradient(45deg, rgba(27, 47, 165, 0.637), rgba(165, 40, 40, 0.637)); border-radius: 10px; position: relative;">
                        <div class="book-box text-center" style="padding: 8px; font-size: 1.3rem; color: rgb(8, 8, 8); line-height: 17px;">
                            {{ $genre }}
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div> --}}

    <div class="row">
        @foreach ($data as $item)
        <div class="col-md-3 mb-4" style="margin-top: 40px; margin-left: 20px">
            <a href="{{ route('account.show', ['id' => $item->id]) }}" style="text-decoration-color: rgba(255, 255, 255, 0);">
                <div class="book d-flex">
                    <div class="cover">
                        @if ($item->foto)
                            <img style="max-width:140px; max-height:180px; border-radius: 10px; border: 1px solid #faf7f7; box-shadow: 0 0 10px rgba(0, 0, 0, 0.342);" src="{{ url('foto') . '/' . $item->foto }}" alt="">
                        @endif
                    </div>
                    <div class="column ms-3">
                        <div class="judul mb-2">
                            <div class="book-box" style="font-size: 1.5rem; color: rgb(0, 0, 0); margin-top: 20px">
                                {{ $item->nama_buku }}
                            </div>
                        </div>
                        <td>
                            @if ($item->kategoris->kategori == 'Horor')
                                <div class="box mb-3" style="width: 80px; height: 19px; background-color: rgb(34, 28, 29); border-radius: 10px; margin-top: 2px">
                                    <div class="book-box text-center" style="font-size: 12px; color: rgb(225, 210, 213); line-height: 17px;">
                                        {{ $item->kategoris->kategori }}
                                    </div>
                                </div>
                            @elseif ($item->kategoris->kategori == 'Romance')
                                <div class="box mb-3" style="width: 80px; height: 19px; background-color: pink; border-radius: 10px; margin-top: 2px">
                                    <div class="book-box text-center" style="font-size: 12px; color: rgb(172, 40, 62); line-height: 17px;">
                                        {{ $item->kategoris->kategori }}
                                    </div>
                                </div>
                            @elseif ($item->kategoris->kategori == 'Drama')
                                <div class="box mb-3" style="width: 80px; height: 19px; background-color: rgb(19, 183, 224); border-radius: 10px; margin-top: 2px">
                                    <div class="book-box text-center" style="font-size: 12px; color: rgb(255, 255, 255); line-height: 17px;">
                                        {{ $item->kategoris->kategori }}
                                    </div>
                                </div>
                            @elseif ($item->kategoris->kategori == 'Fantasi')
                                <div class="box mb-3" style="width: 80px; height: 19px; background-color: rgb(50, 19, 224); border-radius: 10px; margin-top: 2px">
                                    <div class="book-box text-center" style="font-size: 12px; color: rgb(255, 255, 255); line-height: 17px;">
                                        {{ $item->kategoris->kategori }}
                                    </div>
                                </div>
                            @endif
                        </td>
                        <div class="deskripsi" style="width: 90%; height: 60px; background-color: rgba(253, 253, 253, 0); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0); overflow: hidden">
                            <div class="book-box" style="font-size: 0.875rem; color: rgb(0, 0, 0); line-height: 1.25;">
                                {{-- <div style="width: 100%;">{{ $item->deskripsi ?? 'Deskripsi tidak tersedia' }}</div> --}}
                                <div>Presentations are commu nication tools that can be used as demonstrations, lectures, speeches, reports, and more.
                                    Mostly presented before an audience, it serves a variety of purposes, making presentations powerful tools for convincing and teaching.
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
@endsection
