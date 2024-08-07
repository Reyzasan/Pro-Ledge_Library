<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRO-LEDGE Dashboard</title>
    <link rel="stylesheet" href="{{asset('petugas-admin.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Jacquard+12&family=Pinyon+Script&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>
    <div class="sidebar">
        <div class="logo-detail">
            <i class='bx bx-menu-alt-left'></i>
            <span>Pro-Ledge</span>
        </div>
        <ul class="nav-links">
            <div class="dashboard">
                <a href="{{route('petugas.lihat')}}">
                    <i class='bx bxs-grid-alt'></i>
                    <span>Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </div>
            <div class="pengguna">
                <a href="{{route('StatusPetugas')}}">
                    <i class='bx bxs-grid-alt'></i>
                    <span>pengguna</span>
                </a>
                <span class="tooltip">pengguna</span>
            </div>
            <div class="tambahdata">
                <a href="{{url('jenisbukus')}}">
                    <i class='bx bx-bookmark-alt'></i>
                    <span>JenisBuku</span>
                </a>
                <span class="tooltip">tambahdata</span>
            </div>
            <div class="Kategori">
                <a href="{{ url('kategoris') }}">
                    <i class='bx bx-book-reader'></i>
                    <span>Kategori</span>
                </a>
            </div>
            <div class="Pengarang">
                <a href="{{ url('pengarangs') }}">
                    <i class='bx bx-book-reader'></i>
                    <span>Pengarang</span>
                </a>
            </div>
            <div class="Penerbit">
                <a href="{{ url('penerbits') }}">
                    <i class='bx bx-book-reader'></i>
                    <span>Penerbit</span>
                </a>
            </div>
            <div class="peminjaman">
                <a href="{{route('pinjam-buku')}}">
                    <i class='bx bx-book-reader'></i>
                    <span>Peminjaman</span>
                </a>
            </div>
            <div class="Pengembalian">
                <a href="{{route('pengembalian-buku')}}">
                    <i class='bx bx-book-reader'></i>
                    <span>Pengembalian</span>
                </a>
            </div>
            <div class="logout" style="margin-top: 1rem">
                <a href="{{ route('account.logout') }}" class="logout-link">
                    <i class='bx bxs-door-open'></i>
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
