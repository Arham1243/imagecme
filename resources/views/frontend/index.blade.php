@extends('frontend.layouts.main')
@section('content')
    <div class="banner-wrapper">
        <div class="banner-slider">
            <div class="banner">
                <img src='https://aws.amazon.com/startups/upload/44581438-a001-7040-9a81-4d99689048d3/ffa7e866-10dd-4bf4-bba4-04785270d4e2.jpg'
                    alt='image' class='imgFluid banner__bg'>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="banner-content text-center">
                                <img alt="Logo" class="imgFluid banner-content__logo"
                                    src="{{ asset($logo->path ?? 'admin/assets/images/placeholder.png') }}">
                                <h1 class="banner-content__heading">medical imaging
                                    innovation in detection & diagnostic education
                                </h1>
                                <a href="{{ route('auth.signup') }}" class="themeBtn themeBtn--center"> Try For Free</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="banner">
                <img src='https://aws.amazon.com/startups/upload/44581438-a001-7040-9a81-4d99689048d3/ffa7e866-10dd-4bf4-bba4-04785270d4e2.jpg'
                    alt='image' class='imgFluid banner__bg'>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="banner-content text-center">
                                <img alt="Logo" class="imgFluid banner-content__logo"
                                    src="{{ asset($logo->path ?? 'admin/assets/images/placeholder.png') }}">
                                <h1 class="banner-content__heading">learners & experts share interpretation & insights

                                </h1>
                                <a href="{{ route('auth.signup') }}" class="themeBtn themeBtn--center"> Try For Free</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
