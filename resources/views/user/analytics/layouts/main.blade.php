@extends('user.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('user.analytics.index') }}
            <div id="validation-form">
                <div class="custom-sec custom-sec--form">
                    <div class="custom-sec__header">
                        <div class="section-content">
                            <h3 class="heading">Analytics</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        @include('user.analytics.layouts.sidebar')
                    </div>
                    <div class="col-md-9">
                        <div class="form-wrapper">
                            @yield('chart_data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
