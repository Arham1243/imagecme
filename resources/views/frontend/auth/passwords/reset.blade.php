@extends('frontend.layouts.main')
@section('content')
    <div class="inquiry section-padding my-3">
        <div class="container">
            <div class="inquiry-box">
                <div class="row g-0 justify-content-center">
                    <div class="col-md-5">
                        <div class="inquiry__img">
                            <img src='https://deif-cdn-umbraco.azureedge.net/media/dxhamvxe/terms-of-use.jpg?width=1200&v=1da9151c9498cb0&v=9'
                                alt='image' class='imgFluid' loading='lazy'>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="inquiry-box__form">
                            <div class="section-content mb-4">
                                <div class="heading">Reset Your Password</div>
                                <p>You will receive a password reset link at the email address you provide.</p>
                            </div>
                            <form action="{{ route('password.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ $_GET['email'] }}">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-fields">
                                            <label class="title">Password<span class="text-danger">*</span> :</label>
                                            <div class="position-relative">
                                                <input type="password" name="password" id="password" class="field"
                                                    required="">
                                                <span data-target="password" class="toggle-password"
                                                    onclick="togglePassword(event)"><i class='bx bxs-show'></i></span>
                                            </div>
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-fields">
                                            <label class="title">Confirm Password<span class="text-danger">*</span>
                                                :</label>
                                            <div class="position-relative">
                                                <input type="password" name="password_confirmation"
                                                    id="password_confirmation" class="field" required="">
                                                <span data-target="password_confirmation" class="toggle-password"
                                                    onclick="togglePassword(event)"><i class='bx bxs-show'></i></span>
                                            </div>
                                            @error('password_confirmation')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="themeBtn themeBtn--full">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function togglePassword(event) {
            const toggleButton = event.currentTarget;
            const passwordFieldId = toggleButton.getAttribute("data-target");
            const passwordField = document.getElementById(passwordFieldId);
            const passwordIcon = toggleButton.querySelector("i");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                passwordIcon.className = "bx bxs-hide";
            } else {
                passwordField.type = "password";
                passwordIcon.className = "bx bxs-show";
            }
        }
    </script>
@endpush
