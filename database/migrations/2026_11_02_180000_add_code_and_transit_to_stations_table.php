<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->string('code', 10)->nullable()->after('name');
            $table->boolean('is_transit')->default(false)->after('city');
            $table->json('facilities')->nullable()->after('is_transit');
            $table->text('description')->nullable()->after('facilities');
        });
    }

    public function down(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->dropColumn(['code', 'is_transit', 'facilities', 'description']);
        });
    }
};
