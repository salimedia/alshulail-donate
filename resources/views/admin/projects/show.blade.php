@extends('admin.layouts.app')

@section('title', $project->localized_title)
@section('page-title', $project->localized_title)

@section('page-actions')
<div class="flex items-center space-x-3">
    <a href="{{ route('admin.projects.index') }}" 
       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <i class="fas fa-arrow-left mx-2"></i>
        {{ __('Back to Projects') }}
    </a>
    
    <div class="flex space-x-2">
        <button onclick="toggleFeatured()" 
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i class="fas fa-star mx-2 {{ $project->is_featured ? 'text-yellow-500' : 'text-gray-400' }}"></i>
            {{ $project->is_featured ? __('Remove Featured') : __('Mark Featured') }}
        </button>
        
        <button onclick="toggleUrgent()" 
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i class="fas fa-exclamation-triangle mx-2 {{ $project->is_urgent ? 'text-red-500' : 'text-gray-400' }}"></i>
            {{ $project->is_urgent ? __('Remove Urgent') : __('Mark Urgent') }}
        </button>
    </div>
    
    <a href="{{ route('admin.projects.edit', $project->id) }}" 
       class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <i class="fas fa-edit mx-2"></i>
        {{ __('Edit Project') }}
    </a>
</div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Project Images -->
            @if(count($projectImages) > 0)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-images mx-2 text-purple-500"></i>
                        {{ __('Project Images') }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($projectImages as $index => $image)
                            <div class="relative group">
                                <img src="{{ $image->getUrl() }}" 
                                     alt="{{ $project->localized_title }}" 
                                     class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-75 transition-opacity shadow-sm"
                                     onclick="openImageModal('{{ $image->getUrl() }}', '{{ $image->name }}')">
                                
                                @if($index === 0)
                                    <div class="absolute top-2 left-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-star mx-1"></i>
                                            {{ __('Featured Image') }}
                                        </span>
                                    </div>
                                @endif
                                
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all duration-200 flex items-center justify-center">
                                    <i class="fas fa-expand text-white opacity-0 group-hover:opacity-100 transition-opacity text-2xl"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4 text-sm text-gray-500">
                        <i class="fas fa-info-circle mx-1"></i>
                        {{ trans_choice('{0} No images|{1} :count image|[2,*] :count images', count($projectImages), ['count' => count($projectImages)]) }}
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Description -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-align-left mx-2 text-blue-500"></i>
                    {{ __('Project Description') }}
                </h3>
                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed">{{ $project->localized_description }}</p>
                </div>
            </div>
            
            <!-- Expected Impact -->
            @if($project->localized_expected_impact)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-heart mx-2 text-pink-500"></i>
                    {{ __('Expected Impact') }}
                </h3>
                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed">{{ $project->localized_expected_impact }}</p>
                </div>
            </div>
            @endif
            
            <!-- Achieved Impact -->
            @if($project->localized_achieved_impact)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-trophy mx-2 text-yellow-500"></i>
                    {{ __('Achieved Impact') }}
                </h3>
                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed">{{ $project->localized_achieved_impact }}</p>
                </div>
            </div>
            @endif
            
            <!-- Recent Donations -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-donate mx-2 text-green-500"></i>
                    {{ __('Recent Donations') }}
                </h3>
                
                @if($project->donations->count() > 0)
                    <div class="space-y-3">
                        @foreach($project->donations()->latest()->take(10)->get() as $donation)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $donation->user ? $donation->user->name : ($donation->donor_name ?: __('Anonymous')) }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $donation->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-green-600">
                                    {{ number_format($donation->amount) }} {{ __('SAR') }}
                                </p>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $donation->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-donate text-gray-400 text-xl"></i>
                        </div>
                        <p class="text-gray-500">{{ __('No donations yet') }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Progress Card -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-chart-line mx-2 text-indigo-500"></i>
                    {{ __('Progress') }}
                </h3>
                
                <div class="space-y-4">
                    <!-- Progress Bar -->
                    <div>
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>{{ __('Completion') }}</span>
                            <span>{{ number_format($project->progress_percentage, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-gradient-to-r from-green-500 to-blue-500 h-3 rounded-full transition-all duration-500" 
                                 style="width: {{ min(100, $project->progress_percentage) }}%"></div>
                        </div>
                    </div>
                    
                    <!-- Financial Stats -->
                    <div class="grid grid-cols-1 gap-4">
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">{{ number_format($project->raised_amount) }}</div>
                            <div class="text-sm text-green-700">{{ __('SAR Raised') }}</div>
                        </div>
                        
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ number_format($project->target_amount) }}</div>
                            <div class="text-sm text-blue-700">{{ __('SAR Target') }}</div>
                        </div>
                        
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">{{ number_format($project->remaining_amount) }}</div>
                            <div class="text-sm text-purple-700">{{ __('SAR Remaining') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Project Details -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle mx-2 text-gray-500"></i>
                    {{ __('Project Details') }}
                </h3>
                
                <div class="space-y-4">
                    <!-- Status -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ __('Status') }}</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $project->status_badge['class'] }}">
                            {{ $project->status_badge['text'] }}
                        </span>
                    </div>
                    
                    <!-- Category -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ __('Category') }}</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $project->category ? (app()->getLocale() === 'ar' ? $project->category->name_ar : $project->category->name_en) : __('No Category') }}
                        </span>
                    </div>
                    
                    <!-- Location -->
                    @if($project->full_location)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ __('Location') }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $project->full_location }}</span>
                    </div>
                    @endif
                    
                    <!-- Donors -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ __('Donors') }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $project->donors_count }}</span>
                    </div>
                    
                    <!-- Beneficiaries -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ __('Expected Beneficiaries') }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ number_format($project->expected_beneficiaries_count) }}</span>
                    </div>
                    
                    @if($project->actual_beneficiaries_count > 0)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ __('Actual Beneficiaries') }}</span>
                        <span class="text-sm font-medium text-green-600">{{ number_format($project->actual_beneficiaries_count) }}</span>
                    </div>
                    @endif
                    
                    <!-- Timeline -->
                    @if($project->start_date)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ __('Start Date') }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $project->formatted_start_date }}</span>
                    </div>
                    @endif
                    
                    @if($project->end_date)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ __('End Date') }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $project->formatted_end_date }}</span>
                    </div>
                    @endif
                    
                    @if($project->days_left !== null)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ __('Time Remaining') }}</span>
                        <span class="text-sm font-medium {{ $project->days_left <= 7 ? 'text-red-600' : 'text-gray-900' }}">
                            {{ $project->localized_days_left }}
                        </span>
                    </div>
                    @endif
                    
                    <!-- Created At -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ __('Created') }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $project->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Analytics -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-analytics mx-2 text-indigo-500"></i>
                    {{ __('Analytics') }}
                </h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ __('Average Donation') }}</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ number_format($project->average_donation) }} {{ __('SAR') }}
                        </span>
                    </div>
                    
                    @if($project->funding_velocity > 0)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ __('Daily Average') }}</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ number_format($project->funding_velocity) }} {{ __('SAR/day') }}
                        </span>
                    </div>
                    @endif
                    
                    @if($project->completion_probability > 0)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ __('Success Probability') }}</span>
                        <span class="text-sm font-medium {{ $project->completion_probability >= 70 ? 'text-green-600' : ($project->completion_probability >= 40 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $project->completion_probability }}%
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-cogs mx-2 text-gray-500"></i>
                    {{ __('Actions') }}
                </h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.projects.edit', $project->id) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-edit mx-2"></i>
                        {{ __('Edit Project') }}
                    </a>
                    
                    <button onclick="confirmDelete()" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 rounded-lg shadow-sm bg-white text-sm font-medium text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fas fa-trash mx-2"></i>
                        {{ __('Delete Project') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
            <i class="fas fa-times text-xl"></i>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleFeatured() {
    fetch(`/admin/projects/{{ $project->id }}/toggle-featured`, {
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
        }
    })
    .catch(error => console.error('Error:', error));
}

function toggleUrgent() {
    fetch(`/admin/projects/{{ $project->id }}/toggle-urgent`, {
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
        }
    })
    .catch(error => console.error('Error:', error));
}

function confirmDelete() {
    if (confirm('{{ __("Are you sure you want to delete this project? This action cannot be undone.") }}')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.projects.destroy", $project->id) }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function openImageModal(imageUrl, imageName = '') {
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('modalImage').alt = imageName || '{{ $project->localized_title }}';
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endpush