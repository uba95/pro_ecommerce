
<nav class="main_nav">
    <div class="container">
        <div class="row">
            <div class="col">
                
                <div class="main_nav_content d-flex flex-row">

                    <!-- Categories Menu -->

                    <div class="cat_menu_container" style="z-index: 999">
                        <div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
                            <div class="cat_burger"><span></span><span></span><span></span></div>
                            <div class="cat_menu_text">Categories</div>
                        </div>

                        <ul class="cat_menu" >
                            @foreach ($categories as $category)
                                <li class="hassubs">
                                    <a href ='{{ route('shop.index', ['model' => 'category', 'slug' => $category->category_slug]) }}'>
                                        {{ $category->category_name }}
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    <ul>
                                        @foreach ($category->subcategories as $subcategory)
                                            <li class="hassubs">
                                                <a href ='{{ route('shop.index', ['model' => 'subcategory', 'slug' => $subcategory->subcategory_slug]) }}'>
                                                    {{ $subcategory->subcategory_name }}
                                                </a>
                                            </li> 
                                        @endforeach
                                    </ul>          
                                </li>  
                            @endforeach
                        </ul>
                    </div>

                    <!-- Main Nav Menu -->

                    <div class="main_nav_menu ml-auto">
                        <ul class="standard_dropdown main_nav_dropdown">
                            <li><a  href ='{{ url('/') }}'>Home<i class="fas fa-chevron-down"></i></a></li>
                            <li class="hassubs">
                                <a href="#">Featured Brands<i class="fas fa-chevron-down"></i></a>
                                <ul style="z-index: 999">
                                    @foreach ($brands as $brand)
                                    <li>
                                        <a href ='{{ route('shop.index', ['model' => 'brand', 'slug' => $brand->brand_slug]) }}'>
                                            {{ $brand->brand_name }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="hassubs">
                                <a href="{{ route('blog.index') }}">Blog<i class="fas fa-chevron-down"></i></a>
                                <ul>
                                    @foreach ($blogCategories as $blog_category_slug => $blog_category_name)
                                        <li><a href="{{ route('blog.category', $blog_category_slug) }}">{{ $blog_category_name }}<i class="fas fa-chevron-down"></i></a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href ='{{ route('contact.index') }}'>Contact<i class="fas fa-chevron-down"></i></a></li>
                        </ul>
                    </div>

                    <!-- Menu Trigger -->

                    <div class="menu_trigger_container ml-auto">
                        <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
                            <div class="menu_burger">
                                <div class="menu_trigger_text">menu</div>
                                <div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Menu -->

<div class="page_menu">
    <div class="container">
        <div class="row">
            <div class="col">
                
                <div class="page_menu_content">
                    
                    <div class="page_menu_search">
                        <form action="#">
                            <input type="search" required="required" class="page_menu_search_input" placeholder="Search for products...">
                        </form>
                    </div>
                    <ul class="page_menu_nav">
                        <li class="page_menu_item">
                            <a  href ='{{ url('/') }}'>Home<i class="fa fa-angle-down"></i></a>
                        </li>

                        <li class="page_menu_item has-children">
                            <a href="#">Categories<i class="fa fa-angle-down"></i></a>
                            @foreach ($categories as $category)
                                <ul class="page_menu_selection">
                                    <li class="page_menu_item has-children">
                                        <a href =''>
                                            {{ $category->category_name }}
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="page_menu_selection">
                                            <a href ='{{ route('shop.index', ['model' => 'category', 'slug' => $category->category_slug]) }}'>
                                                {{ $category->category_name }}
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            @foreach ($category->subcategories as $subcategory)
                                                <li>
                                                    <a href ='{{ route('shop.index', ['model' => 'subcategory', 'slug' => $subcategory->subcategory_slug]) }}'>
                                                        {{ $subcategory->subcategory_name }}
                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            @endforeach
                        </li>

                        <li class="page_menu_item has-children">
                            <a href="#">Featured Brands<i class="fa fa-angle-down"></i></a>
                            <ul class="page_menu_selection">
                                <li><a href="#">Featured Brands<i class="fa fa-angle-down"></i></a></li>

                                @foreach ($brands as $brand)
                                <li>
                                    <a href ='{{ route('shop.index', ['model' => 'brand', 'slug' => $brand->brand_slug]) }}'>
                                        {{ $brand->brand_name }}
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </li>
                                @endforeach

                            </ul>
                        </li>

                        <li class="page_menu_item has-children">
                            <a href="#">Blog<i class="fa fa-angle-down"></i></a>
                                <ul class="page_menu_selection">
                                    <li class="page_menu_item"><a href ='{{ route('blog.index') }}'>Blog<i class="fa fa-angle-down"></i></a></li>
                                    
                                    @foreach ($blogCategories as $blog_category_slug => $blog_category_name)
                                        <li class="page_menu_item">
                                            <a href="{{ route('blog.category', $blog_category_slug) }}">
                                                {{ $blog_category_name }}
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                        </li>

                        <li class="page_menu_item"><a href ='{{ route('contact.index') }}'>Contact<i class="fa fa-angle-down"></i></a></li>
                    </ul>
                    
                    <div class="menu_contact">

                        @if ($site_settings->phone)
                            <div class="menu_contact_item">
                                <div class="menu_contact_icon">
                                    <img src="{{ asset('frontend/images/phone_white.png')}}" alt="">
                                </div>
                                {{ $site_settings->phone }}
                            </div>
                        @endif

                        @if ($site_settings->email)
                            <div class="menu_contact_item">
                                <div class="menu_contact_icon">
                                    <img src="{{ asset('frontend/images/mail_white.png')}}" alt="">
                                </div>
                                <a href="mailto:{{ $site_settings->email }}">{{ $site_settings->email }}</a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


