@if ($errors->userDeletion->isNotEmpty())
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            window.dispatchEvent(
                new CustomEvent('open-modal', {
                    detail: 'confirm-user-deletion'
                })
            );
        });
    </script>
@endif


<section class="space-y-6">

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <div x-data="{ show: false }" class="w-3/4">
    
                <div class="flex items-center w-full h-10 border border-gray-400 bg-[#F3F3F3] rounded-md shadow-sm focus-within:ring-2 focus-within:ring-gray-600 focus-within:border-gray-600">
                    
                    <input 
                        id="password" 
                        name="password" 
                        :type="show ? 'text' : 'password'" 
                        placeholder="Password"
                        class="flex-1 h-full bg-transparent border-none px-3 focus:ring-0 placeholder-gray-500"
                    >

                    <button 
                        type="button" 
                        @click.prevent="show = !show" 
                        class="flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none border-l border-transparent"
                    >
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button 
                    type="button" 
                    x-on:click="$dispatch('close-modal', 'confirm-user-deletion')"
                >
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button type="submit" class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

