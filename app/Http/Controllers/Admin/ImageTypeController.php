<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImageType;
use App\Traits\Sluggable;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

class ImageTypeController extends Controller
{
    use Sluggable;
    use UploadImageTrait;

    public function index()
    {
        $imageTypes = ImageType::latest()->get();

        return view('admin.image-types.list')->with('title', 'Image Types')->with(compact('imageTypes'));
    }

    public function create()
    {
        return view('admin.image-types.add')->with('title', 'Create Image Type');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'featured_image' => 'nullable',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'nullable|boolean',
        ]);

        $slug = $this->createSlug($request['name'], 'image_types');

        $data = array_merge($validated, [
            'slug' => $slug,
            'featured_image' => $this->simpleUploadImg($request['featured_image'], 'Image-types/Featured-images'),
        ]);

        ImageType::create($data);

        return redirect()->route('admin.image-types.index')
            ->with('notify_success', 'Image Type created successfully.');
    }

    public function edit($id)
    {
        $item = ImageType::find($id);

        return view('admin.image-types.edit')->with('title', 'Edit '.ucfirst($item->name))->with(compact('item'));
    }

    public function update(Request $request, ImageType $imageType)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'featured_image' => 'nullable',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'nullable|boolean',
        ]);

        $slug = $this->createSlug($request['name'], 'image_types', $imageType->slug);
        $data = array_merge($validated, [
            'slug' => $slug,
            'featured_image' => $this->simpleUploadImg($request['featured_image'], 'Image-types/Featured-images'),
        ]);

        $imageType->update($data);

        return redirect()->route('admin.image-types.index')
            ->with('notify_success', 'Image Type updated successfully.');
    }
}
