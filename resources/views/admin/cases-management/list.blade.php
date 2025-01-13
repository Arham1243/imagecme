@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.cases.index') }}
            <form id="bulkActionForm" method="POST" action="{{ route('admin.bulk-actions', ['resource' => 'admin-cases']) }}">
                @csrf
                <div class="table-container universal-table">
                    <div class="custom-sec">
                        <div class="custom-sec__header">
                            <div class="section-content">
                                <h3 class="heading">{{ isset($title) ? $title : '' }}</h3>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-5">
                                <form class="custom-form ">
                                    <div class="form-fields d-flex gap-3">
                                        <select class="field" id="bulkActions" name="bulk_actions" required>
                                            <option value="" disabled selected>Bulk Actions</option>
                                            <option value="active">Make Publish</option>
                                            <option value="inactive">Make Unpublish</option>
                                        </select>
                                        <button type="submit" onclick="confirmBulkAction(event)"
                                            class="themeBtn">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div class="filters">
                                <ul class="filters-list" id="filters-list">

                                </ul>
                                <button data-bs-toggle="modal" badge="0" type="button" data-bs-target="#filterModal"
                                    class="themeBtn filter-btn p-2"><i class='bx bx-filter-alt'></i></button>
                            </div>
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th class="no-sort">
                                            <div class="selection select-all-container"><input type="checkbox"
                                                    id="select-all">
                                            </div>
                                        </th>
                                        <th>Image Type</th>
                                        <th>Title</th>
                                        <th>Author Name</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cases as $item)
                                        <tr>
                                            <td>
                                                <div class="selection item-select-container"><input type="checkbox"
                                                        class="bulk-item" name="bulk_select[]" value="{{ $item->id }}">
                                                </div>
                                            </td>
                                            <td>{{ getRelativeType($item->case_type) }}</td>
                                            <td>{{ $item->diagnosis_title }}</td>
                                            <td>
                                                @if ($item->user)
                                                    <a href="{{ route('admin.users.show', $item->user->id) }}"
                                                        class="link">{{ $item->user->full_name }}</a>
                                                @else
                                                    N/A
                                                @endif

                                            </td>
                                            <td>{{ formatDateTime($item->created_at) }}</td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill bg-{{ $item->status == 'active' ? 'success' : 'danger' }} ">
                                                    {{ $item->status === 'active' ? 'publish' : 'Unpublish' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a target="_blank"
                                                    href="{{ route('frontend.cases.comments.index', $item->slug) }}"
                                                    class="themeBtn"><i class='bx bxs-edit'></i>View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal" id="filterModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        Filter Cases:
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
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
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-fields">
                                    <input type="hidden" id="startDate">
                                    <input type="hidden" id="endDate">
                                    <label class="title">Select Date Range </label>
                                    <input type="text" class="field date-range-picker" readonly>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-fields">
                                    <label class="title">Diagnosed Disease </label>
                                    <select data-required data-error="Diagnosed Disease" name="diagnosed_disease"
                                        class="field select2-select">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($specialities as $speciality)
                                            <option value="{{ $speciality }}"
                                                @if (request()->get('diagnosed_disease') == $speciality) selected @endif>
                                                {{ $speciality }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-fields">
                                    <label class="title">Image Type <span class="text-danger">*</span>:</label>
                                    <select data-required data-error="Image Quality" name="image_type"
                                        class="field select2-select">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($imageTypes as $imageType)
                                            <option value="{{ $imageType->id }}"
                                                @if (request()->get('image_type') == $imageType->id) selected @endif>
                                                {{ $imageType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                @php $imageQualities = ['Low', 'Medium', 'High']; @endphp
                                <div class="form-fields">
                                    <label class="title">Image Quality <span class="text-danger">*</span>:</label>
                                    <select data-required data-error="Image Quality" name="image_quality"
                                        class="field select2-select">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($imageQualities as $imageQuality)
                                            <option value="{{ $imageQuality }}"
                                                @if (request()->get('image_quality') == $imageQuality) selected @endif>
                                                {{ $imageQuality }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                @php $easeOfDiagnosisOptions = ['Easy', 'Difficult', 'Very Difficult']; @endphp
                                <div class="form-fields">
                                    <label class="title">Ease of Diagnosis </label>
                                    <select data-required data-error="Ease of Diagnosis" name="ease_of_diagnosis"
                                        class="field select2-select">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($easeOfDiagnosisOptions as $option)
                                            <option value="{{ $option }}"
                                                @if (request()->get('ease_of_diagnosis') == $option) selected @endif>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                @php $certaintyOptions = ['Certainty', 'Almost Certain', 'Uncertain']; @endphp
                                <div class="form-fields">
                                    <label class="title">Certainty </label>
                                    <select data-required data-error="Certainty" name="certainty"
                                        class="field select2-select">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($certaintyOptions as $option)
                                            <option value="{{ $option }}"
                                                @if (request()->get('certainty') == $option) selected @endif>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                    <label class="title">Ethnicity </label>
                                    <select data-required data-error="Ethnicity" name="ethnicity"
                                        class="field select2-select">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($ethnicityOptions as $option)
                                            <option value="{{ $option }}"
                                                @if (request()->get('ethnicity') == $option) selected @endif>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
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
                                    <label class="title">Segment </label>
                                    <select data-required data-error="Segment" name="segment"
                                        class="field select2-select">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($segmentOptions as $option)
                                            <option value="{{ $option }}"
                                                @if (request()->get('segment') == $option) selected @endif>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-fields">
                                    <label class="title">Author speciality </label>
                                    <select data-required data-error="Diagnosed Disease" name="author_speciality"
                                        class="field select2-select">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($specialities as $speciality)
                                            <option value="{{ $speciality }}"
                                                @if (request()->get('author_speciality') == $speciality) selected @endif>
                                                {{ $speciality }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-fields">
                                    <label class="title">Country</label>
                                    <select class="field select2-select" name="author_country" id="country-select">
                                        <option value="" selected disabled>Select</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="themeBtn bg-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="themeBtn">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        function initializeDateRangePicker(selectedDateRange) {
            let startDate = moment().format('YYYY-MM-DD');
            let endDate = moment().format('YYYY-MM-DD');

            if (selectedDateRange) {
                startDate = moment(selectedDateRange.start).format('YYYY-MM-DD');
                endDate = moment(selectedDateRange.end).format('YYYY-MM-DD');
            }

            $('.date-range-picker').daterangepicker({
                startDate: startDate,
                endDate: endDate,
                locale: {
                    format: 'YYYY-MM-DD'
                },
                opens: 'left'
            }).on('apply.daterangepicker', function(ev, picker) {
                $('#startDate').val(picker.startDate.format('YYYY-MM-DD'));
                $('#endDate').val(picker.endDate.format('YYYY-MM-DD'));
                $('#startDate').attr('name', 'start_date');
                $('#endDate').attr('name', 'end_date');
            });
        }
        const selectedDateRange = {
            start: '{{ request()->get('start_date', \Carbon\Carbon::today()->format('Y-m-d')) }}',
            end: '{{ request()->get('end_date', \Carbon\Carbon::today()->format('Y-m-d')) }}'
        };


        initializeDateRangePicker(selectedDateRange);


        const selectedCountry = '{{ request()->get('author_country') }}';

        fetch('https://restcountries.com/v3.1/all')
            .then(response => response.json())
            .then(countries => {
                const select = document.getElementById('country-select');
                countries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.name.common;
                    option.textContent = country.name.common;
                    select.appendChild(option);

                    if (country.name.common === selectedCountry) {
                        option.selected = true;
                    }
                });
            })
            .catch(error => console.error('Error fetching countries:', error));


        function getFiltersFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            let filters = {};

            if (urlParams.has('diagnosed_disease')) {
                filters.diagnosed_disease = urlParams.get('diagnosed_disease');
            }

            if (urlParams.has('image_type')) {
                filters.image_type = urlParams.get('image_type');
            }

            if (urlParams.has('image_quality')) {
                filters.image_quality = urlParams.get('image_quality');
            }

            if (urlParams.has('ease_of_diagnosis')) {
                filters.ease_of_diagnosis = urlParams.get('ease_of_diagnosis');
            }

            if (urlParams.has('certainty')) {
                filters.certainty = urlParams.get('certainty');
            }

            if (urlParams.has('ethnicity')) {
                filters.ethnicity = urlParams.get('ethnicity');
            }

            if (urlParams.has('segment')) {
                filters.segment = urlParams.get('segment');
            }

            if (urlParams.has('start_date') && urlParams.has('end_date')) {
                filters.date_range = {
                    start: urlParams.get('start_date'),
                    end: urlParams.get('end_date')
                };
            }

            if (urlParams.has('author_speciality')) {
                filters.author_speciality = urlParams.get('author_speciality');
            }

            if (urlParams.has('author_country')) {
                filters.author_country = urlParams.get('author_country');
            }


            return filters;
        }


        function updateFilters(filters) {
            const filtersList = document.getElementById('filters-list');
            const filterCount = document.querySelector('.filter-btn');
            filtersList.innerHTML = '';

            Object.keys(filters).forEach(filterKey => {
                const filterValue = filters[filterKey];

                const filterItem = document.createElement('li');
                filterItem.classList.add('filters-list__chip');

                let displayValue = '';
                if (filterKey === 'date_range' && typeof filterValue === 'object') {
                    displayValue = `${filterValue.start} - ${filterValue.end}`;
                } else {
                    displayValue = filterValue;
                }

                filterItem.innerHTML = `
           <div class="name">${filterKey.replace(/_/g, ' ').replace(/([A-Z])/g, ' $1')}:</div>
            <div class="value">${displayValue}</div>
            <div class="remove" onclick="removeFilter('${filterKey}')"><i class='bx bx-x'></i></div>
        `;

                filtersList.appendChild(filterItem);
            });

            filterCount.setAttribute('badge', Object.keys(filters).length);
            if (Object.keys(filters).length) {
                const clearFiltersItem = document.createElement('li');
                clearFiltersItem.classList.add('filters-list__chip');
                clearFiltersItem.innerHTML = `
        <div class="name">Clear Filters:</div>
        <a href="{{ route('admin.cases.index') }}" class="remove"><i class='bx bx-x'></i></a>
    `;
                filtersList.appendChild(clearFiltersItem);
            }

        }

        function camelToSnakeCase(str) {
            return str.replace(/[A-Z]/g, letter => `_${letter.toLowerCase()}`);
        }

        function removeFilter(key) {
            const snakeKey = camelToSnakeCase(key);

            delete activeFilters[key];

            const urlParams = new URLSearchParams(window.location.search);

            if (snakeKey === 'date_range') {
                urlParams.delete('start_date');
                urlParams.delete('end_date');
            } else if (urlParams.has(snakeKey)) {
                urlParams.delete(snakeKey);
            }

            const newUrl = `${window.location.pathname}?${urlParams.toString()}`;

            window.history.pushState({}, '', newUrl);

            location.reload();
        }

        const activeFilters = getFiltersFromURL();

        updateFilters(activeFilters);
    </script>
@endpush
