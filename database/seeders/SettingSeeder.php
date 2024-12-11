<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Mantax559\LaravelSettings\Enums\SettingTypeEnum;
use Mantax559\LaravelSettings\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'key' => 'paginate',
                'value' => '100',
                'type' => SettingTypeEnum::Integer,
            ],
            [
                'key' => 'on_each_side',
                'value' => '1',
                'type' => SettingTypeEnum::Integer,
            ],
        ];

        foreach ($data as $item) {
            if (! Setting::where('key', $item['key'])->exists()) {
                Setting::set($item['key'], $item['value'], $item['type']);
            }
        }
    }
}
