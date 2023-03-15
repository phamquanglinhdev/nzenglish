<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("packs")->insert([
            "value" => 0,
            "name" => "Gia hạn học phí"
        ]);
        DB::table("packs")->insert([
            "value" => 300000,
            "name" => "Mua giáo trình"
        ]);
        DB::table("packs")->insert([
            "value" => 100000,
            "name" => "Phí thi cuối kỳ"
        ]);
    }
}
