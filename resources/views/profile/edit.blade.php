<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Update Profile Info -->
            <div 
            x-data="{ open: false }" 
            style="background-color: #F3F3F3;"
            class="p-4 sm:p-8 shadow sm:rounded-lg">
                <button @click="open = !open" class="w-full text-left flex justify-between items-center mb-4">
                    <span class="font-semibold text-lg">Update Profile Information</span>
                    <span x-text="open ? '-' : '+'"></span>
                </button>
                <div x-show="open" x-transition>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div 
            x-data="{ open: false }" 
            style="background-color: #F3F3F3;"
            class="p-4 sm:p-8 shadow sm:rounded-lg">
                <button @click="open = !open" class="w-full text-left flex justify-between items-center mb-4">
                    <span class="font-semibold text-lg">Change Password</span>
                    <span x-text="open ? '-' : '+'"></span>
                </button>
                <div x-show="open" x-transition>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User -->
            <div
                x-data="{ open: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }" 
                style="background-color: #F3F3F3;"
                class="p-4 sm:p-8 shadow sm:rounded-lg"
            >
                <!-- Collapsible Header -->
                <button
                    @click="open = !open"
                    class="w-full text-left flex justify-between items-center mb-4"
                >
                    <span class="font-semibold text-lg text-red-600">Delete Account</span>
                    <span x-text="open ? '-' : '+'"></span>
                </button>

                <!-- Collapsible Content -->
                <div x-show="open" x-transition>
                    <p class="text-gray-700 mb-5">
                        {{ __('Deleting your account is permanent. All data will be lost. Enter your password in the popup to confirm.') }}
                    </p>

                    <!-- Button to open modal -->
                    <x-danger-button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    >
                        {{ __('Delete Account') }}
                    </x-danger-button>
                </div>
            </div>

            <!-- Modal is included separately and handles the password + deletion -->
            <x-modal name="confirm-user-deletion" focusable>
                @include('profile.partials.delete-user-form')
            </x-modal>



        </div>
    </div>

    <!-- Alpine.js CDN (if not already included) -->
    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>
