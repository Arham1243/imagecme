@extends('admin.dash_layouts.main')
@section('content')
    @php
        $sectionContent = json_decode($category->section_content);
        $tourCountContent = $sectionContent->tour_count ?? null;
        $callToActionContent = $sectionContent->call_to_action ?? null;
    @endphp

    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.tour-categories.edit', $category) }}
            <form action="{{ route('admin.tour-categories.update', $category->id) }}" method="POST"
                enctype="multipart/form-data" id="validation-form">
                @csrf
                @method('PATCH')
                <div class="custom-sec custom-sec--form">
                    <div class="custom-sec__header">
                        <div class="section-content">
                            <h3 class="heading">Edit Category: {{ isset($title) ? $title : '' }}</h3>

                            <div class="permalink">
                                <div class="title">Permalink:</div>
                                <div class="title">
                                    <div class="full-url">{{ buildUrl(url('/'), 'tours/category/') }}</div>
                                    <input value="{{ $category->slug ?? '#' }}" type="button" class="link permalink-input"
                                        data-field-id="slug">
                                    <input type="hidden" id="slug" value="{{ $category->slug ?? '#' }}"
                                        name="slug">
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('tours.category.details', $category->slug) }}" target="_blank"
                            class="themeBtn">View
                            Category</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Category Content</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="form-fields">
                                        <label class="title">Name <span class="text-danger">*</span> :</label>
                                        <input type="text" name="name" class="field"
                                            value="{{ old('name', $category->name) }}" placeholder="Name" data-error="Name">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-fields">
                                        <label class="title">Parent <span class="text-danger">*</span> :</label>
                                        <select name="parent_category_id" class="select2-select category-select"
                                            {{ !$dropdownCategories->isEmpty() ? '' : '' }} data-error="Category">
                                            <option value="" selected>Parent Category</option>
                                            @php
                                                renderCategories($dropdownCategories, $category->parent_category_id);
                                            @endphp
                                        </select>
                                        @error('parent_category_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-fields mt-4">
                                        <div class="multiple-upload" data-upload-multiple>
                                            <input type="file" class="gallery-input d-none" multiple
                                                data-upload-multiple-input accept="image/*" id="banners" name="gallery[]">
                                            <label class="multiple-upload__btn themeBtn" for="banners">
                                                <i class='bx bx-plus'></i>
                                                Choose Slider images
                                            </label>
                                            <div class="dimensions mt-3">
                                                <strong>Dimensions:</strong> 1116 &times; 250
                                            </div>
                                            <ul class="multiple-upload__imgs" data-upload-multiple-images>
                                            </ul>
                                            <div class="text-danger error-message d-none" data-upload-multiple-error>
                                            </div>
                                        </div>
                                    </div>

                                    @if (!$category->media->isEmpty())
                                        <div class="form-fields mt-3">
                                            <label class="title">Current Slider images:</label>
                                            <ul class="multiple-upload__imgs">
                                                @foreach ($category->media as $media)
                                                    <li class="single-image">
                                                        <a href="{{ route('admin.media.destroy', $media->id) }}"
                                                            onclick="return confirm('Are you sure you want to delete this media?')"
                                                            class="delete-btn">
                                                            <i class='bx bxs-trash-alt'></i>
                                                        </a>
                                                        <a class="mask" href="{{ asset($media->file_path) }}"
                                                            data-fancybox="gallery">
                                                            <img src="{{ asset($media->file_path) }}" class="imgFluid"
                                                                alt="{{ $media->alt_text }}" />
                                                        </a>
                                                        <input type="text" value="{{ $media->alt_text }}" class="field"
                                                            readonly>
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-box">
                                <div class="form-box__header d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="title">Tour Count Section</div>
                                        <div class="form-check form-switch" data-enabled-text="Enabled"
                                            data-disabled-text="Disabled">
                                            <input class="form-check-input" data-toggle-switch=""
                                                {{ isset($tourCountContent->is_enabled) ? 'checked' : '' }} type="checkbox"
                                                id="tour_count_enabled" value="1"
                                                name="content[tour_count][is_enabled]">
                                            <label class="form-check-label" for="tour_count_enabled">Enabled</label>
                                        </div>
                                    </div>
                                    <a href="{{ asset('admin/assets/images/ctas-blocks/3.png') }}" data-fancybox="gallery"
                                        class="themeBtn p-2"><i class='bx bxs-show'></i></a>
                                </div>
                                <div class="form-box__body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-fields">
                                                        <label class="title">Heading <span class="text-danger">*</span>
                                                            :</label>
                                                        <input type="text" name="content[tour_count][heading]"
                                                            class="field" value="{{ $tourCountContent->heading ?? '' }}"
                                                            placeholder="Heading" maxlength="30">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-fields">
                                                        <div class="title d-flex align-items-center gap-2">
                                                            <div>Heading Text Color <span class="text-danger">*</span>:
                                                            </div>
                                                            <a class="p-0 nav-link" href="//html-color-codes.info"
                                                                target="_blank">Get
                                                                Color
                                                                Codes</a>
                                                        </div>
                                                        <div class="field color-picker" data-color-picker-container>
                                                            <label for="color-picker" data-color-picker></label>
                                                            <input id="color-picker" type="text"
                                                                name="content[tour_count][heading_color]"
                                                                data-color-picker-input
                                                                value="{{ $tourCountContent->heading_color ?? '#000000' }}"
                                                                data-error="background Color" inputmode="text">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12">
                                            <hr />
                                        </div>
                                        <div class="col-lg-12 py-4">
                                            <div class="form-fields">
                                                <div class="d-flex align-items-center gap-3 mb-3">
                                                    <label class="title title--sm mb-0">Call to Action Button:</label>
                                                    <div class="form-check form-switch" data-enabled-text="Enabled"
                                                        data-disabled-text="Disabled">
                                                        <input class="form-check-input" data-toggle-switch=""
                                                            {{ isset($tourCountContent->is_button_enabled) ? 'checked' : '' }}
                                                            type="checkbox" id="cta_btn_enabled_tour" value="1"
                                                            name="content[tour_count][is_button_enabled]">
                                                        <label class="form-check-label"
                                                            for="cta_btn_enabled_tour">Enabled</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 mb-4">
                                                        <div class="form-fields">
                                                            <label class="title">Button Text <span
                                                                    class="text-danger">*</span>
                                                                :</label>
                                                            <input type="text"
                                                                value="{{ $tourCountContent->btn_text ?? '' }}"
                                                                name="content[tour_count][btn_text]" class="field"
                                                                placeholder="" data-error="Button Text" maxlength="28">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-4">
                                                        <div class="form-fields">
                                                            <label class="title">
                                                                <div class="d-flex align-items-center gap-2 lh-1">
                                                                    <div class="mt-1">Button Link </div>


                                                                    <button data-bs-placement="top"
                                                                        title="<div class='d-flex flex-column'> <div class='d-flex gap-1'> <strong>Link:</strong> https://abc.com</div> <div class='d-flex gap-1'><strong>Phone:</strong> tel:+971xxxxxxxxx</div> <div class='d-flex gap-1'><strong>Whatsapp:</strong> https://wa.me/971xxxxxxxxx</div> </div>"
                                                                        type="button" data-tooltip="tooltip"
                                                                        class="tooltip-lg">
                                                                        <i class='bx bxs-info-circle'></i>
                                                                    </button>
                                                                </div>
                                                            </label>
                                                            <input type="text"
                                                                value="{{ $tourCountContent->btn_link ?? '' }}"
                                                                name="content[tour_count][btn_link]" class="field"
                                                                placeholder="" data-error="Button Link">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-fields">
                                                            <div class="title d-flex align-items-center gap-2">
                                                                <div>
                                                                    Button Background Color <span
                                                                        class="text-danger">*</span>:
                                                                </div>
                                                                <a class="p-0 nav-link" href="//html-color-codes.info"
                                                                    target="_blank">Get Color
                                                                    Codes</a>
                                                            </div>
                                                            <div class="field color-picker" data-color-picker-container>
                                                                <label for="color-picker" data-color-picker></label>
                                                                <input id="color-picker" type="text"
                                                                    name="content[tour_count][btn_background_color]"
                                                                    data-color-picker-input
                                                                    value="{{ $tourCountContent->btn_background_color ?? '#1c4d99' }}"
                                                                    data-error="background Color" inputmode="text" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-fields">
                                                            <div class="title d-flex align-items-center gap-2">
                                                                <div>
                                                                    Button Text Color <span class="text-danger">*</span>:
                                                                </div>
                                                                <a class="p-0 nav-link" href="//html-color-codes.info"
                                                                    target="_blank">Get Color
                                                                    Codes</a>
                                                            </div>
                                                            <div class="field color-picker" data-color-picker-container>
                                                                <label for="color-picker" data-color-picker></label>
                                                                <input id="color-picker" type="text"
                                                                    name="content[tour_count][btn_text_color]"
                                                                    data-color-picker-input
                                                                    value="{{ $tourCountContent->btn_text_color ?? '#ffffff' }}"
                                                                    data-error="background Color" inputmode="text" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <hr />
                                        </div>
                                        <div class="col-lg-12 pt-3">
                                            <div class="form-fields">
                                                <label class="title title--sm mb-3">Background Style:</label>
                                                <div x-data="{ tour_count_background_type: '{{ isset($tourCountContent->tour_count_background_type) ? $tourCountContent->tour_count_background_type : 'background_image' }}' }">
                                                    <div class="d-flex align-items-center gap-5 px-4">
                                                        <div class="form-check p-0">
                                                            <input class="form-check-input" type="radio"
                                                                id="background_image_count"
                                                                x-model="tour_count_background_type"
                                                                name="content[tour_count][tour_count_background_type]"
                                                                value="background_image" checked />
                                                            <label class="form-check-label"
                                                                for="background_image_count">Background
                                                                Image</label>
                                                        </div>
                                                        <div class="form-check p-0">
                                                            <input class="form-check-input" type="radio"
                                                                id="background_color_2_color_count"
                                                                x-model="tour_count_background_type"
                                                                name="content[tour_count][tour_count_background_type]"
                                                                value="background_color" />
                                                            <label class="form-check-label"
                                                                for="background_color_2_color_count">Background
                                                                Color</label>
                                                        </div>
                                                    </div>
                                                    <div x-show="tour_count_background_type === 'background_image'">
                                                        <div class="row pt-4">
                                                            <div class="col-md-4 mb-4">
                                                                <div class="form-fields">
                                                                    <label class="title">Background Image <span
                                                                            class="text-danger">*</span>:</label>
                                                                    <div class="upload upload--sm mx-0" data-upload>
                                                                        <div class="upload-box-wrapper">
                                                                            <div class="upload-box {{ empty($tourCountContent->background_image) ? 'show' : '' }}"
                                                                                data-upload-box>
                                                                                <input type="file"
                                                                                    name="content[tour_count][background_image]"
                                                                                    data-error="Feature Image"
                                                                                    id="background_image_count"
                                                                                    class="upload-box__file d-none"
                                                                                    accept="image/*" data-file-input />
                                                                                <div class="upload-box__placeholder">
                                                                                    <i class="bx bxs-image"></i>
                                                                                </div>
                                                                                <label for="background_image_count"
                                                                                    class="upload-box__btn themeBtn">Upload
                                                                                    Image</label>
                                                                            </div>
                                                                            <div class="upload-box__img {{ !empty($tourCountContent->background_image) ? 'show' : '' }}"
                                                                                data-upload-img>
                                                                                <button type="button" class="delete-btn"
                                                                                    data-delete-btn="">
                                                                                    <i class="bx bxs-edit-alt"></i>
                                                                                </button>
                                                                                <a href="{{ asset($tourCountContent->background_image ?? 'admin/assets/images/loading.webp') }}"
                                                                                    class="mask"
                                                                                    data-fancybox="gallery">
                                                                                    <img src="{{ asset($tourCountContent->background_image ?? 'admin/assets/images/loading.webp') }}"
                                                                                        alt="Uploaded Image"
                                                                                        class="imgFluid"
                                                                                        data-placeholder="{{ asset('admin/assets/images/loading.webp') }}"
                                                                                        data-upload-preview="" />
                                                                                </a>
                                                                                <input type="text"
                                                                                    name="content[tour_count][background_image_alt_text]"
                                                                                    class="field"
                                                                                    placeholder="Enter alt text"
                                                                                    value="{{ $tourCountContent->background_image_alt_text ?? 'Alt Text' }}">
                                                                            </div>
                                                                        </div>
                                                                        <div data-error-message
                                                                            class="text-danger mt-2 d-none text-center">
                                                                            Please upload a valid image file
                                                                        </div>
                                                                        <div class="dimensions text-center mt-3">
                                                                            <strong>Dimensions:</strong> 1116 &times; 210
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div x-show="tour_count_background_type === 'background_color'">
                                                        <div class="row pt-4">
                                                            <div class="col-md-12">
                                                                <div class="form-fields">
                                                                    <div class="title d-flex align-items-center gap-2">
                                                                        <div>
                                                                            Select Background Color <span
                                                                                class="text-danger">*</span>:
                                                                        </div>
                                                                        <a class="p-0 nav-link"
                                                                            href="//html-color-codes.info"
                                                                            target="_blank">Get Color
                                                                            Codes</a>
                                                                    </div>
                                                                    <div class="field color-picker"
                                                                        data-color-picker-container>
                                                                        <label for="color-picker"
                                                                            data-color-picker></label>
                                                                        <input id="color-picker" type="text"
                                                                            name="content[tour_count][background_color]"
                                                                            data-color-picker-input
                                                                            value="{{ $tourCountContent->background_color ?? '' }}"
                                                                            placeholder="#000000"
                                                                            data-error="background Color"
                                                                            inputmode="text" />
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
                            <div class="form-box">
                                <div class="form-box__header d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="title">Call to Action Section</div>
                                        <div class="form-check form-switch" data-enabled-text="Enabled"
                                            data-disabled-text="Disabled">
                                            <input class="form-check-input" data-toggle-switch=""
                                                {{ isset($callToActionContent->is_enabled) ? 'checked' : '' }}
                                                type="checkbox" id="cta_btn_enabled" value="1"
                                                name="content[call_to_action][is_enabled]">
                                            <label class="form-check-label" for="cta_btn_enabled">Enabled</label>
                                        </div>
                                    </div>
                                    <a href="{{ asset('admin/assets/images/ctas-blocks/1.png') }}"
                                        data-fancybox="gallery" class="themeBtn p-2"><i class='bx bxs-show'></i></a>
                                </div>
                                <div class="form-box__body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-fields">
                                                        <label class="title">Title <span class="text-danger">*</span>
                                                            :</label>
                                                        <input type="text" name="content[call_to_action][title]"
                                                            class="field" placeholder="" data-error="title"
                                                            value="{{ $callToActionContent->title ?? '' }}"
                                                            maxlength="69">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-fields">
                                                        <div class="title d-flex align-items-center gap-2">
                                                            <div>Title Text Color <span class="text-danger">*</span>:
                                                            </div>
                                                            <a class="p-0 nav-link" href="//html-color-codes.info"
                                                                target="_blank">Get
                                                                Color
                                                                Codes</a>
                                                        </div>
                                                        <div class="field color-picker" data-color-picker-container>
                                                            <label for="color-picker" data-color-picker></label>
                                                            <input id="color-picker" type="text"
                                                                name="content[call_to_action][title_color]"
                                                                data-color-picker-input
                                                                value="{{ $callToActionContent->title_color ?? '#000000' }}"
                                                                data-error="background Color" inputmode="text">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-fields">
                                                        <label class="title">Description <span
                                                                class="text-danger">*</span> :</label>
                                                        <textarea name="content[call_to_action][description]" class="field" rows="2" maxlength="255">{{ $callToActionContent->description ?? '' }} </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-fields">
                                                        <div class="title d-flex align-items-center gap-2">
                                                            <div>Description Text Color <span class="text-danger">*</span>:
                                                            </div>
                                                            <a class="p-0 nav-link" href="//html-color-codes.info"
                                                                target="_blank">Get
                                                                Color
                                                                Codes</a>
                                                        </div>
                                                        <div class="field color-picker" data-color-picker-container>
                                                            <label for="color-picker" data-color-picker></label>
                                                            <input id="color-picker" type="text"
                                                                name="content[call_to_action][description_color]"
                                                                data-color-picker-input
                                                                value="{{ $callToActionContent->description_color ?? '#000000' }}"
                                                                data-error="background Color" inputmode="text">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr />
                                        </div>
                                        <div class="col-lg-12 py-4">
                                            <div class="form-fields">
                                                <div class="d-flex align-items-center gap-3 mb-3">
                                                    <label class="title title--sm mb-0">Call to Action Button:</label>
                                                    <div class="form-check form-switch" data-enabled-text="Enabled"
                                                        data-disabled-text="Disabled">
                                                        <input class="form-check-input" data-toggle-switch=""
                                                            {{ isset($callToActionContent->is_button_enabled) ? 'checked' : '' }}
                                                            type="checkbox" id="cta_btn_enabled_cta" value="1"
                                                            name="content[call_to_action][is_button_enabled]">
                                                        <label class="form-check-label"
                                                            for="cta_btn_enabled_cta">Enabled</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 mb-4">
                                                        <div class="form-fields">
                                                            <label class="title">Button Text <span
                                                                    class="text-danger">*</span>
                                                                :</label>
                                                            <input type="text"
                                                                value="{{ $callToActionContent->btn_text ?? '' }}"
                                                                name="content[call_to_action][btn_text]" class="field"
                                                                placeholder="" data-error="Button Text" maxlength="28">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-4">
                                                        <div class="form-fields">
                                                            <label class="title">
                                                                <div class="d-flex align-items-center gap-2 lh-1">
                                                                    <div class="mt-1">Button Link </div>


                                                                    <button data-bs-placement="top"
                                                                        title="<div class='d-flex flex-column'> <div class='d-flex gap-1'> <strong>Link:</strong> https://abc.com</div> <div class='d-flex gap-1'><strong>Phone:</strong> tel:+971xxxxxxxxx</div> <div class='d-flex gap-1'><strong>Whatsapp:</strong> https://wa.me/971xxxxxxxxx</div> </div>"
                                                                        type="button" data-tooltip="tooltip"
                                                                        class="tooltip-lg">
                                                                        <i class='bx bxs-info-circle'></i>
                                                                    </button>
                                                                </div>
                                                            </label>
                                                            <input type="text"
                                                                value="{{ $callToActionContent->btn_link ?? '' }}"
                                                                name="content[call_to_action][btn_link]" class="field"
                                                                placeholder="" data-error="Button Link">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-fields">
                                                            <div class="title d-flex align-items-center gap-2">
                                                                <div>
                                                                    Button Background Color <span
                                                                        class="text-danger">*</span>:
                                                                </div>
                                                                <a class="p-0 nav-link" href="//html-color-codes.info"
                                                                    target="_blank">Get Color
                                                                    Codes</a>
                                                            </div>
                                                            <div class="field color-picker" data-color-picker-container>
                                                                <label for="color-picker" data-color-picker></label>
                                                                <input id="color-picker" type="text"
                                                                    name="content[call_to_action][btn_background_color]"
                                                                    data-color-picker-input
                                                                    value="{{ $callToActionContent->btn_background_color ?? '#1c4d99' }}"
                                                                    data-error="background Color" inputmode="text" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-fields">
                                                            <div class="title d-flex align-items-center gap-2">
                                                                <div>
                                                                    Button Text Color <span class="text-danger">*</span>:
                                                                </div>
                                                                <a class="p-0 nav-link" href="//html-color-codes.info"
                                                                    target="_blank">Get Color
                                                                    Codes</a>
                                                            </div>
                                                            <div class="field color-picker" data-color-picker-container>
                                                                <label for="color-picker" data-color-picker></label>
                                                                <input id="color-picker" type="text"
                                                                    name="content[call_to_action][btn_text_color]"
                                                                    data-color-picker-input
                                                                    value="{{ $callToActionContent->btn_text_color ?? '#ffffff' }}"
                                                                    data-error="background Color" inputmode="text" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr />
                                        </div>
                                        <div class="col-lg-12 pt-3">
                                            <div class="form-fields">
                                                <label class="title title--sm mb-3">Background Style:</label>
                                                <div x-data="{ call_to_action_background_type: '{{ isset($callToActionContent->call_to_action_background_type) ? $callToActionContent->call_to_action_background_type : 'background_image' }}' }">
                                                    <div class="d-flex align-items-center gap-5 px-4">
                                                        <div class="form-check p-0">
                                                            <input class="form-check-input" type="radio"
                                                                name="content[call_to_action][call_to_action_background_type]"
                                                                id="background_image_1"
                                                                x-model="call_to_action_background_type"
                                                                value="background_image" checked />
                                                            <label class="form-check-label"
                                                                for="background_image_1">Background
                                                                Image</label>
                                                        </div>
                                                        <div class="form-check p-0">
                                                            <input class="form-check-input" type="radio"
                                                                id="background_color_2_color"
                                                                x-model="call_to_action_background_type"
                                                                name="content[call_to_action][call_to_action_background_type]"
                                                                value="background_color" />
                                                            <label class="form-check-label"
                                                                for="background_color_2_color">Background
                                                                Color</label>
                                                        </div>
                                                    </div>
                                                    <div x-show="call_to_action_background_type === 'background_image'">
                                                        <div class="row pt-4">
                                                            <div class="col-md-4 mb-4">
                                                                <div class="form-fields">
                                                                    <label class="title">Background Image <span
                                                                            class="text-danger">*</span>:</label>
                                                                    <div class="upload upload--sm mx-0" data-upload>
                                                                        <div class="upload-box-wrapper">
                                                                            <div class="upload-box {{ empty($callToActionContent->background_image) ? 'show' : '' }}"
                                                                                data-upload-box>
                                                                                <input type="file"
                                                                                    name="content[call_to_action][background_image]"
                                                                                    data-error="Feature Image"
                                                                                    id="background_image"
                                                                                    class="upload-box__file d-none"
                                                                                    accept="image/*" data-file-input />
                                                                                <div class="upload-box__placeholder">
                                                                                    <i class="bx bxs-image"></i>
                                                                                </div>
                                                                                <label for="background_image"
                                                                                    class="upload-box__btn themeBtn">Upload
                                                                                    Image</label>
                                                                            </div>
                                                                            <div class="upload-box__img {{ !empty($callToActionContent->background_image) ? 'show' : '' }}"
                                                                                data-upload-img>
                                                                                <button type="button" class="delete-btn"
                                                                                    data-delete-btn="">
                                                                                    <i class="bx bxs-edit-alt"></i>
                                                                                </button>
                                                                                <a href="{{ asset($callToActionContent->background_image ?? 'admin/assets/images/loading.webp') }}"
                                                                                    class="mask"
                                                                                    data-fancybox="gallery">
                                                                                    <img src="{{ asset($callToActionContent->background_image ?? 'admin/assets/images/loading.webp') }}"
                                                                                        alt="Uploaded Image"
                                                                                        class="imgFluid"
                                                                                        data-placeholder="{{ asset('admin/assets/images/loading.webp') }}"
                                                                                        data-upload-preview="" />
                                                                                </a>
                                                                                <input type="text"
                                                                                    name="content[call_to_action][background_image_alt_text]"
                                                                                    class="field"
                                                                                    placeholder="Enter alt text"
                                                                                    value="{{ $callToActionContent->background_image_alt_text ?? 'Alt Text' }}">
                                                                            </div>
                                                                        </div>
                                                                        <div data-error-message
                                                                            class="text-danger mt-2 d-none text-center">
                                                                            Please upload a valid image file
                                                                        </div>
                                                                        <div class="dimensions text-center mt-3">
                                                                            <strong>Dimensions:</strong> 1116 &times;
                                                                            210
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div x-show="call_to_action_background_type === 'background_color'">
                                                        <div class="row pt-4">
                                                            <div class="col-md-12">
                                                                <div class="form-fields">
                                                                    <div class="title d-flex align-items-center gap-2">
                                                                        <div>
                                                                            Select Background Color <span
                                                                                class="text-danger">*</span>:
                                                                        </div>
                                                                        <a class="p-0 nav-link"
                                                                            href="//html-color-codes.info"
                                                                            target="_blank">Get Color
                                                                            Codes</a>
                                                                    </div>
                                                                    <div class="field color-picker"
                                                                        data-color-picker-container>
                                                                        <label for="color-picker"
                                                                            data-color-picker></label>
                                                                        <input id="color-picker" type="text"
                                                                            name="content[call_to_action][background_color]"
                                                                            data-color-picker-input
                                                                            value="{{ $callToActionContent->background_color ?? '' }}"
                                                                            placeholder="#000000"
                                                                            data-error="background Color"
                                                                            inputmode="text" />
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
                            <x-seo-options :seo="$seo ?? null" :resource="'tours/category'" :slug="$category->slug" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-box">
                            <div class="form-box__header">
                                <div class="title">Publish</div>
                            </div>
                            <div class="form-box__body">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="publish"
                                        value="publish"
                                        {{ old('status', $category->status ?? '') == 'publish' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="publish">
                                        Publish
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="status" id="draft"
                                        value="draft"
                                        {{ old('status', $category->status ?? '') == 'draft' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="draft">
                                        Draft
                                    </label>
                                </div>
                                <button class="themeBtn ms-auto mt-4">Save Changes</button>
                            </div>
                        </div>
                        <div class="form-box">
                            <div class="form-box__header">
                                <div class="title">Feature Image</div>
                            </div>
                            <div class="form-box__body">
                                <div class="form-fields">
                                    <div class="upload" data-upload>
                                        <div class="upload-box-wrapper">
                                            <div class="upload-box {{ empty($category->featured_image) ? 'show' : '' }}"
                                                data-upload-box>
                                                <input type="file" name="featured_image"
                                                    {{ empty($category->featured_image) ? '' : '' }}
                                                    data-error="Feature Image" id="featured_image"
                                                    class="upload-box__file d-none" accept="image/*" data-file-input>
                                                <div class="upload-box__placeholder"><i class='bx bxs-image'></i>
                                                </div>
                                                <label for="featured_image" class="upload-box__btn themeBtn">Upload
                                                    Image</label>
                                            </div>
                                            <div class="upload-box__img {{ !empty($category->featured_image) ? 'show' : '' }}"
                                                data-upload-img>
                                                <button type="button" class="delete-btn" data-delete-btn><i
                                                        class='bx bxs-trash-alt'></i></button>
                                                <a href="{{ asset($category->featured_image ?? 'admin/assets/images/loading.webp') }}"
                                                    class="mask" data-fancybox="gallery">
                                                    <img src="{{ asset($category->featured_image) }}"
                                                        alt="{{ $category->featured_image_alt_text }}" class="imgFluid"
                                                        data-upload-preview>
                                                </a>
                                                <input type="text" name="featured_image_alt_text" class="field"
                                                    placeholder="Enter alt text"
                                                    value="{{ $category->featured_image_alt_text }}">
                                            </div>
                                        </div>
                                        <div data-error-message class="text-danger mt-2 d-none text-center">Please
                                            upload a
                                            valid image file
                                        </div>
                                        @error('featured_image')
                                            <div class="text-danger mt-2 text-center">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="dimensions text-center mt-3">
                                        <strong>Dimensions:</strong> 270 &times; 260
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-box">
                            <div class="form-box__header">
                                <div class="title">Tours</div>
                            </div>
                            <div class="form-box__body">
                                <div class="form-fields">
                                    @php
                                        $selectedTopFeaturedTours =
                                            json_decode($category->top_featured_tour_ids, true) ?? [];
                                    @endphp
                                    <label class="title">Top 4 featured tours <span class="text-danger">*</span>
                                        :</label>
                                    <select name="top_featured_tour_ids[]" multiple class="select2-select"
                                        data-max-items="4" placeholder="Select Tours" {{ !$tours->isEmpty() ? '' : '' }}
                                        data-error="Top 4 featured tours">
                                        @foreach ($tours as $tour)
                                            <option value="{{ $tour->id }}"
                                                {{ in_array($tour->id, old('top_featured_tour_ids', $selectedTopFeaturedTours)) ? 'selected' : '' }}>
                                                {{ $tour->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('top_featured_tour_ids')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-fields">
                                    @php
                                        $selectedBottomFeaturedTours =
                                            json_decode($category->bottom_featured_tour_ids, true) ?? [];
                                    @endphp
                                    <label class="title">Bottom featured tours <span class="text-danger">*</span>
                                        :</label>
                                    <select name="bottom_featured_tour_ids[]" multiple class="select2-select"
                                        placeholder="Select Tours" {{ !$tours->isEmpty() ? '' : '' }}
                                        data-error="Bottom featured tours">
                                        @foreach ($tours as $tour)
                                            <option value="{{ $tour->id }}"
                                                {{ in_array($tour->id, old('bottom_featured_tour_ids', $selectedBottomFeaturedTours)) ? 'selected' : '' }}>
                                                {{ $tour->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bottom_featured_tour_ids')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-fields">
                                    @php
                                        $selectedRecommendedTours =
                                            json_decode($category->recommended_tour_ids, true) ?? [];
                                    @endphp
                                    <label class="title">Recommended tours <span class="text-danger">*</span>
                                        :</label>
                                    <select name="recommended_tour_ids[]" multiple class="select2-select"
                                        data-max-items="4" placeholder="Select Tours" {{ !$tours->isEmpty() ? '' : '' }}
                                        data-error="Recommended tours">
                                        @foreach ($tours as $tour)
                                            <option value="{{ $tour->id }}"
                                                {{ in_array($tour->id, old('recommended_tour_ids', $selectedRecommendedTours)) ? 'selected' : '' }}>
                                                {{ $tour->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('recommended_tour_ids')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-box">
                            <div class="form-box__header">
                                <div class="title">Reviews</div>
                            </div>
                            <div class="form-box__body">
                                <div class="form-fields">
                                    @php
                                        $selectedtoursReviews = json_decode($category->tour_reviews_ids, true) ?? [];
                                    @endphp
                                    <label class="title">Featured Reviews<span class="text-danger">*</span>
                                        :</label>
                                    <select name="tour_reviews_ids[]" multiple class="select2-select" data-max-items="4"
                                        placeholder="Select Reviews" {{ !$toursReviews->isEmpty() ? '' : '' }}
                                        data-error="Featured Reviews">
                                        @foreach ($toursReviews as $review)
                                            <option value="{{ $review->id }}"
                                                {{ in_array($review->id, old('tour_reviews_ids', $selectedtoursReviews)) ? 'selected' : '' }}>
                                                {{ $review->title }} (Rating: {{ $review->rating }}/5)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tour_reviews_ids')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr@1.8.2/dist/pickr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document
                .querySelectorAll("[data-color-picker-container]")
                ?.forEach((element) => {
                    InitializeColorPickers(element);
                });
        })
    </script>
@endpush
