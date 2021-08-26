<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CancelOrderStatus;
use App\Enums\OrderStatus;
use App\Enums\ReturnOrderStatus;
use App\Http\Controllers;
use App\Models\Admin;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\User;
use App\Services\ReportService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $data = [
        'latest_orders' => [],
        'mostSoldProductsThisMonth' => [],
        'lists' => [],
        'listsNames' => [],
        'paymentMethods' => [],
      ];

      if (Auth::user()->hasPermissionTo('view orders')) {
        $data =  [
          // 'models' => ReportService::dashboardStatModels(),
          // 'modelsNames' => ['Sales',  'Orders', 'Sold Products', 'Others'],
          'latest_orders' => Order::latest('id')->limit(5)->get(),
          // 'latest_sold_order_items' => OrderItem::with('product')->latest('id')->groupBy('product_id')->limit(5)->get(['id', 'product_id', 'product_name', 'product_quantity']),
          'mostSoldProductsThisMonth' => ReportService::mostSoldProductsThisMonth(),
          'lists' => [ReportService::last30Days(), ReportService::priceTotals()],
          'listsNames' => ['Last 30 Days Totals',  'Price Totals'],
          'paymentMethods' => ReportService::paymentMethods(),
        ];
      }

      return view('admin.home', $data);
      // return view('admin.home', [
      //   'overtime_sales' => Order::sold()->sum('total_price'),
      //   'year_sales' => Order::sold()->thisYear()->sum('total_price'),
      //   'month_sales' => Order::sold()->thisYear()->whereMonth('created_at', now()->month)->sum('total_price'),
      //   'today_sales' => Order::sold()->whereDate('created_at', today())->sum('total_price'),
      //   'total_products' => Product::count(),
      //   'total_orders' => Order::count(),
      //   'total_users' => User::count(),
      //   'latest_users' => User::latest('id')->limit(5)->get(),
      //   'latest_sold_order_items' => OrderItem::latest('id')->groupBy('product_id')->limit(5)->get(['id', 'product_id', 'product_name', 'product_quantity']),
      // ]);
      // $orders_year = Order::whereNotEnum('status', ['pending', 'canceled'])
      // ->whereYear('created_at', now()->year)
      // ->get(['id', 'created_at','total_price']);
      // return view('admin.home', [
      //   'year_sales' => $orders_year->sum->total_price,
      //   'month_sales' => $orders_year->filter(fn($v) => $v->created_at->isCurrentMonth())->sum->total_price,
      //   'week_sales' => $orders_year->filter(fn($v) => $v->created_at->isCurrentWeek())->sum->total_price,
      //   'today_sales' => $orders_year->filter(fn($v) => $v->created_at->isToday())->sum->total_price,
      // ]);
    }
}
