<?php
namespace App\Core\CustomColumn\Actions;

use App\Models\CustomColumn;

final class ListCustomColumnByTaskAction
{

    public function handle($request)
    {
        return CustomColumn::whereNotIn('id', function($query) use($request){
            $query->select('custom_column_id')
                ->from('customs_columns_values')
                    ->where('task_id', $request->task_id);
        })->get();
    }
}
