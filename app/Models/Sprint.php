<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    protected function startAt() : Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => !empty($value) ? date('Y-m-d', strtotime(substr($value, 0, 11))) : null
        );
    }

    public function closeAt() : Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => !empty($value) ? date('Y-m-d', strtotime(substr($value, 0, 11))) : null
        );
    }

    public function name() : Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtolower($value)
        );
    }

    public function tasks() : HasMany
    {

        return $this->hasMany(Task::class, 'sprint_id');
    }
}
