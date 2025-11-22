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

        Schema::create('data_registrasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasi_id')->constrained();
            $table->string('kata_kunci');
            $table->string('pertanyaan');
            $table->string('jawaban')->nullable();
            $table->tinyInteger('urutan');
            $table->enum('status', ["dijawab","menunggu"]);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_registrasis');
    }
};
