<!DOCTYPE html>
<html lang="en">
<head>
    @section('title')
        <title>OneTech</title>
    @show
    @section('meta_description')
        <meta name="description" content="OneTech shop project">
    @show
    @section('meta_keywords')
        
    @show
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/bootstrap4/bootstrap.min.css') }}">
    <link href="{{ asset('frontend/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/OwlCarousel2-2.2.1/owl.carousel.css') }} ">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/OwlCarousel2-2.2.1/owl.theme.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/OwlCarousel2-2.2.1/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/slick-1.8.0/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/star-rating-svg.css') }}">

    @unless (in_array(Route::currentRouteName(), ['products.show', 'cart.show']))
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/main_styles.css') }}">
    @endunless
    @unless (Route::currentRouteName() == 'pages.landing_page.index')
        <style>
            .cat_menu {visibility: hidden;opacity: 0;}
            .cat_menu_container:hover .cat_menu {visibility: visible;opacity: 1;}
        </style>
    @endunless

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/responsive.css') }}">

    <!-- toastr -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <style>
        	.scroll_bar::-webkit-scrollbar {
					height: 3px;
				}
			}
			.scroll_bar::-webkit-scrollbar-track {
				box-shadow: inset 0 0 5px grey;
				border-radius: 20px;
			}
			.scroll_bar::-webkit-scrollbar-thumb {
				background: #0e8ce4;
				border-radius: 20px;
			}
			.scroll_bar::-webkit-scrollbar-thumb:hover {
				background: #005aff;
			}
    </style>
    @stack('styles')

</head>

<body>


<div class="super_container">
    
    <!-- Header -->   
    <header class="header">

        <!-- Top Bar -->
        @include('layouts.app.top_bar')

        <!-- Header Main -->
        @include('layouts.app.header_main')

        <!-- Main Navigation -->
        @include('layouts.app.main_nav')

    </header>


    @yield('content')


    <!-- Footer -->
    @include('layouts.app.footer')

</div>

<script src="{{ asset('frontend/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{ asset('frontend/styles/bootstrap4/popper.js')}}"></script>
<script src="{{ asset('frontend/styles/bootstrap4/bootstrap.min.js')}}"></script>
<script src="{{ asset('frontend/plugins/greensock/TweenMax.min.js')}}"></script>
<script src="{{ asset('frontend/plugins/greensock/TimelineMax.min.js')}}"></script>
<script src="{{ asset('frontend/plugins/scrollmagic/ScrollMagic.min.js')}}"></script>
<script src="{{ asset('frontend/plugins/greensock/animation.gsap.min.js')}}"></script>
<script src="{{ asset('frontend/plugins/greensock/ScrollToPlugin.min.js')}}"></script>
<script src="{{ asset('frontend/plugins/OwlCarousel2-2.2.1/owl.carousel.js')}}"></script>
<script src="{{ asset('frontend/plugins/slick-1.8.0/slick.js')}}"></script>
<script src="{{ asset('frontend/plugins/easing/easing.js')}}"></script>
<script src="{{ asset('frontend/js/jquery.star-rating-svg.js')}}"></script>

@if (in_array(Route::currentRouteName(), ['pages.landing_page.index']))
    <script src="{{ asset('frontend/js/custom.js')}}"></script>
@endif

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    @if(Session::has('message'))
      var type="{{Session::get('alert-type','info')}}"
      switch(type){
          case 'info':
               toastr.info("{{ Session::get('message') }}");
               break;
          case 'success':
              toastr.success("{{ Session::get('message') }}");
              break;
          case 'warning':
             toastr.warning("{{ Session::get('message') }}");
              break;
          case 'error':
              toastr.error("{{ Session::get('message') }}");
              break;
      }
    @endif
    @if(Session::has('verified') === true)
          toastr.success("Your Email Has Been Successfully Verified");
    @endif
</script> 
  
    <script type="text/javascript">
        $(document).ready(function(){
          $(document).on('submit', '.addcart',function(e){
            e.preventDefault();
            var product_id = $(this).data('id');
            if (product_id) {
                 $.ajax({
                     url: `/cart/${product_id}`,
                     type:"POST",
                     datType:"json",
                     data: $(this).serializeArray(),
                     success:function(data){
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 1500,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                            })
     
                            if ($.isEmptyObject(data.error)) {
                
                                Toast.fire({
                                icon: 'success',
                                title: data.success
                                })

                            }else{

                                Toast.fire({
                                icon: 'error',
                                title: data.error
                                })
                            }

                            $('.cart_count').text(data.cart_count)
                            $('.cart_price').text('$' + data.cart_price)
                },
            });
     
            }else{
                alert('error');
            }
        });
     
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
          $(document).on('click', '.addwishlist',function(){
            var product_id = $(this).data('id');

            if (product_id) {
                $.ajax({
                     url: `/wishlist/${product_id}`,
                     type:"POST",
                     datType:"json",
                     data: {"_token": "{{  csrf_token() }}"},
                     success:function(data){
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 1500,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                            })
     
                            if ($.isEmptyObject(data.error)) {
                
                                Toast.fire({
                                icon: 'success',
                                title: data.success
                                })
                            }else{
                                Toast.fire({
                                icon: 'error',
                                title: data.error
                                })
                            }

                            $('.wishlist_count').text(data.countWishlist)
                     },
                });
            }else{
                 alert('error');
             }
          });
        });
    </script>

    <script>
    function dangerAlert(myclass, mytext = false) {  
        $(document).on("click", myclass, function(e){
            e.preventDefault();
        //  var link = $(this).attr("href") ?? $(this).attr("action");
            var form =  $(this).closest("form");
            if (mytext) {
                var title = "Are You Sure Want To Cancel This Order?"
                var text = ""
            } 
        //  console.log(link);
            swal({
                title: !mytext ? "Are You Sure Want To Delete This Item?" : title,
                text: !mytext ? "Once Delete, This Will Be Permanently Delete!" : text,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var formaction = $(this).attr('formaction')
                    if (formaction) {
                        form.attr('action', formaction)
                    }
                    form.submit();
                }
            });
        });
    }
    dangerAlert(".deleteWithoutAjax");
    dangerAlert(".cancelWithoutAjax", true);
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
          $(document).on('click', '.header_search a',function(){
            var slug = $(this).data('slug');
            var form = $(this).closest('form');
            $('input[name="category"]').remove();
            slug ? form.append(`<input type="hidden" name="category" value="${slug}">`) :  '';
          });

        });

        window.onload = function() {
            var url = '';           
            $('.footer_social a').map(function () {    
                url = $(this).attr('href');
                if (!url.match(/^http?:\/\//i) || !url.match(/^https?:\/\//i)) {
                    url = 'https://' + url;
                    $(this).attr('href', url)
                }
            })
        }
    </script>

@stack('scripts')
</body>

</html>