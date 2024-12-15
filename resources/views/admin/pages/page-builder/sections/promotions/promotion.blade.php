@php
    $sectionContent = $pageSection ? json_decode($pageSection->content) : null;
    $customTourIdsCheck = $sectionContent ? isset($sectionContent->custom_tour_ids) : [];
    $customTourIds = $customTourIdsCheck ? $sectionContent->custom_tour_ids : [];
@endphp
<div class="row" x-data="{ no_of_items: '{{ $sectionContent->no_of_items ?? '1' }}' }">
    <div class="col-md-6 mb-3">
        <div class="form-fields">
            <label class="title">Title <span class="text-danger">*</span> :</label>
            <input type="text" name="content[title]" class="field" placeholder="" data-error="Title"
                value="{{ $sectionContent->title ?? '' }}" maxlength="40">
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-fields">
            <div class="title d-flex align-items-center gap-2">
                <div>Title Text Color <span class="text-danger">*</span>:</div>
                <a class="p-0 nav-link" href="//html-color-codes.info" target="_blank">Get
                    Color
                    Codes</a>
            </div>
            <div class="field color-picker" data-color-picker-container>
                <label for="color-picker" data-color-picker></label>
                <input id="color-picker" type="text" name="content[title_color]" data-color-picker-input
                    value="{{ $sectionContent->title_color ?? '#000000' }}" data-error="background Color"
                    inputmode="text">
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="form-fields">
            <label class="title">No. of items <span class="text-danger">*</span> :</label>
            <input type="number" min="1" x-model="no_of_items" name="content[no_of_items]" class="field"
                placeholder="" data-error="Number of Items" oninput="this.value = this.value <= 0 ? 1 : this.value">
        </div>
    </div>
    <div class="col-12">
        <hr />
    </div>
    <div class="col-lg-12 mb-3 pt-3">
        <div class="form-fields">
            <label class="title title--sm mb-3">Box Style:</label>
            <div x-data="{ box_type: '{{ isset($sectionContent->box_type) ? $sectionContent->box_type : 'nomral' }}' }">
                <div class="d-flex align-items-center gap-5 px-4 mb-3">
                    <div class="form-check p-0">
                        <input class="form-check-input" type="radio" name="content[box_type]" id="nomral"
                            x-model="box_type" name="content[box_type]" value="nomral" checked />
                        <label class="form-check-label" for="nomral">Normal</label>
                    </div>
                    <div class="form-check p-0">
                        <input class="form-check-input" type="radio" name="content[box_type]" id="slider_carousel"
                            x-model="box_type" name="content[box_type]" value="slider_carousel" />
                        <label class="form-check-label" for="slider_carousel">Slider Carousel</label>
                    </div>
                    <div class="form-check p-0">
                        <input class="form-check-input" type="radio" name="content[box_type]"
                            id="normal_with_background_color" x-model="box_type" name="content[box_type]"
                            value="normal_with_background_color" />
                        <label class="form-check-label" for="normal_with_background_color">Normal (with
                            background)</label>
                    </div>
                    <div class="form-check p-0">
                        <input class="form-check-input" type="radio" name="content[box_type]"
                            id="slider_carousel_with_background_color" x-model="box_type" name="content[box_type]"
                            value="slider_carousel_with_background_color" />
                        <label class="form-check-label" for="slider_carousel_with_background_color">Slider Carousel
                            (with background)</label>
                    </div>
                </div>
                <div x-show="box_type === 'normal_with_background_color'">
                    <div class="row pt-3 pb-2">
                        <div class="col-md-12">
                            <div class="form-fields">
                                <div class="title d-flex align-items-center gap-2">
                                    <div>
                                        Select Background Color <span class="text-danger">*</span>:
                                    </div>
                                    <a class="p-0 nav-link" href="//html-color-codes.info" target="_blank">Get Color
                                        Codes</a>
                                </div>

                                <div class="field color-picker" data-color-picker-container>
                                    <label for="color-picker" data-color-picker></label>
                                    <input id="color-picker" type="text" name="content[normal_background_color]"
                                        data-color-picker-input
                                        value="{{ $sectionContent->normal_background_color ?? '' }}"
                                        placeholder="#000000" data-error="background Color" inputmode="text" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div x-show="box_type === 'slider_carousel_with_background_color'">
                    <div class="row pt-3 pb-2">
                        <div class="col-md-12">
                            <div class="form-fields">
                                <div class="title d-flex align-items-center gap-2">
                                    <div>
                                        Select Background Color <span class="text-danger">*</span>:
                                    </div>
                                    <a class="p-0 nav-link" href="//html-color-codes.info" target="_blank">Get Color
                                        Codes</a>
                                </div>

                                <div class="field color-picker" data-color-picker-container>
                                    <label for="color-picker" data-color-picker></label>
                                    <input id="color-picker" type="text"
                                        name="content[slider_carousel_background_color]" data-color-picker-input
                                        value="{{ $sectionContent->slider_carousel_background_color ?? '' }}"
                                        placeholder="#000000" data-error="background Color" inputmode="text" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <hr />
    </div>
    <div class="col-lg-12 mb-3 pt-3">
        <div class="form-fields">
            <label class="title title--sm mb-3">Filters:</label>
            <div x-data="{ filter_type: '{{ isset($sectionContent->filter_type) ? $sectionContent->filter_type : 'filters' }}' }">
                <div class="d-flex align-items-center gap-5 px-4 mb-3">
                    <div class="form-check p-0">
                        <input class="form-check-input" type="radio" name="content[filter_type]" id="filters"
                            x-model="filter_type" name="content[filter_type]" value="filters" checked />
                        <label class="form-check-label" for="filters">Filters</label>
                    </div>
                    <div class="form-check p-0">
                        <input class="form-check-input" type="radio" name="content[filter_type]" id="custom"
                            x-model="filter_type" name="content[filter_type]" value="custom" />
                        <label class="form-check-label" for="custom">Custom</label>
                    </div>
                </div>
                <div x-show="filter_type === 'filters'">
                    <div class="row pt-1 pb-2">
                        <div class="col-md-6">
                            <div class="form-fields">
                                <div class="title">Filter by Category <span class="text-danger">*</span> :</div>
                                <select multiple data-max-items="1" name="content[filter_category_id]"
                                    class="field select2-select" placeholder="Select Category" data-error="Category">
                                    @foreach ($tourCategories as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $sectionContent && isset($sectionContent->filter_category_id) && $item->id == $sectionContent->filter_category_id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                            ({{ $item->tours_count > 0 ? $item->tours_count . ' ' . ($item->tours_count === 1 ? 'tour' : 'tours') . ' available' : 'No tours available' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-fields">
                                <div class="title">Filter by Location <span class="text-danger">*</span> :</div>
                                <select multiple data-max-items="1" name="content[filter_city_id]"
                                    class="field select2-select" placeholder="Select Location" data-error="Location">
                                    @foreach ($cities as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $sectionContent && isset($sectionContent->filter_city_id) && $item->id == $sectionContent->filter_city_id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                            ({{ $item->tours_count > 0 ? $item->tours_count . ' ' . ($item->tours_count === 1 ? 'tour' : 'tours') . ' available' : 'No tours available' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div x-show="filter_type === 'custom'">
                    <div class="row pt-1 pb-2">
                        <div class="col-md-12">
                            <div class="form-fields">
                                <label class="title">Select <span x-text="no_of_items" class="px-1"> </span> Tours
                                    <span class="text-danger">*</span> :</label>
                                <select name="content[custom_tour_ids][]" multiple class="field select2-select"
                                    placeholder="Select Tours" data-error="Tours">
                                    @foreach ($tours as $item)
                                        <option value="{{ $item->id }}"
                                            {{ in_array($item->id, $customTourIds) ? 'selected' : '' }}>
                                            {{ $item->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <hr />
    </div>
    <div class="col-lg-12 mb-2 pt-3">
        <div class="form-fields">
            <label class="title title--sm mb-3">Order By:</label>
            <div x-data="{ order_by: '{{ isset($sectionContent->order_by) ? $sectionContent->order_by : 'latest' }}' }">
                <div class="d-flex align-items-center gap-5 px-4 mb-3">
                    <div class="form-check p-0">
                        <input class="form-check-input" type="radio" name="content[order_by]" id="order_by_latest"
                            x-model="order_by" value="latest" checked />
                        <label class="form-check-label" for="order_by_latest">Sort by Latest</label>
                    </div>
                    <div class="form-check p-0">
                        <input class="form-check-input" type="radio" name="content[order_by]" id="order_by_title"
                            x-model="order_by" value="title" />
                        <label class="form-check-label" for="order_by_title">Sort by Title (A to Z)</label>
                    </div>
                    <div class="form-check p-0">
                        <input class="form-check-input" type="radio" name="content[order_by]"
                            id="order_by_price_low_to_high" x-model="order_by" value="price_low_to_high" />
                        <label class="form-check-label" for="order_by_price_low_to_high">Sort by Price (Low to
                            High)</label>
                    </div>
                    <div class="form-check p-0">
                        <input class="form-check-input" type="radio" name="content[order_by]"
                            id="order_by_price_high_to_low" x-model="order_by" value="price_high_to_low" />
                        <label class="form-check-label" for="order_by_price_high_to_low">Sort by Price (High to
                            Low)</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <hr />
    </div>
    <div class="col-12  mb-4 pt-3">
        <div class="form-fields">
            <div class="title title--sm mb-0">Featured Image:</div>
        </div>
        <div class="d-flex align-items-center gap-5 px-4 mb-1">
            <div class="form-check p-0">
                <input class="form-check-input" type="radio" name="content[featured_image_type]"
                    id="image-type-featured" name="content[featured_image_type]" value="featured"
                    {{ $sectionContent ? ($sectionContent->featured_image_type === 'featured' ? 'checked' : '') : '' }} />
                <label class="form-check-label" for="image-type-featured">Show tour Featured Image</label>
            </div>
            <div class="form-check p-0">
                <input class="form-check-input" type="radio" name="content[featured_image_type]"
                    id="image-type-promotional" name="content[featured_image_type]"
                    {{ $sectionContent ? ($sectionContent->featured_image_type === 'promotional' ? 'checked' : '') : '' }}
                    value="promotional" />
                <label class="form-check-label" for="image-type-promotional">Show tour promotional Image</label>
            </div>
        </div>
    </div>
</div>
