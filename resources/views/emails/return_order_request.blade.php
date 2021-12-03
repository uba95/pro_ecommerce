@component('mail::message')
# Hi {{ $return_order_request->order->user->name }},
##### Order ID #{{ $return_order_request->order_id }}
<hr><br>

@switch($return_order_request->status)
@case('pending')
<p>Your return order request has been received and is being reviewed by our team.<br></p>
@break
@case('approved')
<p>Your return order request has been approved and order items are returning process.<br></p>
@break   
@case('shipped')
<p>Your return order request items has been shipped successfully and it's on the way.<br></p>
@break        
@case('returned')
<p>Your return order request items has been returned successfully.<br></p>
@break        
@case('refunded')
<p>We’ve processed your refund, and you should expect to see the amount credited to your account in about 3 to 5 days.<br></p>
@break        
@case('rejected')
<p>We are sorry to announce that your return order request is rejected due to your violation against the Refund and Return Policy.<br></p>
@break        
@endswitch

@component('mail::button', ['url' => route('return_orders.show', $return_order_request->id), 'color' => 'success'])
View Return Order Request
@endcomponent

If you have any other questions or concerns, just reply to this email, We’ll be here to help you in any way we can.<br>
{{ config('app.name') }}
@endcomponent
