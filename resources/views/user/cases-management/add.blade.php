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
            <form class="caseForm" action="{{ route('user.cases.store') }}" method="POST" enctype="multipart/form-data"
                id="validation-form">
                @csrf
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Image Content</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="row">
                                        <div class="col-lg-12 mb-4 pb-1">
                                            <div class="form-fields">
                                                <div class="title title--sm mb-3">Case Type:</div>
                                                <div x-data="{
                                                    case_type: '{{ request('type') ?? 'share_image_diagnosis' }}'
                                                }">
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
                                                        {{-- <div class="form-check p-0">
                                                            <input class="form-check-input" type="radio" name="case_type"
                                                                id="case-type-4" name="case_type" x-model="case_type"
                                                                value="ask_ai_image_diagnosis"
                                                                @change="document.querySelector('.caseForm').submit()" />
                                                            <label class="form-check-label" for="case-type-4">
                                                                Ask AI
                                                                image diagnosis
                                                            </label>
                                                        </div> --}}
                                                    </div>
                                                    <div class="pt-4" x-show="case_type === 'share_image_diagnosis'">
                                                        <div class="row">
                                                            <div class="col-lg-12 mb-3">
                                                                <div class="form-fields">
                                                                    <label class="title">Content </label>
                                                                    <textarea class="editor" name="content" data-placeholder="content" data-error="Content">  {{ old('content') }} </textarea>
                                                                    @error('content')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pt-4" x-show="case_type === 'challenge_image_diagnosis'">
                                                        <div x-data="mcqManager()" class="form-fields">
                                                            <label
                                                                class="d-flex align-items-center mb-3 justify-content-between">
                                                                <span class="title title--sm mb-0">Challenge Others</span>
                                                            </label>
                                                            <div class="repeater-table">
                                                                <table class="table table-bordered">

                                                                    <tbody>
                                                                        <template x-for="(mcq, index) in mcqs"
                                                                            :key="index">
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="form-fields">
                                                                                        <label
                                                                                            class="title">Question</label>
                                                                                        <input type="text"
                                                                                            x-model="mcq.question"
                                                                                            placeholder="" class="field"
                                                                                            :name="'mcqs[' + index +
                                                                                                '][question]'" />
                                                                                    </div>
                                                                                    <template
                                                                                        x-for="(answer, answerIndex) in mcq.answers"
                                                                                        :key="answerIndex">
                                                                                        <div class="form-fields mt-4 py-2">
                                                                                            <label class="title"
                                                                                                x-text="`Option ${answerIndex + 1}`"></label>
                                                                                            <div
                                                                                                class="d-flex align-items-center gap-3">
                                                                                                <input type="text"
                                                                                                    x-model="mcq.answers[answerIndex]"
                                                                                                    placeholder=""
                                                                                                    class="field"
                                                                                                    :name="'mcqs[' + index +
                                                                                                        '][answers][' +
                                                                                                        answerIndex +
                                                                                                        ']'" />
                                                                                                <button type="button"
                                                                                                    @click="removeAnswer(index, answerIndex)"
                                                                                                    class="delete-btn ms-auto delete-btn--static"
                                                                                                    :disabled="mcq.answers
                                                                                                        .length <= 1">
                                                                                                    <i
                                                                                                        class="bx bxs-trash-alt"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </template>

                                                                                    <button type="button"
                                                                                        @click="addAnswer(index)"
                                                                                        class="themeBtn ms-auto mt-3">
                                                                                        Add Option <i
                                                                                            class="bx bx-plus"></i>
                                                                                    </button>
                                                                                </td>
                                                                            </tr>
                                                                        </template>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" x-show="case_type !== 'ask_ai_image_diagnosis'">

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
                                                                <label class="title">Image Quality
                                                                    :</label>
                                                                <select data-error="Image Quality" name="image_quality"
                                                                    class="field select2-select">
                                                                    <option value="" selected disabled>Select
                                                                    </option>
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

                                                        <div x-data="imageTypeManager()">
                                                            <div class="col-lg-12 mb-4">
                                                                <div class="form-fields mb-4">
                                                                    <label class="title">Image Type </label>
                                                                    <select x-model="selectedType" @change="addTypeRow()"
                                                                        class="field">
                                                                        <option value="" selected disabled>Select
                                                                        </option>
                                                                        <template x-for="type in types"
                                                                            :key="type.id">
                                                                            <option :value="type.id"
                                                                                :disabled="selectedTypes.includes(type.id)"
                                                                                x-text="type.name">
                                                                            </option>
                                                                        </template>
                                                                    </select>
                                                                </div>
                                                                <template x-for="(type, index) in selectedTypes"
                                                                    :key="index">
                                                                    <div class="case-image-box mt-4">
                                                                        <div class="close-btn"
                                                                            @click="removeTypeRow(index)">
                                                                            <i class='bx bx-x'></i>
                                                                        </div>
                                                                        <div class="form-fields mb-3">
                                                                            <div class="title title--sm"
                                                                                x-text="type.name"></div>
                                                                            <input type="hidden"
                                                                                :name="'image_types[' + index + '][type]'"
                                                                                :value="type.id">
                                                                            <div class="multiple-upload mt-3">
                                                                                <input type="file"
                                                                                    :id="'gallery-input-' + index"
                                                                                    class="gallery-input d-none" multiple
                                                                                    accept="image/*"
                                                                                    @change="previewFiles($event, index)"
                                                                                    :name="'image_types[' + index +
                                                                                        '][files][]'">
                                                                                <label :for="'gallery-input-' + index"
                                                                                    class="multiple-upload__btn themeBtn">
                                                                                    <i class='bx bx-upload'></i> Choose
                                                                                    images
                                                                                </label>
                                                                                <ul
                                                                                    class="multiple-upload__imgs mt-4 pt-2">
                                                                                    <template
                                                                                        x-for="(file, fileIndex) in uploadedFiles[index]"
                                                                                        :key="fileIndex">
                                                                                        <li class="single-image">
                                                                                            <div class="delete-btn"
                                                                                                @click="removeFile(index, fileIndex)">
                                                                                                <i
                                                                                                    class='bx bxs-trash-alt'></i>
                                                                                            </div>
                                                                                            <a class="mask"
                                                                                                :href="file.preview"
                                                                                                data-fancybox="gallery">
                                                                                                <img :src="file.preview"
                                                                                                    class="imgFluid" />
                                                                                            </a>
                                                                                            <input class="field"
                                                                                                placeholder="Enter description"
                                                                                                x-model="file.description"
                                                                                                :name="'image_types[' + index +
                                                                                                    '][names][]'"
                                                                                                data-required
                                                                                                data-error="Image Description">
                                                                                            <span class="text-danger"
                                                                                                x-show="!file.description">
                                                                                                Please enter image
                                                                                                description
                                                                                            </span>
                                                                                        </li>
                                                                                    </template>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </template>



                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 my-3">
                                                            <div class="form-fields">
                                                                <hr>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 mb-4">
                                                            <div class="form-fields">
                                                                <label class="title">Specific Diagnosis Title :</label>
                                                                <input type="text" data-required=""
                                                                    data-error="Specific Diagnosis Title"
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
                                                                <label class="title">Diagnosed Disease :</label>
                                                                <select data-error="Diagnosed Disease"
                                                                    name="diagnosed_disease" class="field select2-select">
                                                                    <option value="" selected disabled>Select
                                                                    </option>
                                                                    @foreach ($specialities as $speciality)
                                                                        <option value="{{ $speciality }}"
                                                                            {{ old('diagnosed_disease') === $speciality ? 'selected' : '' }}>
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
                                                                $easeOfDiagnosisOptions = [
                                                                    'Easy',
                                                                    'Difficult',
                                                                    'Very Difficult',
                                                                ];
                                                            @endphp
                                                            <div class="form-fields">
                                                                <label class="title">Ease of Diagnosis :</label>
                                                                <select data-error="Ease of Diagnosis"
                                                                    name="ease_of_diagnosis" class="field select2-select">
                                                                    <option value="" selected disabled>Select
                                                                    </option>
                                                                    @foreach ($easeOfDiagnosisOptions as $option)
                                                                        <option value="{{ $option }}"
                                                                            {{ old('ease_of_diagnosis') === $option ? 'selected' : '' }}>
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
                                                                $certaintyOptions = [
                                                                    'Certainty',
                                                                    'Almost Certain',
                                                                    'Uncertain',
                                                                ];
                                                            @endphp
                                                            <div class="form-fields">
                                                                <label class="title">Certainty :</label>
                                                                <select data-error="Certainty" name="certainty"
                                                                    class="field select2-select">
                                                                    <option value="" selected disabled>Select
                                                                    </option>
                                                                    @foreach ($certaintyOptions as $option)
                                                                        <option value="{{ $option }}"
                                                                            {{ old('certainty') === $option ? 'selected' : '' }}>
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
                                                                $ethnicityOptions = [
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
                                                                <label class="title">Ethnicity :</label>
                                                                <select data-error="Ethnicity" name="ethnicity"
                                                                    class="field select2-select">
                                                                    <option value="" selected disabled>Select
                                                                    </option>
                                                                    @foreach ($ethnicityOptions as $option)
                                                                        <option value="{{ $option }}"
                                                                            {{ old('ethnicity') === $option ? 'selected' : '' }}>
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
                                                                $segmentOptions = [
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
                                                                <label class="title">Segment :</label>
                                                                <select data-error="Segment" name="segment"
                                                                    class="field select2-select">
                                                                    <option value="" selected disabled>Select
                                                                    </option>
                                                                    @foreach ($segmentOptions as $option)
                                                                        <option value="{{ $option }}"
                                                                            {{ old('segment') === $option ? 'selected' : '' }}>
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
                                                                <label class="title">Clinical Examination :</label>
                                                                <input type="text" data-error="Clinical Examination"
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
                                                                                <th class="text-end" scope="col">
                                                                                    Remove</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <template x-for="(author, index) in authors"
                                                                                :key="index">
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="form-fields">
                                                                                            <label
                                                                                                class="title">Name:</label>
                                                                                            <input type="hidden"
                                                                                                :name="'authors[' + index +
                                                                                                    '][name]'"
                                                                                                x-model="author.name">
                                                                                            <input type="text"
                                                                                                x-model="author.name"
                                                                                                class="field">
                                                                                        </div>
                                                                                        <div class="form-fields">
                                                                                            <label
                                                                                                class="title">DOI:</label>
                                                                                            <input type="hidden"
                                                                                                :name="'authors[' + index +
                                                                                                    '][doi]'"
                                                                                                x-model="author.doi">
                                                                                            <input type="text"
                                                                                                x-model="author.doi"
                                                                                                class="field">
                                                                                        </div>
                                                                                        <div class="form-fields">
                                                                                            <label class="title">Article
                                                                                                Link, if
                                                                                                any:</label>
                                                                                            <input type="hidden"
                                                                                                :name="'authors[' + index +
                                                                                                    '][article_link]'"
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
                                                                                            <i
                                                                                                class='bx bxs-trash-alt'></i>
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
                                                                <label class="title">Age :</label>
                                                                <input type="text" data-error="Age" name="patient_age"
                                                                    class="field">
                                                                @error('patient_age')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 mb-4">
                                                            <div class="form-fields">
                                                                <label class="title">Gender :</label>
                                                                <input type="text" data-error="Gender"
                                                                    name="patient_gender" class="field">
                                                                @error('patient_gender')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 mb-4">
                                                            <div class="form-fields">
                                                                <label class="title">Socio Economic :</label>
                                                                <input type="text" data-error="Socio Economic"
                                                                    name="patient_socio_economic" class="field">
                                                                @error('patient_socio_economic')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 mb-4">
                                                            <div class="form-fields">
                                                                <label class="title">Concomitant :</label>
                                                                <input type="text" data-error="Concomitant"
                                                                    name="patient_concomitant" class="field">
                                                                @error('patient_concomitant')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-fields">
                                                                <label class="title">Others :</label>
                                                                <input type="text" data-error="Others"
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
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    @if (request('type') === 'ask_ai_image_diagnosis')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('.caseForm').submit();
            });
        </script>
    @endif
    <script>
        function imageTypeManager() {
            return {
                types: [
                    @foreach ($imageTypes as $type)
                        {
                            id: {{ $type->id }},
                            name: "{{ $type->name }}"
                        },
                    @endforeach
                ],
                selectedType: '',
                selectedTypes: [],
                uploadedFiles: {},

                addTypeRow() {
                    const selected = this.types.find(type => type.id === parseInt(this.selectedType));
                    if (selected && !this.selectedTypes.some(type => type.id === selected.id)) {
                        this.selectedTypes.push(selected);
                        this.uploadedFiles[this.selectedTypes.length - 1] = [];
                        this.selectedType = '';
                    }
                },

                removeTypeRow(index) {
                    this.selectedTypes.splice(index, 1);
                    delete this.uploadedFiles[index];
                },

                previewFiles(event, index) {
                    const files = Array.from(event.target.files);
                    if (!this.uploadedFiles[index]) {
                        this.uploadedFiles[index] = [];
                    }
                    files.forEach(file => {
                        const reader = new FileReader();
                        reader.onload = () => {
                            this.uploadedFiles[index].push({
                                name: file.name,
                                description: '',
                                preview: reader.result
                            });
                        };
                        reader.readAsDataURL(file);
                    });
                },

                removeFile(typeIndex, fileIndex) {
                    this.uploadedFiles[typeIndex].splice(fileIndex, 1);
                }
            };
        }

        function mcqManager() {
            return {
                mcqs: [{
                    question: '',
                    answers: ['']
                }],
                addAnswer(index) {
                    this.mcqs[index].answers.push('');
                },
                removeAnswer(index, answerIndex) {
                    this.mcqs[index].answers.splice(answerIndex, 1);
                }
            }
        }
    </script>
@endpush
@push('css')
    <style>
        .multiple-upload__imgs .single-image .text-danger {
            font-size: 0.75rem;
            display: block;
            line-height: 1.35;
            margin-top: 0.5rem;
        }

        .multiple-upload__imgs .single-image {
            box-shadow: none;
            text-align: center;
        }
    </style>
@endpush
