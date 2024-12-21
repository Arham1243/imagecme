@extends('frontend.layouts.main')
@section('content')
    <div class="banner">
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
@endsection
