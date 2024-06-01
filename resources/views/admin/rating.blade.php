{{-- @extends('desain.sidebarAdmin')

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

    <table class="table table-hover table-striped table-bordered">
        <thead class="table-success">
            <tr>
                <th class="col-md-1">No</th>
                <th class="col-md-1">ID</th>
                <th class="col-md-2">Buku</th>
                <th class="col-md-2">Username</th>
                <th class="col-md-1">Review</th>
                <th class="col-md-1">Rating</th>
                {{-- <th class="col-md-2">Status</th>
                <th class="col-md-3">Aksi</th> --}}
            {{-- </tr>
        </thead>
        <tbody>
            @foreach ($ratings as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->buku_r->nama_buku }}</td>
                <td>{{ $item->users_r->name }}</td>
                <td>{{ $item->review }}</td>
                <td>{{ $item->rating }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}
{{-- @endsection --}} --}}
