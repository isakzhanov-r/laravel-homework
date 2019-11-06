<?php

use Illuminate\Database\Seeder;
use \Illuminate\Database\Eloquent\Collection;
use \App\Models\Order;
use \App\Models\Product;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit    = 1000;
        $products = Product::query()->get();

        factory(Order::class, $limit)->create()->each(function (Order $order) use ($products) {
            $this->generateOrdersProduct($order, $products);
        });
    }

    private function generateOrdersProduct(Order $order, Collection $products)
    {
        for ($i = 0; $i < rand(1, 4); $i++) {
            $product    = $products->random();
            $quantity   = rand(1, 3);
            $price      = $product->price;
            $created_at = $order->created_at;
            $updated_at = $order->updated_at;
            $order->products()->attach(
                $product->id,
                compact('quantity', 'price', 'created_at', 'updated_at')
            );
        }
    }
}

