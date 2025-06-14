<?php

namespace App\Models;

use Database\Factories\DeviceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $platform
 * @property string $updated_at
 * @property string $fcm_token
 */
class Device extends Model
{
    /** @use HasFactory<DeviceFactory> */
    use HasFactory;

    protected $table = 'devices';

    protected $fillable = [
        'user_id',
        'fcm_token',
        'platform',
        'last_seen_at'
    ];

    protected $hidden = [
        'fcm_token',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
