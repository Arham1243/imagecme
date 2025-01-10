@if (Auth::check())
    <button data-slug="{{ $case->slug }}" class="{{ $class }}"
        @if ($label) data-label="{{ $label }}" @endif
        data-action="{{ $liked ? 'unlike' : 'like' }}" onclick="likeCase(this, {{ $case->id }})" type="button">
        <i class='{{ $liked ? 'bx bxs-like' : 'bx bx-like' }}'></i>
        <span class="total {{ $showCount ? 'd-block' : 'd-none' }}">{{ formatBigNumber($likesCount) }}</span>
    </button>
@else
    <a href="{{ route('auth.login', ['redirect_url' => url()->current()]) }}" class="{{ $class }}"
        @if ($label) data-label="{{ $label }}" @endif>
        <i class='bx bx-likebx bx-like'></i>
        <span class="total {{ $showCount ? 'd-block' : 'd-none' }}">{{ formatBigNumber($likesCount) }}</span>
    </a>
@endif
@section('js')
    <script>
        const likeCase = async (likeBtn, caseId) => {
            try {
                const action = likeBtn.getAttribute('data-action');
                const slug = likeBtn.getAttribute('data-slug');
                const current_url = window.location.href;

                const likeCaseRoute =
                    `{{ route('frontend.cases.comments.likeCase', ['slug' => ':slug', 'action' => ':action']) }}`
                    .replace(':slug', slug)
                    .replace(':action', action);

                const response = await axios.post(likeCaseRoute, {
                    caseId,
                    action,
                    current_url,
                });

                const icon = likeBtn.querySelector('i');
                const counter = likeBtn.querySelector('.total');

                if (response.data.action === 'like') {
                    icon.className = 'bx bxs-like bx-tada';
                    setTimeout(() => icon.classList.remove('bx-tada'), 500);
                    likeBtn.setAttribute('data-action', 'unlike');
                } else {
                    icon.className = 'bx bx-like';
                    likeBtn.setAttribute('data-action', 'like');
                }
                counter.textContent = response.data.likesCount;
            } catch (error) {
                if (error.response.status === 401) {
                    window.location.href = error.response.data.redirect_url;
                }
            }
        }
    </script>
@endsection
