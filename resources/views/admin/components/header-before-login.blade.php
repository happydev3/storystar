<header id="header">

    <div id="logo-group">
        <a href="{{route('admin-login')}}">
            <span id="logo">
                <img id="logoimg" src="{{app_assets('images/welcome-logo.png')}}" alt="{{config('app.name')}}">
            </span>
        </a>
    </div>

    <span id="extr-page-header-space" style="line-height: 44px;">
            <span class="hidden-mobile hiddex-xs">{{date("D d, M Y H:i:s") }}</span>
        </span>

</header>
