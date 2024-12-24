@extends('frontend.layouts.main')
@section('content')
    <div class='gallery gallery--bg'>
        <div class='container-fluid p-0'>
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
                                    <i class='bx bx-info-circle'></i>
                                    <span>Story Questions</span>
                                </div>
                                <div class="gallery-option ">
                                    <i class='bx bx-file'></i>
                                    <span>Fundings</span>
                                </div>
                            </div>
                            <div class="gallery-sidebar__body">
                                <div class="gallery-category">
                                    <div class="gallery-category__title">X-ray</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="gallery-category__item">
                                                <div class="cover-image">
                                                    <img src='{{ asset('frontend/assets/images/portfolio/1.png') }}'
                                                        alt='image' class='imgFluid' loading='lazy'>
                                                </div>
                                                <div class="cover-name">Frontal</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gallery-category__item">
                                                <div class="cover-image">
                                                    <img src='{{ asset('frontend/assets/images/portfolio/1.png') }}'
                                                        alt='image' class='imgFluid' loading='lazy'>
                                                </div>
                                                <div class="cover-name">Frontal</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gallery-category__item">
                                                <div class="cover-image">
                                                    <img src='{{ asset('frontend/assets/images/portfolio/1.png') }}'
                                                        alt='image' class='imgFluid' loading='lazy'>
                                                </div>
                                                <div class="cover-name">Frontal</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gallery-category__item">
                                                <div class="cover-image">
                                                    <img src='{{ asset('frontend/assets/images/portfolio/1.png') }}'
                                                        alt='image' class='imgFluid' loading='lazy'>
                                                </div>
                                                <div class="cover-name">Frontal</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery-category">
                                    <div class="gallery-category__title">MRI</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="gallery-category__item">
                                                <div class="cover-image">
                                                    <img src='{{ asset('frontend/assets/images/portfolio/1.png') }}'
                                                        alt='image' class='imgFluid' loading='lazy'>
                                                </div>
                                                <div class="cover-name">Frontal</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gallery-category__item">
                                                <div class="cover-image">
                                                    <img src='{{ asset('frontend/assets/images/portfolio/1.png') }}'
                                                        alt='image' class='imgFluid' loading='lazy'>
                                                </div>
                                                <div class="cover-name">Frontal</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gallery-category__item">
                                                <div class="cover-image">
                                                    <img src='{{ asset('frontend/assets/images/portfolio/1.png') }}'
                                                        alt='image' class='imgFluid' loading='lazy'>
                                                </div>
                                                <div class="cover-name">Frontal</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gallery-category__item">
                                                <div class="cover-image">
                                                    <img src='{{ asset('frontend/assets/images/portfolio/1.png') }}'
                                                        alt='image' class='imgFluid' loading='lazy'>
                                                </div>
                                                <div class="cover-name">Frontal</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-9'>
                        <div class="gallery-content">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-5"></div>
                                <div class="col-md-7">
                                    <div class="gallery-selected-image">
                                        <img src='{{ asset('frontend/assets/images/portfolio/1.png') }}' alt='image'
                                            class='imgFluid' loading='lazy'>
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
    <style>
        header,
        footer {
            display: none;
        }
    </style>
@endpush
