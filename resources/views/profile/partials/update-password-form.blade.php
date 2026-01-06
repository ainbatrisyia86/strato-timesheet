<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" 
        x-data="{ 
            password: '', 
            password_confirmation: '',
            get isDirty() { return this.password_confirmation.length > 0 }
        }" 
        class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div x-data="{ show: false }">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div class="mt-1 flex items-center w-full h-10 border border-gray-400 bg-white rounded-md shadow-sm focus-within:ring-1 focus-within:ring-gray-600 focus-within:border-gray-600 overflow-hidden">
                <input 
                    id="update_password_current_password" 
                    name="current_password" 
                    :type="show ? 'text' : 'password'" 
                    class="flex-1 h-full bg-transparent border-none px-3 text-black placeholder-gray-500 focus:ring-0 sm:text-sm"
                    autocomplete="current-password"
                >
                <button type="button" @click="show = !show" class="flex items-center h-full px-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="update_password_password" :value="__('New Password')" />
            
            <div class="mt-1 flex items-center w-full h-10 border border-gray-400 bg-white rounded-md shadow-sm focus-within:ring-1 focus-within:ring-gray-600 focus-within:border-gray-600 overflow-hidden">
                <input 
                    id="update_password_password" 
                    name="password" 
                    x-model="password"
                    :type="show ? 'text' : 'password'" 
                    class="flex-1 h-full bg-transparent border-none px-3 text-black placeholder-gray-500 focus:ring-0 sm:text-sm"
                    autocomplete="new-password"
                >
                <button type="button" @click="show = !show" class="flex items-center h-full px-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            
            <div class="mt-1 flex items-center w-full h-10 border rounded-md shadow-sm overflow-hidden transition-colors"
                 :class="isDirty ? (password === password_confirmation ? 'border-green-500 ring-1 ring-green-500' : 'border-red-500 ring-1 ring-red-500') : 'border-gray-400 bg-white focus-within:ring-1 focus-within:ring-gray-600 focus-within:border-gray-600'">
                <input 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    x-model="password_confirmation"
                    :type="show ? 'text' : 'password'" 
                    class="flex-1 h-full bg-transparent border-none px-3 text-black placeholder-gray-500 focus:ring-0 sm:text-sm"
                    autocomplete="new-password"
                >
                <button type="button" @click="show = !show" class="flex items-center h-full px-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            <p x-show="isDirty && password !== password_confirmation" 
                class="mt-2 text-sm text-red-600" 
                x-cloak>
                    {{ __('Passwords do not match.') }}
            </p>
            <p x-show="isDirty && password === password_confirmation && password.length > 0" 
                class="mt-2 text-sm text-green-600" 
                x-cloak>
                    {{ __('Passwords match!') }}
            </p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button x-bind:disabled="isDirty && password !== password_confirmation">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p 
                x-data="{ show: true }" 
                x-show="show" 
                x-transition x-init="setTimeout(() => show = false, 2000)" 
                lass="text-sm text-gray-600">
                {{ __('Saved.') }}
            </p>
            @endif

        </div>
    </form>

    @if (session('status') === 'password-updated')
        <script>
            alert('Your password has been updated!');
            window.location.href = '{{ route("profile.edit") }}';
        </script>
    @endif
</section>
