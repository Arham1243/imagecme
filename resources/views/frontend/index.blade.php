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
                        <div class="portfolio-card">
                            <div class="portfolio-card__content">
                                <div class="icon"><i class="bx bx-body"></i></div>
                                <div class="title">{{ $item['title'] }}</div>
                            </div>
                            <a href="{{ route('frontend.imagingDetail', $item['slug']) }}" class="portfolio-card__img">
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['slug'] }}" class="imgFluid"
                                    loading="lazy">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <div class='cases section-padding'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-6'>
                    <div class='cases-card'>
                        <div class="cases-card__header">
                            <div class="title">Chronic obstructive pulmonary disease (COPD)</div>
                            <div class="type-badge">Case</div>
                        </div>
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <a href="{{ route('frontend.case.details') }}" class='cases-card__img'> <img
                                        src='https://www.e7health.com/files/blogs/chest-x-ray-29.jpg' alt='image'
                                        class='imgFluid'> </a>
                            </div>
                            <div class="col-md-8">
                                <div class='cases-card__content'>
                                    <div class="content certain">
                                        <div class="level green"></div>
                                        Diagnois almost certain
                                    </div>
                                    <div class="content">David Horvath</div>
                                    <div class="content">Published 11 March 2023</div>
                                    <div class="content">82% complete</div>
                                    <ul class="image-badges">
                                        <li class="image-badge">X-ray</li>
                                        <li class="image-badge">CT</li>
                                        <li class="image-badge">Ultrasound</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='cases-card'>
                        <div class="cases-card__header">
                            <div class="title">Chronic obstructive pulmonary disease (COPD)</div>
                            <div class="type-badge">Case</div>
                        </div>
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <a href="{{ route('frontend.case.details') }}" class='cases-card__img'> <img
                                        src='https://www.e7health.com/files/blogs/chest-x-ray-29.jpg' alt='image'
                                        class='imgFluid'> </a>
                            </div>
                            <div class="col-md-8">
                                <div class='cases-card__content'>
                                    <div class="content certain">
                                        <div class="level yellow"></div>
                                        Diagnois almost certain
                                    </div>
                                    <div class="content">David Horvath</div>
                                    <div class="content">Published 11 March 2023</div>
                                    <div class="content">82% complete</div>
                                    <ul class="image-badges">
                                        <li class="image-badge">X-ray</li>
                                        <li class="image-badge">CT</li>
                                        <li class="image-badge">Ultrasound</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='cases-card'>
                        <div class="cases-card__header">
                            <div class="title">Chronic obstructive pulmonary disease (COPD)</div>
                            <div class="type-badge">Case</div>
                        </div>
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <a href="{{ route('frontend.case.details') }}" class='cases-card__img'> <img
                                        src='https://www.e7health.com/files/blogs/chest-x-ray-29.jpg' alt='image'
                                        class='imgFluid'> </a>
                            </div>
                            <div class="col-md-8">
                                <div class='cases-card__content'>
                                    <div class="content certain">
                                        <div class="level green"></div>
                                        Diagnois almost certain
                                    </div>
                                    <div class="content">David Horvath</div>
                                    <div class="content">Published 11 March 2023</div>
                                    <div class="content">82% complete</div>
                                    <ul class="image-badges">
                                        <li class="image-badge">X-ray</li>
                                        <li class="image-badge">CT</li>
                                        <li class="image-badge">Ultrasound</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='cases-card'>
                        <div class="cases-card__header">
                            <div class="title">Chronic obstructive pulmonary disease (COPD)</div>
                            <div class="type-badge">Case</div>
                        </div>
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <a href="{{ route('frontend.case.details') }}" class='cases-card__img'> <img
                                        src='https://www.e7health.com/files/blogs/chest-x-ray-29.jpg' alt='image'
                                        class='imgFluid'> </a>
                            </div>
                            <div class="col-md-8">
                                <div class='cases-card__content'>
                                    <div class="content certain">
                                        <div class="level yellow"></div>
                                        Diagnois almost certain
                                    </div>
                                    <div class="content">David Horvath</div>
                                    <div class="content">Published 11 March 2023</div>
                                    <div class="content">82% complete</div>
                                    <ul class="image-badges">
                                        <li class="image-badge">X-ray</li>
                                        <li class="image-badge">CT</li>
                                        <li class="image-badge">Ultrasound</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='cases-card'>
                        <div class="cases-card__header">
                            <div class="title">Chronic obstructive pulmonary disease (COPD)</div>
                            <div class="type-badge">Case</div>
                        </div>
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <a href="{{ route('frontend.case.details') }}" class='cases-card__img'> <img
                                        src='https://www.e7health.com/files/blogs/chest-x-ray-29.jpg' alt='image'
                                        class='imgFluid'> </a>
                            </div>
                            <div class="col-md-8">
                                <div class='cases-card__content'>
                                    <div class="content certain">
                                        <div class="level green"></div>
                                        Diagnois almost certain
                                    </div>
                                    <div class="content">David Horvath</div>
                                    <div class="content">Published 11 March 2023</div>
                                    <div class="content">82% complete</div>
                                    <ul class="image-badges">
                                        <li class="image-badge">X-ray</li>
                                        <li class="image-badge">CT</li>
                                        <li class="image-badge">Ultrasound</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-md-6'>

                    <div class='cases-card'>
                        <div class="cases-card__header">
                            <div class="title">Chronic obstructive pulmonary disease (COPD)</div>
                            <div class="type-badge">Case</div>
                        </div>
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <a href="{{ route('frontend.case.details') }}" class='cases-card__img'> <img
                                        src='https://www.e7health.com/files/blogs/chest-x-ray-29.jpg' alt='image'
                                        class='imgFluid'> </a>
                            </div>
                            <div class="col-md-8">
                                <div class='cases-card__content'>
                                    <div class="content certain">
                                        <div class="level green"></div>
                                        Diagnois almost certain
                                    </div>
                                    <div class="content">David Horvath</div>
                                    <div class="content">Published 11 March 2023</div>
                                    <div class="content">82% complete</div>
                                    <ul class="image-badges">
                                        <li class="image-badge">X-ray</li>
                                        <li class="image-badge">CT</li>
                                        <li class="image-badge">Ultrasound</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='cases-card'>
                        <div class="cases-card__header">
                            <div class="title">Chronic obstructive pulmonary disease (COPD)</div>
                            <div class="type-badge">Case</div>
                        </div>
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <a href="{{ route('frontend.case.details') }}" class='cases-card__img'> <img
                                        src='https://www.e7health.com/files/blogs/chest-x-ray-29.jpg' alt='image'
                                        class='imgFluid'> </a>
                            </div>
                            <div class="col-md-8">
                                <div class='cases-card__content'>
                                    <div class="content certain">
                                        <div class="level green"></div>
                                        Diagnois almost certain
                                    </div>
                                    <div class="content">David Horvath</div>
                                    <div class="content">Published 11 March 2023</div>
                                    <div class="content">82% complete</div>
                                    <ul class="image-badges">
                                        <li class="image-badge">X-ray</li>
                                        <li class="image-badge">CT</li>
                                        <li class="image-badge">Ultrasound</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='cases-card'>
                        <div class="cases-card__header">
                            <div class="title">Chronic obstructive pulmonary disease (COPD)</div>
                            <div class="type-badge">Case</div>
                        </div>
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <a href="{{ route('frontend.case.details') }}" class='cases-card__img'> <img
                                        src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRbgjFSXmRzpMxTXr5td7-matshUVlQDFPhGg&s'
                                        alt='image' class='imgFluid'> </a>
                            </div>
                            <div class="col-md-8">
                                <div class='cases-card__content'>
                                    <div class="content certain">
                                        <div class="level green"></div>
                                        Diagnois almost certain
                                    </div>
                                    <div class="content">David Horvath</div>
                                    <div class="content">Published 11 March 2023</div>
                                    <div class="content">82% complete</div>
                                    <ul class="image-badges">
                                        <li class="image-badge">X-ray</li>
                                        <li class="image-badge">CT</li>
                                        <li class="image-badge">Ultrasound</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='cases-card'>
                        <div class="cases-card__header">
                            <div class="title">Chronic obstructive pulmonary disease (COPD)</div>
                            <div class="type-badge">Case</div>
                        </div>
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <a href="{{ route('frontend.case.details') }}" class='cases-card__img'> <img
                                        src='https://www.e7health.com/files/blogs/chest-x-ray-29.jpg' alt='image'
                                        class='imgFluid'> </a>
                            </div>
                            <div class="col-md-8">
                                <div class='cases-card__content'>
                                    <div class="content certain">
                                        <div class="level yellow"></div>
                                        Diagnois almost certain
                                    </div>
                                    <div class="content">David Horvath</div>
                                    <div class="content">Published 11 March 2023</div>
                                    <div class="content">82% complete</div>
                                    <ul class="image-badges">
                                        <li class="image-badge">X-ray</li>
                                        <li class="image-badge">CT</li>
                                        <li class="image-badge">Ultrasound</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='cases-card'>
                        <div class="cases-card__header">
                            <div class="title">Chronic obstructive pulmonary disease (COPD)</div>
                            <div class="type-badge">Case</div>
                        </div>
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <a href="{{ route('frontend.case.details') }}" class='cases-card__img'> <img
                                        src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSpG0xwjiIHyvGSCIJDOCZ_VEzEntS0LHnhCQ&s'
                                        alt='image' class='imgFluid'> </a>
                            </div>
                            <div class="col-md-8">
                                <div class='cases-card__content'>
                                    <div class="content certain">
                                        <div class="level yellow"></div>
                                        Diagnois almost certain
                                    </div>
                                    <div class="content">David Horvath</div>
                                    <div class="content">Published 11 March 2023</div>
                                    <div class="content">82% complete</div>
                                    <ul class="image-badges">
                                        <li class="image-badge">X-ray</li>
                                        <li class="image-badge">CT</li>
                                        <li class="image-badge">Ultrasound</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
