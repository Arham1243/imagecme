@extends('user.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('user.profile.index') }}
            <form action="{{ route('user.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                id="validation-form">
                @csrf
                @method('PATCH')
                <div class="custom-sec custom-sec--form">
                    <div class="custom-sec__header">
                        <div class="section-content">
                            <h3 class="heading">Edit: Personal Information</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Information</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">First Name<span class="text-danger">*</span>
                                                    :</label>
                                                <input type="text" name="first_name" class="field"
                                                    value="{{ old('first_name', $user->first_name) }}" required="">
                                                @error('first_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Last Name<span class="text-danger">*</span>
                                                    :</label>
                                                <input type="text" name="last_name" class="field"
                                                    value="{{ old('last_name', $user->last_name) }}" required="">
                                                @error('last_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Email<span class="text-danger">*</span> :</label>
                                                <input type="email" readonly class="field"
                                                    value="{{ old('email', $user->email) }}" required="">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Phone<span class="text-danger">*</span> :</label>
                                                <input type="text" name="phone" class="field"
                                                    value="{{ old('phone', $user->phone) }}" required="">
                                                @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Country<span class="text-danger">*</span>
                                                    :</label>
                                                <select class="field select2-select" name="country" id="country-select"
                                                    selected-country="{{ $user->country }}">
                                                    <option value="" selected disabled>Select</option>
                                                </select>
                                                @error('country')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">City<span class="text-danger">*</span> :</label>
                                                <input type="text" name="city" class="field"
                                                    value="{{ old('city', $user->city) }}" required="">
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
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Role <span class="text-danger">*</span> :</label>
                                                <select class="field" @if (in_array($user->role, $roles)) name="role" @endif
                                                    id="role" required>
                                                    <option value="" selected disabled>Select</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role }}"
                                                            {{ old('role', $user->role) == $role ? 'selected' : '' }}>
                                                            {{ $role }}
                                                        </option>
                                                    @endforeach
                                                    <option value="Other"
                                                        {{ !in_array($user->role, $roles) ? 'selected' : '' }}>
                                                        Other
                                                    </option>
                                                </select>

                                                <div class="mt-3 {{ !in_array($user->role, $roles) ? 'd-block' : '' }}"
                                                    id="other-role-field" style="display: none;">
                                                    <label class="title">Please specify your role:</label>
                                                    <input type="text" class="field" id="other-role"
                                                        placeholder="Enter your role"
                                                        @if (!in_array($user->role, $roles)) name="role" value="{{ $user->role }}" @endif />
                                                </div>
                                                @error('role')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Speciality <span class="text-danger">*</span>
                                                    :</label>
                                                <select class="field select2-select" name="speciality" required>
                                                    <option value="" selected disabled>Select</option>
                                                    @foreach ($specialities as $speciality)
                                                        <option value="{{ $speciality }}"
                                                            {{ old('speciality', $user->speciality) == $speciality ? 'selected' : '' }}>
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
                                                    value="{{ old('institution_name', $user->institution_name) }}"
                                                    required="">
                                                @error('institution_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button class="themeBtn mx-auto mt-4">Save Changes</button>
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
        fetch('https://restcountries.com/v3.1/all')
            .then(response => response.json())
            .then(countries => {
                const select = document.getElementById('country-select');
                const selectedCountry = select.getAttribute('selected-country');

                countries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.name.common;
                    option.textContent = country.name.common;

                    if (selectedCountry && selectedCountry === country.name.common) {
                        option.selected = true;
                    }

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
                    otherRoleField.classList.remove('d-block');
                    otherRoleInput.removeAttribute('name');
                }
            });
        });
    </script>
@endpush
