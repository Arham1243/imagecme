@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.users.show', $user) }}
            <div id="validation-form">

                <div class="custom-sec custom-sec--form">
                    <div class="custom-sec__header">
                        <div class="section-content">
                            <h3 class="heading">User: {{ isset($title) ? $title : '' }}</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">User Details</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">First Name</label>
                                                <input readonly type="text" name="first_name" class="field"
                                                    value="{{ $user->first_name }}" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Last Name</label>
                                                <input readonly type="text" name="last_name" class="field"
                                                    value="{{ $user->last_name }}" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Email</label>
                                                <input readonly type="email" class="field" value="{{ $user->email }}"
                                                    required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Phone</label>
                                                <input readonly type="text" name="phone" class="field"
                                                    value="{{ $user->phone }}" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Country</label>
                                                <input readonly type="text" name="country" class="field"
                                                    value="{{ $user->country }}" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">City</label>
                                                <input readonly type="text" name="city" class="field"
                                                    value="{{ $user->city }}" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Role </label>
                                                <input readonly type="text" name="role" class="field"
                                                    value="{{ $user->role }}" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Speciality </label>
                                                <input readonly type="text" name="speciality" class="field"
                                                    value="{{ $user->speciality }}" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-fields">
                                                <label class="title">Institution Name</label>
                                                <input readonly type="text" name="institution_name" class="field"
                                                    value="{{ $user->institution_name }}" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
