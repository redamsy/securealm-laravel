<?php

namespace Database\Seeders;
use App\Enums\BloodTypeEnum;
use App\Models\BloodType;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BloodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('blood_types')->insert([
            [
                'name' => BloodTypeEnum::APositive
            ],
            [
                'name' => BloodTypeEnum::ANegative
            ],
            [
                'name' => BloodTypeEnum::BPositive
            ],
            [
                'name' => BloodTypeEnum::BNegative
            ],
            [
                'name' => BloodTypeEnum::ABPositive
            ],
            [
                'name' => BloodTypeEnum::ABNegative
            ],
            [
                'name' => BloodTypeEnum::OPositive
            ],
            [
                'name' => BloodTypeEnum::ONegative
            ]
        ]);
    }
}
