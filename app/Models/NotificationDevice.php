<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotificationDevice extends Model
{
    public $table = 'notification_device';

    public function notification(): HasMany
    {
        return $this->hasMany(
            Notification::class,
            'id',
            'notification_id'
        );
    }

    public function device(): HasMany
    {
        return $this->hasMany(
            Device::class,
            'id',
            'device_id'
        );
    }
}
