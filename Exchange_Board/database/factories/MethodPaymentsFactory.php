<?php

namespace Database\Factories;

use App\Models\MethodPayments;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MethodPayments>
 */
class MethodPaymentsFactory extends Factory
{
    protected $model = MethodPayments::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_method' => $this->faker->word,
            'currency' => $this->faker->word,
        ];
    }
}
