<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table
                ->id();
            $table
                ->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->string('fcm_token');
            $table
                ->string('platform', 20)->nullable();
            $table
                ->timestamp('last_seen_at')->nullable();
            $table
                ->unique(['user_id', 'fcm_token']);
            $table
                ->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
