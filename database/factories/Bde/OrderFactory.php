<?php

namespace Database\Factories\Bde;

use App\Models\Bde\Member;
use App\Models\Bde\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::InRandomOrder()->first();

        if(rand(0, 5) != 1){
            $price = -floatval($product->price);
            $amount = fake()->numberBetween(1, 5);
            $product_id = $product->id;
        }else{
            $price = [5, 10, 20, 50][array_rand([5, 10, 20, 50])];
            $amount = 1;
            $product_id = null;
        }

        return [
            'product_id' => $product_id,
            'member_id' => Member::InRandomOrder()->first()->id,
            'price' => $price * $amount,
            'amount' => $amount,
            'date' => fake()->dateTimeBetween('-10 day', 'now'),
        ];
    }
}
