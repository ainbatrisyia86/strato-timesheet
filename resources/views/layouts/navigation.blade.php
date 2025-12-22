<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 text-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- LEFT: Logo + Navigation --}}
            <div class="flex">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('timesheet.index') }}">
                        <img src="{{ asset('images/strato_logo.png') }}" class="h-9 w-auto" alt="Logo">
                    </a>
                </div>

                {{-- Desktop Navigation Links --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <!-- {{-- Dashboard --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link> -->

                    {{-- Timesheet --}}
                    @if(Auth::user()->role === 'hr')
                        <x-nav-link :href="route('hr.viewTS')" :active="request()->routeIs('hr.viewTS')">
                            {{ __('Timesheet') }}
                        </x-nav-link>

                    @elseif(Auth::user()->role === 'staff')
                        <x-nav-link :href="route('timesheet.index')" :active="request()->routeIs('timesheet.index')">
                            {{ __('Timesheet') }}
                        </x-nav-link>
                    @endif

                    {{-- HR Settings Dropdown --}}
                    @if(Auth::user()->role === 'hr')
                        <div class="relative">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center h-10 px-3 text-sm font-medium bg-white text-gray-700 hover:text-gray-900">
                                        <span>Settings</span>
                                        <svg class="fill-current h-4 w-4 ms-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('manage.users')">Manage User Accounts</x-dropdown-link>
                                    <x-dropdown-link :href="route('manage.projects')">Manage Projects</x-dropdown-link>
                                    <x-dropdown-link :href="route('settings.configuration')">Set Configuration Settings</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
                </div>
            </div>

            {{-- RIGHT: User Dropdown --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md bg-white text-gray-700 hover:text-gray-900">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger Menu --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:bg-gray-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link> -->

            @if(Auth::user()->role === 'hr')
                <x-responsive-nav-link :href="route('hr.viewTS')">Timesheet</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('manage.users')">Manage User Accounts</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('manage.projects')">Manage Projects</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('settings.configuration')">Set Configuration Settings</x-responsive-nav-link>
            @elseif(Auth::user()->role === 'staff')
                <x-responsive-nav-link :href="route('timesheet.create')">Timesheet</x-responsive-nav-link>
            @endif
        </div>

        {{-- Mobile Profile --}}
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-600">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
