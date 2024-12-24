@extends('frontend.layouts.main')
@section('content')
    <div class='gallery gallery--bg'>
        <a href="{{ route('frontend.index') }}" class="back-btn"><i class='bx bx-chevron-left'></i></a>
        <div class='container-fluid p-0'>
            <div x-data="{
                activeImage: '{{ asset('frontend/assets/images/portfolio/1.png') }}'
            }">
                <div class="gallery-box">
                    <div class='row g-0'>
                        <div class='col-md-3'>
                            <div class="gallery-sidebar">
                                <div class="gallery-sidebar__header">
                                    <div class="gallery-option active">
                                        <i class="bx bx-image"></i>
                                        <span>images</span>
                                    </div>
                                    <div class="gallery-option ">
                                        <i class='bx bx-info-circle'></i>
                                        <span>Story Questions</span>
                                    </div>
                                    <div class="gallery-option ">
                                        <i class='bx bx-file'></i>
                                        <span>Fundings</span>
                                    </div>
                                </div>
                                <div class="gallery-sidebar__body">
                                    <div class="gallery-category">
                                        <div class="gallery-category__title">X-ray</div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="gallery-category__item">
                                                    <div class="cover-image"
                                                        :class="{ 'active': activeImage === '{{ asset('frontend/assets/images/portfolio/1.png') }}' }"
                                                        @click="activeImage = '{{ asset('frontend/assets/images/portfolio/1.png') }}'">
                                                        <img src='{{ asset('frontend/assets/images/portfolio/1.png') }}'
                                                            alt='image' class='imgFluid' loading='lazy'>
                                                    </div>
                                                    <div class="cover-name">Frontal</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="gallery-category__item">
                                                    <div class="cover-image"
                                                        :class="{ 'active': activeImage === '{{ asset('frontend/assets/images/portfolio/2.png') }}' }"
                                                        @click="activeImage = '{{ asset('frontend/assets/images/portfolio/2.png') }}'">
                                                        <img src='{{ asset('frontend/assets/images/portfolio/2.png') }}'
                                                            alt='image' class='imgFluid' loading='lazy'>
                                                    </div>
                                                    <div class="cover-name">Frontal</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gallery-category">
                                        <div class="gallery-category__title">MRI</div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="gallery-category__item">
                                                    <div class="cover-image"
                                                        :class="{ 'active': activeImage === '{{ asset('frontend/assets/images/portfolio/3.png') }}' }"
                                                        @click="activeImage = '{{ asset('frontend/assets/images/portfolio/3.png') }}'">
                                                        <img src='{{ asset('frontend/assets/images/portfolio/3.png') }}'
                                                            alt='image' class='imgFluid' loading='lazy'>
                                                    </div>
                                                    <div class="cover-name">Frontal</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="gallery-category__item">
                                                    <div class="cover-image"
                                                        :class="{ 'active': activeImage === '{{ asset('frontend/assets/images/portfolio/4.png') }}' }"
                                                        @click="activeImage = '{{ asset('frontend/assets/images/portfolio/4.png') }}'">
                                                        <img src='{{ asset('frontend/assets/images/portfolio/4.png') }}'
                                                            alt='image' class='imgFluid' loading='lazy'>
                                                    </div>
                                                    <div class="cover-name">Frontal</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gallery-category">
                                        <div class="gallery-category__title">Ultrasound</div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="gallery-category__item">
                                                    <div class="cover-image"
                                                        :class="{ 'active': activeImage === '{{ asset('frontend/assets/images/portfolio/4.png') }}' }"
                                                        @click="activeImage = '{{ asset('frontend/assets/images/portfolio/4.png') }}'">
                                                        <img src='{{ asset('frontend/assets/images/portfolio/4.png') }}'
                                                            alt='image' class='imgFluid' loading='lazy'>
                                                    </div>
                                                    <div class="cover-name">Frontal</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="gallery-category__item">
                                                    <div class="cover-image"
                                                        :class="{ 'active': activeImage === '{{ asset('frontend/assets/images/portfolio/5.png') }}' }"
                                                        @click="activeImage = '{{ asset('frontend/assets/images/portfolio/5.png') }}'">
                                                        <img src='{{ asset('frontend/assets/images/portfolio/5.png') }}'
                                                            alt='image' class='imgFluid' loading='lazy'>
                                                    </div>
                                                    <div class="cover-name">Frontal</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-9'>
                            <div class="gallery-content">
                                <div class="row g-0 align-items-center">
                                    <div class="col-md-5">
                                        <div class="gallery-content-info">
                                            <a href="javascript:void(0)" class="view-btn">View Discussion</a>
                                            <div class="editor-content">

                                                <h1>COPD</h1>

                                                <p>A 60 year old female presents to her GP with fatigue, weight loss and
                                                    wheeze.
                                                    There is no significant past medical history. She is a non-smoker. On
                                                    examination, she has saturations of 99% in air and is afebrile. There is
                                                    wheeze
                                                    in the right upper zone. A chest X-ray is requested to assess for
                                                    malignancy
                                                    or
                                                    COPD.</p>

                                                <p><strong>Patient ID:</strong> Anonymous <strong>Projection:</strong> PA
                                                </p>
                                                <p><strong>Penetration:</strong> Adequate – vertebral bodies just visible
                                                    behind
                                                    heart</p>
                                                <p><strong>Inspiration:</strong> Adequate – 7 anterior ribs visible</p>
                                                <p><strong>Rotation:</strong> The patient is slightly rotated to the right
                                                </p>

                                                <h2>AIRWAY</h2>
                                                <p>The trachea is central after factoring in patient rotation.</p>

                                                <h2>BREATHING</h2>
                                                <p>There is a right upper zone mass projected over the anterior aspects of
                                                    the
                                                    right
                                                    1st and 2nd ribs. There are multiple small pulmonary nodules visible
                                                    within
                                                    the
                                                    left hemithorax.</p>
                                                <p>The lungs are not hyperinflated.</p>
                                                <p>There is pleural thickening at the right lung apex.</p>
                                                <p>Normal pulmonary vascularity.</p>

                                                <h2>CIRCULATION</h2>
                                                <p>The heart is not enlarged. The heart borders are clear. The aorta appears
                                                    normal.
                                                </p>
                                                <p>The mediastinum is central, and not widened. The right upper zone mass
                                                    appears
                                                    contiguous with the superior mediastinum.</p>
                                                <p>The right hilum is abnormally dense. It also appears higher than the
                                                    left.
                                                    Normal
                                                    size, shape and position of the left hilum.</p>

                                                <h2>DIAPHRAGM + DELICATES</h2>
                                                <p>Normal appearance and position of the hemidiaphragms.</p>
                                                <p>No pneumoperitoneum.</p>
                                                <p>The imaged skeleton is intact with no fractures or destructive bony
                                                    lesions
                                                    visible.</p>
                                                <p>The visible soft tissues are unremarkable.</p>

                                                <h2>EXTRAS + REVIEW AREAS</h2>
                                                <p>No vascular lines, tubes, or surgical clips.</p>
                                                <ul>
                                                    <li><strong>Lung Apices:</strong> Right apical pleural thickening</li>
                                                    <li><strong>Hila:</strong> Dense right hilum, normal left hilum</li>
                                                    <li><strong>Behind Heart:</strong> Normal</li>
                                                    <li><strong>Costophrenic Angles:</strong> Normal</li>
                                                    <li><strong>Below the Diaphragm:</strong> Normal</li>
                                                </ul>

                                                <h2>SUMMARY, INVESTIGATIONS & MANAGEMENT</h2>
                                                <p>This X-ray demonstrates a large, rounded right upper lobe lung lesion
                                                    associated
                                                    with multiple smaller nodules. This is highly suspicious of a right
                                                    upper
                                                    lobe
                                                    primary lung cancer with lung metastases. The dense right hilum is
                                                    suspicious
                                                    for hilar nodal disease. The significance of the right apical pleural
                                                    thickening
                                                    is not clear.</p>

                                                <p>Initial blood tests may include FBC, U/Es, CRP, LFTs, & bone profile.</p>

                                                <p>The patient should be referred to respiratory/oncology services for
                                                    further
                                                    management, which may include biopsy and MDT discussion. Treatment,
                                                    which
                                                    may
                                                    include surgery, radiotherapy, chemotherapy, or palliative treatment,
                                                    will
                                                    depend on the outcome of the MDT discussion, investigations, and the
                                                    patient’s
                                                    wishes.</p>

                                                <p>Initial blood tests may include FBC, U/Es, CRP, LFTs, & bone profile.</p>

                                                <p>A staging CT chest, and abdomen with IV contrast should be performed.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="gallery-selected-image">
                                            <img :src="activeImage" alt="selected image" class="imgFluid"
                                                loading="lazy">
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

@push('css')
    <script defer src="{{ asset('admin/assets/js/alpine.min.js') }}"></script>
    <style>
        header,
        footer {
            display: none;
        }
    </style>
@endpush
