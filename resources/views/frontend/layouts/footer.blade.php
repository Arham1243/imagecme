<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class=" footer-info">
                    <a class="footer-info__logo" href="{{ route('frontend.index') }}">
                        <img alt="Logo" class="imgFluid"
                            src="{{ asset($logo->path ?? 'admin/assets/images/placeholder-logo.png') }}">
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
                        @if (!empty($config['COMPANYPHONE']))
                            <li>
                                <a href="tel:{{ $config['COMPANYPHONE'] }}">
                                    <i class="bx bxs-phone"></i>
                                    {{ $config['COMPANYPHONE'] }}</a>
                            </li>
                        @endif
                        @if (!empty($config['COMPANYEMAIL']))
                            <li>
                                <a href="mailto:{{ $config['COMPANYEMAIL'] }}">
                                    <i class="bx bxs-envelope"></i>
                                    {{ $config['COMPANYEMAIL'] }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer__copyright">
            <p>© <?= date('Y') ?> - {{ env('APP_NAME') }} . All Rights Reserved</p>
            <ul class="social-media">
                @if (!empty($config['FACEBOOK']))
                    <li>
                        <a href="{{ sanitizedLink($config['FACEBOOK']) }}" target="_blank"><i
                                class="bx bxl-facebook"></i></a>
                    </li>
                @endif
                @if (!empty($config['INSTAGRAM']))
                    <li>
                        <a href="{{ sanitizedLink($config['INSTAGRAM']) }}" target="_blank"><i
                                class="bx bxl-instagram"></i></a>
                    </li>
                @endif
                @if (!empty($config['TWITTER']))
                    <li>
                        <a href="{{ sanitizedLink($config['TWITTER']) }}" target="_blank"><i
                                class="bx bxl-twitter"></i></a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</footer>



<div class="share-popup-wrapper" data-send-popup>
    <div class="share-popup">
        <div class="share-popup__header">
            <div class="title">Share</div>
            <div class="close-btn">
                <i class='bx bx-x'></i>
            </div>
        </div>
        <div class="share-popup__body">
            <ul class="platforms">
                <li class="platform">
                    <a href="https://wa.me/?text=:title%20:url" target="_blank">
                        <div class="icon" style="background: #27D469;">
                            <i class='bx bxl-whatsapp'></i>
                        </div>
                        <div class="title">WhatsApp</div>
                    </a>
                </li>
                <li class="platform">
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=:url&title=:title" target="_blank">
                        <div class="icon" style="background: #0179B7;">
                            <i class='bx bxl-linkedin'></i>
                        </div>
                        <div class="title">LinkedIn</div>
                    </a>
                </li>
                <li class="platform">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=:url" target="_blank">
                        <div class="icon" style="background: #3D5A98;">
                            <i class='bx bxl-facebook'></i>
                        </div>
                        <div class="title">Facebook</div>
                    </a>
                </li>
                <li class="platform">
                    <a href="https://twitter.com/intent/tweet?text=:title&url=:url" target="_blank">
                        <div class="icon" style="background: #000;">
                            <img src="{{ asset('frontend/assets/images/x.png') }}" alt="">
                        </div>
                        <div class="title">X</div>
                    </a>
                </li>
                <li class="platform">
                    <a href="https://www.instagram.com/share?url=:url" target="_blank">
                        <div class="icon" style="background: linear-gradient(115deg, #f9ce34, #ee2a7b, #6228d7)">
                            <i class='bx bxl-instagram'></i>
                        </div>
                        <div class="title">Instagram</div>
                    </a>
                </li>
            </ul>

            <div class="copy-link">
                <input type="text" readonly class="copy-link__input">
                <button type="button" class="copy-link__btn themeBtn" onclick="copyLink()">Copy</button>
            </div>
        </div>
    </div>
</div>


@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sendPopupBtn = document.querySelectorAll('[data-send-button]');
            const popupWrapper = document.querySelector('[data-send-popup]');
            const popupBody = popupWrapper.querySelector('.share-popup');
            const platforms = popupWrapper.querySelectorAll('.platform a');
            const copyLinkInput = popupWrapper.querySelector('.copy-link__input');
            const closeIcon = popupWrapper.querySelector('.close-btn');

            sendPopupBtn.forEach(btn => {
                btn.addEventListener('click', function() {
                    const popupTheme = btn.getAttribute('data-popup-theme');
                    const caseUrl = btn.getAttribute('data-case-url');
                    const caseTitle = btn.getAttribute('data-case-title');
                    popupBody.classList.add(popupTheme);
                    copyLinkInput.value = caseUrl;
                    platforms.forEach(platform => {
                        platform.href = platform.href.replace(':url', caseUrl).replace(
                            ':title', caseTitle);
                    });

                    popupWrapper.classList.add('open');
                });
            });

            closeIcon.addEventListener('click', function(e) {
                popupWrapper.classList.remove('open');
            });
        });

        const copyLink = () => {
            var copyText = document.querySelector('.copy-link__input');

            copyText.select();
            copyText.setSelectionRange(0, 99999);

            document.execCommand('copy');

            showMessage('Link copied to clipboard!', 'success', 'top-right');
        }
    </script>
@endpush
