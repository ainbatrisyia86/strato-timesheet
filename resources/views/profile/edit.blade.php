<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

           <div 
                x-data="{ open: false }" 
                style="background-color: #F3F3F3;" 
                class="p-4 sm:p-8 shadow sm:rounded-lg">
                
                <button @click="open = !open" class="w-full text-left flex justify-between items-center focus:outline-none">
                    <div>
                        <span class="font-semibold text-lg">{{ __('Profile Information') }}</span>
                        <p class="text-sm text-gray-600">View your account profile information and organizational details.</p>
                    </div>
                    <span class="text-2xl font-light" x-text="open ? '−' : '+'"></span>
                </button>

                <div x-show="open" x-transition class="mt-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div 
                x-data="{ open: false }" 
                style="background-color: #F3F3F3;"
                class="p-4 sm:p-8 shadow sm:rounded-lg">
                
                <button @click="open = !open" class="w-full text-left flex justify-between items-center focus:outline-none">
                    <div>
                        <span class="font-semibold text-lg">Change Password</span>
                        <p class="text-sm text-gray-600">Ensure your account is using a long, random password to stay secure.</p>
                    </div>
                    <span class="text-2xl font-light" x-text="open ? '−' : '+'"></span>
                </button>

                <div x-show="open" x-transition class="mt-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <x-modal name="confirm-user-deletion" focusable>
                @include('profile.partials.delete-user-form')
            </x-modal>

        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>