@php
    $formTitle = 'Add Attribute';
    $formAction = route('admin.tour-attributes.store');
    $buttonText = 'Add new';
    $categoryName = old('name');
    $slug = old('slug');
@endphp

<div class="form-box">
    <div class="form-box__header">
        <div class="title">{{ $formTitle }}</div>
    </div>

    <form action="{{ $formAction }}" class="form-box__body" method="POST">
        @csrf

        <div class="form-fields">
            <label class="title">Name <span class="text-danger">*</span> :</label>
            <input type="text" name="name" class="field" value="{{ $categoryName }}" placeholder="Name" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-fields">
            <button class="themeBtn">{{ $buttonText }}</button>
        </div>
    </form>
</div>
