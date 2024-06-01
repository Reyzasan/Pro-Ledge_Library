<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
    <link rel="stylesheet" href="{{asset('home.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Jacquard+12&family=Pinyon+Script&display=swap" rel="stylesheet">
</head>
<body>
    @extends('desain.sidebar')
    @foreach ($data as $item)
    <div class="book" style="margin: 20px">
        <div class="cover">
            @if ($item->foto)
                <img style="max-width:140px; max-height:180px; border-radius: 10px; border: 1px solid #faf7f7; box-shadow: 0 0 10px rgba(0, 0, 0, 0.342); */" src="{{ url('foto') . '/' . $item->foto }}" alt="">
            @endif
        </div>
        <div class="column">
            <div class="mb-3 row" style="margin-bottom: 8px; margin-left: 19px;">
                <div class="col-sm-10" style="font-size: 2rem;">
                    {{ $item->nama_buku }}
                </div>
            </div>
            <div class="box" style="width: 100px; height: 25px; background-color: pink; margin-left: 20px; margin-bottom: 20px; border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0)">
                <div class="book-box" style="font-size: 1rem; color: rgb(172, 40, 62); width: 50px; height: 40px; margin-left: 20px; margin-bottom: 70px; text-align: center; line-height: 25px;">
                    {{ $item->kategoris->kategori }}
                </div>
            </div>
            <div class="deskripsi" style="width: 120px; height: 60px; background-color: rgba(253, 253, 253, 0); margin-left: 20px;margin-bottom: 10px; border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0); overflow: hidden">
                <div class="book-box" style="font-size: 10px; color: rgb(0, 0, 0); width: 50px; height: 40px; margin-bottom: 70px; line-height: 20px;">
                    <div style="width: 120px">Deskripsihqegrh gwhgwffhjfw hjdjhfjdnshfj shfjhf hhdjwjhruwhfjfms fnjenf dhjdhwjhwedjsefj hwwuefhf</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</body>
</html>
