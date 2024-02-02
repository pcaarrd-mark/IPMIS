<?php

namespace Database\Factories;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Product::class;

    public function definition()
    {
        return [
            'product_desc' => $this->faker->text,
            'product_amt' => $this->faker->numberBetween($min = 100, $max = 1000),
            'product_barcode' => $this->faker->numberBetween($min = 10000000, $max = 20000000)
        ];
    }
}
