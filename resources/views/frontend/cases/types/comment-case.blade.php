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
                <form action="{{ route('frontend.cases.comments.submitMcqAnswer', $case->slug) }}" method="POST"
                    @if ($userAnswer) x-data="{selectedAnswer:'{{ $userAnswer }}'}"
                    @else
                    x-data="{selectedAnswer:''}" @endif>
                    @csrf
                    <ul class="options">
                        @foreach ($mcqData->answers as $i => $answer)
                            <li
                                class="option-item 
                        {{ !Auth::check() || (isset($userAnswer) && $userAnswer !== $answer && $userAnswer !== null) ? 'disabled' : '' }}">
                                <input type="radio" name="answer" class="option-item__input"
                                    id="answer-{{ $i }}" value="{{ $answer }}" x-model="selectedAnswer"
                                    {{ !Auth::check() || (isset($userAnswer) && $userAnswer !== $answer) || $case->is_finish ? 'disabled' : '' }}>
                                <label for="answer-{{ $i }}"
                                    class="option-item__label {{ $userAnswer ? ($mcqData->answers[$mcqData->correct_answer] === $userAnswer ? 'correct' : 'wrong') : '' }}">
                                    {{ $answer }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                    @if (Auth::check() && !$userAnswer && !$case->is_finish)
                        <button class="action-btn comment-btn ms-auto" :disabled="!selectedAnswer">Submit</button>
                    @endif
                    @if ($userAnswer || $case->is_finish)
                        <div class="explantion">
                            @if (Auth::check() && $userAnswer)
                                <div class="title">
                                    {{ $mcqData->answers[$mcqData->correct_answer] === $userAnswer ? 'Correct' : 'Wrong' }}
                                    Answer</div>
                            @endif
                            <p>Correct answer is {{ $mcqData->answers[$mcqData->correct_answer] }}</p>
                            <div class="title">Reason</div>
                            <p>{{ $mcqData->correct_reason }}</p>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endif
<div class="case-details__comments" id="comments-section">
    <div class="heading">{{ count($comments) }} {{ count($comments) === 1 ? 'Comment' : 'Comments' }}</div>
    @if (!$case->is_finish)
        @if (Auth::check())
            <div class="comment-card mb-4 pb-2">
                <div class="comment-card__avatar">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->full_name ?? 'Anonymous') }}&amp;size=80&amp;rounded=true&amp;background=random"
                        alt="image" class="imgFluid" loading="lazy">
                </div>
                <div class="comment-card__fields">
                    <form action="{{ route('frontend.cases.comments.store', $case->slug) }}" method="POST"
                        class="comment-form">
                        @csrf

                        @if (isset($userCaseAnswer) && $userAnswer)
                            <input type="hidden" name="selected_answer" value="{{ $userCaseAnswer->id }}" />
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
                    class="link">Login</a>
                to your account
                to write a comment.
            </div>
        @endif
    @else
        <div class="subHeading mb-4 pb-2">
            {{ $case->user->full_name ?? 'Anonymous' }} has finished the MCQ.
        </div>
    @endif
    @if ($comments->isNotEmpty())
        @foreach ($comments as $comment)
            <div class="comment-card" x-data="parentComment($el)" x-init="init()">
                @if ($case->case_type === 'ask_image_diagnosis')
                    @if (!Auth::check())
                        <a href="{{ route('auth.login', ['redirect_url' => url()->current()]) }}" class="votes">
                            <button
                                class="votes-btn upvote-btn {{ $comment->votes->where('user_id', auth()->id())->where('is_upvote', true)->first() ? 'fill' : '' }}"
                                data-slug="{{ $case->slug }}" data-comment-id="{{ $comment->id }}"
                                data-action="upvote" onclick="voteCase(this, {{ $comment->id }}, 'upvote')">
                                <i class='bx bxs-up-arrow'></i>
                            </button>
                            <div class="votes-count total">{{ $comment->upvotes->count() }}</div>
                            <button
                                class="votes-btn downvote-btn {{ $comment->votes->where('user_id', auth()->id())->where('is_upvote', false)->first() ? 'fill' : '' }}"
                                data-slug="{{ $case->slug }}" data-comment-id="{{ $comment->id }}"
                                data-action="downvote" onclick="voteCase(this, {{ $comment->id }}, 'downvote')">
                                <i class='bx bxs-down-arrow'></i>
                            </button>
                        </a>
                    @else
                        <div class="votes">
                            <button
                                class="votes-btn upvote-btn {{ $comment->votes->where('user_id', auth()->id())->where('is_upvote', true)->first() ? 'fill' : '' }}"
                                data-slug="{{ $case->slug }}" data-comment-id="{{ $comment->id }}"
                                data-action="upvote" onclick="voteCase(this, {{ $comment->id }}, 'upvote')">
                                <i class='bx bxs-up-arrow'></i>
                            </button>
                            <div class="votes-count total">{{ $comment->upvotes->count() }}</div>
                            <button
                                class="votes-btn downvote-btn {{ $comment->votes->where('user_id', auth()->id())->where('is_upvote', false)->first() ? 'fill' : '' }}"
                                data-slug="{{ $case->slug }}" data-comment-id="{{ $comment->id }}"
                                data-action="downvote" onclick="voteCase(this, {{ $comment->id }}, 'downvote')">
                                <i class='bx bxs-down-arrow'></i>
                            </button>
                        </div>
                    @endif
                @endif
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
                    <button x-show="isHeightExceeded" class="position-static px-0 pt-2"
                        x-on:click="expanded = !expanded"
                        x-text="expanded ? $el.getAttribute('data-less-content') : $el.getAttribute('data-more-content')"
                        style="background: #0E0E0E" type="button" data-more-content="Read more"
                        data-less-content="Show Less" data-show-more-btn></button>
                    @if (!$case->is_finish)
                        <div class="comment-actions">
                            <button type="button" class="text-btn" @click="isReplyMode = true">Reply</button>
                        </div>
                        <div x-show="isReplyMode" class="comment-card">
                            <div class="comment-card__avatar comment-card__avatar--sm">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->full_name ?? 'Anonymous') }}&amp;size=80&amp;rounded=true&amp;background=random"
                                    alt="image" class="imgFluid" loading="lazy">
                            </div>
                            <div class="comment-card__fields">
                                <form
                                    action="{{ route('frontend.cases.comment.reply.store', ['slug' => $case->slug, 'id' => $comment->id]) }}"
                                    method="POST" class="comment-form">
                                    @csrf
                                    <textarea class="comment-input" type="text" placeholder="Add a reply..." autocomplete="off" required
                                        name="reply_text" rows="1"></textarea>
                                    <div class="actions-wrapper">
                                        <div class="emoji-picker-wrapper">
                                            <button type="button" class="emoji-picker">
                                                <i class="bx bx-smile"></i>
                                            </button>
                                            <div class="emoji-picker-container" style="display: none;"></div>
                                        </div>
                                        <div class="actions-btns">
                                            <button @click="isReplyMode = false" type="button"
                                                class="action-btn cancel-btn">Cancel</button>
                                            <button class="action-btn  comment-btn" disabled>Reply</button>
                                        </div>
                                    </div>
                                    @error('comment')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </form>
                            </div>
                        </div>
                    @endif

                    @if (count($comment->replies) > 0)
                        <div x-data="{ showReplies: false }">
                            <div class="show-replies">
                                <button class="text-btn" @click="showReplies = !showReplies;">
                                    <i class='bx' :class="showReplies ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                    {{ formatBigNumber(count($comment->replies)) }}
                                    {{ count($comment->replies) === 1 ? 'reply' : 'replies' }}
                                </button>
                            </div>

                            <div x-show="showReplies">
                                @if ($comment->replies->isNotEmpty())
                                    @php
                                        $sortedReplies = $comment->replies->sortBy('created_at');
                                        $uniqueReplies = $sortedReplies->unique('id');
                                    @endphp

                                    @foreach ($uniqueReplies as $reply)
                                        @include('frontend.cases.types.comments.reply', [
                                            'reply' => $reply,
                                            'parentId' => null,
                                        ])
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
                @if (Auth::check() && Auth::user()->id === $comment->user_id && !$case->is_finish)
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
                                        <div class="emoji-picker-container" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="actions-btns">
                                        <button @click="isEditMode = false" type="button"
                                            class="action-btn cancel-btn">Cancel</button>
                                        <button class="action-btn comment-btn" disabled>Save</button>
                                    </div>
                                </div>
                                @error('comment')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </form>
                        </div>
                    @endif
                    @if (!$case->is_finish)
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
                @endif
            </div>
        @endforeach
    @endif
