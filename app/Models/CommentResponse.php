<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentResponse extends Model
{
    use HasFactory;

    protected $table = "comments_response";

    protected $fillable = [
        "response",
        "comment_id",
        "user_id",
        "deleted_at"
    ];

    public function comment() : BelongsTo
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isDeleted() : bool
    {
        return $this->deleted_at !== null;
    }
}
