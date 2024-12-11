<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        for ($index = 1; $index <= config('seeder.base_seeding_sizes.suppliers') * config('seeder.multiplier'); $index++) {
            $data[] = [
                'name' => fake()->company(),
                'code' => fake()->unique()->bothify('#########'),
                'vat_code' => fake()->optional()->bothify('LT#########'),
                'address' => fake()->address(),
                'responsible_person' => fake()->name(),
                'contact_person' => fake()->name(),
                'contact_phone' => fake()->phoneNumber(),
                'alternate_contact_phone' => fake()->optional()->phoneNumber(),
                'email' => fake()->unique()->safeEmail(),
                'alternate_email' => fake()->optional()->safeEmail(),
                'billing_email' => fake()->unique()->safeEmail(),
                'alternate_billing_email' => fake()->optional()->safeEmail(),
                'certificate_code' => fake()->uuid(),
                'is_fsc' => fake()->boolean(),
                'validation_date' => fake()->dateTimeBetween('-1 year'),
                'expiry_date' => fake()->dateTimeBetween('now', '+2 years'),
                'comments' => fake()->optional()->text(),
            ];
        }

        foreach (array_chunk(unique_array($data, 'code'), config('seeder.chunk_size')) as $data) {
            Supplier::insert($data);
        }
    }
}
