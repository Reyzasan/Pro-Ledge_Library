<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rating;

class RatingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $ratingRecord = [
            ['id' => 1, 'user_id'=>4, 'buku_id' => 1, 'review'=> 'Verry Bad', 'rating'=>1, 'status' => 0],
            ['id' => 2, 'user_id'=>4, 'buku_id' => 1, 'review'=> 'Very Good', 'rating'=>5, 'status' => 0],
            ['id' => 3, 'user_id'=>4, 'buku_id' => 1, 'review'=> 'Verry Good Good', 'rating'=>3, 'status' => 0],
        ];

        Rating::insert($ratingRecord);
    }
}
