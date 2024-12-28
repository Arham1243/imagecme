@extends('user.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('user.profile.changePassword') }}
            <form action="{{ route('user.profile.updatePassword', $user->id) }}" method="POST" enctype="multipart/form-data"
                id="validation-form">
                @csrf
                <div class="custom-sec custom-sec--form">
                    <div class="custom-sec__header">
                        <div class="section-content">
                            <h3 class="heading">Change Password</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Password</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="form-fields">
                                                    <label class="title">Password<span class="text-danger">*</span>
                                                        :</label>
                                                    <div class="position-relative">
                                                        <input type="password" id="password" name="password" class="field"
                                                            required="">
                                                        <span data-target="password" class="toggle-password"
                                                            onclick="togglePassword(event)"><i
                                                                class='bx bxs-show'></i></span>
                                                    </div>
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <div class="form-fields">
                                                    <label class="title">Confirm Password<span class="text-danger">*</span>
                                                        :</label>
                                                    <div class="position-relative">
                                                        <input type="password" id="password_confirmation"
                                                            name="password_confirmation" class="field" required="">
                                                        <span data-target="password_confirmation" class="toggle-password"
                                                            onclick="togglePassword(event)"><i
                                                                class='bx bxs-show'></i></span>
                                                    </div>
                                                    @error('password_confirmation ')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <button class="themeBtn mx-auto mt-4">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
