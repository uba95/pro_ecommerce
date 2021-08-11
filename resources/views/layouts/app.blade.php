<!DOCTYPE html>
<html lang="en">
<head>
    <title>OneTech</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="OneTech shop project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/bootstrap4/bootstrap.min.css') }}">
    <link href="{{ asset('frontend/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/OwlCarousel2-2.2.1/owl.carousel.css') }} ">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/OwlCarousel2-2.2.1/owl.theme.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/OwlCarousel2-2.2.1/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/slick-1.8.0/slick.css') }}">

    @unless (in_array(Route::currentRouteName(), ['products.show', 'cart.show']))
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/main_styles.css') }}">
    @endunless
    @unless (Route::currentRouteName() == 'pages.index')
        <style>
            .cat_menu {visibility: hidden;opacity: 0;}
            .cat_menu_container:hover .cat_menu {visibility: visible;opacity: 1;}
        </style>
    @endunless

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/responsive.css') }}">

    <!-- toastr -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    @stack('styles')

</head>

<body>


<div class="super_container">
    
    <!-- Header -->
    
    <header class="header">

        <!-- Top Bar -->

        <div class="top_bar">
            <div class="container">
                <div class="row">
                    <div class="col d-flex flex-row">
                        <div class="top_bar_contact_item"><div class="top_bar_icon"><img src="{{ asset('frontend/images/phone.png')}}" alt=""></div>+38 068 005 3570</div>
                        <div class="top_bar_contact_item"><div class="top_bar_icon"><img src="{{ asset('frontend/images/mail.png')}}" alt=""></div><a href="mailto:fastsales@gmail.com">fastsales@gmail.com</a></div>
                        <div class="top_bar_content ml-auto">
                            <div class="top_bar_menu">
                                <ul class="standard_dropdown top_bar_dropdown">
                                    <li>
                                        <a href="#">English<i class="fas fa-chevron-down"></i></a>
                                        <ul>
                                            <li><a href="#">Italian</a></li>
                                            <li><a href="#">Spanish</a></li>
                                            <li><a href="#">Japanese</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">$ US dollar<i class="fas fa-chevron-down"></i></a>
                                        <ul>
                                            <li><a href="#">EUR Euro</a></li>
                                            <li><a href="#">GBP British Pound</a></li>
                                            <li><a href="#">JPY Japanese Yen</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="top_bar_user">

                                @guest
                                <div>
                                    <a href="{{ route('login') }}">
                                        <div class="user_icon">
                                            <img src="{{ asset('frontend/images/user.svg')}}" alt="">
                                        </div> 
                                        Register/Login
                                    </a>
                                </div>
                                @else
                                <ul class="standard_dropdown top_bar_dropdown">
                                    <li>
                                        <a href="{{ route('home') }}">
                                            <div class="user_icon">
                                                <img src="{{ asset('frontend/images/user.svg')}}" alt="">
                                            </div> 
                                            {{ Auth::user()->name }}
                                        </a>
                                        <ul>
                                            <li><a href ='{{ route('home') }}'>Profile</a></li>
                                            <li><a href ='{{ route('user.logout') }}'>Logout</a></li>
                                        </ul>
                                    </li>
                                </ul> 
                                @endguest
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
        </div>

        <!-- Header Main -->

        <div class="header_main">
            <div class="container">
                <div class="row">

                    <!-- Logo -->
                    <div class="col-lg-2 col-sm-3 col-3 order-1">
                        <div class="logo_container">
                            <div class="logo"><a href ='{{ url('/') }}'>OneTech</a></div>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
                        <div class="header_search">
                            <div class="header_search_content">
                                <div class="header_search_form_container">
                                    <form action ='{{ route('shop.index') }}' method="GET" class="header_search_form clearfix">
                                        <input name="search" type="search" required="required" class="header_search_input" placeholder="Search for products...">
                                        <div class="custom_dropdown">
                                            <div class="custom_dropdown_list">
                                                <span class="custom_dropdown_placeholder clc">All Categories</span>
                                                <input type="hidden" name="model" value="product">
                                                <input type="hidden" name="category">
                                                <i class="fas fa-chevron-down"></i>
                                                <ul class="custom_list clc">
                                                    <li><a class="clc" href="#">All Categories</a></li>
                                                    @foreach ($categories as $category)
                                                    <li class="hassubs">
                                                        <a data-slug="{{ $category->category_slug }}" href="">
                                                            {{ $category->category_name }}
                                                        </a>
                                                    </li>  
                                                    @endforeach            
                                                </ul>
                                            </div>
                                        </div>
                                        <button type="submit" class="header_search_button trans_300" value="Submit"><img src="{{ asset('frontend/images/search.png')}}" alt=""></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Wishlist -->
                    <div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
                        <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                            @auth
                            <div class="wishlist d-flex flex-row align-items-center justify-content-end">
                                <div class="wishlist_icon"><img src="{{ asset('frontend/images/heart.png')}}" alt=""></div>
                                <div class="wishlist_content">
                                    <div class="wishlist_text"><a href ='{{ route('wishlist.index') }}'>Wishlist</a></div>
                                    <div class="wishlist_count">{{ Auth::user()->wishlistItems()->count() }}</div>
                                </div>
                            </div>
                            @endauth

                            <!-- Cart -->
                            <div class="cart">
                                <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                                    <div class="cart_icon">
                                        <img src="{{ asset('frontend/images/cart.png')}}" alt="">
                                        <div class="cart_count"><span>{{ Cart::count() }}</span></div>
                                    </div> 
                                    <div class="cart_content">
                                        <div class="cart_text"><a href ='{{ route('cart.show') }}'>Cart</a></div>
                                        <div class="cart_price">${{ Cart::priceTotal() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @include('layouts.menubar')
    @yield('content')

    <!-- Footer -->

    <footer class="footer">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 footer_col">
                    <div class="footer_column footer_contact">
                        <div class="logo_container">
                            <div class="logo"><a href="#">OneTech</a></div>
                        </div>
                        <div class="footer_title">Got Question? Call Us 24/7</div>
                        <div class="footer_phone">+38 068 005 3570</div>
                        <div class="footer_contact_text">
                            <p>17 Princess Road, London</p>
                            <p>Grester London NW18JR, UK</p>
                        </div>
                        <div class="footer_social">
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                <li><a href="#"><i class="fab fa-google"></i></a></li>
                                <li><a href="#"><i class="fab fa-vimeo-v"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 offset-lg-2">
                    <div class="footer_column">
                        <div class="footer_title">Find it Fast</div>
                        <ul class="footer_list">
                            <li><a href="#">Computers & Laptops</a></li>
                            <li><a href="#">Cameras & Photos</a></li>
                            <li><a href="#">Hardware</a></li>
                            <li><a href="#">Smartphones & Tablets</a></li>
                            <li><a href="#">TV & Audio</a></li>
                        </ul>
                        <div class="footer_subtitle">Gadgets</div>
                        <ul class="footer_list">
                            <li><a href="#">Car Electronics</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="footer_column">
                        <ul class="footer_list footer_list_2">
                            <li><a href="#">Video Games & Consoles</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Cameras & Photos</a></li>
                            <li><a href="#">Hardware</a></li>
                            <li><a href="#">Computers & Laptops</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="footer_column">
                        <div class="footer_title">Customer Care</div>
                        <ul class="footer_list">
                            <li><a href="#">My Account</a></li>
                            <li><a href="#">Order Tracking</a></li>
                            <li><a href="#">Wish List</a></li>
                            <li><a href="#">Customer Services</a></li>
                            <li><a href="#">Returns / Exchange</a></li>
                            <li><a href="#">FAQs</a></li>
                            <li><a href="#">Product Support</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </footer>

    <!-- Copyright -->

    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col">
                    
                    <div class="copyright_container d-flex flex-sm-row flex-column align-items-center justify-content-start">
                        <div class="copyright_content"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
</div>
                        <div class="logos ml-sm-auto">
                            <ul class="logos_list">
                                <li><a href="#"><img src="{{ asset('frontend/images/logos_1.png')}}" alt=""></a></li>
                                <li><a href="#"><img src="{{ asset('frontend/images/logos_2.png')}}" alt=""></a></li>
                                <li><a href="#"><img src="{{ asset('frontend/images/logos_3.png')}}" alt=""></a></li>
                                <li><a href="#"><img src="{{ asset('frontend/images/logos_4.png')}}" alt=""></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

@unless (in_array(Route::currentRouteName(), ['products.show', 'cart.show']))
    <script src="{{ asset('frontend/js/custom.js')}}"></script>
@endunless

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
                alert('danger');
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
                 alert('danger');
             }
          });
        });
    </script>

    <script>  
        function deleteAjax(myclass, mytext) {
            $(document).on('click', myclass, function (event) { 
                    event.preventDefault();
                    var form =  $(this);
                    var route = form.attr('action');

                    function cart_list_empty() {
                        return $('.cart_list').fadeOut(1000, function () {
                            $(this).empty().append(
                                `<h4 style="padding: 20px;color:#888">Your Cart Is Empty</h4>`
                            );
                        }).fadeIn(1000);
                    }

                    Swal.fire({
                        title: `Are You Sure You Want To Delete ${mytext} ?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Delete'
                        
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Item Has Been Deleted.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $.ajax({
                            url         :       route,
                            type        :       "DELETE",
                            data        :       {"_token": "{{  csrf_token() }}"},
                            success     :       function(data) { 

                                                    if (myclass === '.delete') {
                                                    form.closest('.cart_item').fadeOut(1000, function () {
                                                    $(this).remove();
                                                    });

                                                    $('.cart_list').children().length == 1 ?  cart_list_empty() : '';
                                                    } else {

                                                    cart_list_empty();
                                                    }

                                                    $('.order_total_amount').text('$' + data.cart_price);
                                                    $('.cart_count').text(data.cart_count)
                                                    $('.cart_price').text('$' + data.cart_price)
                                                }
                            });
                        }
                    })
                });
        }

        deleteAjax('.delete', 'This Item');
        deleteAjax('.destroyAll', 'All Items');
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
                    //  window.location.href = link;
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
            $('input[name="category"]').val(slug ?? '');
          });
        });
    </script>

@stack('scripts')
</body>

</html>