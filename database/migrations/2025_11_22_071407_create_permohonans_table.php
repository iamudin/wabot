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

        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained();
            $table->timestamp('sesi_dimulai')->nullable();
            $table->timestamp('sesi_berakir')->nullable();
            $table->string('status_permohonan')->default('baru');
            $table->foreignId('penduduk_id')->constrained();
            $table->foreignId('pemohon_id')->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
