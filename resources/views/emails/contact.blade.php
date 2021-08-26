@component('mail::message')
# Hi {{ $name }} !

<p>
    Your request has been received and is being reviewed by our support team.<br>
    To add additional comments, reply to this email.
</p><br><br>

Thanks for contacting us,<br>
{{ config('app.name') }}
@endcomponent