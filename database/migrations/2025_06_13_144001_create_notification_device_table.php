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
        Schema::create('notification_device', function (Blueprint $table) {
            $table
                ->id();
            $table
                ->foreignId('notification_id')
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignId('device_id')
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->enum('status', ['queued', 'sent', 'delivered', 'failed'])
                ->default('queued')
                ->index();
            $table
                ->json('response_payload')
                ->nullable();
            $table
                ->string('error_message')
                ->nullable();
            $table
                ->timestamps();
            $table
                ->unique(['notification_id', 'device_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_device');
    }
};
