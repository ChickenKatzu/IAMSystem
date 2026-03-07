<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'category' => fake()->randomElement(['Electronics', 'Furniture', 'Stationery', 'Appliances']),
            'sku' => strtoupper(fake()->bothify('???-#####')),
            'quantity' => fake()->numberBetween(0, 100),
            'price' => fake()->randomFloat(2, 10, 1000),
            'supplier' => fake()->company(),
            'description' => fake()->sentence()
        ];
    }
}
