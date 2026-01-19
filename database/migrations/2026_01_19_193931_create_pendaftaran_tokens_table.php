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
        Schema::create('pendaftaran_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('token', 64)->unique();
            $table->boolean('used')->default(false);
            $table->timestamp('expired_at');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_tokens');
    }
};
