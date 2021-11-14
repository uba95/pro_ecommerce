<?php

namespace App\Services;

use App\Enums\CancelOrderStatus;
use App\Enums\OrderStatus;
use App\Enums\ProductStatus;
use App\Enums\ReturnOrderStatus;
use App\Models\Order;
use Illuminate\Support\Str;
use Barryvdh\Debugbar\Facade as Debugbar;

class AjaxDatatablesService {

    private static $view = 'components.admin.ajax_datatables';
    
    public static function products($products) {

        return datatables($products)

        ->addColumn('status', fn($v) => view(self::$view, [
            'column' => 'status',
            'status' => $v->status,
        ])->render())
        ->orderColumn('status', 'status $1')
        ->filterColumn('status', fn($q, $keyword) => 
            $q->whereEnum('status', array_filter(ProductStatus::getValues(), fn($v) => stristr($v, $keyword)))
        )

        ->addColumn('cover', fn($v) => view(self::$view, [
            'column' => 'cover',
            'cover' => $v->cover,
        ])->render())

        ->addColumn('action', fn($v) => view(self::$view, [
            'column' => 'action',
            'route' => 'products',
            'permissions' => ['view' => 'view products', 'edit' => 'edit products', 'delete' => 'delete products'],
            'model' => $v,
        ])->render())

        ->rawColumns(['cover', 'status', 'action'])
        ->make(true);
    }

    public static function orders($orders) {
     
        return datatables($orders)

        ->addColumn('show', fn($v) =>  'Order#'. $v->id)
        ->orderColumn('show', 'id $1')
        ->filterColumn('show', fn($q, $keyword) =>
            $q->where('orders.id', 'LIKE', ["%{$keyword}%"])
        )

        ->addColumn('status', fn($v) => view(self::$view, [
            'column' => 'status',
            'order' => $v,
        ])->render())
        ->orderColumn('status', 'status $1')
        ->filterColumn('status', fn($q, $keyword) => 
            $q->whereEnum('status', array_filter(OrderStatus::getValues(), fn($v) => stristr($v, $keyword)))
        )

        ->addColumn('total_price', fn($v) => view(self::$view, [
            'column' => 'total_price',
            'total_price' => $v->total_price,
        ])->render())
        ->orderColumn('total_price', 'total_price $1')
        ->filterColumn('total_price', fn($q, $keyword) => 
            $q->where('total_price', 'LIKE', ["%{$keyword}%"])
        )

        ->addColumn('action', fn($v) => view(self::$view, [
            'column' => 'action',
            'route' => 'orders',
            'permissions' => ['view' => 'view orders'],
            'model' => $v,
        ])->render())

        ->rawColumns(['show', 'status', 'total_price', 'action'])
        ->make(true);
    }

    public static function cancel_order_requests($cancel_order_requests) {

        return datatables($cancel_order_requests)

        ->addColumn('request_show', fn($v) => 'Request#'. $v->id)
        ->orderColumn('request_show', 'id $1')
        ->filterColumn('request_show', fn($q, $keyword) =>
            $q->where('cancel_order_requests.id', 'LIKE', ["%{$keyword}%"])
        )

        ->addColumn('order_show', fn($v) => 'Order#'. $v->order_id)
        ->orderColumn('order_show', 'order_id $1')
        ->filterColumn('order_show', fn($q, $keyword) =>
            $q->where('cancel_order_requests.order_id', 'LIKE', ["%{$keyword}%"])
        )

        ->addColumn('request_status', fn($v) => view(self::$view, [
            'column' => 'status',
            'cancelRequest' => $v,
        ])->render())
        ->orderColumn('request_status', 'status $1')
        ->filterColumn('request_status', fn($q, $keyword) => 
            $q->whereEnum('status', array_filter(CancelOrderStatus::getValues(), fn($v) => stristr($v, $keyword)))
        )
            
        ->addColumn('order_status', fn($v) => view(self::$view, [
            'column' => 'status',
            'order' => $v->order,
        ])->render())
        ->orderColumn('order_status', fn($q, $order) =>
            $q->leftJoin('orders', 'orders.id', 'cancel_order_requests.order_id')
            ->orderBy('orders.status', $order)
        )
        ->filterColumn('order_status', fn($q, $keyword) => 
            $q->whereExists(fn($q) =>
                $q->select('status')
                ->from('orders')
                ->whereRaw('`cancel_order_requests`.`order_id` = `orders`.`id`')
                ->whereIn('status', array_keys(array_filter(OrderStatus::getValues(), fn($v) => stristr($v, $keyword))))
            )
        )

        ->addColumn('action', fn($v) => view(self::$view, [
            'column' => 'action',
            'route' => 'cancel_orders',
            'permissions' => ['view' => 'view orders'],
            'model' => $v,
        ])->render())

        ->rawColumns(['request_show', 'order_show', 'request_status', 'order_status', 'action'])
        ->make(true);
    }

