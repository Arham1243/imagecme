<?php

namespace App\Http\Controllers\Admin\Tour;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Tour;
use App\Models\TourAttribute;
use App\Models\TourCategory;
use App\Models\TourDetail;
use App\Models\TourExtraPrice;
use App\Models\TourFaq;
use App\Models\TourItinerary;
use App\Models\TourOpenHour;
use App\Models\TourPriceDiscount;
use App\Models\TourPricing;
use App\Models\User;
use App\Traits\Sluggable;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

class TourController extends Controller
{
    use Sluggable;
    use UploadImageTrait;

    public function index()
    {
        $tours = Tour::with(['category'])->latest()->get();

        return view('admin.tours.tours-management.list', compact('tours'))->with('title', 'All Tours');
    }

    public function create()
    {

        $categories = TourCategory::where('status', 'publish')->latest()->get();
        // $tours = Tour::where('status', 'publish')->get();
        $tours = Tour::all();
        $users = User::where('is_active', 1)->get();
        $attributes = TourAttribute::where('status', 'active')
            ->latest()->get();

        $cities = City::where('status', 'publish')->get();
        $data = compact(
            'categories',
            'cities',
            'attributes',
            'tours',
            'users'
        );

        return view('admin.tours.tours-management.add', $data)->with('title', 'Add New Tour');
    }