</div>
@push('js')
    <script>
        function parentComment($el) {
            return {
                isEditMode: false,
                isReplyMode: false,
                expanded: false,
                isHeightExceeded: false,
                commentElement: $el.querySelector('.comment'),
                isHeightExceeded: false,
                init() {
                    if (this.commentElement.scrollHeight > 82) {
                        this.isHeightExceeded = true;
                    }
                }
            }
        }
        @if ($case->case_type === 'ask_image_diagnosis')
            const voteCase = async (voteBtn, commentId, action) => {
                try {
                    const slug = voteBtn.getAttribute('data-slug');
                    const currentUrl = window.location.href;

                    const route =
                        `{{ route('frontend.cases.comments.voteCase', ['slug' => ':slug', 'comment_id' => ':comment_id']) }}`
                        .replace(':slug', slug)
                        .replace(':comment_id', commentId);

                    const response = await axios.post(route, {
                        action,
                        current_url: currentUrl,
                    });

                    const counter = voteBtn.closest('.votes').querySelector('.votes-count');
                    const upvoteBtn = voteBtn.closest('.votes').querySelector('.upvote-btn');
                    const downvoteBtn = voteBtn.closest('.votes').querySelector('.downvote-btn');

                    // Update UI based on action
                    if (response.data.action === 'upvote') {
                        upvoteBtn.classList.add('fill');
                        downvoteBtn.classList.remove('fill');
                        upvoteBtn.setAttribute('data-action', 'downvote');
                        downvoteBtn.setAttribute('data-action', 'upvote');
                    } else if (response.data.action === 'downvote') {
                        downvoteBtn.classList.add('fill');
                        upvoteBtn.classList.remove('fill');
                        upvoteBtn.setAttribute('data-action', 'upvote');
                        downvoteBtn.setAttribute('data-action', 'downvote');
                    } else {
                        upvoteBtn.classList.remove('fill');
                        downvoteBtn.classList.remove('fill');
                    }

                    counter.textContent = response.data.votesCount;
                    showMessage('Vote submitted successfully', 'success', 'top-right');
                } catch (error) {
                    if (error.response && error.response.status === 401) {
                        window.location.href = error.response.data.redirect_url;
                    } else {
                        showMessage('An error occurred. Please try again.', 'error', 'top-right');
                    }
                }
            };
        @endif
    </script>
@endpush
