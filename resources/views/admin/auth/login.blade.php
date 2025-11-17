<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 400% 400%;
            animation: gradientShift 10s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .float {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen gradient-bg">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Background decorations -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl float"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl float" style="animation-delay: -3s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl float" style="animation-delay: -1.5s;"></div>
        </div>

        <div class="max-w-md w-full space-y-8 relative z-10">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center glass mb-6">
                    <i class="fas fa-heart text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Admin Portal</h2>
                <p class="text-white text-opacity-80">Sign in to your dashboard</p>
            </div>

            <!-- Login Form -->
            <div class="glass rounded-2xl p-8 shadow-2xl">
                <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-6">
                    @csrf

                    <!-- Flash Messages -->
                    @if (session('success'))
                    <div class="bg-green-100 bg-opacity-80 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="bg-red-100 bg-opacity-80 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                    @endif

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-envelope mr-2"></i>Email Address
                        </label>
                        <input id="email" 
                               name="email" 
                               type="email" 
                               required 
                               value="{{ old('email') }}"
                               class="w-full px-4 py-3 rounded-lg bg-white bg-opacity-20 border border-white border-opacity-30 text-white placeholder-white placeholder-opacity-70 focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent @error('email') border-red-300 @enderror"
                               placeholder="Enter your email">
                        @error('email')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-lock mr-2"></i>Password
                        </label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required
                               class="w-full px-4 py-3 rounded-lg bg-white bg-opacity-20 border border-white border-opacity-30 text-white placeholder-white placeholder-opacity-70 focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent @error('password') border-red-300 @enderror"
                               placeholder="Enter your password">
                        @error('password')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" 
                                   name="remember" 
                                   type="checkbox"
                                   class="w-4 h-4 rounded border-white border-opacity-30 bg-white bg-opacity-20 text-white focus:ring-white focus:ring-opacity-50">
                            <label for="remember" class="ml-2 text-sm text-white text-opacity-80">
                                Remember me
                            </label>
                        </div>
                        <div>
                            <a href="#" class="text-sm text-white text-opacity-80 hover:text-white transition-colors">
                                Forgot password?
                            </a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-purple-600 bg-white hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Sign In
                        </button>
                    </div>
                </form>

                <!-- Demo Credentials -->
                <div class="mt-6 p-4 bg-white bg-opacity-10 rounded-lg border border-white border-opacity-20">
                    <h4 class="text-sm font-medium text-white mb-2">Demo Credentials:</h4>
                    <p class="text-xs text-white text-opacity-80">
                        Email: admin@alshulail-donate.org<br>
                        Password: password
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-white text-opacity-60 text-sm">
                    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>