    public function store(Request $request)
    {
        $general = $request->input('tour.general', []);
        $statusTab = $request->input('tour.status', []);
        $availabilityData = $request->input('tour.availability', []);
        $pricing = $request->input('tour.pricing', []);
        $location = $request->input('tour.location', []);
        $itineraryExperience = $request->input('itinerary_experience', []);

        $slugText = ! empty($general['slug']) ? $general['slug'] : $general['title'];
        $slug = $this->createSlug($slugText, 'tours');

        $inclusions = ! empty($general['inclusions']) && ! in_array(null, $general['inclusions'], true)
            ? json_encode(array_filter($general['inclusions'], fn ($value) => $value !== null))
            : null;

        $exclusions = ! empty($general['exclusions']) && ! in_array(null, $general['exclusions'], true)
            ? json_encode(array_filter($general['exclusions'], fn ($value) => $value !== null))
            : null;

        $features = ! empty($general['features']) && ! in_array(null, $general['features'], true)
            ? json_encode(array_filter($general['features'], fn ($value) => $value !== null))
            : null;

        $relatedTours = ! empty($request->input('related_tour_ids')) ? json_encode($request->input('related_tour_ids')) : null;

        $tour = Tour::create([
            'title' => $general['title'] ?? null,
            'slug' => $slug ?? null,
            'content' => $general['content'] ?? null,
            'category_id' => $general['category_id'] ?? null,
            'badge_icon_class' => $general['badge_icon_class'] ?? null,
            'badge_name' => $general['badge_name'] ?? null,
            'banner_image_alt_text' => $request->input('banner_image_alt_text'),
            'featured_image_alt_text' => $request->input('featured_image_alt_text'),
            'promotional_image_alt_text' => $request->input('promotional_image_alt_text'),
            'banner_type' => $general['banner_type'] ?? null,
            'video_link' => $general['video_link'] ?? null,
            'inclusions' => $inclusions,
            'exclusions' => $exclusions,
            'features' => $features,
            'status' => $statusTab['status'],
            'author_id' => $statusTab['author_id'],
            'is_featured' => $statusTab['is_featured'] ?? 0,
            'featured_state' => $statusTab['featured_state'] ?? null,
            'ical_import_url' => $statusTab['ical_import_url'] ?? null,
            'ical_export_url' => $statusTab['ical_export_url'] ?? null,
            'related_tour_ids' => $relatedTours,
            'is_fixed_date' => $availabilityData['is_fixed_date'] ?? 0,
            'is_open_hours' => $availabilityData['is_open_hours'] ?? 0,
            'is_fixed_date' => $availabilityData['is_fixed_date'] ?? 0,
            'start_date' => $availabilityData['start_date'],
            'end_date' => $availabilityData['end_date'] ?? null,
            'last_booking_date' => $availabilityData['last_booking_date'],
            'regular_price' => $pricing['regular_price'] ?? null,
            'sale_price' => $pricing['sale_price'] ?? null,
            'is_person_type_enabled' => $pricing['is_person_type_enabled'] ?? 0,
            'price_type' => isset($pricing['is_person_type_enabled']) && $pricing['is_person_type_enabled'] == 1 ? $pricing['price_type'] : null,
            'is_extra_price_enabled' => $pricing['is_extra_price_enabled'] ?? 0,
            'enabled_custom_service_fee' => $pricing['enabled_custom_service_fee'] ?? 0,
            'service_fee_price' => $pricing['service_fee_price'] ?? null,
            'show_phone' => $pricing['show_phone'] ?? 0,
            'phone_country_code' => $pricing['phone_country_code'] ?? null,
            'phone_dial_code' => $pricing['phone_dial_code'] ?? null,
            'phone_number' => $pricing['phone_number'] ?? null,
            'address' => $location['normal_location']['address'] ?? null,
            'location_type' => $location['location_type'] ?? null,
            'itinerary_experience' => json_encode($itineraryExperience) ?? null,
        ]);

        // Handle FAQs
        if (isset($general['faq']['question']) && is_array($general['faq']['question'])) {
            foreach ($general['faq']['question'] as $index => $question) {
                $answer = $general['faq']['answer'][$index] ?? null;

                if (! empty($question) && ! empty($answer)) {
                    TourFaq::create([
                        'question' => $question,
                        'answer' => $answer,
                        'tour_id' => $tour->id,
                    ]);
                }
            }
        }

        // Handle attributes and items
        if (! empty($statusTab['attributes'])) {
            foreach ($statusTab['attributes'] as $attributeId => $itemIds) {
                foreach ($itemIds as $itemId) {
                    $tour->attributes()->attach($attributeId, ['tour_attribute_item_id' => $itemId]);
                }
            }
        }

        // Handle details
        if (! empty($general['details'])) {
            foreach ($general['details'] as $detail) {
                if ($detail['name'] !== null && ! empty($detail['items'])) {
                    TourDetail::create([
                        'tour_id' => $tour->id,
                        'name' => $detail['name'],
                        'items' => json_encode($detail['items']),
                        'urls' => json_encode($detail['urls']),
                    ]);
                }
            }
        }

        // Store Open Hours if is_open_hours is true
        if (isset($availabilityData['is_open_hours']) && $availabilityData['is_open_hours'] == 1) {
            foreach ($availabilityData['open_hours'] as $hours) {
                TourOpenHour::create([
                    'tour_id' => $tour->id,
                    'day' => $hours['day'] ?? null,
                    'open_time' => $hours['open_time'] ?? null,
                    'close_time' => $hours['close_time'] ?? null,
                    'enabled' => $hours['enabled'] ?? 0,
                ]);
            }
        }

        // Check if discounts exist and save them
        if (! empty($pricing['discount'])) {

            $discountCount = count($pricing['discount']['people_from']);
            for ($i = 0; $i < $discountCount; $i++) {
                $peopleFrom = $pricing['discount']['people_from'][$i] ?? null;
                $peopleTo = $pricing['discount']['people_to'][$i] ?? null;
                $amount = $pricing['discount']['discount'][$i] ?? null;
                $type = $pricing['discount']['type'][$i] ?? null;

                TourPriceDiscount::create([
                    'tour_id' => $tour->id,
                    'people_from' => $peopleFrom,
                    'people_to' => $peopleTo,
                    'amount' => $amount,
                    'type' => $type,
                ]);
            }
        }

        if (isset($pricing['extra_price'])) {
            foreach ($pricing['extra_price'] as $extraPriceData) {
                if (isset($extraPriceData['name'], $extraPriceData['price'], $extraPriceData['type'])) {
                    TourExtraPrice::create([
                        'tour_id' => $tour->id,
                        'name' => $extraPriceData['name'],
                        'price' => $extraPriceData['price'],
                        'type' => $extraPriceData['type'],
                        'is_per_person' => $extraPriceData['is_per_person'] ?? 0,
                    ]);
                }
            }
        }

        if (isset($pricing['is_person_type_enabled']) && $pricing['is_person_type_enabled'] == '1') {
            // Handle Normal Pricing
            if ($pricing['price_type'] === 'normal' && isset($pricing['normal'])) {
                foreach ($pricing['normal']['person_type'] as $index => $personType) {
                    TourPricing::create([
                        'tour_id' => $tour->id,
                        'price_type' => $pricing['price_type'],
                        'person_type' => $personType,
                        'person_description' => $pricing['normal']['person_description'][$index] ?? null,
                        'min_person' => $pricing['normal']['min_person'][$index] ?? null,
                        'max_person' => $pricing['normal']['max_person'][$index] ?? null,
                        'price' => $pricing['normal']['price'][$index] ?? null,
                    ]);
                }
            }

            // Handle Private Pricing
            if ($pricing['price_type'] === 'private') {
                TourPricing::create([
                    'tour_id' => $tour->id,
                    'price_type' => $pricing['price_type'],
                    'car_price' => $pricing['private']['car_price'] ?? null,
                    'min_person' => $pricing['private']['min_person'] ?? null,
                    'max_person' => $pricing['private']['max_person'] ?? null,
                ]);
            }

            // Handle Water Pricing
            if ($pricing['price_type'] === 'water' && isset($pricing['water'])) {
                foreach ($pricing['water']['time'] as $index => $waterTime) {
                    TourPricing::create([
                        'tour_id' => $tour->id,
                        'price_type' => $pricing['price_type'],
                        'time' => $waterTime,
                        'water_price' => $pricing['water']['water_price'][$index] ?? null,
                    ]);
                }
            }

            // Handle Promo Pricing
            if ($pricing['price_type'] === 'promo' && isset($pricing['promo'])) {
                foreach ($pricing['promo']['promo_title'] as $index => $promoTitle) {
                    TourPricing::create([
                        'tour_id' => $tour->id,
                        'price_type' => $pricing['price_type'],
                        'promo_title' => $promoTitle,
                        'original_price' => $pricing['promo']['original_price'][$index] ?? null,
                        'discount_price' => $pricing['promo']['discount_price'][$index] ?? null,
                        'promo_price' => $pricing['promo']['promo_price'][$index] ?? null,
                        'offer_expire_at' => $pricing['promo']['offer_expire_at'][$index] ?? null,
                    ]);
                }
            }
        }

        // Handle Location
        if (isset($location['location_type'])) {
            if ($location['location_type'] == 'normal_location') {
                $cityIds = $location['normal_location']['city_ids'] ?? [];
                $tour->cities()->sync($cityIds);
            }
            if ($location['location_type'] === 'normal_itinerary') {
                $days = array_filter($location['normal_itinerary']['days'] ?? []);
                $titles = array_filter($location['normal_itinerary']['title'] ?? []);
                $descriptions = array_filter($location['normal_itinerary']['description'] ?? []);
                $locationFiles = $request->file('tour.location', []);
                $featuredImages = $locationFiles['normal_itinerary']['featured_image'] ?? [];
                $featuredImageAltTexts = array_filter($location['normal_itinerary']['featured_image_alt_text'] ?? []);
                foreach ($days as $index => $day) {
                    if (isset($titles[$index]) && isset($descriptions[$index])) {
                        TourItinerary::create([
                            'tour_id' => $tour->id,
                            'day' => $day ?? null,
                            'title' => $titles[$index] ?? null,
                            'description' => $descriptions[$index] ?? null,
                            'featured_image' => isset($featuredImages[$index])
                                ? $this->simpleUploadImg($featuredImages[$index], 'Tours/Tour-itinerary/Featured-images')
                                : null,
                            'featured_image_alt_text' => $featuredImageAltTexts[$index] ?? null,
                        ]);
                    }
                }
            }
        }

        // Handle banner and featured images
        $this->uploadImg('banner_image', 'Tour/Banners/Featured-images', $tour, 'banner_image');
        $this->uploadImg('featured_image', 'Tour/Featured-images', $tour, 'featured_image');
        $this->uploadImg('promotional_image', 'Tour/Promotional-images', $tour, 'promotional_image');

        if ($request->gallery) {
            foreach ($request->file('gallery') as $index => $image) {
                $path = $this->simpleUploadImg($image, 'Tour/Gallery-images');

                $tour->media()->create([
                    'file_path' => $path,
                    'alt_text' => $request['gallery_alt_texts'][$index],
                ]);
            }
        }

        // Handle SEO data
        handleSeoData($request, $tour, 'Tour');

        return redirect()->route('admin.tours.index')->with('notify_success', 'Tour Added successfully.')->with('active_tab', 'details');
    }

