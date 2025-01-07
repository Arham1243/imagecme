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
                <form action="{{ route('frontend.cases.comments.submitMcqAnswer', $case->slug) }}" method="POST">
                    @csrf
                    <ul class="options">
                        @foreach ($mcqData->answers as $i => $answer)
                            <li class="option-item">
                                <input type="radio" name="answer" class="option-item__input"
                                    id="answer-{{ $i }}" value="{{ $answer }}"
                                    {{ $userAnswer === $answer ? 'checked' : '' }} onclick="toggleSubmitButton()">
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
<div class="case-details__comments" id="comments-section">
    <div class="heading">{{ count($comments) }} Comments</div>
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
            Please <a href="{{ route('auth.login', ['redirect_url' => url()->current()]) }}" class="link">Login</a>
            to your account
            to write a comment.
        </div>
    @endif
    @if ($comments->isNotEmpty())
        @foreach ($comments as $comment)
            <div class="comment-card" x-data="parentComment($el)" x-init="init()">
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

                    @if (Auth::check())
                        <div class="comment-actions">
                            <button type="button" class="text-btn" @click="isReplyMode = true">Reply</button>
                        </div>
                    @endif
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
    </script>
@endpush
