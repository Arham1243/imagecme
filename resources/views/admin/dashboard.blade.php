@extends('admin.layouts.main')
@section('content')
    <div class="col-md-9">
        <div class="dashboard-content">
            <div class="revenue">
                <div class="custom-sec custom-sec--form">
                    <div class="custom-sec__header">
                        <div class="section-content">
                            <h3 class="heading">Quick Links</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('admin.logo.show') }}" class="revenue-card">
                            <div class="revenue-card__icon"><i class='bx bxs-image'></i></div>
                            <div class="revenue-card__content">
                                <div class="title">Logo Management</div>
                                <div class="num">Logo </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('admin.contact.show') }}" class="revenue-card">
                            <div class="revenue-card__icon"><i class='bx bxs-chat'></i></div>
                            <div class="revenue-card__content">
                            <div class="title">Details Management</div>
                                <div class="num">Contact/Social</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
