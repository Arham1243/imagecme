<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class=" footer-info">
                    <a class="footer-info__logo" href="{{ route('index') }}">
                        <img alt="Logo" class="imgFluid"
                            src="{{ asset($logo->path ?? 'admin/assets/images/placeholder.png') }}">
                    </a>
                    <p>medical imaging
                        innovation in detection & diagnostic education
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6  offset-lg-1">
                <div class=" footer__quickLinks">
                    <div class="title">Get in touch</div>
                    <ul>
                        <li>
                            <a href="tel:{{ $config['COMPANYPHONE'] ?? '' }}">
                                <i class="bx bxs-phone"></i>
                                {{ $config['COMPANYPHONE'] ?? '' }}</a>
                        <li>
                            <a href="mailto:{{ $config['COMPANYEMAIL'] ?? '' }}">
                                <i class="bx bxs-envelope"></i>
                                {{ $config['COMPANYEMAIL'] ?? '' }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer__copyright">
            <p>© <?= date('Y') ?> - {{ env('APP_NAME') }} . All Rights Reserved</p>
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
</footer>
