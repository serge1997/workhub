<?php

namespace App\Models;

use App\Models\Scopes\NotDeletScope;
use App\Observers\CommentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Carbon\Carbon;

#[ObservedBy(CommentObserver::class)]
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

    public function scopeDeleted(Builder $builder)
    {
        return $builder->where('deleted_at','<>', null);
    }

    public function since()
    {
        $date = Carbon::createFromFormat("Y-m-d H:i:s",$this->created_at);
        $periode_year = Carbon::now()->diffInYears($date);
        $periode = Carbon::now()->diffInDays($date);
        if ($periode == 0){
            $diff = Carbon::now()->diffInHours($date);
            if ($diff == 0){
                return "Há ".Carbon::now()->diffInMinutes($date) . " min";
            }else{
                return "Há {$diff} horas";
            }
        }else if($periode < 7 && $periode > 1){
            return "Há {$periode} dias";
       }else if($periode >= 7 && $periode < 31){
            return "Há ". Carbon::now()->diffInWeeks($date) . " semanas";
       }else if($periode >= 31 && $periode_year == 0){
            return "Há ". Carbon::now()->diffInMonths($date) . " mês";
       }else{
            if ($periode_year >= 1){
                return "Há {$periode_year} ano";
            }
       }
    }
}
