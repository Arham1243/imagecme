<div class="case-details__comments" id="comments-section">
    @foreach (json_decode($case->ai_conversation) as $comment)
        @if ($comment->isUserMessage == false)
            <div class="comment-card" x-data="{ isEditMode: false, expanded: false, isHeightExceeded: false }" x-init=" const commentElement = $el.querySelector('.comment');
             if (commentElement.scrollHeight > 82) { isHeightExceeded = true; }">
                <div class="comment-card__avatar p-2">
                    <img src="{{ asset('user/assets/images/gpt.svg') }}" alt="image" class="imgFluid" loading="lazy"
                        style="filter:invert(1)">
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
                            <div class="user-uploaded-images">
                                @foreach ($comment->images as $image)
                                    <a href="{{ $image->url }}" data-fancybox="gallery" class="image-mask">
                                        <img src="{{ $image->url }}">
                                    </a>
                                @endforeach
                            </div>
                        @endif

                    </div>

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
