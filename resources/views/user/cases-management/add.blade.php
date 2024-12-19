@extends('user.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('user.cases.create') }}
            <div class="custom-sec custom-sec--form">
                <div class="custom-sec__header">
                    <div class="section-content">
                        <h3 class="heading">{{ isset($title) ? $title : '' }}</h3>
                    </div>
                </div>
            </div>
            <form action="{{ route('user.cases.store') }}" method="POST" enctype="multipart/form-data" id="validation-form">
                @csrf
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
                                                <div x-data="{ case_type: 'share_image_diagnosis' }">
                                                    <div class="d-flex align-items-center gap-5 ps-4 mb-1">
                                                        <div class="form-check p-0">
                                                            <input class="form-check-input" type="radio" name="case_type"
                                                                id="case-type-1" name="case_type" x-model="case_type"
                                                                value="share_image_diagnosis" />
                                                            <label class="form-check-label" for="case-type-1">Share
                                                                image
                                                                diagnosis </label>
                                                        </div>
                                                        <div class="form-check p-0">
                                                            <input class="form-check-input" type="radio" name="case_type"
                                                                id="case-type-2" name="case_type" x-model="case_type"
                                                                value="challenge_image_diagnosis" />
                                                            <label class="form-check-label" for="case-type-2">
                                                                Challenge
                                                                image diagnosis
                                                            </label>
                                                        </div>
                                                        <div class="form-check p-0">
                                                            <input class="form-check-input" type="radio" name="case_type"
                                                                id="case-type-3" name="case_type" x-model="case_type"
                                                                value="ask_image_diagnosis" />
                                                            <label class="form-check-label" for="case-type-3">
                                                                Ask
                                                                image diagnosis
                                                            </label>
                                                        </div>
                                                        <div class="form-check p-0">
                                                            <input class="form-check-input" type="radio" name="case_type"
                                                                id="case-type-4" name="case_type" x-model="case_type"
                                                                value="ask_ai_image_diagnosis" />
                                                            <label class="form-check-label" for="case-type-4">
                                                                Ask AI
                                                                image diagnosis
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="pt-4" x-show="case_type === 'share_image_diagnosis'">
                                                        <div class="form-fields">
                                                            <label class="title">Content <span
                                                                    class="text-danger">*</span>:</label>
                                                            <textarea class="editor" name="content" :data-required="case_type === 'share_image_diagnosis' ? true : false"
                                                                data-placeholder="content" data-error="Content">
                                                                {{ old('content') }}
                                                            </textarea>
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

                                        <div class="col-lg-6 mb-4">
                                            @php
                                                $imageTypes = [
                                                    'Optical imaging',
                                                    'X Ray',
                                                    'Fluoroscopy',
                                                    'CT Scan',
                                                    'Ultrasound, Diagnostic',
                                                    'Ultrasound, Pregnancy',
                                                    'MRI',
                                                    'PET Scan',
                                                    'Retinography',
                                                    'Mammography',
                                                    'Arthrogram',
                                                    'Interventional imaging',
                                                    'Histopathology',
                                                    '2D',
                                                    '3D',
                                                    '4D',
                                                ];
                                            @endphp
                                            <div class="form-fields">
                                                <label class="title">Image Type <span class="text-danger">*</span>
                                                    :</label>
                                                <select data-required data-error="Image Type" name="image_type"
                                                    class="field select2-select">
                                                    <option value="" selected disabled>Select</option>
                                                    @foreach ($imageTypes as $imageType)
                                                        <option value="{{ $imageType }}"
                                                            {{ old('image_type') === $imageType ? 'selected' : '' }}>
                                                            {{ $imageType }}</option>
                                                    @endforeach
                                                </select>
                                                @error('image_type')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
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
                                                            {{ old('image_quality') === $imageQuality ? 'selected' : '' }}>
                                                            {{ $imageQuality }}</option>
                                                    @endforeach
                                                </select>
                                                @error('image_quality')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12 my-3">
                                            <div class="form-fields">
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Specific Diagnosis Title <span
                                                        class="text-danger">*</span>
                                                    :</label>
                                                <input type="text" data-required data-error="Specific Diagnosis Title"
                                                    name="diagnosis_title" class="field">
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
                                                <label class="title">Diagnosed Disease <span class="text-danger">*</span>
                                                    :</label>
                                                <select data-required data-error="Diagnosed Disease"
                                                    name="diagnosed_disease" class="field select2-select">
                                                    <option value="" selected disabled>Select</option>
                                                    @foreach ($specialities as $speciality)
                                                        <option value="{{ $speciality }}"
                                                            {{ old('diagnosed_disease') === $speciality ? 'selected' : '' }}>
                                                            {{ $speciality }}</option>
                                                    @endforeach
                                                </select>
                                                @error('diagnosed_disease')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Ease of Diagnosis <span
                                                        class="text-danger">*</span>:</label>
                                                <select data-required data-error="Ease of Diagnosis"
                                                    name="ease_of_diagnosis" class="field select2-select">
                                                    <option value="" selected disabled>Select</option>
                                                    <option value="Easy">Easy</option>
                                                    <option value="Difficult">Difficult</option>
                                                    <option value="Very Difficult">Very Difficult</option>
                                                </select>
                                                @error('ease_of_diagnosis')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Certainty <span
                                                        class="text-danger">*</span>:</label>
                                                <select data-required data-error="Certainty" name="certainty"
                                                    class="field select2-select">
                                                    <option value="" selected disabled>Select</option>
                                                    <option value="Certainty">Certainty</option>
                                                    <option value="Almost Certain">Almost Certain</option>
                                                    <option value="Uncertain">Uncertain</option>
                                                </select>
                                                @error('certainty')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Ethnicity <span
                                                        class="text-danger">*</span>:</label>
                                                <select data-required data-error="Ethnicity" name="ethnicity"
                                                    class="field select2-select">
                                                    <option value="" selected disabled>Select</option>
                                                    <option value="Black">Black</option>
                                                    <option value="African American">African American</option>
                                                    <option value="White">White</option>
                                                    <option value="Hispanic">Hispanic</option>
                                                    <option value="Latino">Latino</option>
                                                    <option value="Asian">Asian</option>
                                                    <option value="American Indian">American Indian</option>
                                                    <option value="Alaska Native">Alaska Native</option>
                                                    <option value="Caucasian">Caucasian</option>
                                                    <option value="Native American">Native American</option>
                                                </select>
                                                @error('ethnicity')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                            <div class="form-fields">
                                                <label class="title">Segment <span class="text-danger">*</span>:</label>
                                                <select data-required data-error="Segment" name="segment"
                                                    class="field select2-select">
                                                    <option value="" selected disabled>Select</option>
                                                    <option value="Elderly Male">Elderly Male</option>
                                                    <option value="Elderly Female">Elderly Female</option>
                                                    <option value="Adult Male">Adult Male</option>
                                                    <option value="Adult Female">Adult Female</option>
                                                    <option value="Adolescent">Adolescent</option>
                                                    <option value="Child">Child</option>
                                                    <option value="Infant">Infant</option>
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
                                                    name="clinical_examination" class="field">
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
                                                    authors: [{ name: '', doi: '', article_link: '' }],
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
                                                    class="field">
                                                @error('patient_age')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <div class="form-fields">
                                                <label class="title">Gender <span class="text-danger">*</span>:</label>
                                                <input type="text" data-required data-error="Gender"
                                                    name="patient_gender" class="field">
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
                                                    name="patient_socio_economic" class="field">
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
                                                    name="patient_concomitant" class="field">
                                                @error('patient_concomitant')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-fields">
                                                <label class="title">Others <span class="text-danger">*</span>:</label>
                                                <input type="text" data-required data-error="Others"
                                                    name="patient_others" class="field">
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
                                            checked value="active">
                                        <label class="form-check-label" for="active">
                                            active
                                        </label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="status" id="inactive"
                                            value="inactive">
                                        <label class="form-check-label" for="inactive">
                                            inactive
                                        </label>
                                    </div>
                                    <button class="themeBtn ms-auto mt-4">Save Changes</button>
                                </div>
                            </div>
                            {{-- <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Feature Image</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="form-fields">

                                        <div class="upload" data-upload>
                                            <div class="upload-box-wrapper">
                                                <div class="upload-box show" data-upload-box>
                                                    <input type="file" name="featured_image"
                                                        data-error="Feature Image" id="featured_image"
                                                        class="upload-box__file d-none" accept="image/*" data-file-input>
                                                    <div class="upload-box__placeholder"><i class='bx bxs-image'></i>
                                                    </div>
                                                    <label for="featured_image" class="upload-box__btn themeBtn">Upload
                                                        Image</label>
                                                </div>
                                                <div class="upload-box__img" data-upload-img>
                                                    <button type="button" class="delete-btn" data-delete-btn><i
                                                            class='bx bxs-trash-alt'></i></button>
                                                    <a href="#" class="mask" data-fancybox="gallery">
                                                        <img src="{{ asset('admin/assets/images/loading.webp') }}"
                                                            alt="Uploaded Image" class="imgFluid" data-upload-preview>
                                                    </a>
                                                    <input type="text" name="featured_image_alt_text" class="field"
                                                        placeholder="Enter alt text" value="Alt Text">
                                                </div>
                                            </div>
                                            <div data-error-message class="text-danger mt-2 d-none text-center">Please
                                                upload a
                                                valid image file
                                            </div>
                                            @error('featured_image_alt_text')
                                                <div class="text-danger mt-2 text-center">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            @error('featured_image')
                                                <div class="text-danger mt-2 text-center">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="dimensions text-center mt-3">
                                            <strong>Dimensions:</strong> 265 &times; 155
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
