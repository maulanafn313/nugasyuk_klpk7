<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form> --}}

    <div class="xl:w-full xl:max-w-sm 2xl:max-w-md xl:mx-auto">
        <h2 class="text-3xl font-bold leading-tight text-blue-800 sm:text-4xl">Sign in to Nugasyuk</h2>
        <p class="mt-2 text-base text-gray-100">Don’t have an account? <a href="{{ route('register') }}" title="" class="font-medium text-blue-800 transition-all duration-200 hover:text-white focus:text-white hover:underline">Create a free account</a></p>

        <form action="{{ route('login') }}" method="POST" class="mt-8">
            @csrf
            <div class="space-y-5">
                {{-- email --}}

                <div>
                    {{-- <label for="" class="text-base font-medium text-gray-900"> Email address </label> --}}
                    <x-input-label for="email" :value="__('Email address')"/>
                    <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>

                        {{-- <input
                            type="email"
                            name=""
                            id=""
                            placeholder="Enter email to get started"
                            class="block w-full py-4 pl-10 pr-4 text-black placeholder-gray-500 transition-all duration-200 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-blue-600 focus:bg-white caret-blue-600"
                        /> --}}
                        <x-text-input 
                        id="email" 
                        class="block mt-1 w-full" 
                        type="email" 
                        name="email" 
                        :value="old('email')"
                        placeholder="Enter email to get started" 
                        required 
                        autofocus 
                        autocomplete="username" />

                    </div>

                    
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- password --}}
                <div>
                    <div class="flex items-center justify-between">
                        <x-input-label for="password" :value="__('Password')" />
                        <a href="{{ route('password.request') }}" title="" class="text-sm font-medium text-blue-800 transition-all duration-200 hover:text-white focus:text-white hover:underline"> Forgot password? </a>
                    </div>
                    <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"
                                />
                            </svg>
                        </div>

                        {{-- <input
                            type="password"
                            name=""
                            id=""
                            placeholder="Enter your password"
                            class="block w-full py-4 pl-10 pr-4 text-black placeholder-gray-500 transition-all duration-200 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-blue-600 focus:bg-white caret-blue-600"
                        /> --}}

                        <x-text-input id="password" class="block mt-1 w-full pr-10"
                            type="password"
                            name="password"
                            :value="old('password')"
                            placeholder="Enter your password"
                            required autocomplete="current-password" />

                        <!-- Eye icon -->
                        <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-9 0a9 9 0 0118 0 9 9 0 01-18 0z" />
                            </svg>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- remember me --}}
                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-600" name="remember">
                        <span class="ms-2 text-sm text-blue-800">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div>
                    <x-primary-button class="w-full mt-4">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(id, element) {
            const passwordInput = document.getElementById(id);
            const passwordType = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', passwordType);

            // Toggle the eye icon
            const eyeIcon = element.querySelector('svg');
            if (eyeIcon) {
                const eyeIconPath = eyeIcon.querySelector('path');
                if (eyeIconPath) {
                    const newPath = eyeIconPath.getAttribute('d') === 'M15 12a3 3 0 11-6 0 3 3 0 016 0zm-9 0a9 9 0 0118 0 9 9 0 01-18 0z'
                        ? 'M13.875 18.825a9.004 9.004 0 01-3.75-.825m-3.375-2.325A9.004 9.004 0 0112 15a9.004 9.004 0 013.75.675m3.375 2.325A9.004 9.004 0 0112 18.825'
                        : 'M15 12a3 3 0 11-6 0 3 3 0 016 0zm-9 0a9 9 0 0118 0 9 9 0 01-18 0z';
                    eyeIconPath.setAttribute('d', newPath);
                }
            }
        }
    </script>
</x-guest-layout>
