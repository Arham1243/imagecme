@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.contact.show') }}
            <form action="{{ route('admin.contact.store') }}" method="POST" enctype="multipart/form-data" id="validation-form">
                @csrf
                @method('POST')
                <div class="custom-sec custom-sec--form">
                    <div class="custom-sec__header">
                        <div class="section-content">
                            <h3 class="heading">Edit Contact/Social Info</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Contact/Social Info</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="row">

                                        <div class="col-lg-6 col-md-6 col-12 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Facebook<span class="text-danger">*</span>:</label>
                                                <input type="url" name="FACEBOOK" class="field"
                                                    value="{{ $config['FACEBOOK'] ?? '' }} "
                                                    placeholder="Enter Facebook Address">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-12 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Instagram<span class="text-danger">*</span>:</label>
                                                <input type="url" name="INSTAGRAM" class="field"
                                                    value="{{ $config['INSTAGRAM'] ?? '' }}"
                                                    placeholder="Enter Instagram Address" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-12 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Twitter<span class="text-danger">*</span>:</label>
                                                <input type="url" name="TWITTER" class="field"
                                                    value="{{ $config['TWITTER'] ?? '' }}"
                                                    placeholder="Enter Twitter Address" required>
                                            </div>
                                        </div>

                                        <div class="col-12 pt-1 pb-4">
                                            <hr>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 mb-4 ">
                                            <div class="form-fields">
                                                <label class="title">Phone<span class="text-danger">*</span>:</label>
                                                <div class="relative-div">
                                                    <input type="text" name="COMPANYPHONE" class="field"
                                                        value="{{ $config['COMPANYPHONE'] ?? '' }}"
                                                        placeholder="Enter Phone Number" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Email<span class="text-danger">*</span>:</label>
                                                <div class="relative-div">
                                                    <input type="email" name="COMPANYEMAIL" class="field"
                                                        value="{{ $config['COMPANYEMAIL'] ?? '' }}"
                                                        placeholder="Enter Email Address" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="themeBtn mx-auto mt-4">Save Changes</button>
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
