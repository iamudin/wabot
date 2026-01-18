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

        Schema::table('chatbot_sessions', function (Blueprint $table) {

            if (Schema::hasColumn( 'chatbot_sessions', 'session_state')) {
                $table->renameColumn('session_state', 'state');
            }

                $table->json('payload')->nullable();
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
