<?php

use App\Models\OrderItem;
use Illuminate\Support\Facades\Artisan;

$data = [ 'guard_name' => 'admin', 'created_at' => now(), 'updated_at' => now()];

array_map(fn($v, $data) => array_merge($v, $data),[ array_merge(array_map(fn ($v) => implode('', $v), Arr::crossJoin(['view_', 'create_', 'edit_', 'delete_'], ['admins', 'products', 'roles', 'blog_posts']) ), array_map(fn ($v) => implode('', $v), Arr::crossJoin(['view_', 'edit_', 'delete_'], ['permissions', 'categories', 'subcategories', 'brands', 'coupons', 'blog_categories']) ), array_map(fn ($v) => implode('', $v), Arr::crossJoin(['view_', 'edit_'], ['orders', 'cancel_orders', 'return_orders']) ), array_map(fn ($v) => implode('', $v), Arr::crossJoin(['view_'], ['stocks', 'reports'])))]);
