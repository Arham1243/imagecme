@extends('frontend.layouts.main')
@section('content')

    <div class="loader-mask" id="loader">
        <div class="loader"></div>
    </div>

    <div class='gallery case-details-bg'>
        <a href="{{ route('frontend.index') }}" class="back-btn"><i class='bx bx-chevron-left'></i></a>
        <div class='container-fluid p-0'>
            <div x-data="{
                activeImage: '{{ asset($case->featured_image ?? 'user/assets/images/placeholder.png') }}'
            }">
                <div class="gallery-box">
                    <div class='row g-0'>
                        <div class='col-md-3'>
                            <div class="gallery-sidebar">
                                <div class="gallery-sidebar__header">
                                    <div class="gallery-option active">
                                        <i class="bx bx-image"></i>
                                        <span>images</span>
                                    </div>
                                    <div class="gallery-option ">

                                    </div>
                                    <div class="gallery-option ">

                                    </div>
                                </div>
                                <div class="gallery-sidebar__body">
                                    @php
                                        $groupImages = $case
                                            ->images()
                                            ->with('imageType')
                                            ->get()
                                            ->groupBy(fn($image) => $image->imageType->name ?? 'Unknown');
                                    @endphp
                                    @if ($groupImages->isNotEmpty())
                                        @foreach ($groupImages as $type => $images)
                                            <div class="gallery-category">
                                                <div class="gallery-category__title">{{ $type }}</div>
                                                <div class="row">
                                                    @foreach ($images as $image)
                                                        <div class="col-md-6">
                                                            <div class="gallery-category__item">
                                                                <div class="cover-image"
                                                                    :class="{ 'active': activeImage === '{{ asset($image->path) }}' }"
                                                                    @click="activeImage = '{{ asset($image->path) }}'">
                                                                    <img src='{{ asset($image->path) }}' alt='image'
                                                                        class='imgFluid' loading='lazy'>
                                                                </div>
                                                                <div class="cover-name">{{ $image->name }}</div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class='col-md-9'>
                            <div class="gallery-content">
                                <div class="row g-0 align-items-center">
                                    <div class="col-md-5">
                                        <div class="gallery-content-info">
                                            <a href="{{ route('frontend.cases.comments.index', $case->slug) }}"
                                                class="view-btn">View
                                                Discussion</a>
                                            <div class="my-4">
                                                <ul class="case-details-list">
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
                                                            <ul>
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
                                                                                title="{{ $author->article_link }}"
                                                                                data-tooltip="tooltip" target="_blank">Open
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
                                                </ul>
                                            </div>
                                            <div class="editor-content">
                                                {!! $case->content !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="gallery-selected-image">
                                            <img :src="activeImage" alt="selected image" class="imgFluid"
                                                loading="lazy">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
