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
    {{-- <div class="user">
        <i class='bx bx-user'></i>
    </div> --}}

    <div class="row">
        @foreach ($data as $item)
        <div class="col-md-3 mb-1" style="margin-top: 40px; margin-left: 60px;width: 360px">
            <a href="{{ route('account.show', ['id' => $item->id]) }}" style="text-decoration-color: rgba(255, 255, 255, 0);">
                <div class="book d-flex">
                    <div class="cover">
                        @if ($item->foto)
                            <img style="max-width:140px; max-height:180px; border-radius: 10px; border: 1px solid #faf7f7; box-shadow: 0 0 10px rgba(0, 0, 0, 0.342);" src="{{ url('foto') . '/' . $item->foto }}" alt="">
                        @endif
                    </div>
                    <div class="column ms-3">
                        <div class="judul mb-2">
                            <div class="col-sm-12" style="font-size: 16px; font-weight: 200; margin-top: 10px; height: 25px; overflow: hidden; width: 100%; color: green">
                                {{ $item->pengarangs->pengarang}}
                            </div>
                            <div class="book-box" style="font-size: 1.5rem; color: rgb(0, 0, 0); overflow: hidden; line-height: 1.25; height: 30px">
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
                        <div class="deskripsi" style="width: 100%; height: 70px; background-color: rgba(253, 253, 253, 0); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0); overflow: hidden">
                            <div class="book-box" style="font-size: 0.875rem; color: rgb(0, 0, 0); line-height: 1.25;">
                                {{-- <div style="width: 100%;">{{ $item->deskripsi ?? 'Deskripsi tidak tersedia' }}</div> --}}
                                <div>{{$item->deskripsi}}
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
