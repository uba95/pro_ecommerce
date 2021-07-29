<?php

use App\Models\CancelOrderItem;
use App\Models\OrderItem;
use App\Models\ReturnOrderItem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

$totalCancel = App\Models\CancelOrderItem::totalCancel()->dateRange($fromDate, $toDate);
$totalReturn = App\Models\ReturnOrderItem::totalReturn()->dateRange($fromDate, $toDate);

$join = OrderItem::query()
->selectRaw("
  order_items.product_id,
  SUM(order_items.product_quantity) AS sold_quantity,
  SUM(order_items.product_price * order_items.product_quantity) AS sales
")
->dateRange($fromDate, $toDate)
->groupBy('order_items.product_id');

$returns = DB::table(DB::raw("(
  {$totalCancel->toSql()}
    UNION ALL
  {$totalReturn->toSql()}
  ) AS r
"))
->selectRaw('r.product_id,  SUM(tq) AS returns_quantity, SUM(total) AS returns')
->mergeBindings($totalCancel->getQuery())
->mergeBindings($totalReturn->getQuery())
->groupBy('product_id');

$left = DB::table(DB::raw("
    ({$join->toSql()}) AS sub1 LEFT JOIN ({$returns->toSql()}) AS sub2 
    ON `sub2`.`product_id` = `sub1`.`product_id`
"))
->selectRaw('
    sub1.product_id, 
    sub1.sold_quantity,
    sub2.returns_quantity,
    (IFNULL(sub1.sold_quantity, 0) - IFNULL(sub2.returns_quantity, 0)) AS net_quantity, 
    sub1.sales,
    sub2.returns AS returns,
   (IFNULL(sub1.sales, 0) - IFNULL(sub2.returns, 0)) AS net_sales
')
->mergeBindings($join->getQuery())
->mergeBindings($returns);

$right = DB::table(DB::raw("
    ({$join->toSql()}) AS sub1 RIGHT JOIN ({$returns->toSql()}) AS sub2 
    ON `sub2`.`product_id` = `sub1`.`product_id`
"))
->selectRaw('
    sub2.product_id, 
    sub1.sold_quantity,
    sub2.returns_quantity,
    (IFNULL(sub1.sold_quantity, 0) - IFNULL(sub2.returns_quantity, 0)) AS net_quantity, 
    sub1.sales,
    sub2.returns AS returns,
   (IFNULL(sub1.sales, 0) - IFNULL(sub2.returns, 0)) AS net_sales
')
->mergeBindings($join->getQuery())
->mergeBindings($returns);

return DB::table(DB::raw("({$left->toSql()} UNION ALL {$right->toSql()}) AS d")) 
->selectRaw('DISTINCT *') 
->mergeBindings($left->getQuery()) 
->mergeBindings($right->getQuery()) 
->get();