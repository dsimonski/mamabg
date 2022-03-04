<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PregnancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'expected_date' => $this->faker
                ->dateTimeBetween('+10 days', '+9 months')
                ->format('Y-m-d'),
        ];
    }
}
