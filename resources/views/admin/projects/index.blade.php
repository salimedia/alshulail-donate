@extends('admin.layouts.app')

@section('title', 'Projects')

@section('page-title', 'Projects')

@section('page-actions')
<div class="flex space-x-3">
    <a href="{{ route('admin.projects.create') }}" 
       class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
        <i class="fas fa-plus mr-2"></i>
        Create Project
    </a>
</div>
@endsection

@section('content')
<!-- Filters and Search -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6 fade-in-up">
    <form method="GET" action="{{ route('admin.projects.index') }}" class="space-y-4 lg:space-y-0 lg:flex lg:items-end lg:space-x-4">
        <!-- Search -->
        <div class="flex-1">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       name="search" 
                       id="search"
                       value="{{ request('search') }}"
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="Search projects...">
            </div>
        </div>

        <!-- Category Filter -->
        <div class="lg:w-48">
            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category" 
                    id="category"
                    class="block w-full border border-gray-300 rounded-lg py-2 pl-3 pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name_en }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Status Filter -->
        <div class="lg:w-32">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" 
                    id="status"
                    class="block w-full border border-gray-300 rounded-lg py-2 pl-3 pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="paused" {{ request('status') == 'paused' ? 'selected' : '' }}>Paused</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <!-- Featured Filter -->
        <div class="lg:w-32">
            <label for="featured" class="block text-sm font-medium text-gray-700 mb-1">Featured</label>
            <select name="featured" 
                    id="featured"
                    class="block w-full border border-gray-300 rounded-lg py-2 pl-3 pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All</option>
                <option value="true" {{ request('featured') == 'true' ? 'selected' : '' }}>Featured</option>
                <option value="false" {{ request('featured') == 'false' ? 'selected' : '' }}>Not Featured</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-filter mr-2"></i>
                Filter
            </button>
        </div>

        <!-- Clear Button -->
        @if(request()->hasAny(['search', 'category', 'status', 'featured']))
        <div>
            <a href="{{ route('admin.projects.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                <i class="fas fa-times mr-2"></i>
                Clear
            </a>
        </div>
        @endif
    </form>
</div>

<!-- Projects Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($projects as $project)
    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover-lift fade-in-up">
        <!-- Project Image -->
        <div class="relative h-48 bg-gradient-to-br from-indigo-400 to-purple-500">
            @if($project->getFirstMediaUrl('images'))
            <img src="{{ $project->getFirstMediaUrl('images') }}" 
                 alt="{{ $project->title_en }}"
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
                    <i class="fas fa-star mr-1"></i> Featured
                </span>
                @endif
                @if($project->is_urgent)
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    <i class="fas fa-exclamation mr-1"></i> Urgent
                </span>
                @endif
            </div>

            <!-- Status -->
            <div class="absolute top-4 right-4">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                    {{ $project->status === 'active' ? 'bg-green-100 text-green-800' : 
                       ($project->status === 'paused' ? 'bg-yellow-100 text-yellow-800' : 
                       ($project->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                    {{ ucfirst($project->status) }}
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
                <h3 class="text-lg font-semibold text-gray-900 mb-1 truncate">{{ $project->title_en }}</h3>
                <p class="text-sm text-gray-600">{{ $project->category->name_en }}</p>
            </div>

            <!-- Progress Bar -->
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Progress</span>
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
                    <p class="text-xs text-gray-500">Raised</p>
                    <p class="text-sm font-semibold text-green-600">${{ number_format($project->raised_amount, 0) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Goal</p>
                    <p class="text-sm font-semibold text-gray-900">${{ number_format($project->target_amount, 0) }}</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                <span><i class="fas fa-users mr-1"></i>{{ $project->donors_count }} donors</span>
                <span><i class="fas fa-heart mr-1"></i>{{ $project->expected_beneficiaries_count }} beneficiaries</span>
            </div>

            <!-- Actions -->
            <div class="flex space-x-2">
                <a href="{{ route('admin.projects.show', $project) }}" 
                   class="flex-1 text-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-eye mr-1"></i> View
                </a>
                <a href="{{ route('admin.projects.edit', $project) }}" 
                   class="flex-1 text-center px-3 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-edit mr-1"></i> Edit
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
            <h3 class="text-lg font-medium text-gray-900 mb-2">No projects found</h3>
            <p class="text-gray-500 mb-6">Get started by creating your first project.</p>
            <a href="{{ route('admin.projects.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700">
                <i class="fas fa-plus mr-2"></i>
                Create Project
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
    admin.ajax(`/admin/projects/${projectId}/toggle-featured`, {
        method: 'POST',
    })
    .then(response => {
        admin.showMessage(response.message, 'success');
        // Refresh the page to show updated status
        setTimeout(() => window.location.reload(), 1000);
    })
    .catch(error => {
        admin.showMessage('Failed to update project status', 'error');
    });
}

// Toggle urgent status
function toggleUrgent(projectId) {
    admin.ajax(`/admin/projects/${projectId}/toggle-urgent`, {
        method: 'POST',
    })
    .then(response => {
        admin.showMessage(response.message, 'success');
        // Refresh the page to show updated status
        setTimeout(() => window.location.reload(), 1000);
    })
    .catch(error => {
        admin.showMessage('Failed to update project status', 'error');
    });
}
</script>
@endpush