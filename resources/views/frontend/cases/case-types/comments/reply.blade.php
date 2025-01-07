<div class="comment-card mb-3 mt-2" x-data="{ isEditMode: false, isReplyMode: false, expanded: false, isHeightExceeded: false }" x-init=" const commentElement = $el.querySelector('.comment');
 if (commentElement.scrollHeight > 82) { isHeightExceeded = true; }">

    <div class="comment-card__avatar comment-card__avatar--sm">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->full_name ?? 'Anonymous') }}&amp;size=80&amp;rounded=true&amp;background=random"
            alt="image" class="imgFluid" loading="lazy">
    </div>

    <div x-show="!isEditMode" class="comment-card__details">

        <div class="wrapper">
            <div class="name">
                {{ $reply->user ? $reply->user->full_name : 'Anonymous' }}
                @if ($reply->user && $reply->user->id === $case->user_id)
                    <div class="author">Author</div>
                @endif
            </div>
            <div class="time">
                {{ $reply->created_at->diffForHumans() }}</div>
            @if ($reply->edited_at)
                <div class="time">(edited)</div>
            @endif
        </div>
        <div :class="{ 'd-block': expanded }" class="comment" data-show-more-container>
            {!! nl2br(e($reply->reply_text)) !!}
        </div>
        @if (Auth::check())
            <div class="comment-actions">
                <button type="button" class="text-btn" @click="isReplyMode = true">Reply</button>
            </div>
        @endif
        <div x-show="isReplyMode" class="comment-card mt-3">
            <div class="comment-card__avatar comment-card__avatar--sm">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->full_name ?? 'Anonymous') }}&amp;size=80&amp;rounded=true&amp;background=random"
                    alt="image" class="imgFluid" loading="lazy">
            </div>
            <div class="comment-card__fields">
                <form
                    action="{{ route('frontend.cases.comment.reply.store', ['slug' => $case->slug, 'id' => $comment->id, 'parentReplyId' => $reply->id]) }}"
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

        @php
            $isLongComment = strlen($comment->reply_text) > 463;
        @endphp

        <button x-show="isHeightExceeded" class="position-static px-0 pt-2" x-on:click="expanded = !expanded"
            x-text="expanded ? $el.getAttribute('data-less-content') : $el.getAttribute('data-more-content')"
            style="background: #0E0E0E" type="button" data-more-content="Read more" data-less-content="Show Less"
            data-show-more-btn></button>
    </div>
</div>
