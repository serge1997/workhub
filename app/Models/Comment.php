<?php

namespace App\Models;

use App\Models\Scopes\NotDeletScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy(NotDeletScope::class)]
class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";
    protected $fillable = [
        'comment',
        'user_id',
        'task_id',
        'has_response',
        'deleted_at'
    ];

    public function task() : BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function commentResponse() : HasMany
    {
        return $this->hasMany(CommentResponse::class, 'comment_id');
    }

    public function isDeleted(): bool
    {
        return $this->deleted_at !== null;
    }

    public function hasResponse() : bool
    {
        return $this->has_response === true;
    }

    public function scopeCommentOf(Builder $builder, int $user_id)
    {
        return $builder->where('user_id', $user_id);
    }
}
