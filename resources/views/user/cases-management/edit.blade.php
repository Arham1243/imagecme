@extends('user.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('user.cases.edit', $case) }}
            <form action="{{ route('user.cases.update', $case->id) }}" method="POST" enctype="multipart/form-data"
                id="validation-form">
                @csrf
                @method('PATCH')
                <div class="custom-sec custom-sec--form">
                    <div class="custom-sec__header">
                        <div class="section-content">
                            <h3 class="heading">Edit Case: {{ isset($title) ? $title : '' }}</h3>
                        </div>
                        <div class="d-flex gap-3">
                            @if ($case->case_type === 'ask_ai_image_diagnosis')
                                <a href="{{ route('user.cases.chat', $case->id) }}" class="themeBtn"> <img
                                        src='https://cdn.worldvectorlogo.com/logos/chatgpt-6.svg' alt='image'
                                        class='imgFluid' loading='lazy'> Ask AI</a>
                            @endif
                            <a href="javascript:void(0)" class="themeBtn"><i class='bx bxs-show'></i> View Case</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Case Content</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="row">
                                        <div class="col-lg-12 mb-4 pb-1">
                                            <div class="form-fields">
                                                <div class="title title--sm mb-3">Case Type:</div>
                                                <div x-data="{ case_type: '{{ old('case_type', $case->case_type ?? 'share_image_diagnosis') }}' }">
                                                    <div class="d-flex align-items-center gap-5 ps-4 mb-1">
                                                        <div class="form-check p-0">
                                                            <input class="form-check-input" type="radio" name="case_type"
                                                                id="case-type-1" x-model="case_type"
                                                                value="share_image_diagnosis" />
                                                            <label class="form-check-label" for="case-type-1">Share image
                                                                diagnosis</label>
                                                        </div>
                                                        <div class="form-check p-0">
                                                            <input class="form-check-input" type="radio" name="case_type"
                                                                id="case-type-2" x-model="case_type"
                                                                value="challenge_image_diagnosis" />
                                                            <label class="form-check-label" for="case-type-2">Challenge
                                                                image diagnosis</label>
                                                        </div>
                                                        <div class="form-check p-0">
                                                            <input class="form-check-input" type="radio" name="case_type"
                                                                id="case-type-3" x-model="case_type"
                                                                value="ask_image_diagnosis" />
                                                            <label class="form-check-label" for="case-type-3">Ask image
                                                                diagnosis</label>
                                                        </div>
                                                        <div class="form-check p-0">
                                                            <input class="form-check-input" type="radio" name="case_type"
                                                                id="case-type-4" x-model="case_type"
                                                                value="ask_ai_image_diagnosis" />
                                                            <label class="form-check-label" for="case-type-4">Ask AI image
                                                                diagnosis</label>
                                                        </div>
                                                    </div>
                                                    <div class="pt-4" x-show="case_type === 'share_image_diagnosis'">
                                                        <div class="form-fields">
                                                            <label class="title">Content <span
                                                                    class="text-danger">*</span>:</label>
                                                            <textarea class="editor" name="content" :data-required="case_type === 'share_image_diagnosis' ? true : false"
                                                                data-placeholder="content" data-error="Content">{{ old('content', $case->content ?? '') }}</textarea>
                                                            @error('content')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12 mb-3">
                                            <div class="form-fields">
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mb-2">
                                            <div class="form-fields">
                                                <div class="title title--sm">Case Image:</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-4">
                                            @php
                                                $imageQualities = ['Low', 'Medium', 'High'];
                                            @endphp
                                            <div class="form-fields">
                                                <label class="title">Image Quality <span class="text-danger">*</span>
                                                    :</label>
                                                <select data-required data-error="Image Quality" name="image_quality"
                                                    class="field select2-select">
                                                    <option value="" selected disabled>Select</option>
                                                    @foreach ($imageQualities as $imageQuality)
                                                        <option value="{{ $imageQuality }}"
                                                            {{ old('image_quality', $case->image_quality ?? '') === $imageQuality ? 'selected' : '' }}>
                                                            {{ $imageQuality }}</option>
                                                    @endforeach
                                                </select>
                                                @error('image_quality')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12  mb-4" x-data="imageUploadManager()">
                                            <template x-for="(row, index) in rows" :key="index">
                                                <div class="case-image-box">
                                                    <div class="close-btn" @click="removeImageRow(index)">
                                                        <i class='bx bx-x'></i>
                                                    </div>

                                                    <div class="form-fields mb-4">
                                                        <label class="title">Image Type <span
                                                                class="text-danger">*</span>:</label>
                                                        <select x-model="row.selectedImageType" class="field">
                                                            <option value="" selected disabled>Select</option>
                                                            <template x-for="type in availableImageTypes"
                                                                :key="type">
                                                                <option :value="type" x-text="type"
                                                                    :disabled="isTypeSelected(type, index)"></option>
                                                            </template>
                                                        </select>
                                                    </div>
                                                    <div class="form-fields mb-3" x-show="row.selectedImageType">
                                                        <div class="multiple-upload mt-3">
                                                            <input :id="'case-images-' + index" type="file"
                                                                class="gallery-input d-none" multiple accept="image/*"
                                                                @change="handleFileUpload($event, index)"
                                                                :name="'case_images[' + row.selectedImageType +
                                                                    '][images][file][]'">

                                                            <label class="multiple-upload__btn themeBtn"
                                                                :for="'case-images-' + index">
                                                                <i class='bx bx-upload'></i> Choose images
                                                            </label>
                                                            <ul class="multiple-upload__imgs mt-4 pt-2">
                                                                <template x-for="(image, imgIndex) in row.uploadedImages"
                                                                    :key="imgIndex">
                                                                    <li class="single-image">
                                                                        <div class="delete-btn"
                                                                            @click="removeImage(index, imgIndex)">
                                                                            <i class='bx bxs-trash-alt'></i>
                                                                        </div>
                                                                        <a class="mask" :href="image.src"
                                                                            data-fancybox="gallery">
                                                                            <img :src="image.src"
                                                                                class="imgFluid" />
                                                                        </a>
                                                                        <input
                                                                            :name="'case_images[' + row.selectedImageType +
                                                                                '][images][name][]'"
                                                                            class="field" placeholder="Enter Name"
                                                                            data-required data-error="Image Name"
                                                                            x-model="image.name">
                                                                    </li>
                                                                </template>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                            <div class="dimensions mt-4">
                                                <strong>Dimensions:</strong> 603 &times; 641
                                            </div>
                                            <button type="button" class="themeBtn ms-auto mt-4" @click="addImageRow"
                                                x-show="!(rows.length >= availableImageTypes.length)">
                                                <i class='bx bx-plus'></i> Add Image
                                            </button>
                                        </div>

                                        <div class="col-lg-12 mb-2">
                                            @php
                                                $groupImages = $case->images->groupBy('type');
                                            @endphp


                                            <div class="form-fields">
                                                <div class="title title--sm">Current Case Images:</div>
                                            </div>
                                            @foreach ($groupImages as $type => $images)
                                                <div class="form-fields mb-4">
                                                    <div class="title mb-3">{{ $type }}:</div>
                                                    <ul class="multiple-upload__imgs">
                                                        @foreach ($images as $i => $image)
                                                            <li class="single-image">
                                                                <a href="{{ route('user.cases.deleteImage', $image->id) }}"
                                                                    onclick="return confirm('Are you sure you want to delete this image?')"
                                                                    class="delete-btn">
                                                                    <i class='bx bxs-trash-alt'></i>
                                                                </a>
                                                                <a class="mask" href="{{ asset($image->path) }}"
                                                                    data-fancybox="gallery-{{ $i }}">
                                                                    <img src="{{ asset($image->path) }}" class="imgFluid"
                                                                        alt="{{ $image->name }}" />
                                                                </a>
                                                                <div class="filename">{{ $image->name }}</div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach

                                        </div>
                                        <div class="col-lg-12 my-3">
                                            <div class="form-fields">
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Specific Diagnosis Title <span
                                                        class="text-danger">*</span>:</label>
                                                <input type="text" data-required data-error="Specific Diagnosis Title"
                                                    name="diagnosis_title" class="field"
                                                    value="{{ old('diagnosis_title', $case->diagnosis_title ?? '') }}">
                                                @error('diagnosis_title')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-4">
                                            @php
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
                                            <div class="form-fields">
                                                <label class="title">Diagnosed Disease <span
                                                        class="text-danger">*</span>:</label>
                                                <select data-required data-error="Diagnosed Disease"
                                                    name="diagnosed_disease" class="field select2-select">
                                                    <option value="" selected disabled>Select</option>
                                                    @foreach ($specialities as $speciality)
                                                        <option value="{{ $speciality }}"
                                                            {{ old('diagnosed_disease', $case->diagnosed_disease ?? '') === $speciality ? 'selected' : '' }}>
                                                            {{ $speciality }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('diagnosed_disease')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-4">
                                            @php
                                                $ease_of_diagnosis_options = ['Easy', 'Difficult', 'Very Difficult'];
                                            @endphp
                                            <div class="form-fields">
                                                <label class="title">Ease of Diagnosis <span
                                                        class="text-danger">*</span>:</label>
                                                <select data-required data-error="Ease of Diagnosis"
                                                    name="ease_of_diagnosis" class="field select2-select">
                                                    <option value="" selected disabled>Select</option>
                                                    @foreach ($ease_of_diagnosis_options as $option)
                                                        <option value="{{ $option }}"
                                                            {{ old('ease_of_diagnosis', $case->ease_of_diagnosis ?? '') === $option ? 'selected' : '' }}>
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('ease_of_diagnosis')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-4">
                                            @php
                                                $certainty_options = ['Certainty', 'Almost Certain', 'Uncertain'];
                                            @endphp
                                            <div class="form-fields">
                                                <label class="title">Certainty <span
                                                        class="text-danger">*</span>:</label>
                                                <select data-required data-error="Certainty" name="certainty"
                                                    class="field select2-select">
                                                    <option value="" selected disabled>Select</option>
                                                    @foreach ($certainty_options as $option)
                                                        <option value="{{ $option }}"
                                                            {{ old('certainty', $case->certainty ?? '') === $option ? 'selected' : '' }}>
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('certainty')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-4">
                                            @php
                                                $ethnicity_options = [
                                                    'Black',
                                                    'African American',
                                                    'White',
                                                    'Hispanic',
                                                    'Latino',
                                                    'Asian',
                                                    'American Indian',
                                                    'Alaska Native',
                                                    'Caucasian',
                                                    'Native American',
                                                ];
                                            @endphp
                                            <div class="form-fields">
                                                <label class="title">Ethnicity <span
                                                        class="text-danger">*</span>:</label>
                                                <select data-required data-error="Ethnicity" name="ethnicity"
                                                    class="field select2-select">
                                                    <option value="" selected disabled>Select</option>
                                                    @foreach ($ethnicity_options as $option)
                                                        <option value="{{ $option }}"
                                                            {{ old('ethnicity', $case->ethnicity ?? '') === $option ? 'selected' : '' }}>
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('ethnicity')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                            @php
                                                $segment_options = [
                                                    'Elderly Male',
                                                    'Elderly Female',
                                                    'Adult Male',
                                                    'Adult Female',
                                                    'Adolescent',
                                                    'Child',
                                                    'Infant',
                                                ];
                                            @endphp
                                            <div class="form-fields">
                                                <label class="title">Segment <span class="text-danger">*</span>:</label>
                                                <select data-required data-error="Segment" name="segment"
                                                    class="field select2-select">
                                                    <option value="" selected disabled>Select</option>
                                                    @foreach ($segment_options as $option)
                                                        <option value="{{ $option }}"
                                                            {{ old('segment', $case->segment ?? '') === $option ? 'selected' : '' }}>
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('segment')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                            <div class="form-fields">
                                                <label class="title">Clinical Examination <span
                                                        class="text-danger">*</span>:</label>
                                                <input type="text" data-required data-error="Clinical Examination"
                                                    name="clinical_examination" class="field"
                                                    value="{{ old('clinical_examination', $case->clinical_examination ?? '') }}">
                                                @error('clinical_examination')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12 my-3">
                                            <div class="form-fields">
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-fields">
                                                <div class="title title--sm mb-2">Add Co-Author:</div>
                                                <div class="repeater-table" x-data="{
                                                    authors: {{ json_encode(old('authors', json_decode($case->authors ?? '[]'))) }},
                                                    addAuthor() {
                                                        this.authors.push({ name: '', doi: '', article_link: '' });
                                                    },
                                                    removeAuthor(index) {
                                                        this.authors.splice(index, 1);
                                                    }
                                                }">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Information</th>
                                                                <th class="text-end" scope="col">Remove</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <template x-for="(author, index) in authors"
                                                                :key="index">
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-fields">
                                                                            <label class="title">Name:</label>
                                                                            <input type="hidden"
                                                                                :name="'authors[' + index + '][name]'"
                                                                                x-model="author.name">
                                                                            <input type="text" x-model="author.name"
                                                                                class="field">
                                                                        </div>
                                                                        <div class="form-fields">
                                                                            <label class="title">DOI:</label>
                                                                            <input type="hidden"
                                                                                :name="'authors[' + index + '][doi]'"
                                                                                x-model="author.doi">
                                                                            <input type="text" x-model="author.doi"
                                                                                class="field">
                                                                        </div>
                                                                        <div class="form-fields">
                                                                            <label class="title">Article Link, if
                                                                                any:</label>
                                                                            <input type="hidden"
                                                                                :name="'authors[' + index + '][article_link]'"
                                                                                x-model="author.article_link">
                                                                            <input type="text"
                                                                                x-model="author.article_link"
                                                                                class="field">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button"
                                                                            class="delete-btn ms-auto delete-btn--static"
                                                                            @click="removeAuthor(index)">
                                                                            <i class='bx bxs-trash-alt'></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                    </table>
                                                    <button type="button" class="themeBtn ms-auto"
                                                        @click="addAuthor">Add
                                                        <i class="bx bx-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 my-3">
                                            <div class="form-fields">
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-2">
                                            <div class="form-fields">
                                                <div class="title title--sm">Patient info:</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Age <span class="text-danger">*</span>:</label>
                                                <input type="text" data-required data-error="Age" name="patient_age"
                                                    class="field"
                                                    value="{{ old('patient_age', $case->patient_age ?? '') }}">
                                                @error('patient_age')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Gender <span class="text-danger">*</span>:</label>
                                                <input type="text" data-required data-error="Gender"
                                                    name="patient_gender" class="field"
                                                    value="{{ old('patient_gender', $case->patient_gender ?? '') }}">
                                                @error('patient_gender')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Socio Economic <span
                                                        class="text-danger">*</span>:</label>
                                                <input type="text" data-required data-error="Socio Economic"
                                                    name="patient_socio_economic" class="field"
                                                    value="{{ old('patient_socio_economic', $case->patient_socio_economic ?? '') }}">
                                                @error('patient_socio_economic')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Concomitant <span
                                                        class="text-danger">*</span>:</label>
                                                <input type="text" data-required data-error="Concomitant"
                                                    name="patient_concomitant" class="field"
                                                    value="{{ old('patient_concomitant', $case->patient_concomitant ?? '') }}">
                                                @error('patient_concomitant')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-fields">
                                                <label class="title">Others <span class="text-danger">*</span>:</label>
                                                <input type="text" data-required data-error="Others"
                                                    name="patient_others" class="field"
                                                    value="{{ old('patient_others', $case->patient_others ?? '') }}">
                                                @error('patient_others')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="seo-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Publish</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="active"
                                            value="active"
                                            {{ old('status', $case->status ?? '') == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">
                                            active
                                        </label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="status" id="inactive"
                                            value="inactive"
                                            {{ old('status', $case->status ?? '') == 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inactive">
                                            inactive
                                        </label>
                                    </div>
                                    <button class="themeBtn ms-auto mt-4">Save Changes</button>
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
        document.addEventListener("alpine:init", () => {
            Alpine.data('imageUploadManager', () => ({
                availableImageTypes: [
                    'Optical imaging', 'X Ray', 'Fluoroscopy', 'CT Scan', 'Ultrasound, Diagnostic',
                    'Ultrasound, Pregnancy', 'MRI', 'PET Scan', 'Retinography', 'Mammography',
                    'Arthrogram', 'Interventional imaging', 'Histopathology', '2D', '3D', '4D',
                ],
                rows: [{
                    selectedImageType: '',
                    uploadedImages: []
                }],

                isTypeSelected(type, currentIndex) {
                    return this.rows.some((row, index) => index !== currentIndex && row
                        .selectedImageType === type);
                },

                addImageRow() {
                    this.rows.push({
                        selectedImageType: '',
                        uploadedImages: []
                    });
                },

                removeImageRow(index) {
                    this.rows.splice(index, 1);
                },

                handleFileUpload(event, rowIndex) {
                    const files = event.target.files;
                    const row = this.rows[rowIndex];

                    if (files && files.length > 0) {
                        for (const file of files) {
                            row.uploadedImages.push({
                                src: URL.createObjectURL(file),
                                file: file,
                                name: ''
                            });
                        }
                    }
                },

                removeImage(rowIndex, imgIndex) {
                    this.rows[rowIndex].uploadedImages.splice(imgIndex, 1);
                }
            }));
        });
    </script>
@endpush
