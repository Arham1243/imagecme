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
                        <div class="title">{{ $case->diagnosed_disease }}</div>
                        <div class="user-profile">
                            <div class="user-profile___avatar">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($case->user->full_name ?? 'Anonymous') }}&amp;size=80&amp;rounded=true&amp;background=random"
                                    alt="image" class="imgFluid" loading="lazy">
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
                    </div>
                    <div class="case-details__details">
                        <div class="date">{{ formatDate($case->created_at) }}</div>


                        <div x-data="{ expanded: false }" :class="{ 'd-block': expanded }" class="case-details-list"
                            data-show-more-container>
                            <button x-on:click="expanded = !expanded"
                                x-text="expanded ? $el.getAttribute('data-less-content') : $el.getAttribute('data-more-content')"
                                type="button" data-more-content="..more" data-less-content="Show Less"
                                data-show-more-btn></button>
                            <li><strong>Diagnosis Title:</strong> {{ $case->diagnosis_title }}</li>
                            <li><strong>Diagnosed Disease:</strong> {{ $case->diagnosed_disease }}
                            </li>
                            <li><strong>Ease of Diagnosis:</strong> {{ $case->ease_of_diagnosis }}
                            </li>
                            <li><strong>Certainty:</strong> {{ $case->certainty }}</li>
                            <li><strong>Ethnicity:</strong> {{ $case->ethnicity }}</li>
                            <li><strong>Segment:</strong> {{ $case->segment }}</li>
                            <li><strong>Image Quality:</strong> {{ $case->image_quality }}</li>
                            <li><strong>Clinical Examination:</strong>
                                {{ $case->clinical_examination }}</li>
                            <li><strong>Patient Age:</strong> {{ $case->patient_age }}</li>
                            <li><strong>Patient Gender:</strong> {{ $case->patient_gender }}</li>
                            <li><strong>Patient Socio-Economic Status:</strong>
                                {{ $case->patient_socio_economic }}</li>
                            <li><strong>Patient Concomitant:</strong>
                                {{ $case->patient_concomitant }}
                            </li>
                            <li><strong>Patient Others:</strong> {{ $case->patient_others }}</li>
                            @if (!empty(json_decode($case->authors)))
                                <li class="d-block"><strong>Authors:</strong>
                                    <ul class="ms-0">
                                        @foreach (json_decode($case->authors) as $author)
                                            <li class="d-block">
                                                @if ($author->name)
                                                    <strong>Name:</strong> {{ $author->name }}<br>
                                                @endif
                                                @if ($author->doi)
                                                    <strong>DOI:</strong> {{ $author->doi }}<br>
                                                @endif
                                                @if ($author->article_link)
                                                    <strong>Article Link:</strong> <a class="link"
                                                        href="{{ $author->article_link }}"
                                                        title="{{ $author->article_link }}" data-tooltip="tooltip"
                                                        target="_blank">Open
                                                        in
                                                        new
                                                        tab</a>
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
                    @if ($case->mcq_data)
                        @php
                            $userCaseAnswer = Auth::user()
                                ?->userMcqAnswers->where('case_id', $case->id)
                                ->first();
                            $mcqData = json_decode($case->mcq_data)[0];

                            $userAnswer = $userCaseAnswer->answer ?? null;
                        @endphp
                        <div class="mt-5 mb-2">
                            <div class="comment-card">
                                <div class="comment-card__avatar">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($case->user->full_name ?? 'Anonymous') }}&amp;size=80&amp;rounded=true&amp;background=random"
                                        alt="image" class="imgFluid" loading="lazy">
                                </div>
                                <div x-show="!isEditMode" class="comment-card__details">
                                    <div class="wrapper">
                                        <div class="name">
                                            {{ $case->user ? $case->user->full_name : 'Anonymous' }}
                                            @if ($case->user && $case->user->id === $case->user_id)
                                                <div class="author">Author</div>
                                            @endif
                                        </div>
                                        <div class="time">{{ $case->created_at->diffForHumans() }}</div>

                                    </div>
                                    <div class="comment comment--lg">{{ $mcqData->question }}</div>
                                    <form action="{{ route('frontend.cases.comments.submitMcqAnswer', $case->slug) }}"
                                        method="POST">
                                        @csrf
                                        <ul class="options">
                                            @foreach ($mcqData->answers as $i => $answer)
                                                <li class="option-item">
                                                    <input type="radio" name="answer" class="option-item__input"
                                                        id="answer-{{ $i }}" value="{{ $answer }}"
                                                        {{ $userAnswer === $answer ? 'checked' : '' }}
                                                        onclick="toggleSubmitButton()">
                                                    <label for="answer-{{ $i }}"
                                                        class="option-item__label">{{ $answer }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @if (Auth::check() && !$userAnswer)
                                            <button class="action-btn comment-btn ms-auto" id="submitButton">Submit</button>
                                        @endif

                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!in_array($case->case_type, ['share_image_diagnosis', 'ask_ai_image_diagnosis']))
                        <div class="case-details__comments" id="comments-section">
                            <div class="heading">{{ count($comments) }} Comments</div>
                            @if (Auth::check())
                                <div class="comment-card mb-4 pb-2">
                                    <div class="comment-card__avatar">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->full_name ?? 'Anonymous') }}&amp;size=80&amp;rounded=true&amp;background=random"
                                            alt="image" class="imgFluid" loading="lazy">
                                    </div>
                                    <div class="comment-card__fields">
                                        <form action="{{ route('frontend.cases.comments.store', $case->slug) }}"
                                            method="POST" class="comment-form">
                                            @csrf

                                            @if (isset($userCaseAnswer) && $userAnswer)
                                                <input type="hidden" name="selected_answer"
                                                    value="{{ $userCaseAnswer->id }}" />
                                                <div class="selected-answer ms-2">
                                                    <span>Your Answer</span>
                                                    {{ $userAnswer }}
                                                </div>
                                            @endif

                                            <textarea class="comment-input" type="text" placeholder="Add a comment..." autocomplete="off" required name="comment"
                                                rows="1"></textarea>
                                            <div class="actions-wrapper">
                                                <div class="emoji-picker-wrapper">
                                                    <button type="button" class="emoji-picker">
                                                        <i class="bx bx-smile"></i>
                                                    </button>
                                                    <div class="emoji-picker-container" style="display: none;"></div>
                                                </div>
                                                <div class="actions-btns">
                                                    <button class="action-btn  comment-btn" disabled>Comment</button>
                                                </div>
                                            </div>
                                            @error('comment')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </form>
                                    </div>


                                </div>
                            @else
                                <div class="subHeading mb-4 pb-2">
                                    Please <a href="{{ route('auth.login', ['redirect_url' => url()->current()]) }}"
                                        class="link">Login</a> to your account
                                    to write a comment.
                                </div>
                            @endif
                            @if ($comments->isNotEmpty())
                                @foreach ($comments as $comment)
                                    <div class="comment-card" x-data="{ isEditMode: false, expanded: false, isHeightExceeded: false }" x-init=" const commentElement = $el.querySelector('.comment');
                                     if (commentElement.scrollHeight > 82) { isHeightExceeded = true; }">

                                        <div class="comment-card__avatar">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->full_name ?? 'Anonymous') }}&amp;size=80&amp;rounded=true&amp;background=random"
                                                alt="image" class="imgFluid" loading="lazy">
                                        </div>

                                        <div x-show="!isEditMode" class="comment-card__details">

                                            <div class="wrapper">
                                                <div class="name">
                                                    {{ $comment->user ? $comment->user->full_name : 'Anonymous' }}
                                                    @if ($comment->user && $comment->user->id === $case->user_id)
                                                        <div class="author">Author</div>
                                                    @endif
                                                </div>
                                                <div class="time">{{ $comment->created_at->diffForHumans() }}</div>
                                                @if ($comment->edited_at)
                                                    <div class="time">(edited)</div>
                                                @endif
                                            </div>
                                            @if ($comment->selected_answer && $comment->userAnswer)
                                                <div class="selected-answer ms-2">
                                                    <span>Your Answer</span>
                                                    {{ $comment->userAnswer->answer }}
                                                </div>
                                            @endif
                                            <div :class="{ 'd-block': expanded }" class="comment" data-show-more-container>
                                                {!! nl2br(e($comment->comment_text)) !!}
                                            </div>

                                            @php
                                                $isLongComment = strlen($comment->comment_text) > 463;
                                            @endphp

                                            <button x-show="isHeightExceeded" class="position-static px-0 pt-2"
                                                x-on:click="expanded = !expanded"
                                                x-text="expanded ? $el.getAttribute('data-less-content') : $el.getAttribute('data-more-content')"
                                                style="background: #0E0E0E" type="button" data-more-content="Read more"
                                                data-less-content="Show Less" data-show-more-btn></button>
                                        </div>
                                        @if (Auth::check() && Auth::user()->id === $comment->user_id)
                                            @if ($comment->canEdit)
                                                <div x-show="isEditMode" class="comment-card__fields">
                                                    <form
                                                        action="{{ route('frontend.cases.comments.update', ['slug' => $case->slug, 'comment' => $comment->id]) }}"
                                                        method="POST" class="comment-form">
                                                        @csrf
                                                        @method('PATCH')

                                                        @if ($comment->selected_answer && $comment->userAnswer)
                                                            <input type="hidden" name="selected_answer"
                                                                value="{{ $comment->userAnswer->id }}" />
                                                            <div class="selected-answer ms-2">
                                                                <span>Your Answer</span>
                                                                {{ $comment->userAnswer->answer }}
                                                            </div>
                                                        @endif
                                                        <textarea class="comment-input" type="text" placeholder="Add a comment..." autocomplete="off" required
                                                            name="comment" rows="1">{{ $comment->comment_text }}</textarea>
                                                        <div class="actions-wrapper">
                                                            <div class="emoji-picker-wrapper">
                                                                <button type="button" class="emoji-picker">
                                                                    <i class="bx bx-smile"></i>
                                                                </button>
                                                                <div class="emoji-picker-container"
                                                                    style="display: none;">
                                                                </div>
                                                            </div>
                                                            <div class="actions-btns">
                                                                <button @click="isEditMode = false" type="button"
                                                                    class="action-btn cancel-btn">Cancel</button>
                                                                <button class="action-btn comment-btn"
                                                                    disabled>Save</button>
                                                            </div>
                                                        </div>
                                                        @error('comment')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </form>
                                                </div>
                                            @endif
                                            <div x-show="!isEditMode" class="dropstart bootsrap-dropdown">
                                                <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class='bx bx-dots-vertical-rounded'></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @if ($comment->canEdit)
                                                        <li>
                                                            <a class="dropdown-item edit-btn" href="javascript:void(0)"
                                                                @click="isEditMode = true">
                                                                <i class='bx bx-pencil'></i>
                                                                Edit
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('frontend.cases.comments.deleteItem', ['slug' => $case->slug, 'id' => $comment->id]) }}"
                                                            onclick="return confirm('Are you sure you want to delete this comment?')">

                                                            <i class='bx bx-trash'></i>
                                                            delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    @endif
                    @if ($case->case_type === 'ask_ai_image_diagnosis' && $case->ai_conversation && $case->publish_ai_conversation === 1)
                        <div class="case-details__comments" id="comments-section">
                            @foreach (json_decode($case->ai_conversation) as $comment)
                                @if ($comment->isUserMessage == false)
                                    <div class="comment-card" x-data="{ isEditMode: false, expanded: false, isHeightExceeded: false }" x-init=" const commentElement = $el.querySelector('.comment');
                                     if (commentElement.scrollHeight > 82) { isHeightExceeded = true; }">
                                        <div class="comment-card__avatar p-2">
                                            <img src="{{ asset('user/assets/images/gpt.svg') }}" alt="image"
                                                class="imgFluid" loading="lazy" style="filter:invert(1)">
                                        </div>
                                        <div x-show="!isEditMode" class="comment-card__details">
                                            <div class="wrapper">
                                                <div class="name">
                                                    AI
                                                </div>
                                            </div>
                                            <div :class="{ 'd-block': expanded }" class="comment" data-show-more-container>
                                                {!! nl2br(e($comment->message)) !!}
                                            </div>

                                            @php
                                                $isLongComment = strlen($comment->message) > 463;
                                            @endphp

                                            <button x-show="isHeightExceeded" class="position-static px-0 pt-2"
                                                x-on:click="expanded = !expanded"
                                                x-text="expanded ? $el.getAttribute('data-less-content') : $el.getAttribute('data-more-content')"
                                                style="background: #0E0E0E" type="button" data-more-content="Read more"
                                                data-less-content="Show Less" data-show-more-btn></button>
                                        </div>
                                    </div>
                                @else
                                    <div class="comment-card" x-data="{ isEditMode: false, expanded: false, isHeightExceeded: false }" x-init=" const commentElement = $el.querySelector('.comment');
                                     if (commentElement.scrollHeight > 82) { isHeightExceeded = true; }">

                                        <div class="comment-card__avatar">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($case->user->full_name ?? 'Anonymous') }}&amp;size=80&amp;rounded=true&amp;background=random"
                                                alt="image" class="imgFluid" loading="lazy">
                                        </div>
                                        <div x-show="!isEditMode" class="comment-card__details">
                                            <div class="wrapper">
                                                <div class="name">
                                                    {{ $case->user ? $case->user->full_name : 'Anonymous' }}
                                                    <div class="author">Author</div>
                                                </div>
                                            </div>
                                            <div :class="{ 'd-block': expanded }" class="comment" data-show-more-container>
                                                {!! nl2br(e($comment->message)) !!}
                                                @if (isset($comment->images) && !empty($comment->images))
                                                    <!-- Check if images exist and are an array -->
                                                    <div class="user-uploaded-images">
                                                        @foreach ($comment->images as $image)
                                                            <a href="{{ $image->url }}" data-fancybox="gallery"
                                                                class="image-mask">
                                                                <img src="{{ $image->url }}">
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif

                                            </div>

                                            @php
                                                $isLongComment = strlen($comment->message) > 463;
                                            @endphp

                                            <button x-show="isHeightExceeded" class="position-static px-0 pt-2"
                                                x-on:click="expanded = !expanded"
                                                x-text="expanded ? $el.getAttribute('data-less-content') : $el.getAttribute('data-more-content')"
                                                style="background: #0E0E0E" type="button" data-more-content="Read more"
                                                data-less-content="Show Less" data-show-more-btn></button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
                @if ($case->image_types->isNotEmpty())
                    <div class="col-md-4">
                        <div class="gallery-category-wrapper">
                            @foreach ($case->image_types as $type => $images)
                                <div class="gallery-category">
                                    <div class="gallery-category__title">{{ $type }}</div>
                                    <div class="row">
                                        @foreach ($images as $image)
                                            <div class="col-md-6">
                                                <div class="gallery-category__item">
                                                    <a href="{{ asset($image->path) }}" data-fancybox="gallery"
                                                        class="cover-image">
                                                        <img src='{{ asset($image->path) }}'
                                                            alt='{{ $image->name ?? 'image' }}' class='imgFluid'
                                                            loading='lazy'>
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
        function toggleSubmitButton() {
            const isAnyOptionChecked = document.querySelector('input[name="answer"]:checked');
            document.getElementById('submitButton').disabled = !isAnyOptionChecked;
        }

        window.onload = toggleSubmitButton;

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
