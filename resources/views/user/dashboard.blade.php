@extends('desain.sidebar')
<!-- START DATA -->
@section('konten')
    @if (Session::has('success'))
        <div class="pt-3">
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        </div>
    @endif

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <!-- FORM PENCARIAN -->
        <div class="pb-3">
            <form class="d-flex" action="{{ url('buku') }}" method="get">
                <input class="form-control me-1" type="search" name="katakunci" value="{{ Request::get('katakunci') }}"
                    placeholder="Masukkan kata kunci" aria-label="Search">
                <button class="btn btn-secondary" type="submit">Cari</button>
            </form>
        </div>

        <div class="row">
            @foreach ($data as $item)
            <div class="col-md-4 mb-4" style="margin-top: 40px">
                <a href="{{ route('account.show', ['id' => $item->id]) }}" style="text-decoration-color: rgba(255, 255, 255, 0)">
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
                                @elseif ($item->kategoris->kategori == 'Fantasi')
                                    <div class="box mb-3" style="width: 80px; height: 19px; background-color: rgb(216, 87, 173); border-radius: 10px; margin-top: 2px">
                                        <div class="book-box text-center" style="font-size: 12px; color: rgb(17, 51, 187); line-height: 17px;">
                                            {{ $item->kategoris->kategori }}
                                        </div>
                                    </div>
                                @endif
                            </td>
                            {{-- <div class="kategori">
                                @if ($item->kategori == 'Horor')
                                <div class="box mb-3" style="width: 80px; height: 19px; background-color: rgb(34, 28, 29); border-radius: 10px; margin-top: 2px">
                                    <div class="book-box text-center" style="font-size: 12px; color: rgb(172, 40, 62); line-height: 17px;">
                                        {{ $item->kategoris->kategori }}
                                    </div>
                                </div>
                                @else

                                @endif
                            </div> --}}
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
    </div>
    <!-- AKHIR DATA -->
@endsection