<?php
namespace App\Core\CustomColumnsValue\Actions;

use App\Models\CustomColumnsValue;

final class UpdateCustomColumnsValueAction
{
    public function __construct(
        private CustomColumnsValue $customColumnsValue,
        private mixed $request
    )
    {}

    public function handle()
    {
        $this->customColumnsValue->update([
            'value' => $this->request->value
        ]);
    }
}
