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
        Schema::create('notifications', function (Blueprint $table) {
            $table
                ->id();
            $table
                ->string('title')
                ->nullable();
            $table
                ->text('body');
            $table
                ->timestamp('send_at')
                ->index();
            $table
                ->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();
            $table
                ->boolean('dispatched')
                ->default(false);
            $table
                ->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
