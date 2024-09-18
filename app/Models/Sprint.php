<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sprint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_at',
        'close_at',
        'deleted_at'
    ];

    public function tasks() : HasMany
    {
        return $this->hasMany(Task::class, 'sprint_id');
    }
}
