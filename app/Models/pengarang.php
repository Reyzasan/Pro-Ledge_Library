<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengarang extends Model
{
    use HasFactory;
    protected $table = 'pengarang';
    // protected $primaryKey = 'id';
    protected $fillable = ['pengarang', 'jk'];
    public $timestamps = false;

    public function buku()
    {
        return $this->hashMany(buku::class, 'bukus_id');
    }
}
