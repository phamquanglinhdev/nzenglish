<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 10; $i++) {
            $start = Carbon::today()->subDays(rand(0, 30));
            DB::table("students")->insert([
                'origin' => rand(1, 3),
                'name' => fake("vi_VN")->name,
                'phone' => '8090412312',
                'first' => Carbon::today()->subDays(rand(0, 365)),
                'start' => $start,
                'first_reg' => 0,
                'end' => Carbon::parse($start)->days(rand(0, 50)),
                'avatar' => 'https://znews-photo.zingcdn.me/w660/Uploaded/gtnzjz/2019_05_30/IMG_0606.jpg',
                'birthday' => Carbon::today(),
            ]);
            DB::table("students")->insert([
                'origin' => rand(1, 3),
                'name' => fake("vi_VN")->name,
                'phone' => '8090412312',
                'first' => Carbon::today()->subDays(rand(0, 365)),
                'start' => $start,
                'first_reg' => 0,
                'end' => Carbon::parse($start)->days(rand(0, 50)),
                'avatar' => 'https://znews-photo.zingcdn.me/w660/Uploaded/gtnzjz/2019_05_30/IMG_0606.jpg',
                'birthday' => Carbon::today(),
                'reserve_at' => Carbon::today()->subDays(rand(0, 10)),
                'reserve_day' => 50
            ]);
        }
    }
}
