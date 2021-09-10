<div class="top_bar">
    <div class="container">
        <div class="row">
            <div class="col d-flex flex-row">
                <div class="top_bar_contact_item">
                    @if ($site_settings->phone)
                        <div class="top_bar_icon">
                            <img src="{{ asset('frontend/images/phone.png')}}" alt="">
                        </div>
                        {{ $site_settings->phone }}
                    @endif
                </div>
                <div class="top_bar_contact_item">
                    @if ($site_settings->phone)
                        <div class="top_bar_icon">
                            <img src="{{ asset('frontend/images/mail.png')}}" alt="">
                        </div>
                        <a href="mailto:{{ $site_settings->email }}">{{ $site_settings->email }}</a>
                    @endif
                </div>
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

                        @guest('web')
                        <div>
                            <a href="{{ route('login') }}">
                                <div class="user_icon">
                                    <img src="{{ asset('frontend/images/user.svg')}}" alt="">
                                </div> 
                                Login
                            </a>
                        </div>
                        @else
                        <ul class="standard_dropdown top_bar_dropdown">
                            <li>
                                <a style="cursor: pointer;">
                                    <div class="user_icon">
                                        <img src="{{ asset('frontend/images/user.svg')}}" alt="">
                                    </div> 
                                    {{ current_user()->name }}
                                </a>
                                <ul>
                                    <li><a href ='{{ route('home') }}'>Profile</a></li>
                                    <li>
                                        <a style="cursor: pointer;" onclick="document.getElementById('logout').submit()">
                                            <form id="logout" action="{{ route('logout') }}" method="POST"> @csrf
                                                Logout
                                            </form>
                                        </a>
                                    </li>                              
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
