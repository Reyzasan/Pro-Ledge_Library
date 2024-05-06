<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class akun extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'username', 'password'];
    protected $table = 'akun';
    public $timestamps = false;
}
