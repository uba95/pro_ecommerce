<?php

use App\Models\OrderItem;
use Illuminate\Support\Facades\Artisan;

Artisan::call('dump:q');

$Sales = OrderItem::query()
->selectRaw("order_items.product_id, SUM(order_items.product_price * order_items.product_quantity) AS Sales")
->groupBy('order_items.product_id')
->get();


