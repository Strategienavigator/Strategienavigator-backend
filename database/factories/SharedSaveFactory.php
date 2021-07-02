<?php

namespace Database\Factories;

use App\Models\SharedSave;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SharedSaveFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SharedSave::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'permission'=>$this->faker->numberBetween(0,3),
            'accepted'=>$this->faker->boolean(70),
        ];
    }
}
