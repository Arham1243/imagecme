<button data-slug="{{ $case->slug }}" class="{{ $class }}" @if (!Auth::check()) disabled @endif
    @if ($label) data-label="{{ $label }}" @endif
    @if (Auth::check()) data-action="{{ $liked ? 'unlike' : 'like' }}" 
        onclick="likeCase(this, {{ $case->id }})" @endif
    type="button">
    <i class='{{ $liked ? 'bx bxs-like' : 'bx bx-like' }}'></i>
    <span class="total {{ $showCount ? 'd-block' : 'd-none' }}">{{ formatBigNumber($likesCount) }}</span>
</button>
