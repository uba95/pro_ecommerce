<?php

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Artisan;

$order  =  Order::with('orderItems')->where('id', 143)->whereEnum('status', ['pending', 'paid'])->first();
$orderItems = $order->orderItems->whereIn('id', [374]);
$cancel_order_items = OrderItem::cancelableQuantitiesRequset($orderItems, [1]);
$remainingItems = OrderItem::remainingQuantities($order->orderItems, $cancel_order_items);