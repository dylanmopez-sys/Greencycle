<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('trees', function (Blueprint $table) {
            //
            $table->dateTime('last_cared_at')->nullable();
            $table->dateTime('last_decay_at')->nullable();
            $table->dateTime('harvested_at')->nullable();
        });
    }

    
    public function down(): void
    {
        Schema::table('trees', function (Blueprint $table) {
            //
            $table->dropColumn(['last_cared_at', 'last_decay_at', 'harvested_at']);
        });
    }
};
