<?php

namespace App\Enums;

use Mantax559\LaravelHelpers\Traits\EnumTrait;

enum LogStatusEnum: string
{
    use EnumTrait;

    case Success = 'success';
    case Warning = 'warning';
    case Error = 'error';
}
