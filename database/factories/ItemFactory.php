<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'sell_in' => $this->faker->numberBetween(1, 30),
            'quality' => $this->faker->numberBetween(0, 50),
            'img_url' => $this->faker->imageUrl(),
        ];
    }
}
