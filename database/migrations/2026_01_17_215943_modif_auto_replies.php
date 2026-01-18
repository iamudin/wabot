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

        Schema::table('auto_replies', function (Blueprint $table) {
          
            $table->string('title')->nullable();
         
            if (Schema::hasColumn('auto_replies', 'action')) {
                $table->dropColumn('action');
            }
            if (Schema::hasColumn('auto_replies', 'level')) {
                $table->dropColumn('level');
            }
        });
      

        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
