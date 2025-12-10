<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Main wrapper -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white">

            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-2">{{ __("Welcome, ") }} {{ Auth::user()->name }}!</h3>
                    <p class="mb-2">{{ __("You're logged in as: ") }} <span class="font-semibold">{{ Auth::user()->role }}</span></p>
                    <p class="text-gray-600">{{ __("You're logged in!") }}</p>
                </div>
            </div>

            <!-- Quick Access Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Settings Card -->
                <div x-data="{ open: false }" class="relative">
                    <div
                        @click="open = !open"
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300 cursor-pointer p-6 flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <!-- Settings Icon -->
                            <svg class="h-12 w-12 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">Settings</h4>
                            <p class="text-sm text-gray-600">
                                Manage system settings and configurations
                            </p>
                        </div>
                        <div class="ml-auto">
                            <svg :class="{'rotate-180': open}" class="h-5 w-5 transform transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Dropdown -->
                    <div x-show="open" @click.outside="open = false"
                        class="absolute left-0 mt-2 w-64 bg-white shadow-lg rounded-md overflow-hidden z-10">
                        <a href="{{ route('manage.users') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            Manage User Account
                        </a>
                        <a href="{{ route('manage.projects') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            Manage Project
                        </a>
                        <a href="{{ route('settings.configuration') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            Set Configuration Settings
                        </a>
                    </div>
                </div>

                <!-- View Timesheets Card (HR Only) -->
                @if(Auth::user()->role === 'hr')
                    <a href="{{ route('hr.viewTS') }}" class="block">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900">
                                            {{ __('View Timesheets') }}</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ __('Review all staff timesheets') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
