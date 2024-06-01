<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koleksi extends Model
{
    use HasFactory;

    protected $table = "koleksis";

    public function bukus()
    {
        return $this->belongsTo('App\Models\buku','nama_buku');
    }

    public function userss()
    {
        return $this->belongsTo('App\Models\User','user');
    }

    public function kategoris()
    {
        return $this->belongsTo('App\Models\kategori','kategori');
    }
    public function penerbits()
    {
        return $this->belongsTo('App\Models\Penerbit', 'penerbit');
    }

}
