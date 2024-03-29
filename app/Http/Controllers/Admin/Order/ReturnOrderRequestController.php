<?php

namespace App\Http\Controllers\Admin\Order;

use App\Enums\OrderStatus;
use App\Enums\ReturnOrderStatus;
use Illuminate\Http\Request;
use App\Models\ReturnOrderRequest;
use App\Http\Controllers\Controller;
use App\Mail\ReturnOrderMail;
use App\Services\AjaxDatatablesService;
use Illuminate\Support\Facades\Mail;
use Spatie\Enum\Laravel\Rules\EnumRule;

class ReturnOrderRequestController extends Controller
{
    public function __construct() {
        $this->middleware('can:view orders',    ['only' => ['index', 'show']]);
        $this->middleware('can:edit orders',    ['only' => ['update']]);
    }

    public function index(Request $request) {
        $returnOrders = ReturnOrderRequest::with(
            'order:id,user_id,status,created_at',
            'order.user:id,name'
        )->select('return_order_requests.*');

        $return_order_requests = $request->status && in_array($request->status, ReturnOrderStatus::getValues())
        ? $returnOrders->whereEnum('status', $request->status)
        : $returnOrders;

        return  request()->expectsJson() 
                ? AjaxDatatablesService::return_order_requests($return_order_requests) 
                : view('admin.orders.return_order_requests');
    }

    public function show(ReturnOrderRequest $returnOrder) {
        $returnOrderItems = $returnOrder->returnOrderItems->load('orderItem');
        return view('admin.orders.return_order_show', compact('returnOrder', 'returnOrderItems')); 
    }    

    public function update(ReturnOrderRequest $returnOrder, Request $request) {

        $validated = $request->validate(['status' => new EnumRule(ReturnOrderStatus::class)]);
        $request->status == 'shipped' ? $returnOrder->update(['shipping_started_at' => now()]) : '';
        $request->status == 'returned' ? $returnOrder->update(['shipping_returned_at' => now()]) : '';
        $returnOrder->update(['status' => $validated['status']]);
        $msg = toastNotification('Request', 'updated');

        if ($request->status == 'approved') {
            $returnOrder->order()->update(['status' => OrderStatus::returning()->getIndex()]);
            $msg = toastNotification('Request Is Approved And Order Is In Returning Process');
        }

        if ($request->status == 'returned') {
            $returnOrder->order->update(['status' =>  $returnOrder->order->returnStatus()->getIndex()]);
            $msg = toastNotification('Order Is Returned');
        }

        Mail::to($returnOrder->order->user->email)->send(new ReturnOrderMail($returnOrder));
    
        return redirect()->route('admin.return_orders.index')->with($msg);
    }
}