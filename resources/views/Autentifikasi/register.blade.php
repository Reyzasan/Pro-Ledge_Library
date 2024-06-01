@extends('desain.desain')

@section('konten')
@if ($errors->any())
<div class="pt-3">
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $item)
                <li>{{$item}}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
@if (Session::has('success'))
<div class="pt-3">
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
</div>
@endif
    <div class="w-50 center border rounded px-3 py-3 mx-auto">
        <h1>Register</h1>
        <form action="{{route('account.ProcessRegister')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" value="{{old('email')}}" name="email"  class="form-control  @error('email') is-invalid @enderror">
                @error('email')
                    <p class="invalid-feedback">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" value="{{old('name')}}" name="name"  class="form-control  @error('name') is-invalid @enderror">
                @error('name')
                    <p class="invalid-feedback">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" value="{{old('password')}}" name="password"  class="form-control  @error('password') is-invalid @enderror">
                @error('password')
                    <p class="invalid-feedback">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Confirm Password</label>
                <input type="password" value="" name="password_confirmation" class="form-control" id="password_confirmation">
            </div>
            <div class="mb-3 d-grid">
                <button name="submit" type="submit" class="btn btn-primary">Register</button>
            </div>
            <div class="mb-3 d-grid">
                <a href="{{route('account.login')}}" class="btn btn-secondary">Have Account</a>
            </div>
        </form>
    </div>
@endsection
