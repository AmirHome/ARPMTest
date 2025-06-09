<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    public function index()
    {
        $cacheKey = 'orders_index_data';

        $orderData = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            $ordersData = collect(); // Initialize an empty collection

            Order::with(['customer', 'items.product'])
                ->chunk(500, function ($orders) use ($ordersData) {
                    $orderIds = $orders->pluck('id');

                    $lastAddedCartItems = CartItem::whereIn('order_id', $orderIds)
                        ->selectRaw('order_id, MAX(created_at) as last_added')
                        ->groupBy('order_id')
                        ->pluck('last_added', 'order_id');

                    $completedOrdersIds = Order::whereIn('id', $orderIds)
                        ->where('status', 'completed')
                        ->pluck('id')
                        ->flip(); // Convert to array

                    $chunkData = $orders->map(function ($order) use ($lastAddedCartItems, $completedOrdersIds) {
                        return [
                            'order_id' => $order->id,
                            'customer_name' => $order->customer->name,
                            'total_amount' => $order->items->sum(fn($item) => $item->price * $item->quantity),
                            'items_count' => $order->items->count(),
                            'last_added_to_cart' => $lastAddedCartItems[$order->id] ?? null,
                            'completed_order_exists' => isset($completedOrdersIds[$order->id]),
                            'created_at' => $order->created_at,
                            'completed_at' => $order->completed_at,
                        ];
                    });

                    $ordersData->push(...$chunkData);
                });
            // usort on Eloquent
            return $ordersData->sortByDesc('completed_at')->values()->all();
        });

        return view('orders.index', ['orders' => $orderData]);
    }
}
