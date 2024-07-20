<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomColumnsValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'custom_column_id',
        'task_id'
    ];

    protected $table = 'customs_columns_values';

    public function task() : BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function customColumn() : BelongsTo
    {
        return $this->belongsTo(CustomColumn::class, 'custom_column_id');
    }
}
