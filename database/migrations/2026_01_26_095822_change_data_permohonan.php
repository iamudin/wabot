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
         if (Schema::hasColumn('jenis_syarats', 'sumber_data')) {
            Schema::table('jenis_syarats', function (Blueprint $table) {
               $table->dropColumn('sumber_data');
             });
         }
           Schema::table( 'data_permohonans', function (Blueprint $table) {
            $table->string('koreksidata')->nullable()->change();
            $table->string('keterangan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
