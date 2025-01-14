<header class="header">
    <div class="container p-0">
        <div class="header-main">
            <a href="{{ route('frontend.index') }}" class="header-main__logo">
                <img alt="Logo" class="imgFluid"
                    src="{{ asset($logo->path ?? 'admin/assets/images/placeholder-logo.png') }}">
            </a>
            <div class="header-main__btns">
                @if (Auth::check())
                    <a href="{{ route('user.dashboard') }}"
                        class="themeBtn themeBtn--secondary themeBtn--outline">Dashboard</a>
                    <a href="{{ route('auth.logout') }}" onclick="return confirm('Are you sure you want to log out')"
                        class="themeBtn themeBtn--secondary themeBtn--outline">Logout</a>
                @else
                    <a href="{{ route('auth.login') }}" class="themeBtn themeBtn--secondary themeBtn--outline">Login</a>
                    <a href="{{ route('auth.signup') }}"
                        class="themeBtn themeBtn--secondary themeBtn--outline">Signup</a>
                @endif
            </div>
        </div>
    </div>
</header>
