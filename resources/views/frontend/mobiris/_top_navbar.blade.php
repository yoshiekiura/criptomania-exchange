<nav class="navbar navbar-expand-lg navbar-light beta-menu navbar-dropdown align-items-center navbar-fixed-top">
    <div class="menu-logo">
        <div class="navbar-brand">
            @if(admin_settings('company_logo'))
            <a href="{{ route('home') }}" class="navbar-brand"><img class="logo-icon-company"
                    src="{{ get_image(admin_settings('company_logo')) }}"></a>
            @else
            <a style="text-transform: uppercase" href="{{ route('home') }}"
                class="navbar-brand"><b>{{ env('APP_NAME') }}</b></a>
            @endif

            <span class="navbar-caption-wrap"><a class="navbar-caption text-black display-4"
                    href="https://mobirisethemes.com/">
                    KriptoMania</a></span>
        </div>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ml-auto">
            <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
                @guest
                <a class="nav-link link text-black display-4" href="{{ route('login') }}">Login</a>

                <a class="nav-link link text-black display-4" href="{{ route('register.index') }}">Register</a>
                @endguest

                @auth

                @php
                $userNotifications = get_user_specific_notice();
                @endphp
                <li class="dropdown">
                    @if(!$userNotifications['list']->isEmpty())
                    <button class="btn btn-light dropdown-toggle"
                        style="color: #FFFFFF;background-color: #ffffff;border-color: #ffffff;width: 100%;"
                        type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="fa fa-bell text-orange" style="color:orange;"></i><span
                            style="color:black;">{{ $userNotifications['count_unread'] }}</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <p class="dropdown-item">
                            {{ __('You have :count notifications',['count' => $userNotifications['count_unread']]) }}
                        </p>
                        @foreach($userNotifications['list'] as $notification)
                        <a class="dropdown-item"><i class="fa fa-bell text-orange" style="color:orange;"></i><span
                                style="color: #000000">{{ str_limit($notification->data, 50) }}</span></a>
                        @endforeach
                        <a class="dropdown-item bg-green-active" style="color: #000000 !important"
                            href="{{ route('notices.index') }}"><button class="btn btn-toogle">View all</button></a>
                    </div>
                    @endif
                </li>
                <a class="nav-link link text-black display-4 text-profile" id="userProfile"
                    href="{{ route('profile.index') }}"><span
                        class="txt-profile">{{ Auth::user()->userInfo->full_name }} |
                    </span></a>

                <a class="nav-link link text-black display-4 text-logout" href="{{ route('logout') }}"><i
                        class="fas fa-sign-out-alt icon-logout"></i></a>
                @endauth
            </ul>
        </div>
    </div>
</nav>