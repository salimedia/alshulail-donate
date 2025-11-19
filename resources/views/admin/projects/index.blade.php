@extends('admin.layouts.app')

@section('title', __('Projects'))

@section('page-title', __('Projects Management'))

@section('page-actions')
<div class="flex space-x-3">
    <a href="{{ route('admin.projects.create') }}"
       class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
        <i class="fas fa-plus mx-2"></i>
        {{ __("Create Project") }}
    </a>
</div>
@endsection

@section('content')
<!-- Filters and Search -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6 fade-in-up">
    <form method="GET" action="{{ route('admin.projects.index') }}" class="space-y-4 lg:space-y-0 lg:flex lg:items-end lg:space-x-4">
        <!-- Search -->
        <div class="flex-1">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">{{ __("Search") }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text"
                       name="search"
                       id="search"
                       value="{{ request('search') }}"
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="{{ __("Search projects...") }}">
            </div>
        </div>

        <!-- Category Filter -->
        <div class="lg:w-48">
            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">{{ __("Category") }}</label>
            <select name="category"
                    id="category"
                    class="block w-full border border-gray-300 rounded-lg py-2 pl-3 pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">{{ __("All Categories") }}</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Status Filter -->
        <div class="lg:w-32">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">{{ __("Status") }}</label>
            <select name="status"
                    id="status"
                    class="block w-full border border-gray-300 rounded-lg py-2 pl-3 pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">{{ __("All Statuses") }}</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __("Active") }}</option>
                <option value="paused" {{ request('status') == 'paused' ? 'selected' : '' }}>{{ __("Paused") }}</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __("Completed") }}</option>
                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>{{ __("Closed") }}</option>
            </select>
        </div>

        <!-- Featured Filter -->
        <div class="lg:w-32">
            <label for="featured" class="block text-sm font-medium text-gray-700 mb-1">{{ __("Featured") }}</label>
            <select name="featured"
                    id="featured"
                    class="block w-full border border-gray-300 rounded-lg py-2 pl-3 pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">{{ __("All Projects") }}</option>
                <option value="true" {{ request('featured') == 'true' ? 'selected' : '' }}>{{ __("Featured Only") }}</option>
                <option value="false" {{ request('featured') == 'false' ? 'selected' : '' }}>{{ __("Non-Featured") }}</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-filter mx-2"></i>
                {{ __("Apply Filters") }}
            </button>
        </div>

        <!-- Show Deleted Toggle -->
        <div>
            <label class="inline-flex items-center">
                <input type="checkbox"
                       name="show_deleted"
                       value="1"
                       {{ request('show_deleted') ? 'checked' : '' }}
                       onchange="this.form.submit()"
                       class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-700">{{ __('Show Deleted') }}</span>
            </label>
        </div>

        <!-- Clear Button -->
        @if(request()->hasAny(['search', 'category', 'status', 'featured']))
        <div>
            <a href="{{ route('admin.projects.index') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                <i class="fas fa-times mx-2"></i>
                {{ __("Clear") }}
            </a>
        </div>
        @endif
    </form>
</div>

