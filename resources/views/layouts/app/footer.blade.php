<footer class="footer">
    <div class="container">
        <div class="row">

            <div class="col-lg-3 footer_col">
                <div class="footer_column footer_contact">
                    <div class="logo_container">
                        <div class="logo"><a href="#">OneTech</a></div>
                    </div>
                    @if ($site_settings->phone)
                    <div class="footer_title">Got Question? Call Us 24/7</div>
                    <div class="footer_phone">{{ $site_settings->phone }}</div>
                    @endif
                    <div class="footer_contact_text">
                        <p>{{ $site_settings->address }}</p>
                    </div>
                    <div class="footer_social">
                        <ul>
                            @if ($site_settings->facebook)
                            <li><a target="_blank" href="{{ $site_settings->facebook }}/"><i
                                        class="fab fa-facebook-f"></i></a></li>
                            @endif
                            @if ($site_settings->twitter)
                            <li><a target="_blank" href="{{ $site_settings->twitter }}/"><i
                                        class="fab fa-twitter"></i></a></li>
                            @endif
                            @if ($site_settings->youtube)
                            <li><a target="_blank" href="{{ $site_settings->youtube }}/"><i
                                        class="fab fa-youtube"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            @foreach ($categories->chunk(6) as $chunk)
                <div class="col-lg-2 {{ $loop->first ? 'offset-lg-2' : '' }}">
                    <div class="footer_column">
                        @if ($loop->first)
                            <div class="footer_title">Find it Fast</div>
                        @endif
                        <ul class="footer_list {{ !$loop->first ? 'footer_list_2' : '' }}">
                            @foreach ($chunk as $category)
                                <li>
                                    <a href ='{{ route('shop.index', ['model' => 'category', 'slug' => $category->category_slug]) }}'>
                                        {{ $category->category_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach

            @auth('web')
                <div class="col-lg-2">
                    <div class="footer_column">
                        <div class="footer_title">Customer Care</div>
                        <ul class="footer_list">
                            <li><a href ='{{ route('home') }}'>My Account</a></li>
                            <li><a href ='{{ route('cart.show') }}'>My Cart</a></li>
                            <li><a href ='{{ route('wishlist.index') }}'>My WishList</a></li>
                            <li><a href="{{ route('cancel_orders.index') }}">Cancel Order</a></li>
                            <li><a href="{{ route('return_orders.index') }}">Return Order</a></li>
                            <li><a href ='{{ route('contact.index') }}'>Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            @endauth
            
        </div>
    </div>
</footer>

<!-- Copyright -->

<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col">

                <div
                    class="copyright_container d-flex flex-sm-row flex-column align-items-center justify-content-start">
                    <div class="copyright_content">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | This template is made with <i class="fa fa-heart"
                            aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
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