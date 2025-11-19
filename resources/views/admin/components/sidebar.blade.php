<!-- Sidebar -->
<div class="flex flex-col h-full bg-gradient-to-b from-indigo-900 via-purple-900 to-pink-900 text-white shadow-xl">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 px-4 bg-black bg-opacity-20">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-heart text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold">{{ __("Donation Admin") }}</h2>
                <p class="text-xs text-purple-200">{{ __("Control Panel") }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard*') ? 'bg-white bg-opacity-20 text-white shadow-lg' : 'text-purple-200 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
            <i class="fas fa-tachometer-alt mr-3 text-lg"></i>
            <span>{{ __("Dashboard") }}</span>
        </a>

        <!-- Projects -->
        <div x-data="{ open: {{ request()->routeIs('admin.projects*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.projects*') ? 'bg-white bg-opacity-20 text-white' : 'text-purple-200 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
                <div class="flex items-center">
                    <i class="fas fa-project-diagram mr-3 text-lg"></i>
                    <span>{{ __("Projects") }}</span>
                </div>
                <i class="fas fa-chevron-down transform transition-transform" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1">
                <a href="{{ route('admin.projects.index') }}" 
                   class="flex items-center px-4 py-2 text-sm rounded-lg {{ request()->routeIs('admin.projects.index') ? 'bg-white bg-opacity-10 text-white' : 'text-purple-200 hover:bg-white hover:bg-opacity-5 hover:text-white' }}">
                    <i class="fas fa-list mr-2"></i> {{ __("All Projects") }}
                </a>
                <a href="{{ route('admin.projects.create') }}" 
                   class="flex items-center px-4 py-2 text-sm rounded-lg {{ request()->routeIs('admin.projects.create') ? 'bg-white bg-opacity-10 text-white' : 'text-purple-200 hover:bg-white hover:bg-opacity-5 hover:text-white' }}">
                    <i class="fas fa-plus mr-2"></i> {{ __("Create Project") }}
                </a>
            </div>
        </div>

        <!-- Donations -->
        <div x-data="{ open: {{ request()->routeIs('admin.donations*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.donations*') ? 'bg-white bg-opacity-20 text-white' : 'text-purple-200 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
                <div class="flex items-center">
                    <i class="fas fa-donate mr-3 text-lg"></i>
                    <span>{{ __("Donations") }}</span>
                </div>
                <i class="fas fa-chevron-down transform transition-transform" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1">
                <a href="{{ route('admin.donations.index') }}" 
                   class="flex items-center px-4 py-2 text-sm rounded-lg text-purple-200 hover:bg-white hover:bg-opacity-5 hover:text-white">
                    <i class="fas fa-list mr-2"></i> {{ __("All Donations") }}
                </a>
                <a href="{{ route('admin.donations.index', ['status' => 'pending']) }}" 
                   class="flex items-center px-4 py-2 text-sm rounded-lg text-purple-200 hover:bg-white hover:bg-opacity-5 hover:text-white">
                    <i class="fas fa-clock mr-2"></i> {{ __("Pending") }}
                </a>
            </div>
        </div>

        <!-- Users -->
        <div x-data="{ open: {{ request()->routeIs('admin.users*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users*') ? 'bg-white bg-opacity-20 text-white' : 'text-purple-200 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
                <div class="flex items-center">
                    <i class="fas fa-users mr-3 text-lg"></i>
                    <span>{{ __("Users") }}</span>
                </div>
                <i class="fas fa-chevron-down transform transition-transform" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1">
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center px-4 py-2 text-sm rounded-lg text-purple-200 hover:bg-white hover:bg-opacity-5 hover:text-white">
                    <i class="fas fa-list mr-2"></i> {{ __("All Users") }}
                </a>
                <a href="{{ route('admin.users.create') }}" 
                   class="flex items-center px-4 py-2 text-sm rounded-lg text-purple-200 hover:bg-white hover:bg-opacity-5 hover:text-white">
                    <i class="fas fa-user-plus mr-2"></i> {{ __("Create User") }}
                </a>
            </div>
        </div>

        <!-- Categories -->
        <a href="{{ route('admin.categories.index') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.categories*') ? 'bg-white bg-opacity-20 text-white shadow-lg' : 'text-purple-200 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
            <i class="fas fa-tags mr-3 text-lg"></i>
            <span>{{ __("Categories") }}</span>
        </a>

        <!-- Separator -->
        <div class="border-t border-white border-opacity-20 my-4"></div>

        <!-- Statistics -->
        <a href="{{ route('admin.statistics') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.statistics*') ? 'bg-white bg-opacity-20 text-white shadow-lg' : 'text-purple-200 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
            <i class="fas fa-chart-bar mr-3 text-lg"></i>
            <span>{{ __("Statistics") }}</span>
        </a>

        <!-- Audit Logs -->
        <a href="{{ route('admin.audit-logs') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.audit-logs*') ? 'bg-white bg-opacity-20 text-white shadow-lg' : 'text-purple-200 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
            <i class="fas fa-history mr-3 text-lg"></i>
            <span>{{ __("Audit Logs") }}</span>
        </a>

        <!-- Settings -->
        <a href="{{ route('admin.settings') }}" 
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.settings*') ? 'bg-white bg-opacity-20 text-white shadow-lg' : 'text-purple-200 hover:bg-white hover:bg-opacity-10 hover:text-white' }}">
            <i class="fas fa-cog mr-3 text-lg"></i>
            <span>{{ __("Settings") }}</span>
        </a>
    </nav>

    <!-- User info -->
    <div class="px-4 py-4 border-t border-white border-opacity-20">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-pink-400 to-red-500 rounded-full flex items-center justify-center">
                <span class="text-sm font-semibold">{{ substr(auth()->user()->name, 0, 2) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-purple-200 truncate">{{ auth()->user()->email }}</p>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-purple-200 hover:text-white p-1 rounded transition-colors">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                </button>
            </form>
        </div>
    </div>
</div>