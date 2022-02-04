<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'title' => $this->faker->words(2, true),
            'price' => $this->faker->randomFloat(2, 20, 1000),
            'excerpt' => $this->faker->text(),
            'isbn' => $this->faker->numerify('##-###-####-#'),
            'language' => $this->faker->randomElement(['English', 'Portuguese']),
            'pages' => $this->faker->randomNumber(4),
            'edition' => $this->faker->numberBetween(1, 20),
        ];
    }
}
