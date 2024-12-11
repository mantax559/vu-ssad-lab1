<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@admin.admin',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($data as $item) {
            if (! User::where('id', $item['id'])->exists()) {
                User::create($item);
            }
        }
    }
}
