<div class='cases-card'>
    <div class="cases-card__header">
        <div class="type-badge">
            {{ getRelativeType($case->case_type) }}</div>
        <div class="title" @if (Str::length($case->title) > 51) title="{{ $case->title }}" data-tooltip="tooltip" @endif>
            {{ $case->title ?? 'N/A' }}</div>

    </div>
    <div class="row g-0 align-items-center">
        <div class="col-md-4">
            <a href="{{ route('frontend.cases.details', $case->slug) }}" class='cases-card__img'>
                <img src='{{ asset($case->featured_image) }}' alt='image' class='imgFluid'>
            </a>
        </div>
        <div class="col-md-8">
            <div class='cases-card__content'>
                @if ($case->diagnosis_title)
                    <div class="content title">Diagnosis: {{ $case->diagnosis_title ?? 'N/A' }}</div>
                @endif
                @if ($case->certainty)
                    <div class="content certain">
                        <div class="level {{ $case->certainty === 'Uncertain' ? 'yellow' : 'green' }}"></div>
                        Certainty: {{ $case->certainty }}
                    </div>
                @endif
                <div class="content">Author: {{ $case->user->full_name ?? 'Anonymous' }}</div>
                <div class="content">Date Published: {{ formatDate($case->created_at) }}</div>
                @if ($case->diagnosed_disease)
                    <div class="content">Disease Specialty: {{ $case->diagnosed_disease ?? 'N/A' }}</div>
                @endif
                <div class="content d-flex align-items-center gap-2">Image Type:
                    @php
                        $groupImages = $case
                            ->images()
                            ->with('imageType')
                            ->get()
                            ->groupBy(fn($image) => $image->imageType->name ?? 'Unknown');
                    @endphp
                    @if ($groupImages->isNotEmpty())
                        <ul class="image-badges">
                            @foreach ($groupImages as $type => $images)
                                <li class="image-badge">{{ $type }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="case-card__footer">
                <div class="reaction-list">
                    @php
                        $likedUsers = $case->likes()->with('user')->take(3)->get()->pluck('user');
                        $showLikedUsers = $case->likes()->with('user')->take(1)->get()->pluck('user');
                    @endphp
                    <div class="reaction-list__likes">
                        @if ($likedUsers->isNotEmpty() && $showLikedUsers->isNotEmpty())
                            <div class="people">
                                @foreach ($likedUsers as $user)
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->full_name ?? 'Anonymous') }}&amp;size=80&amp;rounded=true&amp;background=random"
                                        alt="{{ $user->full_name }}" class="imgFluid" loading="lazy">
                                @endforeach
                            </div>
                            <div class="names">
                                @if ($case->likes->count() > 1)
                                    {{ implode(', ', $showLikedUsers->pluck('full_name')->toArray()) }} and
                                    {{ formatBigNumber($case->likes->count() - 1) }} others
                                @else
                                    {{ implode(', ', $showLikedUsers->pluck('full_name')->toArray()) }}
                                @endif
                            </div>
                        @else
                            <div class="names">Be the first to like this case</div>
                        @endif
                    </div>
                    <div class="reaction-list__comments">
                        <span>{{ formatBigNumber($case->views->count()) }} views</span>
                        @if ($case->case_type !== 'share_image_diagnosis')
                            <span><i class='bx bxs-circle'></i></span>
                            <span><a href="{{ route('frontend.cases.comments.index', $case->slug) }}">{{ formatBigNumber($case->comments->count()) }}
                                    comments</a></span>
                        @endif
                    </div>
                </div>
                <ul class="reaction-action">
                    <li>
                        <x-like-button :caseId="$case->id" class="reaction-action-item" label="Like" />
                    </li>
                    @if ($case->case_type !== 'share_image_diagnosis')
                        <li>
                            <a data-label="Comment" href="{{ route('frontend.cases.comments.index', $case->slug) }}"
                                class="reaction-action-item">
                                <i class='bx bxs-message-rounded-dots'></i> </a>
                        </li>
                    @endif
                    <li>
                        <x-send-button :caseId="$case->id" class="reaction-action-item" label="Send"
                            theme="{{ $send_popup_theme }}" />
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
