@php
    $caseUrl = route('frontend.cases.comments.index', $case->slug);
    $caseTitle = $case->diagnosis_title;
@endphp

<button data-send-button data-popup-theme="{{ $theme }}" data-case-url="{{ $caseUrl }}"
    data-case-title="{{ $caseTitle }}" class="{{ $class }}"
    @if ($label) data-label="{{ $label }}" @endif type="button">
    <i class='bx bxs-paper-plane'></i>
    @if ($showText)
        Send
    @endif
</button>