    public function edit($id)
    {
        $tour = Tour::with(['attributes', 'attributes.attributeItems'])->find($id);
        $attributes = TourAttribute::where('status', 'active')
            ->latest()->get();
        $categories = TourCategory::where('status', 'publish')->latest()->get();
        // $tours = Tour::where('status', 'publish')->get();
        $tours = Tour::where('id', '!=', $id)->get();
        $users = User::where('is_active', 1)->get();

        $cities = City::where('status', 'publish')->get();
        $data = compact('tour', 'categories', 'cities', 'tours', 'users', 'attributes');

        return view('admin.tours.tours-management.edit', $data)->with('title', ucfirst(strtolower($tour->title)));
    }

    public function update(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);

        $general = $request->input('tour.general', []);
        $statusTab = $request->input('tour.status', []);
        $availabilityData = $request->input('tour.availability', []);
        $pricing = $request->input('tour.pricing', []);
        $location = $request->input('tour.location', []);
        $itineraryExperience = $request->input('itinerary_experience', []);

        $slugText = ! empty($general['slug']) ? $general['slug'] : $general['title'];
        $slug = $this->createSlug($slugText, 'tours', $tour->slug);

        $inclusions = ! empty($general['inclusions']) && ! in_array(null, $general['inclusions'], true)
            ? json_encode(array_filter($general['inclusions'], fn ($value) => $value !== null))
            : null;

