<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Seeder Chunk Size
    |--------------------------------------------------------------------------
    |
    | This value determines the number of records that will be inserted per
    | batch when seeding the database. You can adjust this value depending
    | on your system's memory or database constraints.
    |
    */
    'chunk_size' => 1000,

    /*
    |--------------------------------------------------------------------------
    | Seeder Multiplier
    |--------------------------------------------------------------------------
    |
    | This multiplier is used to increase or decrease the number of records
    | that are seeded for each model. For example, a multiplier of 1 will seed
    | the default amount, but setting it to 5 will seed 5 times the default amount.
    |
    */
    'multiplier' => 1,

    /*
    |--------------------------------------------------------------------------
    | Seeder Base Sizes
    |--------------------------------------------------------------------------
    |
    | Define the base number of records to seed for each model. These values
    | will be multiplied by the seeder multiplier to determine the final count
    | of records to insert into the database.
    |
    */
    'base_seeding_sizes' => [
        'suppliers' => 200,
    ],
];
