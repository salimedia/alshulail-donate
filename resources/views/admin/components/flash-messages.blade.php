<!-- Flash Messages -->
@if (session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info'))
<div class="mb-6 space-y-4">
    @if (session()->has('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 fade-in-up" data-auto-dismiss>
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600"></i>
                </div>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-medium text-green-800">Success!</h3>
                <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
            </div>
            <div class="ml-auto">
                <button type="button" onclick="this.closest('[data-auto-dismiss]').remove()" 
                        class="text-green-400 hover:text-green-600 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 fade-in-up" data-auto-dismiss>
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-medium text-red-800">Error!</h3>
                <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
            </div>
            <div class="ml-auto">
                <button type="button" onclick="this.closest('[data-auto-dismiss]').remove()" 
                        class="text-red-400 hover:text-red-600 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    @if (session()->has('warning'))
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 fade-in-up" data-auto-dismiss>
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation text-yellow-600"></i>
                </div>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-medium text-yellow-800">Warning!</h3>
                <p class="text-sm text-yellow-700 mt-1">{{ session('warning') }}</p>
            </div>
            <div class="ml-auto">
                <button type="button" onclick="this.closest('[data-auto-dismiss]').remove()" 
                        class="text-yellow-400 hover:text-yellow-600 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    @if (session()->has('info'))
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 fade-in-up" data-auto-dismiss>
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-info text-blue-600"></i>
                </div>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-medium text-blue-800">Info</h3>
                <p class="text-sm text-blue-700 mt-1">{{ session('info') }}</p>
            </div>
            <div class="ml-auto">
                <button type="button" onclick="this.closest('[data-auto-dismiss]').remove()" 
                        class="text-blue-400 hover:text-blue-600 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
@endif

<!-- Validation Errors -->
@if ($errors->any())
<div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 fade-in-up">
    <div class="flex">
        <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
            <div class="mt-2 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endif