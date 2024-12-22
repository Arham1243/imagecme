@extends('frontend.layouts.main')
@section('content')
    <div class="banner">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="banner-content text-center">
                        <div class="banner-content__logo">
                            <img alt="xray" class="imgFluid" src="{{ asset('frontend/assets/images/xray.png') }}">
                        </div>
                        <h1 class="banner-content__heading">
                            medical imaging
                            innovation in detection & diagnostic education

                            learners & experts share interpretation & insights
                        </h1>
                        <div class="btns-wrapper d-flex align-items-center justify-content-center flex-wrap">
                            <a href="javascript:void(0)" class="themeBtn">Share <span>image diagnosis</span></a>
                            <a href="javascript:void(0)" class="themeBtn themeBtn--outline"> Challenge <span>image
                                    diagnosis</span></a>
                            <a href="javascript:void(0)" class="themeBtn"> Ask <span>image diagnosis</span></a>
                            <a href="javascript:void(0)" class="themeBtn themeBtn--outline"> Ask AI <span>image
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
                        {{-- <img alt="xray" class="imgFluid" src="https://www.spinalbackrack.com/wp-content/uploads/2021/05/bilateral-sciatica-representation-1024x576.png"> --}}
                        {{-- <img alt="xray" class="imgFluid" src="https://media.visualstories.com/uploads/images/1/136/5428385-1280_174907035-1603900_l.jpg"> --}}
                        <img alt="xray" class="imgFluid" src="{{ asset('frontend/assets/images/xray-1.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio pb-5">
        <div class="container-fluid">
            <div class="row justify-content-center mb-4">
                <div class="col-md-10">
                    <div class="section-content text-center">
                        <h3 class="heading">Get the most out of Complete Anatomy</h3>
                        <p>Complete Anatomy is built to take you through each stage of your professional journey. </p>
                    </div>
                </div>
            </div>
            <div class="row portfolio-slider">
                <div class="col-md-4">
                    <div class="portfolio-card">
                        <div class="portfolio-card__content">
                            <div class="icon"><i class='bx bx-body'></i></div>
                            <div class="title">X-rays</div>
                        </div>
                        <a href="{{ asset('frontend/assets/images/portfolio/1.png') }}" data-fancybox="gallery"
                            class="portfolio-card__img">
                            <img src='{{ asset('frontend/assets/images/portfolio/1.png') }}' alt='image' class='imgFluid'
                                loading='lazy'>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portfolio-card">
                        <div class="portfolio-card__content">
                            <div class="icon"><i class='bx bx-body'></i></div>
                            <div class="title">CT scan</div>
                        </div>
                        <a href="{{ asset('frontend/assets/images/portfolio/2.png') }}" data-fancybox="gallery"
                            class="portfolio-card__img">
                            <img src='{{ asset('frontend/assets/images/portfolio/2.png') }}' alt='image' class='imgFluid'
                                loading='lazy'>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portfolio-card">
                        <div class="portfolio-card__content">
                            <div class="icon"><i class='bx bx-body'></i></div>
                            <div class="title">MRI scan</div>
                        </div>
                        <a href="{{ asset('frontend/assets/images/portfolio/3.png') }}" data-fancybox="gallery"
                            class="portfolio-card__img">
                            <img src='{{ asset('frontend/assets/images/portfolio/3.png') }}' alt='image' class='imgFluid'
                                loading='lazy'>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portfolio-card">
                        <div class="portfolio-card__content">
                            <div class="icon"><i class='bx bx-body'></i></div>
                            <div class="title">Ultrasound</div>
                        </div>
                        <a href="{{ asset('frontend/assets/images/portfolio/4.png') }}" data-fancybox="gallery"
                            class="portfolio-card__img">
                            <img src='{{ asset('frontend/assets/images/portfolio/4.png') }}' alt='image' class='imgFluid'
                                loading='lazy'>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portfolio-card">
                        <div class="portfolio-card__content">
                            <div class="icon"><i class='bx bx-body'></i></div>
                            <div class="title">Mammogram</div>
                        </div>
                        <a href="{{ asset('frontend/assets/images/portfolio/5.jpg') }}" data-fancybox="gallery"
                            class="portfolio-card__img">
                            <img src='{{ asset('frontend/assets/images/portfolio/5.jpg') }}' alt='image'
                                class='imgFluid' loading='lazy'>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portfolio-card">
                        <div class="portfolio-card__content">
                            <div class="icon"><i class='bx bx-body'></i></div>
                            <div class="title">PET scan</div>
                        </div>
                        <a href="{{ asset('frontend/assets/images/portfolio/5.png') }}" data-fancybox="gallery"
                            class="portfolio-card__img">
                            <img src='{{ asset('frontend/assets/images/portfolio/5.png') }}' alt='image'
                                class='imgFluid' loading='lazy'>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