        $exclusions = ! empty($general['exclusions']) && ! in_array(null, $general['exclusions'], true)
            ? json_encode(array_filter($general['exclusions'], fn ($value) => $value !== null))
            : null;

        $features = ! empty($general['features']) && ! in_array(null, $general['features'], true)
            ? json_encode(array_filter($general['features'], fn ($value) => $value !== null))
            : null;

        $relatedTours = ! empty($request->input('related_tour_ids')) ? json_encode($request->input('related_tour_ids')) : null;

        $tour->update([
            'title' => $general['title'] ?? null,
            'slug' => $slug ?? null,
            'content' => $general['content'] ?? null,
            'category_id' => $general['category_id'] ?? null,
            'badge_icon_class' => $general['badge_icon_class'] ?? null,
            'badge_name' => $general['badge_name'] ?? null,
            'banner_image_alt_text' => $request->input('banner_image_alt_text'),
            'featured_image_alt_text' => $request->input('featured_image_alt_text'),
            'promotional_image_alt_text' => $request->input('promotional_image_alt_text'),
            'banner_type' => $general['banner_type'] ?? null,
            'video_link' => $general['video_link'] ?? null,
            'inclusions' => $inclusions,
            'exclusions' => $exclusions,
            'features' => $features,
            'status' => $statusTab['status'],
            'author_id' => $statusTab['author_id'],
            'is_featured' => $statusTab['is_featured'] ?? 0,
            'is_open_hours' => $availabilityData['is_open_hours'] ?? 0,
            'featured_state' => $statusTab['featured_state'] ?? null,
            'ical_import_url' => $statusTab['ical_import_url'] ?? null,
            'ical_export_url' => $statusTab['ical_export_url'] ?? null,
            'related_tour_ids' => $relatedTours,
            'is_fixed_date' => $availabilityData['is_fixed_date'] ?? 0,
            'start_date' => $availabilityData['start_date'],
            'end_date' => $availabilityData['end_date'] ?? null,
            'last_booking_date' => $availabilityData['last_booking_date'],
            'regular_price' => $pricing['regular_price'] ?? null,
            'sale_price' => $pricing['sale_price'] ?? null,
            'is_person_type_enabled' => $pricing['is_person_type_enabled'] ?? 0,
            'enabled_custom_service_fee' => $pricing['enabled_custom_service_fee'] ?? 0,
            'price_type' => isset($pricing['is_person_type_enabled']) && $pricing['is_person_type_enabled'] == 1 ? $pricing['price_type'] : null,
            'is_extra_price_enabled' => $pricing['is_extra_price_enabled'] ?? 0,
            'service_fee_price' => $pricing['service_fee_price'] ?? null,
            'show_phone' => $pricing['show_phone'] ?? 0,
            'phone_country_code' => $pricing['phone_country_code'] ?? null,
            'phone_dial_code' => $pricing['phone_dial_code'] ?? null,
            'phone_number' => $pricing['phone_number'] ?? null,
            'address' => $location['normal_location']['address'] ?? null,
            'location_type' => $location['location_type'] ?? null,
            'itinerary_experience' => json_encode($itineraryExperience) ?? null,
        ]);

        // Handle FAQs

        if (isset($general['faq']['question']) && is_array($general['faq']['question'])) {
            $tour->faqs()->delete();
            foreach ($general['faq']['question'] as $index => $question) {
                $answer = $general['faq']['answer'][$index] ?? null;

                if (! empty($question) && ! empty($answer)) {
                    TourFaq::create([
                        'question' => $question,
                        'answer' => $answer,
                        'tour_id' => $tour->id,
                    ]);
                }
            }
        }

