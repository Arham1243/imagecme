@extends('frontend.layouts.main')
@section('content')
    <div class='imaging-detail'>
        <div class="imaging-detail__img">
            <img src='{{ asset($item->featured_image ?? 'admin/assets/images/placeholder.png') }}' alt='{{ $item->name }}'
                class='imgFluid' loading='lazy'>
        </div>
        <div class='container'>
            <div class="imaging-detail__content section-content">
                <div class="heading">{{ $item->name }}</div>
                <div class="editor-content">
                    {!! $item->content !!}
                </div>
            </div>
        </div>
    </div>

    @if ($cases->isNotEmpty())
        <div class='cases py-5'>
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
