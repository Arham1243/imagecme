<header class="header">
    <div class="header-topbar">
        <div class="container p-0">
            <div class="header-topbar__social">
                <div class="title">Follow Us:</div>
                <ul class="social-media">
                    <li>
                        <a href="{{ sanitizedLink($config['FACEBOOK'] ?? '') }}" target="_blank"><i
                                class="bx bxl-facebook"></i></a>
                    </li>
                    <li>
                        <a href="{{ sanitizedLink($config['INSTAGRAM'] ?? '') }}" target="_blank"><i
                                class="bx bxl-instagram"></i></a>
                    </li>
                    <li>
                        <a href="{{ sanitizedLink($config['TWITTER'] ?? '') }}" target="_blank"><i
                                class="bx bxl-twitter"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container p-0">
        <div class="header-main">
            <a href="{{ route('index') }}" class="header-main__logo">
                <img alt="Logo" class="imgFluid"
                    src="{{ asset($logo->path ?? 'admin/assets/images/placeholder.png') }}">
            </a>
            <ul class="header-main__contact">
                <li>
                    <i class='bx bx-headphone'></i>
                    <div class="content">
                        <a href="tel:{{ $config['COMPANYPHONE'] ?? '' }}">{{ $config['COMPANYPHONE'] ?? '' }}</a>
                        Contact Us
                    </div>
                </li>
                <li class="header__call">
                    <i class='bx bxs-chat'></i>
                    <div class="content">
                        <a href="mailto:{{ $config['COMPANYEMAIL'] ?? '' }}">{{ $config['COMPANYEMAIL'] ?? '' }}</a>
                        Email Us
                    </div>
                </li>
                <li>
                    @if (!Auth::check())
                        <a href="{{ route('auth.signup') }}" class="themeBtn ms-4"> Try For Free<i
                                class="bx bxs-user"></i></a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="themeBtn ms-4"> Dashboard<i
                                class="bx bxs-user"></i></a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</header>
