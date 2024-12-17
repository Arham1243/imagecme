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
                                <div class="heading">Sign up</div>
                                <p>Join our community to learn and share insights in medical imaging and diagnostics.</p>
                            </div>
                            <form action="{{ route('auth.signup.perform') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-fields">
                                            <label class="title">First Name<span class="text-danger">*</span> :</label>
                                            <input type="text" name="first_name" class="field"
                                                value="{{ old('first_name') }}" required="">
                                            @error('first_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-fields">
                                            <label class="title">Last Name<span class="text-danger">*</span> :</label>
                                            <input type="text" name="last_name" class="field"
                                                value="{{ old('last_name') }}" required="">
                                            @error('last_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-fields">
                                            <label class="title">Email<span class="text-danger">*</span> :</label>
                                            <input type="email" name="email" class="field" value="{{ old('email') }}"
                                                required="">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-fields">
                                            <label class="title">Phone<span class="text-danger">*</span> :</label>
                                            <input type="text" name="phone" class="field" value="{{ old('phone') }}"
                                                required="">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-fields">
                                            <label class="title">Country<span class="text-danger">*</span> :</label>
                                            <select class="field select2" name="country" id="country-select">
                                                <option value="" selected disabled>Select</option>
                                            </select>
                                            @error('country')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-fields">
                                            <label class="title">City<span class="text-danger">*</span> :</label>
                                            <input type="text" name="city" class="field" value="{{ old('city') }}"
                                                required="">
                                            @error('city')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    @php
                                        $roles = [
                                            'Student',
                                            'PG Student',
                                            'Family Physician',
                                            'Junior Doctor',
                                            'Senior Doctor',
                                            'Educationist',
                                            'Other',
                                        ];
                                        $specialities = [
                                            'Cardiology',
                                            'Dermatology',
                                            'Endocrinology',
                                            'ENT',
                                            'Gastroenterology',
                                            'Gynaecology',
                                            'Haematology',
                                            'Infectious diseases',
                                            'Neurology',
                                            'Nephrology',
                                            'Neurosurgery',
                                            'Oncology',
                                            'Ophthalmology',
                                            'Orthopaedics',
                                            'Paediatrics',
                                            'Pulmonology',
                                            'Radiology',
                                            'Rheumatology',
                                            'Surgery',
                                            'Urology',
                                        ];
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="form-fields">
                                            <label class="title">Role <span class="text-danger">*</span> :</label>
                                            <select class="field" name="role" id="role" required>
                                                <option value="" selected disabled>Select</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role }}"
                                                        {{ old('role') == $role ? 'selected' : '' }}>
                                                        {{ $role }}</option>
                                                @endforeach
                                            </select>

                                            <div class="mt-3" id="other-role-field" style="display: none;">
                                                <label class="title">Please specify your role:</label>
                                                <input type="text" class="field" id="other-role"
                                                    placeholder="Enter your role" />
                                            </div>
                                            @error('role')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-fields">
                                            <label class="title">Speciality <span class="text-danger">*</span> :</label>
                                            <select class="field select2" name="speciality" required>
                                                <option value="" selected disabled>Select</option>
                                                @foreach ($specialities as $speciality)
                                                    <option value="{{ $speciality }}"
                                                        {{ old('speciality') == $speciality ? 'selected' : '' }}>
                                                        {{ $speciality }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('speciality')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-fields">
                                            <label class="title">Institution Name<span class="text-danger">*</span>
                                                :</label>
                                            <input type="text" name="institution_name" class="field"
                                                value="{{ old('institution_name') }}" required="">
                                            @error('institution_name')
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
                                        <button type="submit" class="themeBtn themeBtn--full">Create Account</button>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="bottom-content text-center">
                                            <p>Already have an account? <a href="{{ route('auth.login') }}">Login here</a>
                                            </p>
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

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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

        $('.select2').select2({
            placeholder: 'Select',
        });

        fetch('https://restcountries.com/v3.1/all')
            .then(response => response.json())
            .then(countries => {
                const select = document.getElementById('country-select');
                countries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.name.common;
                    option.textContent = country.name.common;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching countries:', error));


        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const otherRoleField = document.getElementById('other-role-field');
            const otherRoleInput = document.getElementById('other-role');


            if (roleSelect.value === 'Other') {
                otherRoleField.style.display = 'block';
            }


            roleSelect.addEventListener('change', function() {
                if (roleSelect.value === 'Other') {

                    roleSelect.removeAttribute('name');
                    otherRoleField.style.display = 'block';
                    otherRoleInput.setAttribute('name',
                        'role');
                } else {

                    roleSelect.setAttribute('name', 'role');
                    otherRoleField.style.display = 'none';
                    otherRoleInput.removeAttribute('name');
                }
            });
        });
    </script>
@endpush
