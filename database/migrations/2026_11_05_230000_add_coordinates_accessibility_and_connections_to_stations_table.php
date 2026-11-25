<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('city');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->boolean('is_active')->default(true)->after('is_transit');
            $table->json('accessibility')->nullable()->after('facilities');
            $table->json('transit_connections')->nullable()->after('accessibility');
        });
    }

    public function down(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->dropColumn([
                'latitude',
                'longitude',
                'is_active',
                'accessibility',
                'transit_connections',
            ]);
        });
    }
};
