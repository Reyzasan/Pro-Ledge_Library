@extends('desain.tampilanAdmin')

@section('konten')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

    <div class="mt-5">
        @if (Session('message'))
            <div class="pt-3">
                <div class="alert {{ session('alert-class') }}">
                    {{ Session('message') }}
                </div>
            </div>
        @endif
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <h1 class="mb-5">Book Rent</h1>
                <!-- Single form for book rental process -->
                <form action="{{ route('admin.book-rent.store') }}" method="post">
                    @csrf <!-- CSRF token for security -->
                    <div class="mb-3">
                        <label for="user" class="col-form-label">User</label>
                        <select name="user_id" id="user" class="form-control userbox">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="book" class="col-form-label">Book</label>
                        <select name="book_id" id="book" class="form-control userbox">
                            <option value="">Select Book</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}">{{ $book->nama_buku }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.userbox').select2();
        });
    </script>
@endsection
