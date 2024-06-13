<?php
namespace App\Utility;

use Carbon\Carbon;

class Utilities
{

    public static function now() : string
    {
        return Carbon::now()->isoFormat('Y-MM-DD HH:mm');
    }
}
