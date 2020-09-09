<header class="light-bb main-header">
    <nav class="navbar navbar-expand-lg">
        @if(admin_settings('company_logo'))
        <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ get_image(admin_settings('company_logo')) }}"
                style="border-radius:50%;" alt="logo"></a>
        @else
        <a style="text-transform: uppercase" href="{{ route('home') }}"
            class="navbar-brand"><b>{{ env('APP_NAME') }}</b></a>
        @endif

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#headerMenu"
            aria-controls="headerMenu" aria-expanded="false" aria-label="Toggle navigation">
            <i class="icon ion-md-menu"></i>
        </button>

        <div class="collapse navbar-collapse" id="headerMenu">
            @php
            $userNotifications = get_user_specific_notice();
            @endphp
            {{-- navigasi --}}
            <ul class="navbar-nav mr-auto">
                <li class="{{ is_current_route('home') }} nav-item">
                    <a href="{{ route('home') }}" class="nav-link">{{ __('Home') }}</a>
                </li>
                <li class="{{ is_current_route('exchange.index') }} nav-item">
                    <a href="{{ route('exchange.index') }}" class="nav-link">{{ __('Exchange') }}</a>
                </li>
                <li class="{{ is_current_route('exchange.ico.index') }} nav-item">
                    <a href="{{ route('exchange.ico.index') }}" class="nav-link">{{ __('ICO') }}</a>
                </li>
            </ul>
            @guest
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">{{__('Login')}}</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('register.index') }}" class="nav-link">{{ __('Register') }}</a>
                </li>
            </ul>
            @endguest
            {{-- end navigasi --}}

            @auth
            <ul class="navbar-nav ml-auto">
                {{-- navigasi fullscreen --}}
                {{-- <li class="nav-item header-custom-icon">
                    <a class="nav-link" href="#" id="clickFullscreen">
                        <i class="icon ion-md-expand"></i>
                    </a>
                </li> --}}
                {{-- end navigasi fullscreen --}}

                {{-- notif --}}
                <li class="nav-item dropdown header-custom-icon">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        @if(!$userNotifications['list']->isEmpty())
                        <i class="icon ion-md-notifications"></i>
                        <span class="circle-pulse"></span>
                        @else
                        <i class="icon ion-md-notifications"></i>
                        @endif
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <p class="mb-0 font-weight-medium">{{ $userNotifications['count_unread'] }} New
                                Notifications</p>
                            {{-- <a href="#!" class="text-muted">Clear all</a> --}}
                        </div>
                        <div class="dropdown-body">
                            @foreach($userNotifications['list'] as $notification)
                            <a href="#!" class="dropdown-item">
                                <div class="icon">
                                    <i class="icon ion-md-mail-unread"></i>
                                </div>
                                <div class="content">
                                    <p><span style="color: #000000">{{ str_limit($notification->data, 50) }}</span></p>
                                    <p class="sub-text text-muted">{{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        <div class="dropdown-footer d-flex align-items-center justify-content-center">
                            <a href="{{ route('notices.index') }}">View all</a>
                        </div>
                    </div>
                </li>
                {{-- end notif --}}

                <li class="nav-item dropdown img-profile header-img-icon">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src=" {{ asset('newAssets/img/avatar.svg') }} " alt="avatar">
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-header d-flex flex-column align-items-center">
                            <div class="figure mb-3">
                                <img src="{{ asset('newAssets/img/avatar.svg') }}" alt="">
                            </div>
                            <div class="info text-center">
                                <p class="name font-weight-bold mb-0">{{ Auth::user()->userInfo->full_name }}</p>
                                <p class="email text-muted mb-3">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <div class="dropdown-body">
                            <ul class="profile-nav">
                                <li class="nav-item">
                                    <a href="{{ route('profile.index') }}" class="nav-link">
                                        <i class="icon ion-md-person"></i>
                                        <span>Profile</span>
                                    </a>
                                </li>
                                @if(Auth::user()->user_role_management_id != 1)
                                <li class="nav-item">
                                    <a href="{{ route('trader.wallets.index') }}" class="nav-link">
                                        <i class="icon ion-md-wallet"></i>
                                        <span>My Wallet</span>
                                    </a>
                                </li>
                                @endif
                                @if(Auth::user()->user_role_management_id == 1)
                                <li class="nav-item">
                                    <a href="{{ route('admin-settings.index') }}" class="nav-link">
                                        <i class="icon ion-md-settings"></i>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a href="{{ route('logout')}}" class="nav-link red">
                                        <i class="icon ion-md-power"></i>
                                        <span>Log Out</span>
                                    </a>
                                </li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>

{{-- <script>
    var logout = window.matchMedia("(max-width: 700px)")
    myFunction(logout) // Call listener function at run time
    logout.addListener(myFunction) // Attach listener function on state changes

    function myFunction(logout) {
    if (logout.matches) { // If media query matches
        $('.icon-logout').remove();
        $('.logout-mobile').prepend('<a class="icon-logout" href="{{ route('logout') }}">Log Out <i
    class="fa fa-sign-out"></i></a>')

} else {
if($('li').hasClass('logout-desktop'))
{
$('.icon-logout').remove();
$('.logout-desktop').prepend('<a class="icon-logout" href="{{ route('logout') }}"><i class="fa fa-sign-out"></i></a>')
}
}
}
</script> --}}