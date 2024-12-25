@extends('frontend.layouts.main')
@section('content')
    <div class="case-details case-details-bg">
        <a href="http://127.0.0.1:8000/case/details" class="back-btn"><i class="bx bx-chevron-left"></i></a>
        <div class="container">
            <div class="row g-0">
                <div class="col-md-12">
                    <div class="case-details__image">
                        <img src="http://127.0.0.1:8000/frontend/assets/images/portfolio/5.jpg" alt="image"
                            class="imgFluid" loading="lazy">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="case-details__content">
                        <div class="title">Chronic obstructive pulmonary disease (COPD)</div>
                        <div class="user-profile">
                            <div class="user-profile___avatar">
                                <img src="https://ui-avatars.com/api/?name=jd&amp;size=80&amp;rounded=true&amp;background=random"
                                    alt="image" class="imgFluid" loading="lazy">
                            </div>
                            <div class="user-profile__info">
                                <div title="John Doe" class="name" data-tooltip="tooltip">John Doe <i
                                        class='bx bxs-check-circle'></i></div>
                                <div class="level">Senior Student</div>
                            </div>
                        </div>
                    </div>
                    <div class="case-details__details">
                        <div class="date">Aug 11, 2020</div>
                        <div x-data="{ expanded: false }" :class="{ 'd-block': expanded }" class="editor-content"
                            data-show-more-container>
                            <button x-on:click="expanded = !expanded"
                                x-text="expanded ? $el.getAttribute('data-less-content') : $el.getAttribute('data-more-content')"
                                type="button" data-more-content="..more" data-less-content="Show Less"
                                data-show-more-btn></button>

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

                            <h2>SUMMARY, INVESTIGATIONS &amp; MANAGEMENT</h2>
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

                            <p>Initial blood tests may include FBC, U/Es, CRP, LFTs, &amp; bone profile.</p>

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

                            <p>Initial blood tests may include FBC, U/Es, CRP, LFTs, &amp; bone profile.</p>

                            <p>A staging CT chest, and abdomen with IV contrast should be performed.</p>
                        </div>
                    </div>
                    <div class="case-details__comments">
                        <div class="heading">5 Comments</div>
                        <div class="comment-card mb-4 pb-2">
                            <div class="comment-card__avatar">
                                <img src="https://ui-avatars.com/api/?name=sk&amp;size=80&amp;rounded=true&amp;background=random"
                                    alt="image" class="imgFluid" loading="lazy">
                            </div>
                            <form x-data="{ comment: '' }" action="javascript:void(0)" class="comment-card__fields">
                                <input x-model="comment" type="text" placeholder="Add a comment...">
                                <div class="actions-wrapper">
                                    <button class="emoji-picker" type="button"><i class='bx bx-smile'></i></button>
                                    <button :disabled="!comment.trim()" class="comment-btn">Comment</button>
                                </div>
                            </form>
                        </div>
                        <div class="comment-card">
                            <div class="comment-card__avatar">
                                <img src="https://ui-avatars.com/api/?name=JW&amp;size=80&amp;rounded=true&amp;background=random"
                                    alt="image" class="imgFluid" loading="lazy">
                            </div>
                            <div class="comment-card__details">
                                <div class="wrapper">
                                    <div class="name">John Wilson</div>
                                    <div class="time">2 hours ago</div>
                                </div>
                                <div class="comment">
                                    It seems like the patient's symptoms could be indicative of something serious. The
                                    presence of wheeze and weight loss is concerning, especially with the findings on the
                                    chest X-ray.
                                </div>
                            </div>
                        </div>

                        <div class="comment-card">
                            <div class="comment-card__avatar">
                                <img src="https://ui-avatars.com/api/?name=AL&amp;size=80&amp;rounded=true&amp;background=random"
                                    alt="image" class="imgFluid" loading="lazy">
                            </div>
                            <div class="comment-card__details">
                                <div class="wrapper">
                                    <div class="name">Amanda Lee</div>
                                    <div class="time">1 hour ago</div>
                                </div>
                                <div x-data="{ expanded: false }">
                                    <div :class="{ 'd-block': expanded }" class="comment" data-show-more-container>
                                        Agreed. The right upper lobe mass and the nodules in the left lung are highly
                                        suggestive of malignancy. However, considering the patient's age and lack of
                                        significant smoking history, we should also keep a broader differential in mind.
                                        Infectious causes, such as tuberculosis, cannot be completely ruled out, especially
                                        if there’s a history of travel to endemic regions or exposure to someone with an
                                        active infection. At the same time, autoimmune conditions like sarcoidosis might
                                        present similarly.

                                        It’s also intriguing that there’s no significant fever or systemic signs of
                                        infection, which makes neoplastic causes more likely. We should definitely proceed
                                        with a high-resolution CT scan to better characterize these findings. Furthermore,
                                        it would be helpful to obtain a detailed history regarding occupational exposures,
                                        family history of malignancies, and any recent weight loss trends or appetite
                                        changes. While the imaging findings are worrisome, I think a tissue diagnosis is
                                        critical before jumping to conclusions. Bronchoscopy or CT-guided biopsy could
                                        provide clarity. Let’s also consider engaging the multidisciplinary team early to
                                        streamline the investigation process and involve oncology if needed.
                                    </div>
                                    <button class="position-static px-0 pt-2" x-on:click="expanded = !expanded"
                                        x-text="expanded ? $el.getAttribute('data-less-content') : $el.getAttribute('data-more-content')"
                                        style="background: #0E0E0E" type="button" data-more-content="Read more"
                                        data-less-content="Show Less" data-show-more-btn></button>
                                </div>
                            </div>
                        </div>

                        <div class="comment-card">
                            <div class="comment-card__avatar">
                                <img src="https://ui-avatars.com/api/?name=jd&amp;size=80&amp;rounded=true&amp;background=random"
                                    alt="image" class="imgFluid" loading="lazy">
                            </div>
                            <div class="comment-card__details">
                                <div class="wrapper">
                                    <div class="name">John Doe <div class="author">author</div>
                                    </div>
                                    <div class="time">45 minutes ago</div>
                                </div>
                                <div class="comment">
                                    The findings are quite alarming. The dense right hilum could indicate nodal involvement,
                                    and the multiple nodules in the left lung point towards metastases.
                                </div>
                            </div>
                        </div>

                        <div class="comment-card">
                            <div class="comment-card__avatar">
                                <img src="https://ui-avatars.com/api/?name=JW&amp;size=80&amp;rounded=true&amp;background=random"
                                    alt="image" class="imgFluid" loading="lazy">
                            </div>
                            <div class="comment-card__details">
                                <div class="wrapper">
                                    <div class="name">John Wilson</div>
                                    <div class="time">30 minutes ago</div>
                                </div>
                                <div class="comment">
                                    That’s a good point about the apical thickening, John. It might even be a sign of
                                    previous inflammation or scarring. I hope the staging CT provides a clearer picture of
                                    what we’re dealing with here.
                                </div>
                            </div>
                        </div>

                        <div class="comment-card">
                            <div class="comment-card__avatar">
                                <img src="https://ui-avatars.com/api/?name=AL&amp;size=80&amp;rounded=true&amp;background=random"
                                    alt="image" class="imgFluid" loading="lazy">
                            </div>
                            <div class="comment-card__details">
                                <div class="wrapper">
                                    <div class="name">Amanda Lee</div>
                                    <div class="time">10 minutes ago</div>
                                </div>
                                <div class="comment">
                                    Absolutely. It’s a complex case, but I’m hopeful the referral team can devise a
                                    comprehensive plan for diagnosis and management.
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gallery-category-wrapper">
                        <div class="gallery-category">
                            <div class="gallery-category__title">X-ray</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="gallery-category__item">
                                        <a href="{{ asset('frontend/assets/images/portfolio/1.png') }}"
                                            data-fancybox="gallery" class="cover-image">
                                            <img src='{{ asset('frontend/assets/images/portfolio/1.png') }}'
                                                alt='image' class='imgFluid' loading='lazy'>
                                        </a>
                                        <div class="cover-name">Frontal</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="gallery-category__item">
                                        <a href="{{ asset('frontend/assets/images/portfolio/2.png') }}"
                                            data-fancybox="gallery" class="cover-image">
                                            <img src='{{ asset('frontend/assets/images/portfolio/2.png') }}'
                                                alt='image' class='imgFluid' loading='lazy'>
                                        </a>
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
                                        <a href="{{ asset('frontend/assets/images/portfolio/3.png') }}"
                                            data-fancybox="gallery" class="cover-image">
                                            <img src='{{ asset('frontend/assets/images/portfolio/3.png') }}'
                                                alt='image' class='imgFluid' loading='lazy'>
                                        </a>
                                        <div class="cover-name">Frontal</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="gallery-category__item">
                                        <a href="{{ asset('frontend/assets/images/portfolio/4.png') }}"
                                            data-fancybox="gallery" class="cover-image">
                                            <img src='{{ asset('frontend/assets/images/portfolio/4.png') }}'
                                                alt='image' class='imgFluid' loading='lazy'>
                                        </a>
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
                                        <a href="{{ asset('frontend/assets/images/portfolio/5.jpg') }}"
                                            data-fancybox="gallery" class="cover-image">
                                            <img src='{{ asset('frontend/assets/images/portfolio/5.jpg') }}'
                                                alt='image' class='imgFluid' loading='lazy'>
                                        </a>
                                        <div class="cover-name">Frontal</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="gallery-category__item">
                                        <a href="{{ asset('frontend/assets/images/portfolio/5.png') }}"
                                            data-fancybox="gallery" class="cover-image">
                                            <img src='{{ asset('frontend/assets/images/portfolio/5.png') }}'
                                                alt='image' class='imgFluid' loading='lazy'>
                                        </a>
                                        <div class="cover-name">Frontal</div>
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

        .tooltip-inner {
            background-color: #fff;
            color: #000;
        }

        .tooltip-arrow::before {
            border-top-color: #fff !important;
        }
    </style>
@endpush
