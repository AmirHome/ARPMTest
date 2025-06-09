<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Carbon;

class DemoOrderSeeder extends Seeder
{
    public function run(): void
    {
        // Create customers
        $customer1 = Customer::create(['name' => 'John Doe']);
        $customer2 = Customer::create(['name' => 'Jane Smith']);

        // Create products
        $product1 = Product::create(['name' => 'Laptop', 'price' => 1200]);
        $product2 = Product::create(['name' => 'Mouse', 'price' => 25]);
        $product3 = Product::create(['name' => 'Keyboard', 'price' => 60]);

        // Create orders
        $order1 = Order::create([
            'customer_id' => $customer1->id,
            'status' => 'completed',
            'created_at' => Carbon::now()->subDays(2),
            'completed_at' => Carbon::now()->subDay(),
        ]);
        $order2 = Order::create([
            'customer_id' => $customer2->id,
            'status' => 'pending',
            'created_at' => Carbon::now()->subDay(),
            'completed_at' => null,
        ]);

        // Add cart items
        CartItem::create([
            'order_id' => $order1->id,
            'product_id' => $product1->id,
            'quantity' => 1,
            'price' => 1200,
            'created_at' => Carbon::now()->subDays(2)->addHour(),
        ]);
        CartItem::create([
            'order_id' => $order1->id,
            'product_id' => $product2->id,
            'quantity' => 2,
            'price' => 25,
            'created_at' => Carbon::now()->subDays(2)->addHours(2),
        ]);
        CartItem::create([
            'order_id' => $order2->id,
            'product_id' => $product3->id,
            'quantity' => 1,
            'price' => 60,
            'created_at' => Carbon::now()->subDay()->addHour(),
        ]);
    }
}
