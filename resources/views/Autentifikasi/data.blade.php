@extends('desain.desain')

@section('konten')
{{-- @if ($errors->any())
<div class="pt-3">
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $item)
                <li>{{$item}}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif --}}
@if (Session::has('success'))
<div class="pt-3">
        <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
</div>
@endif
    <div class="w-50 center border rounded px-3 py-3 mx-auto">
        <h1>Login</h1>
        <form action="{{route('account.authenticate')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text"  value="{{old('email')}}" name="email" class="form-control @error('email')
                    is-invalid
                @enderror" placeholder="name@gmail.com">
                @error('email')
                    <p class="invalid-feedback">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror">
                @error('password')
                    <p class="invalid-feedback">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3 d-grid">
                <button name="submit" type="submit" class="btn btn-primary">LOGIN</button>
            </div>
            <div class="mb-3 d-grid">
                <a href="{{route('account.register')}}" class="btn btn-secondary">Create New Account</a>
            </div>
        </form>
    </div>
@endsection
