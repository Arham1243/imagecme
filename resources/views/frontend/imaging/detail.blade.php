@extends('frontend.layouts.main')
@section('content')
    <div class='imaging-detail section-padding'>
        <div class='container'>
            <div class='row justify-content-center'>
                <div class='col-lg-11'>
                    <div class="imaging-detail__img">
                        <img src='{{ asset($item['image']) }}' alt='image' class='imgFluid' loading='lazy'>
                    </div>
                    <div class="imaging-detail__content section-content">
                        <div class="heading">{{ $item['title'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
