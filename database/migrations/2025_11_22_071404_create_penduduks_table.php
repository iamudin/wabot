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

        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16);
            $table->string('nama');
            $table->enum('jenis_kelamin', ["L","P"]);
            $table->string('alamat')->nullable();
            $table->foreignId('rt_id')->nullable()->constrained();
            $table->string('agama')->nullable();
            $table->string('status_kawin')->nullable();
            $table->string('nomor_whatsapp')->index();
            $table->timestamp('terdaftar_pada')->nullable();
            $table->timestamp('terverifikasi_pada')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};
