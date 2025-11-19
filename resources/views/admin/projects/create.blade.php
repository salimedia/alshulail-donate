@extends('admin.layouts.app')

@section('title', __('Create Project'))
@section('page-title', __('Create New Project'))

@section('page-actions')
<div class="flex items-center space-x-3">
    <a href="{{ route('admin.projects.index') }}" 
       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <i class="fas fa-arrow-left mx-2"></i>
        {{ __('Back to Projects') }}
    </a>
</div>
@endsection

@section('content')
<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl mx-auto">
    @csrf
    
    <div class="space-y-8">
        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6 flex items-center">
                <i class="fas fa-info-circle mx-2 text-indigo-500"></i>
                {{ __('Basic Information') }}
            </h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Arabic Title -->
                <div>
                    <label for="title_ar" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Arabic Title') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title_ar" 
                           id="title_ar"
                           value="{{ old('title_ar') }}"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title_ar') border-red-500 @enderror"
                           placeholder="{{ __('Enter project title in Arabic') }}"
                           required>
                    @error('title_ar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- English Title -->
                <div>
                    <label for="title_en" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('English Title') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title_en" 
                           id="title_en"
                           value="{{ old('title_en') }}"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title_en') border-red-500 @enderror"
                           placeholder="{{ __('Enter project title in English') }}"
                           required>
                    @error('title_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Category') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" 
                            id="category_id"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('category_id') border-red-500 @enderror"
                            required>
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('URL Slug') }}
                        <span class="text-gray-400 text-xs">({{ __('Optional - auto-generated if empty') }})</span>
                    </label>
                    <input type="text" 
                           name="slug" 
                           id="slug"
                           value="{{ old('slug') }}"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('slug') border-red-500 @enderror"
                           placeholder="{{ __('project-url-slug') }}">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Descriptions -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6 flex items-center">
                <i class="fas fa-align-left mx-2 text-indigo-500"></i>
                {{ __('Descriptions') }}
            </h3>
            
            <div class="space-y-6">
                <!-- Arabic Description -->
                <div>
                    <label for="description_ar" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Arabic Description') }} <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description_ar" 
                              id="description_ar"
                              rows="5"
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description_ar') border-red-500 @enderror"
                              placeholder="{{ __('Describe the project in Arabic...') }}"
                              required>{{ old('description_ar') }}</textarea>
                    @error('description_ar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- English Description -->
                <div>
                    <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('English Description') }} <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description_en" 
                              id="description_en"
                              rows="5"
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description_en') border-red-500 @enderror"
                              placeholder="{{ __('Describe the project in English...') }}"
                              required>{{ old('description_en') }}</textarea>
                    @error('description_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Financial Information -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6 flex items-center">
                <i class="fas fa-dollar-sign mx-2 text-green-500"></i>
                {{ __('Financial Information') }}
            </h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Target Amount -->
                <div>
                    <label for="target_amount" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Target Amount') }} ({{ __('SAR') }}) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                               name="target_amount" 
                               id="target_amount"
                               value="{{ old('target_amount') }}"
                               step="0.01"
                               min="0"
                               class="block w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('target_amount') border-red-500 @enderror"
                               placeholder="0.00"
                               required>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">{{ __('SAR') }}</span>
                        </div>
                    </div>
                    @error('target_amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expected Beneficiaries -->
                <div>
                    <label for="expected_beneficiaries_count" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Expected Beneficiaries') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="expected_beneficiaries_count" 
                           id="expected_beneficiaries_count"
                           value="{{ old('expected_beneficiaries_count') }}"
                           min="1"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('expected_beneficiaries_count') border-red-500 @enderror"
                           placeholder="{{ __('Number of people who will benefit') }}"
                           required>
                    @error('expected_beneficiaries_count')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Location -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6 flex items-center">
                <i class="fas fa-map-marker-alt mx-2 text-red-500"></i>
                {{ __('Location') }}
            </h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Country -->
                <div>
                    <label for="location_country" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Country') }}
                    </label>
                    <input type="text" 
                           name="location_country" 
                           id="location_country"
                           value="{{ old('location_country') }}"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('location_country') border-red-500 @enderror"
                           placeholder="{{ __('e.g., Saudi Arabia') }}">
                    @error('location_country')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Region -->
                <div>
                    <label for="location_region" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Region') }}
                    </label>
                    <input type="text" 
                           name="location_region" 
                           id="location_region"
                           value="{{ old('location_region') }}"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('location_region') border-red-500 @enderror"
                           placeholder="{{ __('e.g., Riyadh Province') }}">
                    @error('location_region')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City -->
                <div>
                    <label for="location_city" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('City') }}
                    </label>
                    <input type="text" 
                           name="location_city" 
                           id="location_city"
                           value="{{ old('location_city') }}"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('location_city') border-red-500 @enderror"
                           placeholder="{{ __('e.g., Riyadh') }}">
                    @error('location_city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6 flex items-center">
                <i class="fas fa-calendar mx-2 text-blue-500"></i>
                {{ __('Timeline') }}
            </h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Start Date') }}
                    </label>
                    <input type="date" 
                           name="start_date" 
                           id="start_date"
                           value="{{ old('start_date') }}"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('start_date') border-red-500 @enderror">
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('End Date') }}
                    </label>
                    <input type="date" 
                           name="end_date" 
                           id="end_date"
                           value="{{ old('end_date') }}"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('end_date') border-red-500 @enderror">
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Impact -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6 flex items-center">
                <i class="fas fa-heart mx-2 text-pink-500"></i>
                {{ __('Expected Impact') }}
            </h3>
            
            <div class="space-y-6">
                <!-- Arabic Impact -->
                <div>
                    <label for="expected_impact_ar" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Arabic Impact Description') }}
                    </label>
                    <textarea name="expected_impact_ar" 
                              id="expected_impact_ar"
                              rows="4"
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('expected_impact_ar') border-red-500 @enderror"
                              placeholder="{{ __('Describe the expected impact in Arabic...') }}">{{ old('expected_impact_ar') }}</textarea>
                    @error('expected_impact_ar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- English Impact -->
                <div>
                    <label for="expected_impact_en" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('English Impact Description') }}
                    </label>
                    <textarea name="expected_impact_en" 
                              id="expected_impact_en"
                              rows="4"
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('expected_impact_en') border-red-500 @enderror"
                              placeholder="{{ __('Describe the expected impact in English...') }}">{{ old('expected_impact_en') }}</textarea>
                    @error('expected_impact_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6 flex items-center">
                <i class="fas fa-cog mx-2 text-gray-500"></i>
                {{ __('Project Settings') }}
            </h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Status') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="status" 
                            id="status"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror"
                            required>
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="paused" {{ old('status') === 'paused' ? 'selected' : '' }}>{{ __('Paused') }}</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>{{ __('Closed') }}</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Display Order -->
                <div>
                    <label for="display_order" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Display Order') }}
                    </label>
                    <input type="number" 
                           name="display_order" 
                           id="display_order"
                           value="{{ old('display_order', 0) }}"
                           min="0"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('display_order') border-red-500 @enderror"
                           placeholder="0">
                    @error('display_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Flags -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">{{ __('Flags') }}</label>
                    
                    <div class="space-y-3">
                        <!-- Featured -->
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   value="1"
                                   {{ old('is_featured') ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700 flex items-center">
                                <i class="fas fa-star mx-2 text-yellow-500"></i>
                                {{ __('Featured Project') }}
                            </span>
                        </label>

                        <!-- Urgent -->
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_urgent" 
                                   value="1"
                                   {{ old('is_urgent') ? 'checked' : '' }}
                                   class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            <span class="ml-2 text-sm text-gray-700 flex items-center">
                                <i class="fas fa-exclamation-triangle mx-2 text-red-500"></i>
                                {{ __('Urgent Project') }}
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Images -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6 flex items-center">
                <i class="fas fa-images mx-2 text-purple-500"></i>
                {{ __('Project Images') }}
            </h3>
            
            <div class="space-y-4">
                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Upload Images') }}
                        <span class="text-gray-400 text-xs">({{ __('Multiple images allowed - JPG, PNG, GIF') }})</span>
                    </label>
                    <input type="file" 
                           name="images[]" 
                           id="images"
                           multiple
                           accept="image/jpeg,image/png,image/gif"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('images')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="text-sm text-gray-500">
                    <p>{{ __('Tips:') }}</p>
                    <ul class="list-disc list-inside mt-1 space-y-1">
                        <li>{{ __('First image will be used as featured image') }}</li>
                        <li>{{ __('Recommended size: 1200x800 pixels') }}</li>
                        <li>{{ __('Maximum file size: 2MB per image') }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.projects.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-times mx-2"></i>
                    {{ __('Cancel') }}
                </a>
                
                <div class="flex space-x-3">
                    <button type="submit" 
                            name="action" 
                            value="draft"
                            class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-save mx-2"></i>
                        {{ __('Save as Draft') }}
                    </button>
                    
                    <button type="submit" 
                            name="action" 
                            value="publish"
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-rocket mx-2"></i>
                        {{ __('Create Project') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Auto-generate slug from English title
document.getElementById('title_en').addEventListener('input', function() {
    const slug = this.value
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    
    if (!document.getElementById('slug').value) {
        document.getElementById('slug').value = slug;
    }
});

// Validate end date after start date
document.getElementById('start_date').addEventListener('change', function() {
    const endDate = document.getElementById('end_date');
    if (this.value) {
        endDate.min = this.value;
    }
});

// Preview uploaded images
document.getElementById('images').addEventListener('change', function() {
    const files = this.files;
    const previewContainer = document.getElementById('image-preview');
    
    if (!previewContainer) {
        const preview = document.createElement('div');
        preview.id = 'image-preview';
        preview.className = 'mt-4 grid grid-cols-2 md:grid-cols-4 gap-4';
        this.parentElement.appendChild(preview);
    }
    
    document.getElementById('image-preview').innerHTML = '';
    
    for (let i = 0; i < Math.min(files.length, 8); i++) {
        const file = files[i];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-full h-24 object-cover rounded-lg border border-gray-200';
            document.getElementById('image-preview').appendChild(img);
        };
        
        reader.readAsDataURL(file);
    }
});

// Form validation before submit
document.querySelector('form').addEventListener('submit', function(e) {
    const requiredFields = ['title_ar', 'title_en', 'description_ar', 'description_en', 'target_amount', 'category_id', 'expected_beneficiaries_count'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            input.classList.add('border-red-500');
            isValid = false;
        } else {
            input.classList.remove('border-red-500');
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('{{ __("Please fill in all required fields") }}');
    }
});
</script>
@endpush