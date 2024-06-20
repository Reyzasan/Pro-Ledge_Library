<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenisbuku extends Model
{
    use HasFactory;
    protected $table = 'jenisbuku';
    // protected $primaryKey = 'id';
    protected $fillable = ['jenisbuku', 'deskripsi'];
    public $timestamps = false;

    public function buku()
    {
        return $this->hashMany(buku::class, 'bukus_id');
    }
}
