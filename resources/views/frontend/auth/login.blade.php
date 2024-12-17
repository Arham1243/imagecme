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
                                <div class="heading">Login</div>
                                <p>Join our community to learn and share insights in medical imaging and diagnostics.</p>
                            </div>
                            <form action="{{ route('auth.login.perform') }}" method="POST">
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
                                    <div class="col-md-12">
                                        <div class="form-fields">
                                            <label class="title">Password<span class="text-danger">*</span> :</label>
                                            <div class="position-relative">
                                                <input type="password" name="password" id="password" class="field"
                                                    required="">
                                                <span class="toggle-password" onclick="togglePassword()"><i
                                                        class='bx bxs-show'></i></span>
                                            </div>
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="themeBtn themeBtn--full">Login</button>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="bottom-content text-center">
                                            <p>Don't have an account? <a href="{{ route('auth.signup') }}">Sign up here</a>
                                            </p>
                                            <p><a href="javascript:void(0)">Forgot your password?</a></p>
                                        </div>
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
