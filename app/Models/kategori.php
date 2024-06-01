<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    // protected $primaryKey = 'id';
    protected $fillable = ['kategori', 'deskripsi'];
    public $timestamps = false;

    public function buku()
    {
        return $this->hashMany(buku::class, 'bukus_id');
    }
}
