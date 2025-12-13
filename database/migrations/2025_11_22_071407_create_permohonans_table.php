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
            $table->timestamp('diproses_pada')->nullable();
            $table->timestamp('diajukan_pada')->nullable();
            $table->timestamp('diselesaikan_pada')->nullable();
            $table->timestamp('ditolak_pada')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->string('status_permohonan')->default('baru');
            $table->foreignId('penduduk_id')->constrained();
            $table->foreignId('pemohon_id')->constrained();
            $table->string('file_surat')->nullable();
            $table->string('penandatangan_id')->nullable();
            $table->string('kode_tiket')->nullable();

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
