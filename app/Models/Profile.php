<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'name', 'bio','phone', 'picture','address','status','jk'];
    protected $table = 'profiles';
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
