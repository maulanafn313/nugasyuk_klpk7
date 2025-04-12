<x-guest-layout>
    {{-- <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form> --}}

    <div class="xl:w-full xl:max-w-sm 2xl:max-w-md xl:mx-auto">
        <h2 class="text-3xl font-bold leading-tight text-blue-800 sm:text-4xl">Sign up to Nugasyuk</h2>
        <p class="mt-2 text-base text-gray-100">Do you have an account? <a href="{{ route('login') }}" class="font-medium text-blue-800 transition-all duration-200 hover:text-white focus:text-white hover:underline">Sign in to your account</a></p>

        <form action="{{ route('register') }}" method="POST" class="mt-8">
            @csrf
            <div class="space-y-5">
                {{-- name --}}
                <div>
                    {{-- <label for="" class="text-base font-medium text-gray-900"> Email address </label> --}}
                    <x-input-label for="email" :value="__('Your Name')"/>
                    <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/>
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
                        id="name" 
                        class="block mt-1 w-full" 
                        type="name" 
                        name="name" 
                        :value="old('name')"
                        placeholder="Write your name" 
                        required 
                        autofocus 
                        autocomplete="username" />

                    </div>

                    
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>


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

                        <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            :value="old('password')"
                            placeholder="Enter your password"
                            required autocomplete="current-password" />

                        
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- confirm password --}}
                <div>
                    <div class="flex items-center justify-between">
                        <x-input-label for="password_confirmation" :value="__('Password Confirmation')" />
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

                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation"
                            :value="old('password')"
                            placeholder="Enter your password confirmation"
                            required autocomplete="new-password" />

                        
                    </div>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>


                <div>
                    <x-primary-button class="w-full mt-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
