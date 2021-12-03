@component('mail::message')
# Hi {{ $cancel_order_request->order->user->name }},
##### Order ID #{{ $cancel_order_request->order_id }}
<hr><br>

@switch($cancel_order_request->status)
@case('pending')
<p>Your cancel order request has been received and is being reviewed by our team.<br></p>
@break
@case('approved')
<p>Your cancel order request has been approved and order items are canceled.<br></p>
@break        
@case('refunded')
<p>We’ve processed your refund, and you should expect to see the amount credited to your account in about 3 to 5 days.<br></p>
@break        
@case('rejected')
<p>We are sorry to announce that your cancel order request is rejected due to your violation against the Refund and Return Policy.<br></p>
@break        
@endswitch

@component('mail::button', ['url' => route('cancel_orders.show', $cancel_order_request->id), 'color' => 'success'])
View Cancel Order Request
@endcomponent

If you have any other questions or concerns, just reply to this email, We’ll be here to help you in any way we can.<br>
{{ config('app.name') }}
@endcomponent