<!-- Projects Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($projects as $project)
    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover-lift fade-in-up group">
        <!-- Project Image -->
        <div class="relative h-48 bg-gradient-to-br from-indigo-400 to-purple-500">
            @if($project->getFirstMediaUrl('images'))
            <img src="{{ $project->getFirstMediaUrl('images') }}"
                 alt="{{ $project->localized_title }}"
                 class="w-full h-full object-cover">
            @else
            <div class="w-full h-full flex items-center justify-center">
                <i class="fas fa-image text-white text-4xl opacity-50"></i>
            </div>
            @endif

            <!-- Badges -->
            <div class="absolute top-4 left-4 space-y-2">
                @if($project->is_featured)
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    <i class="fas fa-star mx-2"></i> {{ __("Featured") }}
                </span>
                @endif
                @if($project->is_urgent)
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    <i class="fas fa-exclamation mx-2"></i> {{ __("Urgent") }}
                </span>
                @endif
            </div>

            <!-- Status -->
            <div class="absolute top-4 right-4 space-y-1">
                @if($project->deleted_at)
                <span class="block px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    {{ __('Deleted') }}
                </span>
                @endif
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                    {{ $project->status === 'active' ? 'bg-green-100 text-green-800' :
                       ($project->status === 'paused' ? 'bg-yellow-100 text-yellow-800' :
                       ($project->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                    {{ $project->status_badge['text'] ?? ucfirst($project->status) }}
                </span>
            </div>

            <!-- Quick Actions -->
            <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity space-x-2">
                <button onclick="toggleFeatured({{ $project->id }})"
                        class="w-8 h-8 bg-black bg-opacity-50 text-white rounded-full hover:bg-opacity-70 transition-colors">
                    <i class="fas fa-star text-xs"></i>
                </button>
                <button onclick="toggleUrgent({{ $project->id }})"
                        class="w-8 h-8 bg-black bg-opacity-50 text-white rounded-full hover:bg-opacity-70 transition-colors">
                    <i class="fas fa-exclamation text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Project Content -->
        <div class="p-6">
            <div class="mb-3">
                <h3 class="text-lg font-semibold text-gray-900 mb-1 line-clamp-2">{{ $project->localized_title }}</h3>
                <p class="text-sm text-gray-500 flex items-center">
                    <i class="fas fa-tag mx-2"></i>
                    {{ $project->category ? (app()->getLocale() === 'ar' ? $project->category->name_ar : $project->category->name_en) : __("No Category") }}
                </p>
            </div>

            <!-- Progress Bar -->
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">{{ __("Progress") }}</span>
                    <span class="text-sm text-gray-500">{{ number_format($project->progress_percentage, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-green-500 to-blue-600 h-2 rounded-full transition-all duration-300"
                         style="width: {{ min(100, $project->progress_percentage) }}%"></div>
                </div>
            </div>

            <!-- Funding Info -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-xs text-gray-500">{{ __("Raised") }}</p>
                    <p class="text-sm font-semibold text-green-600">{{ number_format($project->raised_amount, 0) }} {{ __("SAR") }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">{{ __("Goal") }}</p>
                    <p class="text-sm font-semibold text-gray-900">{{ number_format($project->target_amount, 0) }} {{ __("SAR") }}</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                <span><i class="fas fa-users mx-2"></i>{{ $project->donors_count }} {{ __("donors") }}</span>
                @if($project->full_location)
                    <span><i class="fas fa-map-marker-alt mx-2"></i>{{ $project->full_location }}</span>
                @endif
            </div>

            <!-- Actions -->
            <div class="flex space-x-2">
                <a href="{{ route('admin.projects.show', $project->id) }}"
                   class="flex-1 text-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-eye mx-2"></i> {{ __("View") }}
                </a>
                <a href="{{ route('admin.projects.edit', $project->id) }}"
                   class="flex-1 text-center px-3 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-edit mx-2"></i> {{ __("Edit") }}
                </a>
            </div>
        </div>
    </div>
    @empty
    <!-- Empty State -->
    <div class="col-span-full">
        <div class="text-center py-12">
            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-project-diagram text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __("No projects found") }}</h3>
            <p class="text-gray-500 mb-6">{{ __("Get started by creating your first project") }}</p>
            <a href="{{ route('admin.projects.create') }}"
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700">
                <i class="fas fa-plus mx-2"></i>
                {{ __("Create Project") }}
            </a>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($projects->hasPages())
<div class="mt-8">
    {{ $projects->links() }}
</div>
@endif
@endsection

@push('scripts')
<script>
// Toggle featured status
function toggleFeatured(projectId) {
    fetch(`/admin/projects/${projectId}/toggle-featured`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('{{ __("Error updating project") }}');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ __("Error updating project") }}');
    });
}

// Toggle urgent status
function toggleUrgent(projectId) {
    fetch(`/admin/projects/${projectId}/toggle-urgent`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('{{ __("Error updating project") }}');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ __("Error updating project") }}');
    });
}

// Auto-submit search after typing stops
let searchTimeout;
document.querySelector('input[name="search"]')?.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        this.form.submit();
    }, 500);
});
</script>
@endpush

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.group:hover .group-hover\\:opacity-100 {
    opacity: 1;
}
</style>
@endpush
