@extends('frontend.layouts.main')
@section('content')

    <div class="loader-mask" id="loader">
        <div class="loader"></div>
    </div>

    <div class="case-details case-details-bg">
        <a href="{{ route('frontend.cases.details', $case->slug) }}" class="back-btn"><i class="bx bx-chevron-left"></i></a>
        <div class="container">
            <div class="row g-0">
                <div class="col-md-12">
                    <div class="case-details__image">
                        <img src="{{ asset($case->featured_image ?? 'admin/assets/images/placeholder.png') }}"
                            alt="image" class="imgFluid" loading="lazy">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="case-details__content">
                        <div class="title">{{ $case->title }}</div>
                        <div class="case-actions-wrapper">
                            <div class="user-profile">
                                <div class="user-profile___avatar">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($case->user->full_name ?? 'Anonymous') }}&amp;size=80&amp;rounded=true&amp;background=random"
                                        alt="{{ $case->user->full_name ?? 'Anonymous' }}" class="imgFluid" loading="lazy">
                                </div>
                                <div class="user-profile__info">
                                    <div title="{{ $case->user->full_name ?? 'Anonymous' }}" class="name"
                                        data-tooltip="tooltip">{{ $case->user->full_name ?? 'Anonymous' }}
                                        @if ($case->user)
                                            <i class='bx bxs-check-circle'></i>
                                        @endif
                                    </div>
                                    <div class="level">{{ $case->user->role ?? '' }}</div>
                                </div>
                            </div>
                            <ul class="case-actions">
                                <li>
                                    <x-like-button :caseId="$case->id" class="case-actions-item" show-count />
                                </li>
                                <li>
                                    <x-send-button :caseId="$case->id" class="case-actions-item" theme="dark" showText />
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="case-details__details">
                        <div class="d-flex gap-3 flex-wrap">
                            <div class="date">{{ formatBigNumber($case->views->count()) }}
                                {{ $case->views->count() === 1 ? 'view' : 'views' }}</div>
                            <div class="date">{{ formatDate($case->created_at) }}</div>
                        </div>
                        <div x-data="{ expanded: false }" :class="{ 'd-block': expanded }" class="case-details-list"
                            data-show-more-container>
                            <button x-on:click="expanded = !expanded"
                                x-text="expanded ? $el.getAttribute('data-less-content') : $el.getAttribute('data-more-content')"
                                type="button" data-more-content="..more" data-less-content="Show Less"
                                data-show-more-btn></button>
                            @if (!empty($case->diagnosis_title))
                                <li><strong>Diagnosis Title:</strong> {{ $case->diagnosis_title }}</li>
                            @endif
                            @if (!empty($case->diagnosed_disease))
                                <li><strong>Diagnosed Disease:</strong> {{ $case->diagnosed_disease }}</li>
                            @endif
                            @if (!empty($case->ease_of_diagnosis))
                                <li><strong>Ease of Diagnosis:</strong> {{ $case->ease_of_diagnosis }}</li>
                            @endif
                            @if (!empty($case->certainty))
                                <li><strong>Certainty:</strong> {{ $case->certainty }}</li>
                            @endif
                            @if (!empty($case->ethnicity))
                                <li><strong>Ethnicity:</strong> {{ $case->ethnicity }}</li>
                            @endif
                            @if (!empty($case->segment))
                                <li><strong>Segment:</strong> {{ $case->segment }}</li>
                            @endif
                            @if (!empty($case->image_quality))
                                <li><strong>Image Quality:</strong> {{ $case->image_quality }}</li>
                            @endif
                            @if (!empty($case->clinical_examination))
                                <li><strong>Clinical Examination:</strong> {{ $case->clinical_examination }}</li>
                            @endif
                            @if (!empty($case->patient_age))
                                <li><strong>Patient Age:</strong> {{ $case->patient_age }}</li>
                            @endif
                            @if (!empty($case->patient_gender))
                                <li><strong>Patient Gender:</strong> {{ $case->patient_gender }}</li>
                            @endif
                            @if (!empty($case->patient_socio_economic))
                                <li><strong>Patient Socio-Economic Status:</strong> {{ $case->patient_socio_economic }}
                                </li>
                            @endif
                            @if (!empty($case->patient_concomitant))
                                <li><strong>Patient Concomitant:</strong> {{ $case->patient_concomitant }}</li>
                            @endif
                            @if (!empty($case->patient_others))
                                <li><strong>Patient Others:</strong> {{ $case->patient_others }}</li>
                            @endif
                            @if (json_decode($case->authors)[0]->name && json_decode($case->authors)[0]->doi)
                                <li class="d-block"><strong>Authors:</strong>
                                    <ul class="ms-0">
                                        @foreach (json_decode($case->authors) as $author)
                                            <li class="d-block">
                                                @if (!empty($author->name))
                                                    <strong>Name:</strong> {{ $author->name }}<br>
                                                @endif
                                                @if (!empty($author->doi))
                                                    <strong>DOI:</strong> {{ $author->doi }}<br>
                                                @endif
                                                @if (!empty($author->article_link))
                                                    <strong>Article Link:</strong> <a class="link"
                                                        href="{{ $author->article_link }}"
                                                        title="{{ $author->article_link }}" data-tooltip="tooltip"
                                                        target="_blank">Open in new tab</a>
                                                @endif
                                            </li>
                                            <hr>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                            <div class="editor-content">
                                {!! $case->content !!}
                            </div>
                        </div>
                    </div>
                    @if (!in_array($case->case_type, ['share_image_diagnosis', 'ask_ai_image_diagnosis']))
                        @include('frontend.cases.types.comment-case')
                    @endif
                    @if ($case->case_type === 'ask_ai_image_diagnosis' && $case->ai_conversation && $case->publish_ai_conversation === 1)
                        @include('frontend.cases.types.ai-case')
                    @endif
                </div>
                @if ($groupImages->isNotEmpty())
                    <div class="col-md-4">
                        <div class="gallery-category-wrapper">
                            @foreach ($groupImages as $type => $images)
                                <div class="gallery-category">
                                    <div class="gallery-category__title">{{ $type }}</div>
                                    <div class="row">
                                        @foreach ($images as $image)
                                            <div class="col-md-6">
                                                <div class="gallery-category__item">
                                                    <a href="{{ asset($image->path) }}" data-fancybox="gallery"
                                                        class="cover-image">
                                                        @php
                                                            $extension = pathinfo($image->path, PATHINFO_EXTENSION);
                                                        @endphp
                                                        @if (in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                                            <video>
                                                                <source src="{{ asset($image->path) }}"
                                                                    type="video/{{ $extension }}">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        @elseif (strtolower($extension) === 'gif')
                                                            <img src="{{ asset($image->path) }}"
                                                                alt="{{ $image->name ?? 'GIF image' }}" class="imgFluid"
                                                                loading="lazy">
                                                        @else
                                                            <img src="{{ asset($image->path) }}"
                                                                alt="{{ $image->name ?? 'image' }}" class="imgFluid"
                                                                loading="lazy">
                                                        @endif
                                                    </a>
                                                    <div class="cover-name">{{ $image->name }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('css')
    <script defer src="{{ asset('admin/assets/js/alpine.min.js') }}"></script>

    <style>
        header,
        footer {
            display: none;
        }

        .tooltip-inner {
            background-color: #fff;
            color: #000;
        }

        .tooltip-arrow::before {
            border-top-color: #fff !important;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/emoji-mart@5.6.0/dist/browser.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const forms = document.querySelectorAll('.comment-form');

            forms.forEach((form) => {
                const commentInput = form.querySelector('.comment-input');
                const emojiButton = form.querySelector('.emoji-picker');
                const commentButton = form.querySelector('.comment-btn');
                const emojiPickerContainer = form.querySelector('.emoji-picker-container');
                let picker;

                picker = new EmojiMart.Picker({
                    onEmojiSelect: emoji => {
                        commentInput.value += emoji.native;
                        toggleCommentButton();
                    },
                    emojiSize: 25,
                    set: 'apple',
                    include: (emoji) => {
                        const excludeEmojis = ['🫥'];
                        return !excludeEmojis.includes(emoji.native);
                    }
                });

                emojiPickerContainer.appendChild(picker);

                emojiButton.addEventListener('click', function(event) {
                    event.stopPropagation();
                    if (emojiPickerContainer.style.display === 'none' || emojiPickerContainer
                        .innerHTML === '') {
                        emojiPickerContainer.style.display = 'block';
                    } else {
                        emojiPickerContainer.style.display = 'none';
                    }
                });

                document.addEventListener('click', function(event) {
                    if (!emojiPickerContainer.contains(event.target) && event.target !==
                        emojiButton) {
                        emojiPickerContainer.style.display = 'none';
                    }
                });

                commentInput.addEventListener('input', toggleCommentButton);

                function toggleCommentButton() {
                    commentButton.disabled = !commentInput.value.trim();
                }

                commentInput.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
                commentInput.addEventListener('focus', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });

                toggleCommentButton();
            });
        });
    </script>
@endpush
