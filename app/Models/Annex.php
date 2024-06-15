<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annex extends Model
{
    use HasFactory;

    protected $table = 'task_annexes';

    protected $fillable = [
        'task_id',
        'annex',
        'deleted_at',
        'deleted_reason'
    ];
}
