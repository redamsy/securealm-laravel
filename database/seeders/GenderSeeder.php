<?php

namespace Database\Seeders;

use App\Models\Gender;
use App\Enums\GenderEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('genders')->insert([
            [
                'name' => GenderEnum::Male
            ],
            [
                'name' => GenderEnum::Female
            ],
            [
                'name' => GenderEnum::Other
            ]
        ]);
    }
}
