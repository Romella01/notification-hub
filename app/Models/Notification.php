<?php

namespace App\Models;

use Database\Factories\NotificationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $id
 * @property string $title
 * @property string $body
 * @property string $send_at
 */
class Notification extends Model
{
    /** @use HasFactory<NotificationFactory> */
    use HasFactory;

    public $table = 'notifications';

    protected $fillable = [
        'title',
        'body',
        'send_at',
        'created_at',
        'dispatched',
        'created_by'
    ];

    public function devices(): BelongsToMany
    {
        return $this->belongsToMany(
            Device::class,
            'notification_device',
            'notification_id',
            'device_id'
        )->withTimestamps();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
