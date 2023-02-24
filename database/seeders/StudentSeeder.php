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
                'name' => fake()->name,
                'phone' => '8090412312',
                'first' => Carbon::today()->subDays(rand(0, 365)),
                'start' => $start,
                'end' => Carbon::parse($start)->days(rand(0, 50)),
                'grade' => fake()->company,
                'avatar' => 'https://cdn-icons-png.flaticon.com/512/168/168734.png',
                'birthday' => Carbon::today(),
            ]);
        }
    }
}
