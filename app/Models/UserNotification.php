<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNotification extends Model
{
    use HasFactory;

    protected $table = 'users_notifications';

    protected $fillable = [
        'user_id',
        'notification_id',
        'is_readed'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(TaskActivity::class, 'notification_id');
    }


}
