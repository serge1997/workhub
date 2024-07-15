<?php
namespace App\Core\CustomColumn\Actions;

use App\Models\CustomColumn;

final class CreateCustomColumnAction
{
    public static function run($request)
    {
        return CustomColumn::query()->create([
            'label' => $request->label(),
            'description' => $request->description()
        ]);
    }
}
