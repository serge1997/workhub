<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomColumn extends Model
{
    use HasFactory;

    protected $table ="custom_columns";


    protected $fillable = [
        'label',
        'description',
        'deleted_at'
    ];

    public function customColumnValue() : HasMany
    {
        return $this->hasMany(CustomsColumnsValue::class, 'custom_column_id');
    }
}
