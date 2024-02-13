<?php

namespace Database\Factories;

use App\Models\MOOEGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MOOEExpense>
 */
class MOOEExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'm_o_o_e_group_id'=> MOOEGroup::random()->first()->id,
            'title' => fake()->word(),
            'amount' => rand(100, 1000),
        ];
    }
}
