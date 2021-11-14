<div class="newsletter">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
                    <div class="newsletter_title_container">
                        <div class="newsletter_icon"><img src="{{ asset('frontend/images/send.png')}}" alt=""></div>
                        <div class="newsletter_title">Sign up for Newsletter</div>
                        <div class="newsletter_text"><p>...and receive %20 coupon for first shopping.</p></div>
                    </div>
                    <div class="newsletter_content clearfix">
                        <form action='{{ route('newslaters.store') }}' method="POST" class="newsletter_form">
                            @csrf
                            <input name="email" type="email" class="newsletter_input" required="required" placeholder="Enter your email address">
                            <button onclick="storeNewslater(event)" class="newsletter_button">Subscribe</button>
                        </form>
                        <form action="{{ route('newslaters.destroy') }}"> @csrf @method('DELETE')
                            <div class="newsletter_unsubscribe_link" ><a href="#" onclick="destroyNewslater(event)">unsubscribe</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function newslaterAjax(form, method, emailInput, email) {
        $.ajax({
            url: form.attr('action'),
            type:method,
            dataType:"json",
            data: {"_token": "{{  csrf_token() }}", 'email' : email},
            success:function(data) { 
                if (data.error) {
                    toastr.error(data.error)
                }
                if (data.success) {
                    emailInput.val('')
                    toastr.success(data.success)
                }
            },
            error:function(data) { 
                if (email = data.responseJSON.errors.email[0]) {
                    toastr.error(email)
                }
            },
        });
    }
    function storeNewslater(e) {
        e.preventDefault();
        var form = $(e.target).parent();
        var emailInput = form.children('input[name="email"]');
        var email = emailInput.val();
        if (email) {   
            newslaterAjax(form, "POST", emailInput, email);
        }
    }
    function destroyNewslater(e) {
        e.preventDefault();
        var form = $(e.target).closest('form');
        var emailInput = form.siblings('form').children('input[name="email"]');
        var email = emailInput.val();
        if (email) {   
            newslaterAjax(form, "DELETE", emailInput, email);
        }
    }
</script>
@endpush
