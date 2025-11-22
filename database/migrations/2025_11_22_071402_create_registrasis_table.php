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
        Schema::disableForeignKeyConstraints();

        Schema::create('registrasis', function (Blueprint $table) {
            $table->id();
            $table->timestamp('sesi_dimulai')->nullable();
            $table->timestamp('sesi_berakir')->nullable();
            $table->string('nomor_whatsapp');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasis');
    }
};
