<!DOCTYPE html>
<html>
<head>
    <title>PRO-LEDGE Login</title>
    <link rel="stylesheet" href="{{ asset('signup.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Jacquard+12&family=Pinyon+Script&display=swap" rel="stylesheet">
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
<!-- Boxicons CSS -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container container-custom" style="background-color: rgb(39, 158, 3);width: 100vw; height: 100vh;">
        <div class="row align-items-center min-vh-100">
            <div class="col-md-2">
                <img src="{{ asset('asset/2.jpg') }}" alt="Login" class="img-fluid" style="width: 150%; height: 100%;">
            </div>
            <div class="col-md-10 d-flex justify-content-center">
                <box-icon name='arrow-back'></box-icon>
                <div class="page" style="width: 430px; height: 100%;background: linear-gradient(45deg, rgb(155, 214, 148), rgb(50, 109, 65));margin-left: 21%;padding: 2rem;border-radius: 10px;">
                    <h1 style="text-align: left;color: white;font-weight: 300;font-size: 3rem;margin-bottom: 0.5rem;margin-top: 5%">Sign Up</h1>
                    <p style="text-align: left;color: rgb(206, 194, 33); font-size: 1rem;margin-bottom: 1rem;">Hello!<span style="color: white"> Welcome To Pro-Ledge</span></p>
                    <form action="{{route('account.ProcessRegister')}}" method="post">
                        @csrf
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label for="email" class="form-label" style="color: rgb(248, 248, 247); font-size: 1rem" >Email</label>
                            <input type="text" id="email" value="{{ old('email') }}" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="name@gmail.com" style="background-color: rgba(255, 255, 255, 0);width: 100%;padding: 0.75rem;margin-top: 0.5rem;margin-bottom: 0.5rem;border: 2px solid #104e2f;border-radius: 10px;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label for="name" class="form-label" style="color: white">Username</label>
                            <input type="name" id="name" value="{{ old('name') }}" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Username" style="background-color: rgba(255, 255, 255, 0);width: 100%;padding: 0.75rem;margin-top: 0.5rem;margin-bottom: 0.5rem;border: 2px solid #104e2f;border-radius: 10px;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label for="password" class="form-label" style="color: white">Password</label>
                            <input type="password" id="password" value="{{ old('password') }}" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="password" style="background-color: rgba(255, 255, 255, 0);width: 100%;padding: 0.75rem;margin-top: 0.5rem;margin-bottom: 0.5rem;border: 2px solid #104e2f;border-radius: 10px;">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label for="password" class="form-label" style="color: white">Password</label>
                            <input type="password" value="" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm Password" style="background-color: rgba(255, 255, 255, 0);width: 100%;padding: 0.75rem;margin-top: 0.5rem;margin-bottom: 0.5rem;border: 2px solid #104e2f;border-radius: 10px;">
                        </div>
                        <button id="myButton">Sign Up</button>
                        <span style="color: white; text-align:center; margin: 6.4rem">You Have Account?<a href="{{route('account.login')}}" style="color: rgb(191, 243, 48);text-decoration: underline; transform: scaleX(2);">Login</a></span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
