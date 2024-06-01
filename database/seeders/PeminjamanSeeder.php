<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run()
    {
        DB::table('peminjaman')->insert([
            [
                'buku' => 1,
                'user' => 1,
                'status' => 'waiting',
                'denda' => 0,
                'tangal_peminjaman' => Carbon::now()->toDateString(),
                'tanggal_pengembalian' => Carbon::now()->addDays(7)->toDateString(),
            ],
            [
                'buku' => 2,
                'user' => 2,
                'status' => 'disetujui',
                'denda' => 0,
                'tangal_peminjaman' => Carbon::now()->toDateString(),
                'tanggal_pengembalian' => Carbon::now()->addDays(7)->toDateString(),
            ],
        ]);
    }
}
