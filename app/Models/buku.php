<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class buku extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nama_buku', 'kategori', 'tahun_terbit','stock'];
    protected $table = 'buku';
    public $timestamps = false;
    // protected $dates = ['birthdate'];

    public function kategoris()
    {
        return $this->belongsTo(kategori::class, 'kategori', 'id');
    }
}
