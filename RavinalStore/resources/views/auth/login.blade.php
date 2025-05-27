<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login now to start shopping!</title>
    <link rel="icon" href="{{ asset('storage/images/ravinallogo.jpg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/ravinallogo.jpg') }}">
</head>
<body class="bg-gradient-to-br from-indigo-200 via-purple-200 to-pink-200 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md bg-white/70 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-2xl p-8">
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('storage/images/ravinallogo.jpg') }}" alt="Ravinal Store Logo" class="w-20 h-20 mb-2 rounded-full shadow-lg">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Welcome Back</h2>
                <p class="text-gray-500 dark:text-gray-300 text-sm">Login to start shopping!</p>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600 dark:text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 dark:text-red-400">
                    {{ __('Whoops! Something went wrong.') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5" autocomplete="on">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email Address
                    </label>
                    <input id="email" name="email" type="email" placeholder="Enter your email" required autofocus
                        value="{{ old('email') }}"
                        autocomplete="email"
                        aria-label="Email Address"
                        class="mt-1 block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition">
                    @error('email')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div x-data="{ show: false }">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Password
                    </label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" id="password" name="password" placeholder="••••••••" required
                            autocomplete="current-password"
                            aria-label="Password"
                            class="mt-1 block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-indigo-600 focus:outline-none"
                            tabindex="-1" aria-label="Toggle password visibility">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M6.7 6.7A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.043 5.197M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline dark:text-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400 rounded">
                            Forgot password?
                        </a>
                    @endif
                </div>
                <button type="submit"
                    class="w-full px-4 py-2 font-semibold text-white bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg shadow-md hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                    Log in
                </button>
            </form>
            <p class="mt-6 text-sm text-center text-gray-600 dark:text-gray-400">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-indigo-600 hover:underline dark:text-indigo-400 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-400 rounded">Sign up</a>
            </p>
        </div>
    </div>
</body>
</html>
