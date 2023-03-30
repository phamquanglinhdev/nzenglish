<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create([
            'name' => 'Chi nhánh TPCHM',
            'code' => 1
        ]);
        Branch::create([
            'name' => 'Chi nhánh Bình Dương',
            'code' => 2
        ]);
        Branch::create([
            'name' => 'Chi nhánh Hà Nội',
            'code' => 3
        ]);
    }
}
