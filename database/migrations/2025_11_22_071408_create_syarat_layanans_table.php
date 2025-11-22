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

        Schema::create('syarat_layanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained();
            $table->string('nama');
            $table->string('keterangan');
            $table->enum('jenis_syarat', ["file","text"]);
            $table->boolean('status');
            $table->tinyInteger('urutan');
            $table->enum('sumber_data', ["user","database"]);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syarat_layanans');
    }
};
