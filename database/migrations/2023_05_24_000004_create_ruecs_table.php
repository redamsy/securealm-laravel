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
        // changed name from 'regular_user_educational_certificate' to 'ruec'
        Schema::create('ruecs', function (Blueprint $table) {

            $table->unsignedBigInteger('regular_user_id');
            $table->foreign('regular_user_id')->references('user_id')->on('regular_users');

            $table->unsignedInteger('educational_certificate_id');
            $table->foreign('educational_certificate_id')->references('id')->on('educational_certificates');

            $table->primary(['regular_user_id', 'educational_certificate_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruecs');
    }
};