        // Handle attributes and items
        if (! empty($statusTab['attributes'])) {
            $tour->attributes()->detach();
            foreach ($statusTab['attributes'] as $attributeId => $itemIds) {
                foreach ($itemIds as $itemId) {
                    $tour->attributes()->attach($attributeId, ['tour_attribute_item_id' => $itemId]);
                }
            }
        } else {
            $tour->attributes()->detach();
        }

        // Handle details
        if (! empty($general['details'])) {
            $tour->tourDetails()->delete();
            foreach ($general['details'] as $detail) {
                if ($detail['name'] !== null && ! empty($detail['items'])) {
                    TourDetail::create([
                        'tour_id' => $tour->id,
                        'name' => $detail['name'],
                        'items' => json_encode($detail['items']),
                        'urls' => json_encode($detail['urls']),
                    ]);
                }
            }
        }

        // Update Open Hours if is_open_hours is true
        if (isset($availabilityData['is_open_hours']) && $availabilityData['is_open_hours'] == 1) {
            $tour->openHours()->delete();
            foreach ($availabilityData['open_hours'] as $hours) {
                TourOpenHour::create([
                    'tour_id' => $tour->id,
                    'day' => $hours['day'] ?? null,
                    'open_time' => $hours['open_time'] ?? null,
                    'close_time' => $hours['close_time'] ?? null,
                    'enabled' => $hours['enabled'] ?? 0,
                ]);
            }
        }

        // Handle discounts
        if (! empty($pricing['discount'])) {
            $tour->discounts()->delete();
            $discountCount = count($pricing['discount']['people_from']);
            for ($i = 0; $i < $discountCount; $i++) {
                $peopleFrom = $pricing['discount']['people_from'][$i] ?? null;
                $peopleTo = $pricing['discount']['people_to'][$i] ?? null;
                $amount = $pricing['discount']['discount'][$i] ?? null;
                $type = $pricing['discount']['type'][$i] ?? null;

                TourPriceDiscount::create([
                    'tour_id' => $tour->id,
                    'people_from' => $peopleFrom,
                    'people_to' => $peopleTo,
                    'amount' => $amount,
                    'type' => $type,
                ]);
            }
        }

        // Handle extra prices
        if (isset($pricing['extra_price'])) {
            $tour->extraPrices()->delete();
            foreach ($pricing['extra_price'] as $extraPriceData) {
                if (isset($extraPriceData['name'], $extraPriceData['price'], $extraPriceData['type'])) {
                    TourExtraPrice::create([
                        'tour_id' => $tour->id,
                        'name' => $extraPriceData['name'],
                        'price' => $extraPriceData['price'],
                        'type' => $extraPriceData['type'],
                        'is_per_person' => $extraPriceData['is_per_person'] ?? 0,
                    ]);
                }
            }
        }

        // Handle normal, private, water, promo pricing
        if (isset($pricing['is_person_type_enabled']) && $pricing['is_person_type_enabled'] == '1') {
            $tour->pricing()->delete();
            // Normal Pricing
            if ($pricing['price_type'] === 'normal' && isset($pricing['normal'])) {
                foreach ($pricing['normal']['person_type'] as $index => $personType) {
                    TourPricing::create([
                        'tour_id' => $tour->id,
                        'price_type' => $pricing['price_type'],
                        'person_type' => $personType,
                        'person_description' => $pricing['normal']['person_description'][$index] ?? null,
                        'min_person' => $pricing['normal']['min_person'][$index] ?? null,
                        'max_person' => $pricing['normal']['max_person'][$index] ?? null,
                        'price' => $pricing['normal']['price'][$index] ?? null,
                    ]);
                }
            }

            // Private Pricing
            if ($pricing['price_type'] === 'private') {
                TourPricing::create([
                    'tour_id' => $tour->id,
                    'price_type' => $pricing['price_type'],
                    'car_price' => $pricing['private']['car_price'] ?? null,
                    'min_person' => $pricing['private']['min_person'] ?? null,
                    'max_person' => $pricing['private']['max_person'] ?? null,
                ]);
            }

            // Handle Water Pricing
            if ($pricing['price_type'] === 'water' && isset($pricing['water'])) {
                foreach ($pricing['water']['time'] as $index => $waterTime) {
                    TourPricing::create([
                        'tour_id' => $tour->id,
                        'price_type' => $pricing['price_type'],
                        'time' => $waterTime,
                        'water_price' => $pricing['water']['water_price'][$index] ?? null,
                    ]);
                }
            }

            // Handle Promo Pricing
            if ($pricing['price_type'] === 'promo' && isset($pricing['promo'])) {
                foreach ($pricing['promo']['promo_title'] as $index => $promoTitle) {
                    TourPricing::create([
                        'tour_id' => $tour->id,
                        'price_type' => $pricing['price_type'],
                        'promo_title' => $promoTitle,
                        'original_price' => $pricing['promo']['original_price'][$index] ?? null,
                        'discount_price' => $pricing['promo']['discount_price'][$index] ?? null,
                        'promo_price' => $pricing['promo']['promo_price'][$index] ?? null,
                        'offer_expire_at' => $pricing['promo']['offer_expire_at'][$index] ?? null,
                    ]);
                }
            }
        }

