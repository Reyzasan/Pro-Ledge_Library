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
        &lt;&lt; Kembali
    </a>
</div>

<form action="{{ route('profile-edit', $userinfo->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mt-3">
        <div class="mb-3 row">
            <div class="col-sm-10">
                <input type="file" class="form-control" name="picture" id="picture" style="display: none;">
            </div>
        </div>
        @if ($userinfo && $userinfo->picture)
            @php
                $imagePath = url('foto') . '/' . $userinfo->picture;
            @endphp
            <div class="col-md-4 mt-4 mb-3">
                <img id="profile-picture" style="max-height: 200px; max-width: 200px; border-radius: 20px; cursor: pointer;" src="{{ $imagePath }}" alt="Profile Picture">
                <div class="mb-1 row" style="text-align: center">
                    <div class="col-sm-10">
                        {{ $userinfo->email }}
                    </div>
                </div>
            </div>
        @endif
        {{-- {{dd($userinfo->jk)}} --}}
        <div class="col-md-8">
            <div class="mb-3 row">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <textarea name="name" class="form-control" placeholder="name" style="width: 100%; height: 20px">{{ $userinfo->name }}</textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="bio" class="col-sm-2 col-form-label">Bio</label>
                <div class="col-sm-10">
                    <textarea name="bio" class="form-control" placeholder="bio" style="width: 100%; height: 60px">{{ $userinfo->bio }}</textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                <div class="col-sm-10">
                    <textarea name="phone" class="form-control" placeholder="phone" style="width: 100%; height: 20px">{{ $userinfo->phone }}</textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <textarea name="address" class="form-control" placeholder="address" style="width: 100%; height: 60px">{{ $userinfo->address }}</textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-10">
                    <select class="form-select" name="jk" id="jk">
                        <option value="Laki-laki" {{ $userinfo->jk == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $userinfo->jk == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="kategori" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">Perbarui</button></div>
            </div>
        </div>
    </div>
</form>
<script>
    document.getElementById('profile-picture').addEventListener('click', function() {
        document.getElementById('picture').click();
    });
</script>
@endsection
