<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class SelectHelper
{
    public static function booleanOptions(): Collection
    {
        return collect([
            [
                'id' => '1',
                'text' => __('Yes'),
            ],
            [
                'id' => '0',
                'text' => __('No'),
            ],
        ]);
    }
}
