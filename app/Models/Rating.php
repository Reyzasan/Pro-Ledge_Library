<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    public function users_r()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buku_r()
    {
        return $this->belongsTo(buku::class, 'buku_id');
    }
    public function pinjam_r()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }
}
