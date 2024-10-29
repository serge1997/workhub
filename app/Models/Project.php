<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $table = "projects";
    protected $fillable = [
        'id',
        'name',
        'descricao',
        'severity',
        'start_at',
        'end_at',
        'status',
    ];

    public function tasks() : HasMany
    {
        return $this->hasMany(Task::class);
    }
}
