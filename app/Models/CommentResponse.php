<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
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

    public function since()
    {
        $date = Carbon::createFromFormat("Y-m-d H:i:s",$this->created_at);
        $periode_year = Carbon::now()->diffInYears($date);
        $periode = Carbon::now()->diffInDays($date);
        if ($periode == 0){
            $diff = Carbon::now()->diffInHours($date);
            if ($diff == 0){
                $periode = "Há ".Carbon::now()->diffInMinutes($date) . " min";
            }else{
                $periode = "Há {$diff} horas";
            }

       }else if($periode >= 7 && $periode < 31){
            $periode = "Há ". Carbon::now()->diffInWeeks($date) . " semanas";
       }else if($periode >= 31 && $periode_year == 0){
            $periode = "Há ". Carbon::now()->diffInMonths($date) . " mês";
       }else{
            $periode = "Há {$periode_year} ano";
       }
       return $periode;
    }
}
