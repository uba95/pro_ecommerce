@component('mail::message')
# Hi {{ $order->user->name }},

@switch($order->status)
@case('pending')
<p>Your order has been placed and is being reviewed by our team.<br></p>
@break
@case('paid')
<p>Your order has been paid successfully and it's in shipping process.<br></p>
@break        
@case('shipped')
<p>Your order has been shipped successfully and it's on the way.<br></p>
@break        
@case('delivered')
<p>Your order has been delivered successfully.<br></p>
@break        
@case('canceled')
<p>
    Your order has been canceled<br>
    To add additional comments, reply to this email.
</p>
@break        
@endswitch

@component('mail::button', ['url' => route('orders.show', $order->id), 'color' => 'success'])
View Order
@endcomponent

{{ config('app.name') }}
@endcomponent
