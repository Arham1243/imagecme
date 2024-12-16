@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.logo.show') }}
            <form action="{{ route('admin.logo.store') }}" method="POST" enctype="multipart/form-data" id="validation-form">
                @csrf
                @method('POST')
                <div class="custom-sec custom-sec--form">
                    <div class="custom-sec__header">
                        <div class="section-content">
                            <h3 class="heading">Edit Logo</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Logo</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="placeholder-user">
                                        <label for="profile-img" class="placeholder-user__img">
                                            <img src="{{ asset($logo->path ?? 'admin/assets/images/placeholder-logo.png') }}"
                                                alt="image" class="imgFluid" id="profile-preview" loading="lazy">
                                        </label>
                                        <input type="file" name="path" id="profile-img"
                                            onchange="showImage(this, 'profile-preview', 'filename-preview');"
                                            class="d-none" accept="image/*">
                                        <div class="placeholder-user__name" id="filename-preview">Current Logo</div>
                                        @error('record')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
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

@push('css')
    <style type="text/css">
        .placeholder-user__img img {
            object-fit: contain
        }
    </style>
@endpush
