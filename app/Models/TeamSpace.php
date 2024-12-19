<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamSpace extends Model
{
    use HasFactory;

    protected $table = "teams_spaces";
    protected $fillable = [
        'id',
        'name',
        'description',
        'created_by'
    ];

    public function users() : HasMany
    {
        return $this->hasMany(User::class, 'team_id');
    }
}
