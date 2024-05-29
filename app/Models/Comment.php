<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";
    protected $fillable = [
        'comment',
        'user_id',
        'task_id',
        'banned_at'
    ];

    public function isBanned(): bool
    {
        return $this->banned_at !== null;
    }
}
