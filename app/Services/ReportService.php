<?php

namespace App\Services;

use App\Enums\CancelOrderStatus;
use App\Enums\ReturnOrderStatus;
use App\Models\Order;
use App\Models\Brand;
use App\Models\CancelOrderItem;
use App\Models\CancelOrderRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\ReturnOrderItem;
use App\Models\ReturnOrderRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService 
{
    public static function get($key) {
             
        switch ($key) {
          case 'sales':
            return ['name' => 'Sales' , 'value' => [
              ['class' => 'bg-primary', 'text' => 'Today\'s Sales', 
                'value' =>  '$' . Order::whereToday()->sum('total_price')
              ],
              ['class' => 'bg-teal', 'text' => 'This Month\'s Sales', 
                'value' => '$' . Order::thisMonth()->sum('total_price')
              ],
              ['class' => 'bg-purple', 'text' => 'This Year\'s Sales', 
                'value' => '$' . Order::thisYear()->sum('total_price')
              ],
              ['class' => 'bg-dark', 'text' => 'Over Time Sales', 
                'value' => '$' . Order::sum('total_price')
              ],
            ]];
            break;

          case 'returns':
            return ['name' => 'Returns' , 'value' => [
              ['class' => 'bg-primary', 'text' => 'Today\'s Returns', 
                'value' =>  '$' . self::TotalReturns('whereToday')
              ],
              ['class' => 'bg-teal', 'text' => 'This Month\'s Returns', 
                'value' => '$' . self::TotalReturns('thisMonth')
              ],
              ['class' => 'bg-purple', 'text' => 'This Year\'s Returns', 
                'value' => '$' . self::TotalReturns('thisYear')
              ],
              ['class' => 'bg-dark', 'text' => 'Over Time Returns', 
                'value' => '$' . self::TotalReturns()
              ],
            ]];
            break;

          case 'net_sales':
            return ['name' => 'Net Sales' , 'value' => [
              ['class' => 'bg-primary', 'text' => 'Today\'s Net Sales', 
                'value' =>  '$' . (Order::whereToday()->sum('total_price') - self::TotalReturns('whereToday'))              
              ],
              ['class' => 'bg-teal', 'text' => 'This Month\'s Net Sales', 
                'value' =>  '$' . (Order::thisMonth()->sum('total_price') - self::TotalReturns('thisMonth'))              
              ],
              ['class' => 'bg-purple', 'text' => 'This Year\'s Net Sales', 
                'value' =>  '$' . (Order::thisYear()->sum('total_price') - self::TotalReturns('thisYear'))              
              ],
              ['class' => 'bg-dark', 'text' => 'Over Time Net Sales', 
                'value' =>  '$' . (Order::sum('total_price') - self::TotalReturns())              
              ],
            ]];
            break;

          case 'orders':
            return ['name' => 'Orders' , 'value' => [
              ['class' => 'bg-primary', 'text' => 'Today\'s Orders', 
              'value' =>  Order::whereToday()->count()
              ],
              ['class' => 'bg-teal', 'text' => 'This Month\'s Orders', 
                'value' => Order::thisMonth()->count()
              ],
              ['class' => 'bg-purple', 'text' => 'This Year\'s Orders', 
                'value' => Order::thisYear()->count()
              ],
              ['class' => 'bg-dark', 'text' => 'Over Time Orders', 
                'value' => Order::count()
              ],
            ]];
            break;

          case 'sold_products':
            return ['name' => 'Sold Products' , 'value' => [
              ['class' => 'bg-primary', 'text' => 'Today\'s Sold Products', 
                'value' =>  OrderItem::whereToday()->sum('product_quantity')
              ],
              ['class' => 'bg-teal', 'text' => 'This Month\'s Sold Products', 
                'value' =>  OrderItem::thisMonth()->sum('product_quantity')
              ],
              ['class' => 'bg-purple', 'text' => 'This Year\'s Sold Products', 
                'value' =>  OrderItem::thisYear()->sum('product_quantity')
              ],
              ['class' => 'bg-dark', 'text' => 'Over Time Sold Products', 
                'value' =>  OrderItem::sum('product_quantity')
              ],
            ]];
            break;

          case 'others':
            return ['name' => 'Others' , 'value' => [
              ['class' => 'bg-danger', 'text' => 'Total Customers', 
                'value' =>  User::count()
              ],
              ['class' => 'bg-pink', 'text' => 'Total Products', 
                'value' =>  Product::count()
              ],
              ['class' => 'bg-info', 'text' => 'Total Categories', 
                'value' =>  Category::count()
              ],
              ['class' => 'bg-warning', 'text' => 'Total Brands', 
                'value' =>  Brand::count()
              ],
            ]];
            break;
        }
    }
    
    public static function last30Days() { 
        return [
            'Sales($)'            =>      Order::last30days()->sum('total_price'),
            'Orders'              =>      Order::last30days()->count(),
            'Sold Products'       =>      OrderItem::last30days()->sum('product_quantity'),
            'Buyers'              =>      OrderItem::selectRaw("count(distinct orders.user_id) as buyers")
                                          ->join('orders', 'order_items.order_id', 'orders.id')->last30days()->first()->buyers,
            'Billing Countries'   =>      OrderItem::selectRaw("count(distinct addresses.country_id) as countries")
                                          ->join('orders', 'order_items.order_id', 'orders.id')
                                          ->join('addresses', 'orders.address_id', 'addresses.id')
                                          ->join('countries', 'addresses.country_id', 'countries.id')
                                          ->last30days()->first()->countries,
        ];
    }

    public static function paymentMethods() {

      return [
        ['label' => 'Stripe', 'color' => '#dc3545', 
          'data' =>  Order::where('payment_method', 'Stripe')->count()
        ],
        ['label' => 'Paypal', 'color' => '#0866c6', 
          'data' =>  Order::where('payment_method', 'Paypal')->count()
        ],
        ['label' => 'Cash On Delivery', 'color' => '#6f42c1', 
          'data' =>   Order::where('payment_method', 'Cash On Delivery')->count()
        ],
      ]; 
    }

    public static function priceTotals() {

      return [
        'Subtotal Price'  =>      Order::sum('subtotal_price'),
        'Discount Price'  =>      Order::sum('discount_price'),
        'Shipping Cost'   =>      Order::sum('shipping_cost'),
        'Total Price'     =>      Order::sum('total_price'),
      ]; 
    }

    public static function mostSoldProductsThisMonth() {

      return OrderItem::with([
        'product:id,cover,product_quantity', 
        'order' => fn($q) => $q->select('id','status')->sold()
      ])
      ->selectRaw("id, product_id, order_id, product_name, SUM(product_quantity) AS sold_quantity")
      ->thisMonth()
      ->groupBy('product_id')
      ->limit(5)
      ->latest('sold_quantity')
      ->get();
  }

  public static function TotalReturns($date = null) {

    $totalCancel = CancelOrderRequest::totalCancel()->when($date, fn($q) => $q->$date())->first()->Total;

    $totalReturn = ReturnOrderRequest::totalReturn()->when($date, fn($q) => $q->$date())->first()->Total;
    return round($totalCancel + $totalReturn, 2);
  }

  public static function salesBy($from, $to) {

    $fromDate = Carbon::createFromFormat('d/m/Y', $from)->startOfDay();
    $toDate = Carbon::createFromFormat('d/m/Y', $to)->startOfDay();
       
    $totalReturn = ReturnOrderItem::totalReturn()->dateRange($fromDate, $toDate);
    
    $join = OrderItem::query()
    ->selectRaw("
      order_items.product_id, order_items.product_name,
      SUM(order_items.product_quantity) AS sold_quantity,
      SUM(order_items.product_price * order_items.product_quantity) AS sales
    ")
    ->dateRange($fromDate, $toDate)
    ->groupBy('order_items.product_id');
    
    $returns = DB::table(DB::raw("( {$totalReturn->toSql()} ) AS r"))
    ->mergeBindings($totalReturn->getQuery())
    ->groupBy('product_id');
    
    $left = self::dirJoin('LEFT', 'sub1', $join, $returns);
    $right = self::dirJoin('RIGHT', 'sub2', $join, $returns);

    return DB::table(DB::raw("({$left->toSql()} UNION ALL {$right->toSql()}) AS d")) 
    ->selectRaw('DISTINCT *') 
    ->mergeBindings($left) 
    ->mergeBindings($right) 
    ->get();
  }

  private static function dirJoin($dir, $name, $join, $returns) {
            
    return DB::table(DB::raw("
      ({$join->toSql()}) AS sub1 $dir JOIN ({$returns->toSql()}) AS sub2 
      ON `sub2`.`product_id` = `sub1`.`product_id`
    "))
    ->selectRaw("
      $name.product_id, 
      $name.product_name, 
      IFNULL(sub1.sold_quantity, 0) AS sold_quantity,
      IFNULL(sub2.tq, 0) AS returns_quantity,
      (IFNULL(sub1.sold_quantity, 0) - IFNULL(sub2.tq, 0)) AS net_quantity, 
      IFNULL(sub1.sales, 0) AS sales,
      IFNULL(sub2.total, 0) AS returns,
      (IFNULL(sub1.sales, 0) - IFNULL(sub2.total, 0)) AS net_sales
    ")
    ->mergeBindings($join->getQuery())
    ->mergeBindings($returns);
  }
}


