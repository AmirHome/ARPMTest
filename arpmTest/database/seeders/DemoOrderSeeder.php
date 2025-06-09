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

        // More customers
        $customer3 = Customer::create(['name' => 'Alice Johnson']);
        $customer4 = Customer::create(['name' => 'Bob Lee']);
        $customer5 = Customer::create(['name' => 'Charlie Brown']);

        // Create products
        $product1 = Product::create(['name' => 'Laptop', 'price' => 1200, 'code' => 'LAP123']);
        $product2 = Product::create(['name' => 'Mouse', 'price' => 25, 'code' => 'MOU456']);
        $product3 = Product::create(['name' => 'Keyboard', 'price' => 60, 'code' => 'KEY789']);

        // More products
        $product4 = Product::create(['name' => 'Monitor', 'price' => 300, 'code' => 'MON321']);
        $product5 = Product::create(['name' => 'USB Cable', 'price' => 10, 'code' => 'USB654']);
        $product6 = Product::create(['name' => 'Desk Lamp', 'price' => 45, 'code' => 'LAM987']);

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

        // More orders
        $order3 = Order::create([
            'customer_id' => $customer3->id,
            'status' => 'completed',
            'created_at' => Carbon::now()->subDays(5),
            'completed_at' => Carbon::now()->subDays(4),
        ]);
        $order4 = Order::create([
            'customer_id' => $customer4->id,
            'status' => 'pending',
            'created_at' => Carbon::now()->subDays(3),
            'completed_at' => null,
        ]);
        $order5 = Order::create([
            'customer_id' => $customer5->id,
            'status' => 'completed',
            'created_at' => Carbon::now()->subDays(7),
            'completed_at' => Carbon::now()->subDays(6),
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

        // More cart items
        CartItem::create([
            'order_id' => $order3->id,
            'product_id' => $product4->id,
            'quantity' => 2,
            'price' => 300,
            'created_at' => Carbon::now()->subDays(5)->addHour(),
        ]);
        CartItem::create([
            'order_id' => $order3->id,
            'product_id' => $product5->id,
            'quantity' => 5,
            'price' => 10,
            'created_at' => Carbon::now()->subDays(5)->addHours(2),
        ]);
        CartItem::create([
            'order_id' => $order4->id,
            'product_id' => $product6->id,
            'quantity' => 1,
            'price' => 45,
            'created_at' => Carbon::now()->subDays(3)->addHour(),
        ]);
        CartItem::create([
            'order_id' => $order5->id,
            'product_id' => $product1->id,
            'quantity' => 1,
            'price' => 1200,
            'created_at' => Carbon::now()->subDays(7)->addHour(),
        ]);
        CartItem::create([
            'order_id' => $order5->id,
            'product_id' => $product2->id,
            'quantity' => 3,
            'price' => 25,
            'created_at' => Carbon::now()->subDays(7)->addHours(2),
        ]);
    }
}
