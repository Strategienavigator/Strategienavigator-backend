<?php

namespace Database\Factories;

use App\Models\Save;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaveFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Save::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'last_opened' => now(),
            'name' => $this->faker->state,
            'data' => json_encode([
                'number1' => $this->faker->randomNumber(),
                'number2' => $this->faker->randomNumber(),
                'another_section' => [
                    'number3' => $this->faker->randomNumber(),
                    'number4' => $this->faker->randomNumber()
                ]
            ]),
            'tool_id'=>Tool::all()->random(),
        ];
    }
}
