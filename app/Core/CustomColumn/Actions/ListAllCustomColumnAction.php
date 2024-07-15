<?php
namespace App\Core\CustomColumn\Actions;

use App\Models\CustomColumn;

final class ListAllCustomColumnAction
{

    public function handle()
    {
        return CustomColumn::query()
            ->where('deleted_at', null)
                ->get();
    }
}
