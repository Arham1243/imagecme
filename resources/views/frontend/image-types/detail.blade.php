@extends('frontend.layouts.main')
@section('content')
    <div class='imaging-detail'>
        <div class="imaging-detail__img">
            <img src='{{ asset($item->featured_image ?? 'admin/assets/images/placeholder.png') }}' alt='{{ $item->name }}'
                class='imgFluid' loading='lazy'>
        </div>
        <div class='container'>
            <div class="imaging-detail__content section-content">
                <div class="heading">{{ $item->name }}</div>
                <div class="editor-content">
                    {!! $item->content !!}
                </div>
            </div>
        </div>
    </div>

    @if ($cases->isNotEmpty())
        <div class='cases py-5'>
            <div class='container'>
                <div class='row'>
                    @foreach ($cases as $case)
                        <div class='col-md-6'>
                            <x-case-card :case="$case" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
@push('js')
    <script>
        const likeCase = async (likeBtn, caseId) => {
            try {
                const action = likeBtn.getAttribute('data-action');
                const slug = likeBtn.getAttribute('data-slug');

                const likeCaseRoute =
                    `{{ route('frontend.cases.comments.likeCase', ['slug' => ':slug', 'action' => ':action']) }}`
                    .replace(':slug', slug)
                    .replace(':action', action);

                const response = await axios.post(likeCaseRoute, {
                    caseId,
                    action
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
                console.error(error);
            }
        }
    </script>
@endpush
