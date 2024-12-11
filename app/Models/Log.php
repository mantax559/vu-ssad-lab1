<?php

namespace App\Models;

use App\Enums\LogStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    const CODE_LENGTH = 10;

    protected $fillable = [
        'status',
        'code',
        'description',
    ];

    protected $casts = [
        'status' => LogStatusEnum::class,
    ];

    public $timestamps = true;

    public static function success(string $description): string
    {
        return (new LogService)->store($description, LogStatusEnum::Success)->code;
    }

    public static function warning(string $description): string
    {
        return (new LogService)->store($description, LogStatusEnum::Warning)->code;
    }

    public static function error(string $description): string
    {
        return (new LogService)->store($description, LogStatusEnum::Error)->code;
    }
}
