<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('active_effects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tree_id')->constrained('trees')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained()->restrictOnDelete();
            $table->string('effect_type'); // ACCELERATOR, AUTO_WATER
            $table->dateTime('started_at');
            $table->dateTime('expires_at');
            $table->timestamps();

            $table->index(['tree_id', 'effect_type', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('active_effects');
    }
};