@extends('admin.layouts.main')
@section('content')
    <div class="col-md-9">
        <div class="dashboard-content">
            <div class="revenue">
                <div class="row">
                    <div class="col-md-4">
                        <div class="revenue-card">
                            <div class="revenue-card__icon"><i class='bx bxs-group'></i></div>
                            <div class="revenue-card__content">
                                <div class="title">Verified vendors</div>
                                {{-- <div class="num">{{ count($users) }}</div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="revenue-card">
                            <div class="revenue-card__icon"><i class='bx bxs-plane'></i></div>
                            <div class="revenue-card__content">
                                <div class="title">Active Tours</div>
                                {{-- <div class="num">{{ count($tours) }}</div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="revenue-card">
                            <div class="revenue-card__icon"><i class='bx bx-dollar'></i></div>
                            <div class="revenue-card__content">
                                <div class="title">Monthly Online Payments</div>
                                <div class="num">{{ env('APP_CURRENCY') }}100000</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
