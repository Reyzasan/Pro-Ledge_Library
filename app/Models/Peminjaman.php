<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'table_peminjaman';

    public function bukus()
    {
        return $this->belongsTo('App\Models\buku','buku');
    }

    public function userss()
    {
        return $this->belongsTo('App\Models\User','user');
    }

    // public function status_s()
    // {
    //     return $this->belongsTo('App\Models\Status','status','kode')->withDefault(['nama' => 'Menunggu Verifikasi']);
    // }
}