    public static function return_order_requests($return_order_requests) {

        return datatables($return_order_requests)

        ->addColumn('request_show', fn($v) => 'Request#'. $v->id)
        ->orderColumn('request_show', 'id $1')
        ->filterColumn('request_show', fn($q, $keyword) =>
            $q->where('return_order_requests.id', 'LIKE', ["%{$keyword}%"])
        )

        ->addColumn('order_show', fn($v) => 'Order#'. $v->order_id)
        ->orderColumn('order_show', 'order_id $1')
        ->filterColumn('order_show', fn($q, $keyword) =>
            $q->where('return_order_requests.order_id', 'LIKE', ["%{$keyword}%"])
        )

        ->addColumn('request_status', fn($v) => view(self::$view, [
            'column' => 'status',
            'returnRequest' => $v,
        ])->render())
        ->orderColumn('request_status', 'status $1')
        ->filterColumn('request_status', fn($q, $keyword) => 
            $q->whereEnum('status', array_filter(ReturnOrderStatus::getValues(), fn($v) => stristr($v, $keyword)))
        )
            
        ->addColumn('order_status', fn($v) => view(self::$view, [
            'column' => 'status',
            'order' => $v->order,
        ])->render())
        ->orderColumn('order_status', fn($q, $order) =>
            $q->leftJoin('orders', 'orders.id', 'return_order_requests.order_id')
            ->orderBy('orders.status', $order)
        )
        ->filterColumn('order_status', fn($q, $keyword) => 
            $q->whereExists(fn($q) =>
                $q->select('status')
                ->from('orders')
                ->whereRaw('`return_order_requests`.`order_id` = `orders`.`id`')
                ->whereIn('status', array_keys(array_filter(OrderStatus::getValues(), fn($v) => stristr($v, $keyword))))
            )
        )

        ->addColumn('action', fn($v) => view(self::$view, [
            'column' => 'action',
            'route' => 'return_orders',
            'permissions' => ['view' => 'view orders'],
            'model' => $v,
        ])->render())

        ->rawColumns(['request_show', 'order_show', 'request_status', 'order_status', 'request_created_at', 'order_created_at', 'action'])
        ->make(true);
    }

    public static function customers($customers) {

        return datatables($customers)

        ->addColumn('action', fn($v) => view(self::$view, [
            'column' => 'action',
            'route' => 'customers',
            'permissions' => ['delete' => 'delete customers'],
            'model' => $v,
        ])->render())

        ->rawColumns(['action'])
        ->make(true);
    }

    public static function stocks($products) {
        
        return datatables($products)

        ->addColumn('action', fn($v) => view(self::$view, [
            'column' => 'action',
            'route' => 'products',
            'permissions' => ['view' => 'view products'],
            'model' => $v,
        ])->render())

        ->rawColumns(['action'])
        ->make(true);
    }

    public static function salesBy($products) {

        return datatables($products)

        ->addColumn('action', fn($v) => view(self::$view, [
            'column' => 'action',
            'route' => 'products',
            'permissions' => ['view' => 'view products'],
            'model' => $v,
        ])->render())

        ->rawColumns(['action'])
        ->make(true);
    }

    public static function newslaters($newslaters) {

        return datatables($newslaters)

        ->addColumn('action', fn($v) => view(self::$view, [
            'column' => 'action',
            'route' => 'newslaters',
            'permissions' => ['delete' => 'delete newslaters'],
            'model' => $v,
        ])->render())

        ->rawColumns(['action'])
        ->make(true);
    }

    public static function contactMessages($messages) {

        return datatables($messages)

        ->setRowAttr([
            'style' => fn($v) =>!$v->replied ? 'background-color:#c4f9f9 !important' : '',
        ])

        ->addColumn('name', fn($v) => ucwords($v->name))
        ->orderColumn('name', 'name $1')
        ->filterColumn('name', fn($q, $keyword) => 
            $q->where('name', 'LIKE', ["%{$keyword}%"])
        )

        ->addColumn('subject', fn($v) => Str::limit($v->subject, 30))
        ->orderColumn('subject', 'subject $1')
        ->filterColumn('subject', fn($q, $keyword) => 
            $q->where('subject', 'LIKE', ["%{$keyword}%"])
        )

        ->addColumn('action', fn($v) => view(self::$view, [
            'column' => 'action',
            'route' => 'contact.messages',
            'permissions' => ['reply' => 'reply contact messages', 'delete' => 'delete contact messages'],
            'model' => $v,
        ])->render())

        ->rawColumns(['show', 'name', 'subject', 'action'])
        ->make(true);
    }
}