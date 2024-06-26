<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Annex extends Model
{
    use HasFactory;

    protected $table = 'task_annexes';
    public static array $extension = ['pdf', 'docx'];


    protected $fillable = [
        'task_id',
        'annex',
        'deleted_at',
        'deleted_reason'
    ];

    public function task() : BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function isDeleted() : bool
    {
        return $this->deleted_at !== null;
    }
}
