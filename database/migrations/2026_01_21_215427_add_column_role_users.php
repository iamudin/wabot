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
                Schema::table('users', function (Blueprint $table) {
                $table->enum('role',['admin','penandatangan'])->default('admin')->nullable();
        });
       if (Schema::hasColumn('permohonans', 'pemohon_id')) {
            Schema::table('permohonans', function (Blueprint $table) {
                $table->dropColumn('pemohon_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
