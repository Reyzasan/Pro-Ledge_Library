<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRO-LEDGE Dashboard</title>
    <link rel="stylesheet" href="{{asset('dashboard.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Jacquard+12&family=Pinyon+Script&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo-detail">
            <i class='bx bx-menu-alt-left' style="color: white"></i>
            <span style="color: white">Pro-Ledge</span>
        </div>
        <ul class="nav-links">
            {{-- <div class="Profile">
                <a href="{{route('profile')}}">
                    <i class='bx bxs-grid-alt'></i>
                    <span>Profile</span>
                </a>
                <span class="tooltip">Profile</span>
            </div> --}}
            <div class="dashboard" style="margin-top: 10rem">
                <a href="{{route('account.dashboard')}}">
                    <i class='bx bxs-grid-alt'></i>
                    <span>Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </div>
            <div class="Favorit">
                <a href="{{route('account.koleksi')}}">
                    <i class='bx bx-bookmark-alt'></i>
                    <span>Koleksi</span>
                </a>
                <span class="tooltip">Koleksi</span>
            </div>
            <div class="peminjaman">
                <a href="{{route('PeminjamanUser')}}">
                    <i class='bx bx-book-reader'></i>
                    <span>Peminjaman</span>
                </a>
                <span class="tooltip">Peminjaman</span>
            </div>
            <div class="logout" style="margin-top: 12rem">
                <a href="{{ route('account.logout') }}" class="logout-link">
                    <i class='bx bx-door-open'></i>
                    <span>Log Out</span>
                </a>
                <span class="tooltip">Log Out</span>
            </div>
        </ul>
    </div>
    <div class="home-section">
        <div class="container">
            @yield('konten')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
