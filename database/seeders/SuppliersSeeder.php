<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SuppliersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        // Seed 10 unique suppliers
        for ($i = 0; $i < 10; $i++) {
            Supplier::create([
                'uuid' => $faker->uuid,
                'code' => $faker->unique()->randomNumber(5, true),
                'slug' => Str::slug($faker->name),
                'name' => $faker->name,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
            ]);
        }
    }
}
