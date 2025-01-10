@extends('frontend.layouts.main')
@section('content')
    <div class="banner">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="banner-content text-center">
                        <div class="banner-content__logo">
                            <img alt="xray" class="imgFluid" src="{{ asset('frontend/assets/images/xray.jpg') }}">
                        </div>
                        <h1 class="banner-content__heading">
                            medical imaging <br>
                            innovation in detection & diagnostic education <br>

                            <span>learners & experts share interpretation & insights</span>
                        </h1>
                        <div class="btns-wrapper d-flex align-items-center justify-content-center flex-wrap">
                            <a href="{{ route('user.cases.create', ['type' => 'share_image_diagnosis']) }}"
                                class="themeBtn themeBtn--secondary themeBtn--outline">Share <span>image
                                    diagnosis</span></a>
                            <a href="{{ route('user.cases.create', ['type' => 'challenge_image_diagnosis']) }}"
                                class="themeBtn themeBtn--secondary themeBtn--outline"> Challenge <span>image
                                    diagnosis</span></a>
                            <a href="{{ route('user.cases.create', ['type' => 'ask_image_diagnosis']) }}"
                                class="themeBtn themeBtn--secondary themeBtn--outline"> Ask <span>image
                                    diagnosis</span></a>
                            {{-- <a href="{{ route('user.cases.create', ['type' => 'ask_ai_image_diagnosis']) }}"
                                class="themeBtn themeBtn--secondary themeBtn--outline"> Ask AI <span>image
                                    diagnosis</span></a> --}}
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
    @if ($imageTypes->isNotEmpty())
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
                @endphp
                <div class="row portfolio-slider">
                    @foreach ($imageTypes as $item)
                        <div class="col-md-4">
                            <a href="{{ route('frontend.image-types.details', $item->slug) }}" class="portfolio-card">
                                <div class="portfolio-card__content">
                                    <div class="icon"><i class="bx bx-body"></i></div>
                                    <div class="title">{{ $item->name }}</div>
                                </div>
                                <div class="portfolio-card__img">
                                    <img src="{{ asset($item->featured_image ?? 'admin/assets/images/placeholder.png') }}"
                                        alt="{{ $item->name }}" class="imgFluid" loading="lazy">
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    @endif

    @if ($cases->isNotEmpty())
        <div class='cases section-padding'>
            <div class='container'>
                <div class='row'>
                    @foreach ($cases as $case)
                        <div class='col-md-6'>
                            <x-case-card :case="$case" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
