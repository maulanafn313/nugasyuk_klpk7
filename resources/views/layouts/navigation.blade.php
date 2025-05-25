<nav x-data="{ open: false }" class="bg-blue-300 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('dashboard') }}">
                        {{-- <x-application-logo class="block h-9 w-auto fill-current text-gray-800" /> --}}
                        {{-- <img src="{{ asset('images/logo nugasyuk.png') }}" alt="logo nugasyuk" class="block h-9 w-auto fill-current text-gray-800"> --}}
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>


                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="Auth::user()->role == 'admin' ? route('admin.dashboard') : route('dashboard')" :active="Auth::user()->role == 'admin' ? request()->routeIs('admin.dashboard') : request()->routeIs('dashboard') ">
                        {{ __('Dashboard') }}
                    </x-nav-link>


                    {{-- admin links --}}
                    @if(Auth::user()->role == 'admin')
                        <x-nav-link href="{{ route('admin.userManagement.index') }}" :active="request()->routeIs('admin.userManagement')">
                            {{ __('User Management') }}
                        </x-nav-link>
                        
                    
                        <x-nav-link href="{{ route('admin.cms.index') }}" :active="request()->routeIs('admin.userManagement')">
                            {{ __('CMS') }}
                        </x-nav-link>


                        <x-nav-link href="{{ route('admin.facilities.index') }}" :active="request()->routeIs('admin.userManagement')">
                            {{ __('Facility') }}
                        </x-nav-link>


                        <x-nav-link href="{{ route('admin.category.index') }}" :active="request()->routeIs('admin.category')">
                            {{ __('Category') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('admin.faqs') }}" :active="request()->routeIs('admin.faqs')">
                            {{ __('Question FAQ') }}
                        </x-nav-link>
                    @endif


                    {{-- user links --}}
                    @if(Auth::user()->role == 'user')
                        <x-nav-link href="create-schedule" :active="request()->routeIs('user.create-schedule')">
                            {{ __('Create Schedule') }}
                        </x-nav-link>


                        <x-nav-link href="view-schedule" :active="request()->routeIs('user.view-schedule')">
                            {{ __('View Schedule') }}
                        </x-nav-link>


                        <x-nav-link href="calendar" :active="request()->routeIs('user.calendar')">
                            {{ __('Calendar') }}
                        </x-nav-link>

                        <x-nav-link href="/google/calendar/events" :active="request()->routeIs('google.calendar.events')">
                            {{ __('Google Calendar') }}
                        </x-nav-link>
            
                        <x-nav-link href="history-schedule" :active="request()->routeIs('user.history-schedule')">
                            {{ __('History Schedule') }}
                        </x-nav-link>
                    @endif


                </div>
            </div>


            @if(Auth::user()->role == 'user')
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Notification Dropdown -->
                <div class="relative mr-4">
                    <x-dropdown align="right" width="80">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    @if($notifications->isNotEmpty())
                                        <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 text-xs flex items-center justify-center">
                                            {{ $notifications->count() }}
                                        </span>
                                    @endif
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="max-h-80 overflow-y-auto w-80">
                                @if ($notifications->isEmpty())
                                    <div class="px-4 py-3 text-sm text-gray-700">
                                        Tidak ada notifikasi baru.
                                    </div>
                                @else
                                    @foreach ($notifications as $n)
                                        <div class="px-4 py-3 text-sm border-b last:border-b-0 hover:bg-gray-50
                                            @if($n['type']=='info') text-blue-800
                                            @elseif($n['type']=='primary') text-indigo-800
                                            @elseif($n['type']=='warning') text-yellow-800
                                            @elseif($n['type']=='danger') text-red-800
                                            @endif">
                                            <div class="flex items-start space-x-2">
                                                <div class="flex-shrink-0">
                                                    @if($n['type']=='info')
                                                        <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 1010 10A10 10 0 0012 2z"/>
                                                        </svg>
                                                    @elseif($n['type']=='warning')
                                                        <svg class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                        </svg>
                                                    @elseif($n['type']=='danger')
                                                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    @else
                                                        <svg class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="flex-1">
                                                    {!! $n['message'] !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>


                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>


                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href='route("faq.form")'>
                            {{ __('FAQ') }}
                        </x-dropdown-link>


                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf


                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endif

            @if(Auth::user()->role == 'admin')
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <!-- User Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>


                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>


                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>


                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf


                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endif

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="Auth::user()->role == 'admin' ? route('admin.dashboard') : route('dashboard')" :active="Auth::user()->role == 'admin' ? request()->routeIs('admin.dashboard') : request()->routeIs('dashboard') ">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>


            {{-- user links --}}
            @if(Auth::user()->role == 'user')
                <x-responsive-nav-link href="schedule" :active=" request()->routeIs('schedule')">
                    {{ __('Create Schedule') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="view-schedule" :active=" request()->routeIs('user.view-schedule')">
                    {{ __('View Schedule') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="history-schedule" :active=" request()->routeIs('schedule')">
                    {{ __('History Schedule') }}
                </x-responsive-nav-link>
            @endif


            {{-- admin links --}}
            @if(Auth::user()->role == 'admin')
            <x-responsive-nav-link :href="route('admin.userManagement.index')" :active="request()->routeIs('admin.userManagement.*')">
                {{ __('User Management') }}
            </x-responsive-nav-link>


            @endif

            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>


                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>


                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf


                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>

        <!-- Responsive Notifications -->
        @if($notifications->isNotEmpty())
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">Notifikasi</div>
            </div>
            <div class="mt-3 space-y-1 max-h-60 overflow-y-auto">
                @foreach($notifications as $n)
                    <div class="px-4 py-2 text-sm
                        @if($n['type']=='info') text-blue-800
                        @elseif($n['type']=='primary') text-indigo-800
                        @elseif($n['type']=='warning') text-yellow-800
                        @elseif($n['type']=='danger') text-red-800
                        @endif">
                        {!! $n['message'] !!}
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    
</nav>


