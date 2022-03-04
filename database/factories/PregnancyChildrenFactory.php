<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PregnancyChildrenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'gender' => $this->faker->randomElement(
                array_keys(config('mamabg.pregnancyChildrenGenders'))
            ),
        ];
    }
}
