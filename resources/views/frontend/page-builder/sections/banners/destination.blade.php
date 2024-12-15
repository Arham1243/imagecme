@if (isset($content->is_destination_enabled))
    @php
        $isBackgroundColor = isset($content->destination_background_type)
            ? $content->destination_background_type === 'background_color'
            : null;
        $isBackgroundImage = isset($content->destination_background_type)
            ? $content->destination_background_type === 'background_image'
            : null;
    @endphp
    <div class=destinations
        style="background-color: {{ $isBackgroundColor ? $content->destination_background_color : 'transparent' }}">
        @if ($isBackgroundImage)
            <img data-src="{{ asset($content->destination_background_image ?? 'admin/assets/images/placeholder.png') }}"
                alt="{{ $content->destination_background_alt_text ?? 'destination image' }}"
                class="imgFluid lazy destinations__bg">
        @endif
        <div class=container>
            <div class="row justify-content-between">
                <div class=col-md-4>
                    <div class=destinations-content>
                        <h2 class="heading">
                            <div class=dst1
                                style="color: {{ isset($content->destination_title_text_color) ? $content->destination_title_text_color : '' }};">
                                {{ $content->destination_title ?? '' }}
                            </div>
                            @if (isset($content->destination_subtitle->title[0]))
                                <div class="dst2"
                                    style="color: {{ isset($content->destination_subtitle->text_color[0]) ? $content->destination_subtitle->text_color[0] : '' }};">
                                    {{ $content->destination_subtitle->title[0] }}
                                </div>
                            @endif

                            @if (isset($content->destination_subtitle->title[1]))
                                <div class="dst2 mt-0"
                                    style="color: {{ isset($content->destination_subtitle->text_color[1]) ? $content->destination_subtitle->text_color[1] : '' }};">
                                    {{ $content->destination_subtitle->title[1] }}
                                    <div class="darrow">
                                        <img data-src="{{ asset('assets/images/darrow.webp') }}" alt="image"
                                            class="imgFluid lazy" width="100" height="20.36">
                                    </div>
                                </div>
                            @endif
                        </h2>
                    </div>
                </div>
                <div class=col-md-8>
                    @php
                        $styleType = $content->destination_style_type;
                        $contentType = null;
                        $resourceIds = [];
                        $columnMappings = [
                            'city' => [
                                'name' => 'name',
                                'image' => 'featured_image',
                                'alt_text' => 'featured_image_alt_text',
                                'slug' => 'slug',
                                'route' => 'city.details',
                            ],
                            'country' => [
                                'name' => 'name',
                                'image' => 'featured_image',
                                'alt_text' => 'featured_image_alt_text',
                                'slug' => 'slug',
                                'route' => 'country.details',
                            ],
                            'tour' => [
                                'name' => 'title',
                                'image' => 'featured_image',
                                'alt_text' => 'featured_image_alt_text',
                                'slug' => 'slug',
                                'route' => 'tours.details',
                            ],
                        ];

                        if ($styleType === 'normal') {
                            $contentType = $content->destination_content_type_normal;
                            $resourceIds = match ($contentType) {
                                'city' => $content->destination_city_ids_normal ?? [],
                                'country' => $content->destination_country_ids_normal ?? [],
                                'tour' => $content->destination_tour_ids_normal ?? [],
                                default => [],
                            };
                        } elseif ($styleType === 'carousel') {
                            $contentType = $content->destination_content_type_carousel ?? [];
                            $resourceIds = match ($contentType) {
                                'city' => $content->destination_city_ids_carousel ?? [],
                                'country' => $content->destination_country_ids_carousel ?? [],
                                'tour' => $content->destination_tour_ids_carousel ?? [],
                                default => [],
                            };
                        }

                        $resourcesToShow = collect([]);
                        if ($contentType && !empty($resourceIds)) {
                            $resourcesToShow = match ($contentType) {
                                'city' => \App\Models\City::withCount('tours')
                                    ->whereIn('id', $resourceIds)
                                    ->where('status', 'publish')
                                    ->get(),
                                'country' => \App\Models\Country::whereIn('id', $resourceIds)
                                    ->where('status', 'publish')
                                    ->get(),
                                'tour' => \App\Models\Tour::whereIn('id', $resourceIds)
                                    ->where('status', 'publish')
                                    ->get(),
                                default => collect([]),
                            };
                        }
                        $columns = $columnMappings[$contentType] ?? [];

                    @endphp

                    <div
                        class="row g-0 {{ isset($content->destination_style_type) && $content->destination_style_type === 'carousel' ? 'destinations-slider' : '' }}  {{ $content->destination_style_type === 'normal' && $content->destination_style_type === 'normal' ? 'row-cols-1 row-cols-md-3 row-cols-lg-3 row-cols-xl-5' : '' }}">
                        @foreach ($resourcesToShow as $resource)
                            @php
                                $resourceType = '';
                                if ($resource instanceof \App\Models\City) {
                                    $resourceType = 'city';
                                } elseif ($resource instanceof \App\Models\Country) {
                                    $resourceType = 'country';
                                } elseif ($resource instanceof \App\Models\Tour) {
                                    $resourceType = 'tour';
                                }
                            @endphp
                            <div class=col>
                                <a href="{{ route($columns['route'], $resource->{$columns['slug']}) }}" class=dst-card>
                                    <div class=destinations-img>
                                        <img data-src={{ asset($resource->{$columns['image']} ?? 'admin/assets/images/placeholder.png') }}
                                            alt="{{ $resource->{$columns['alt_text']} }}" class="imgFluid lazy">
                                    </div>
                                    <div class=dst-location>
                                        {{ $resource->{$columns['name']} }}
                                    </div>
                                    @if ($resourceType !== 'tour')
                                        <div class="dst-num">
                                            @if ($resourceType === 'city' && $resource->tours_count > 0)
                                                {{ $resource->tours_count }}
                                            @elseif ($resourceType === 'country' && $resource->toursCount() > 0)
                                                {{ $resource->toursCount() }}
                                            @endif
                                        </div>
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
