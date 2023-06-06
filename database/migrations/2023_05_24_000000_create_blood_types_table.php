<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blood_types', function (Blueprint $table) {
            $table->increments('id');
            $table->enum(
                'name',
                [
                    'A positive (A+)',
                    'A negative (A-)',
                    'B positive (B+)',
                    'B negative (B-)',
                    'AB positive (AB+)',
                    'AB negative (AB-)',
                    'O positive (O+)',
                    'O negative (O-)'
                ]
            )->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_type');
    }
};
