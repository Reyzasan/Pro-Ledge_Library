<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pro-Ledge Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    {{-- {{dd($item)}} --}}
    <h1 style="text-align: center; margin-bottom: 60px">Laporan Peminjaman</h1>
    <div class="column" style="display: flex; align-items: center;">
        <h3 style="margin-right: 20px;">ID Petugas : {{ Auth::user()->id }}</h3>
        <h3>Petugas : {{Auth::user()->name}}</h3>
    </div>
    <h3>Status : Disetujui</h3>
    @if(!empty($bulan))
        <h3>Bulan Laporan: {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}</h3>
    @else
        <h3>Bulan Laporan: Semua Bulan</h3>
    @endif
    <table class="table" style="border: 1px solid black;">
        <thead class="table-light" style="padding: 5px">
            <tr>
                <th class="col-md-1" style="border: 2px solid black;">No</th>
                <th class="col-md-1" style="border: 2px solid black;">ID</th>
                <th class="col-md-2" style="border: 2px solid black;">Username</th>
                <th class="col-md-2" style="border: 2px solid black;">Buku</th>
                <th class="col-md-1" style="border: 2px solid black;">Pengajuan</th>
                <th class="col-md-1" style="border: 2px solid black;">Peminjaman</th>
                <th class="col-md-1" style="border: 2px solid black;">Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            {{-- { ($data)}} --}}
            @foreach ($data as $item)
            <tr style="border: 1px solid black;">
                <td style="border: 2px solid black;">{{ $loop->iteration }}</td>
                <td style="border: 2px solid black;">{{ $item->id }}</td>
                <td style="border: 2px solid black;">{{ $item->userss->name }}</td>
                <td style="border: 2px solid black;">{{ $item->bukus->nama_buku }}</td>
                <td style="border: 2px solid black;">{{ $item->pengajuan }}</td>
                <td style="border: 2px solid black;">{{ $item->tangal_peminjaman }}</td>
                <td style="border: 2px solid black;">{{ $item->tanggal_pengembalian }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