        if (isset($location['location_type'])) {
            if ($location['location_type'] == 'normal_location') {
                $cityIds = $location['normal_location']['city_ids'] ?? [];
                $tour->cities()->sync($cityIds); // Sync city IDs with the tour
            }

            if ($location['location_type'] === 'normal_itinerary') {

                $ids = $location['normal_itinerary']['ids'] ?? [];
                $tour->normalItineraries()->whereNotIn('id', $ids)->delete();

                $days = array_filter($location['normal_itinerary']['days'] ?? []);
                $titles = array_filter($location['normal_itinerary']['title'] ?? []);
                $descriptions = array_filter($location['normal_itinerary']['description'] ?? []);
                $locationFiles = $request->file('tour.location', []);
                $featuredImages = $locationFiles['normal_itinerary']['featured_image'] ?? [];
                $featuredImageAltTexts = array_filter($location['normal_itinerary']['featured_image_alt_text'] ?? []);

                foreach ($days as $index => $day) {
                    if (isset($titles[$index]) && isset($descriptions[$index])) {
                        if (! empty($ids[$index])) { // Check if ID exists
                            $itinerary = TourItinerary::find($ids[$index]);
                            if ($itinerary) {
                                $itinerary->update([
                                    'day' => $day ?? null,
                                    'title' => $titles[$index] ?? null,
                                    'description' => $descriptions[$index] ?? null,
                                    'featured_image' => isset($featuredImages[$index]) && $featuredImages[$index]
                                        ? $this->simpleUploadImg($featuredImages[$index], 'Tours/Tour-itinerary/Featured-images')
                                        : $itinerary->featured_image,
                                    'featured_image_alt_text' => $featuredImageAltTexts[$index] ?? $itinerary->featured_image_alt_text,
                                ]);
                            }
                        } else {
                            // Create a new itinerary if ID is null
                            TourItinerary::create([
                                'tour_id' => $tour->id,
                                'day' => $day ?? null,
                                'title' => $titles[$index] ?? null,
                                'description' => $descriptions[$index] ?? null,
                                'featured_image' => isset($featuredImages[$index])
                                    ? $this->simpleUploadImg($featuredImages[$index], 'Tours/Tour-itinerary/Featured-images')
                                    : null,
                                'featured_image_alt_text' => $featuredImageAltTexts[$index] ?? null,
                            ]);
                        }
                    }
                }
            }
        }

        if ($request->gallery) {
            foreach ($request->file('gallery') as $index => $image) {
                $path = $this->simpleUploadImg($image, 'Tour/Gallery-images');

                $tour->media()->create([
                    'file_path' => $path,
                    'alt_text' => $request['gallery_alt_texts'][$index],
                ]);
            }
        }

        if ($request->hasFile('banner_image')) {
            $tour->banner_image = $this->simpleUploadImg($request->file('banner_image'), 'Tours/Banners/Featured-images');
        }
        if ($request->hasFile('featured_image')) {
            $tour->featured_image = $this->simpleUploadImg($request->file('featured_image'), 'Tours/Featured-images');
        }
        if ($request->hasFile('promotional_image')) {
            $tour->promotional_image = $this->simpleUploadImg($request->file('promotional_image'), 'Tours/Promotional-images');
        }

        $tour->save();

        // Handle SEO data
        handleSeoData($request, $tour, 'Tour');

        return redirect()->route('admin.tours.index')->with('notify_success', 'Tour Added successfully.')->with('active_tab', 'details');
    }
}
