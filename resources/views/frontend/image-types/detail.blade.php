@extends('frontend.layouts.main')
@section('content')
    <div class='imaging-detail section-padding'>
        <div class='container'>
            <div class='row justify-content-center'>
                <div class='col-lg-11'>
                    <div class="imaging-detail__img">
                        <img src='{{ asset($item->featured_image) }}' alt='{{ $item->name }}' class='imgFluid' loading='lazy'>
                    </div>
                    <div class="imaging-detail__content section-content">
                        <div class="heading">{{ $item->name }}</div>
                        <div class="editor-content">
                            {!! $item->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($cases->isNotEmpty())
        <div class='cases pb-5'>
            <div class='container'>
                <div class='row'>
                    @foreach ($cases as $case)
                        <div class='col-md-6'>
                            <div class='cases-card'>
                                <div class="cases-card__header">
                                    <div class="title">{{ $case->diagnosis_title }}</div>
                                    <div class="type-badge">
                                        {{ $case->case_type ? getRelativeType($case->case_type) : 'N/A' }}</div>
                                </div>
                                <div class="row g-0 align-items-center">
                                    <div class="col-md-4">
                                        <a href="{{ route('frontend.cases.details', $case->slug) }}"
                                            class='cases-card__img'>
                                            <img src='{{ asset($case->featured_image) }}' alt='image' class='imgFluid'>
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class='cases-card__content'>
                                            <div class="content certain">
                                                <div
                                                    class="level {{ $case->certainty === 'Uncertain' ? 'yellow' : 'green' }}">
                                                </div>
                                                Diagnois {{ $case->certainty }}
                                            </div>
                                            <div class="content">{{ $case->user->full_name ?? 'Anonymous' }}</div>
                                            <div class="content">Published {{ formatDate($case->created_at) }}</div>
                                            <div class="content"> {{ $case->diagnosed_disease ?? 'N/A' }}</div>
                                            @if ($case->image_types->isNotEmpty())
                                                <ul class="image-badges">
                                                    @foreach ($case->image_types as $type => $images)
                                                        <li class="image-badge">{{ $type }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
