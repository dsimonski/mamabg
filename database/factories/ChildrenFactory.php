<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChildrenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'birthday' => $this->faker
                ->dateTimeBetween('-20 years', '-1 week')
                ->format('Y-m-d'),
            'gender' => $this->faker->randomElement(
                array_keys(config('mamabg.childrenGenders'))
            ),
        ];
    }
}
