<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationalCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('educational_certificates')->insert([
            [
                'name' => 'BS'
            ],
            [
                'name' => 'MS'
            ],
            [
                'name' => 'PHD'
            ]
        ]);
    }
}
