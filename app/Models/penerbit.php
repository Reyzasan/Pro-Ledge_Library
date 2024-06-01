<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penerbit extends Model
{
    use HasFactory;
    protected $table = 'penerbit';
    // protected $primaryKey = 'id';
    protected $fillable = ['penerbit', 'alamat'];
    public $timestamps = false;

    public function buku()
    {
        return $this->hashMany(buku::class, 'bukus_id');
    }
}
