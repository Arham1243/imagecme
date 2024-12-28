@extends('frontend.layouts.main')
@section('content')
    <div class="inquiry section-padding my-3">
        <div class="container">
            <div class="inquiry-box">
                <div class="row g-0 justify-content-center">
                    <div class="col-md-7">
                        <div class="inquiry-box__form">
                            <div class="section-content text-center">
                                <div class="heading">Password Reset Email Sent</div>
                                <p>A reset link has been sent to: <strong>{{ $_GET['email'] }}</strong> <br>Check your inbox
                                    or spam folder..</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
