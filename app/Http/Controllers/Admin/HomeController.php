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
        'latest_orders' => collect(),
        'mostSoldProductsThisMonth' => collect(),
        'priceTotals' => collect(),
        'paymentMethods' => collect(),
        'last30Days' => collect(),
        'salesLast30Days' => collect(),
      ];

      if (Auth::user()->can('view orders')) {
        $data =  [
          'latest_orders' => Order::latest('id')->limit(5)->get(),
          'mostSoldProductsLast30Days' => ReportService::mostSoldProducts(),
          'priceTotals' => ReportService::priceTotals(),
          'paymentMethods' => ReportService::paymentMethods(),
          'last30Days' => ReportService::last30Days(),
          'salesLast30Days' =>  ReportService::last30days(true),
        ];
      }

      return view('admin.home', $data);
    }
}
