<div class='cases-card'>
    <div class="cases-card__header">
        <div class="title">{{ $case->diagnosis_title }}</div>
        <div class="type-badge">
            {{ $case->case_type ? getRelativeType($case->case_type) : 'N/A' }}</div>
    </div>
    <div class="row g-0 align-items-center">
        <div class="col-md-4">
            <a href="{{ route('frontend.cases.details', $case->slug) }}" class='cases-card__img'>
                <img src='{{ asset($case->featured_image) }}' alt='image' class='imgFluid'>
            </a>
        </div>
        <div class="col-md-8">
            <div class='cases-card__content'>
                <div class="content certain">
                    <div class="level {{ $case->certainty === 'Uncertain' ? 'yellow' : 'green' }}">
                    </div>
                    Diagnois {{ $case->certainty }}
                </div>
                <div class="content">{{ $case->user->full_name ?? 'Anonymous' }}</div>
                <div class="content">Published {{ formatDate($case->created_at) }}</div>
                <div class="content"> {{ $case->diagnosed_disease ?? 'N/A' }}</div>
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
</div>
