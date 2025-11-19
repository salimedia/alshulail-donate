<!-- Top header -->
<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <!-- Mobile menu button -->
        <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-600">
            <i class="fas fa-bars text-lg"></i>
        </button>

        <!-- Search bar -->
        <div class="flex-1 max-w-lg mx-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       placeholder="{{ __("Search projects, donations, users...") }}"
                       x-data="{ value: '' }"
                       x-model="value"
                       @input="debounce(() => { if(value.length > 2) { console.log('Searching for:', value); } }, 300)">
            </div>
        </div>

        <!-- Right side actions -->
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="relative p-2 text-gray-500 hover:text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class="fas fa-bell text-lg"></i>
                    <!-- Notification badge -->
                    <span class="absolute -top-1 -right-1 h-5 w-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                </button>

                <!-- Notifications dropdown -->
                <div x-show="open" 
                     @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50"
                     x-cloak>
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-900">{{ __("Notifications") }}</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        <!-- Notification items -->
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900 font-medium">{{ __("New donation received") }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ __("$500 donated to Yemen School Project") }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ __("5 minutes ago") }}</p>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900 font-medium">{{ __("Project goal reached") }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ __("Orphan Sponsorship project completed") }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ __("2 hours ago") }}</p>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900 font-medium">{{ __("New user registered") }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ __("Ahmed Ali joined the platform") }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ __("1 day ago") }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-t border-gray-100">
                        <a href="#" class="block text-center text-sm text-indigo-600 hover:text-indigo-800">
                            {{ __("View all notifications") }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick stats button -->
            <button class="p-2 text-gray-500 hover:text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors"
                    @click="$dispatch('open-stats-modal')">
                <i class="fas fa-chart-line text-lg"></i>
            </button>

            <!-- User dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="flex items-center space-x-2 p-2 text-gray-700 hover:text-gray-900 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    <div class="w-8 h-8 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full flex items-center justify-center">
                        <span class="text-sm font-semibold text-white">{{ substr(auth()->user()->name, 0, 2) }}</span>
                    </div>
                    <span class="hidden sm:block text-sm font-medium">{{ auth()->user()->name }}</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>

                <!-- User dropdown menu -->
                <div x-show="open" 
                     @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50"
                     x-cloak>
                    <div class="p-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="py-1">
                        <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user-circle mr-2"></i>
                            {{ __("Profile Settings") }}
                        </a>
                        <a href="{{ route('admin.settings') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i>
                            {{ __("System Settings") }}
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-question-circle mr-2"></i>
                            {{ __("Help & Support") }}
                        </a>
                    </div>
                    <div class="border-t border-gray-100">
                        <form method="POST" action="{{ route('admin.logout') }}" class="block">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                {{ __("Sign Out") }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
// Debounce function for search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>