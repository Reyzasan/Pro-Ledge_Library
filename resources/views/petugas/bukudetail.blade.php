@extends('desain.sidebarpetugas')

@section('konten')
    <form action='{{ url('buku/'.$data->id) }}' method='post' enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <a href="{{route('petugas.lihat')}}" class="btn btn-secondary"><< Kembali</a>
            <div class="row mt-3">
                @if ($data->foto)
                    <div class="col mt-4 mb-3">
                        <img style="max-height: 2000px;max-width: 200px" src="{{url('foto').'/'.$data->foto}}" alt="" srcset="">
                    </div>
                @endif
                <div class="col-md-8">
                    <div class="mb-3 mt-4 row">
                        <label for="id" class="col-sm-2 col-form-label">ID</label>
                        <div class="col-sm-10">
                            {{ $data->id }}
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama_buku" class="col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-10">
                            <div class="col-sm-10">
                                {{ $data->nama_buku }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="kategori" class="col-sm-2 col-form-label">kategori</label>
                        <div class="col-sm-10">
                            <div class="col-sm-10">
                                {{ $data->kategoris->kategori }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="penerbit" class="col-sm-2 col-form-label">penerbit</label>
                        <div class="col-sm-10">
                            <div class="col-sm-10">
                                {{ $data->penerbits->penerbit }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tahun_terbit" class="col-sm-2 col-form-label">Tahun Terbit</label>
                        <div class="col-sm-10" >
                            <div class="col-sm-10">
                                {{ $data->tahun_terbit }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="stock" class="col-sm-2 col-form-label">Stock</label>
                        <div class="col-sm-10" >
                            <div class="col-sm-10">
                                {{ $data->stock }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-10" >
                            <div class="col-sm-10">
                                {{ $data->harga }}
                            </div>
                        </div>
                    </div>
            </div>
            </div>
        </div>
    </form>
    <!-- AKHIR FORM -->
@endsection
