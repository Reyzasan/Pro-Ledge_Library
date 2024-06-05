<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class buku extends Model
{
    use HasFactory;
    protected $fillable = ['nama_buku', 'kategori', 'pengarang','tahun_terbit','penerbit','stock','foto'];
    protected $table = 'buku';
    public $timestamps = false;

    public function kategoris()
    {
        return $this->belongsTo(kategori::class, 'kategori', 'id');
    }

    public function penerbits()
    {
        return $this->belongsTo(penerbit::class, 'penerbit', 'id');
    }
    public function pengarangs()
    {
        return $this->belongsTo(penerbit::class, 'pengarang', 'id');
    }

    // public function koleksis()
    // {
    //     return $this->belongsTo('App\Models\Koleksi', 'status');
    // }
    // public function detailPeminjaman()
    // {
    //     return $this->hasMany(DetailPeminjaman::class, 'buku_id');
    // }
}
