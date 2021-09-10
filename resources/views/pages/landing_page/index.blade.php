@extends('layouts.app.index')

@section('content')
    
    @include('pages.landing_page.main_slider')

    <!-- Characteristics -->
    @include('pages.landing_page.characteristics')

    <!-- Deals of the week -->
    @include('pages.landing_page.deals_featured')

    <!-- Popular Categories -->
    {{-- @include('pages.landing_page.popular_categories') --}}

    <!-- Banner -->
    @include('pages.landing_page.mid_slider')

    <!-- Hot New Arrivals -->
    @include('pages.landing_page.new_arrivals')

    <!-- Best Sellers -->
    @include('pages.landing_page.best_sellers')

    <!-- Adverts -->
    @include('pages.landing_page.adverts')

    <!-- Trends -->
    @include('pages.landing_page.trends')

    <!-- Reviews -->
    @include('pages.landing_page.reviews')

    <!-- Recently Viewed -->
    @include('layouts.recently_viewed')

    <!-- Brands -->
    @include('pages.landing_page.brands')

    <!-- Newsletter -->
    @include('pages.landing_page.newsletter')


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
@endsection