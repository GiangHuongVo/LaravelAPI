<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Faker does the name randomly
        $type = $this->faker->randomElement(['I', 'B']);
        $name = $type == 'I' ? $this->faker->name() : $this->faker->company();

        return [
            'name'=>$name,
            'type'=>$type,
            'email'=>$this->faker->email(),
            'address'=>$this->faker->address(),
            'city'=>$this->faker->city(),
            'state'=>$this->faker->state(),
            'post_code'=>$this->faker->postcode()
        ];
    }
}
