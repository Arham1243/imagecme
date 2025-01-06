@extends('frontend.layouts.main')
@section('content')
    <div class="banner">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="banner-content text-center">
                        <div class="banner-content__logo">
                            <img alt="xray" class="imgFluid"
                                src="https://thumbs.dreamstime.com/b/xray-lung-ray-image-healthy-chest-31070096.jpg">
                        </div>
                        <h1 class="banner-content__heading">
                            medical imaging <br>
                            innovation in detection & diagnostic education <br>

                            <span>learners & experts share interpretation & insights</span>
                        </h1>
                        <div class="btns-wrapper d-flex align-items-center justify-content-center flex-wrap">
                            <a href="{{ route('user.cases.create') }}"
                                class="themeBtn themeBtn--secondary themeBtn--outline">Share <span>image
                                    diagnosis</span></a>
                            <a href="{{ route('user.cases.create') }}"
                                class="themeBtn themeBtn--secondary themeBtn--outline"> Challenge <span>image
                                    diagnosis</span></a>
                            <a href="{{ route('user.cases.create') }}"
                                class="themeBtn themeBtn--secondary themeBtn--outline"> Ask <span>image
                                    diagnosis</span></a>
                            <a href="{{ route('user.cases.create') }}"
                                class="themeBtn themeBtn--secondary themeBtn--outline"> Ask AI <span>image
                                    diagnosis</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="video-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="video-section__video">
                        {{-- <video autoplay muted>
                            <source src="">
                        </video> --}}
                        <img alt="xray" class="imgFluid"
                            src="https://www.thesun.co.uk/wp-content/uploads/2018/01/nintchdbpict0003769782041.jpg">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio">
        <div class="container-fluid">
            <div class="row justify-content-center mb-4">
                <div class="col-md-10">
                    <div class="section-content text-center">
                        <h3 class="heading">Get the most out of Image CME</h3>
                        <p>Image CME is designed to support you through every stage of your professional journey </p>
                    </div>
                </div>
            </div>
            @php
                $portfolioItems = [
                    [
                        'slug' => 'x-ray',
                        'title' => 'X Ray',
                        'image' => 'frontend/assets/images/portfolio/1.png',
                    ],
                    [
                        'slug' => 'ct-scan',
                        'title' => 'CT Scan',
                        'image' => 'frontend/assets/images/portfolio/2.png',
                    ],
                    [
                        'slug' => 'mri',
                        'title' => 'MRI',
                        'image' => 'frontend/assets/images/portfolio/3.png',
                    ],
                    [
                        'slug' => 'ultrasound-diagnostic',
                        'title' => 'Ultrasound, Diagnostic',
                        'image' => 'frontend/assets/images/portfolio/4.png',
                    ],
                    [
                        'slug' => 'mammography',
                        'title' => 'Mammography',
                        'image' => 'frontend/assets/images/portfolio/5.jpg',
                    ],
                    [
                        'slug' => 'pet-scan',
                        'title' => 'PET Scan',
                        'image' => 'frontend/assets/images/portfolio/5.png',
                    ],
                ];
            @endphp
            <div class="row portfolio-slider">
                @foreach ($portfolioItems as $item)
                    <div class="col-md-4">
                        <a href="{{ route('frontend.imagingDetail', $item['slug']) }}" class="portfolio-card">
                            <div class="portfolio-card__content">
                                <div class="icon"><i class="bx bx-body"></i></div>
                                <div class="title">{{ $item['title'] }}</div>
                            </div>
                            <div class="portfolio-card__img">
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['slug'] }}" class="imgFluid"
                                    loading="lazy">
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    @if ($cases->isNotEmpty())
        <div class='cases section-padding'>
            <div class='container'>
                <div class='row'>
                    @foreach ($cases as $case)
                        <div class='col-md-6'>
                            <div class='cases-card'>
                                <div class="cases-card__header">
                                    <div class="title">{{ $case->diagnosis_title }}</div>
                                    <div class="type-badge">{{ getRelativeType($case->case_type) }}</div>
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
