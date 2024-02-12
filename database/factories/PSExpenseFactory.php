<?php

namespace Database\Factories;

use App\Models\PSGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PSExpense>
 */
class PSExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'p_s_group_id'=> PSGroup::random()->first()->id,
            'title' => fake()->word(),
            'amount' => rand(100, 1000),
        ];
    }
}
