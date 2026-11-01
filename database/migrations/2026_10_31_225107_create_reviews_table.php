<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('station_id')
                ->constrained('stations')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('rating')->nullable();

            $table->string('category');

            $table->text('content');

            $table->boolean('is_private')->default(false);

            $table->timestamp('created_at')->useCurrent();

            $table->index(['station_id', 'is_private']);
            $table->index(['user_id', 'is_private']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};