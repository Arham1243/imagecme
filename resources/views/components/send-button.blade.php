@php
    $caseUrl = route('frontend.cases.comments.index', $case->slug);
    $caseTitle = $case->diagnosis_title;
@endphp
@if (Auth::check())
    <button data-send-button data-popup-theme="{{ $theme }}" data-case-url="{{ $caseUrl }}"
        data-case-title="{{ $caseTitle }}" class="{{ $class }}"
        @if ($label) data-label="{{ $label }}" @endif type="button">
        <i class='bx bxs-paper-plane'></i>
        @if ($showText)
            Send
        @endif
    </button>
@else
    <a data-label="{{ $label }}" href="{{ route('auth.login', ['redirect_url' => url()->current()]) }}"
        class="{{ $class }}">
        <i class='bx bxs-paper-plane'></i>
        @if ($showText)
            Send
        @endif
    </a>
@endif
