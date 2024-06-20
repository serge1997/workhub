<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'user_name',
        'password',
        'banned_at',
        'banned_reason',
        'position_id',
        'department_id',
        'manager_id',
        'avatar',
        'user_type'
    ];

    public function isBanned(): bool
    {
        return $this->banned_at !== null;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function department() : BelongsTo
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function taskUser() : HasMany
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    public function taskManager() : HasMany
    {
        return $this->hasMany(Task::class, 'manager_id');
    }

    public function latestTasks()
    {
        return $this->taskUser()->count();
    }
}
