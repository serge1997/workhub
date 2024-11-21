<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
