<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var User $admin */
        $admin = User::query()->where('email', 'admin@example.com')->first();

        Notification::factory()
            ->for($admin, 'creator')
            ->create();
    }
}
