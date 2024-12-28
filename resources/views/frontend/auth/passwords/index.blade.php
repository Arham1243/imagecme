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
                            <form action="{{ route('password.email') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-fields">
                                            <label class="title">Email<span class="text-danger">*</span> :</label>
                                            <input type="email" name="email" class="field" value="{{ old('email') }}"
                                                required="">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="themeBtn themeBtn--full">Send</button>
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
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var passwordIcon = document.querySelector(".toggle-password i");

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
