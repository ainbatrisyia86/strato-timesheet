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
            current_password: '',
            password: '', 
            password_confirmation: '',
            passwordTouched: false,

            get missingRequirements() {
                let requirements = [];
                if (this.password.length < 8) requirements.push('at least 8 characters');
                if (!/[a-z]/.test(this.password) || !/[A-Z]/.test(this.password)) requirements.push('uppercase and lowercase letters');
                if (!/[@$!%*?&]/.test(this.password)) requirements.push('at least one symbol (@$!%*?&)');
                return requirements;
            },
            get isPasswordValid() { return this.password.length > 0 && this.missingRequirements.length === 0 },
            get isMatch() { return this.password === this.password_confirmation && this.password_confirmation.length > 0 },
            get canSave() { return this.current_password.length > 0 && this.isPasswordValid && this.isMatch }
        }" 
        class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div x-data="{ show: false }">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div class="mt-1 flex items-center w-full h-10 border border-gray-300 bg-white rounded-md shadow-sm overflow-hidden"
                 style="background-color:#F3F3F3;">
                <input 
                    id="update_password_current_password" 
                    name="current_password" 
                    x-model="current_password"
                    :type="show ? 'text' : 'password'" 
                    class="flex-1 h-full bg-transparent border-none px-3 text-black focus:ring-0 sm:text-sm"
                    autocomplete="current-password"
                >
                <button type="button" @click="show = !show" class="px-3 text-gray-500">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <div class="mt-1 flex items-center w-full h-10 border rounded-md shadow-sm overflow-hidden transition-all duration-200"
                 style="background-color:#F3F3F3;"
                 :style="password.length > 0 ? 
                    (isPasswordValid ? 'border-color: #22c55e; border-width: 2px' 
                    : (passwordTouched ? 'border-color: #ef4444; border-width: 2px' : 'border-color: #D1D5DB')) : 'border-color: #D1D5DB'">
                <input 
                    id="update_password_password" 
                    name="password" 
                    x-model="password"
                    @blur="passwordTouched = true"
                    :type="show ? 'text' : 'password'" 
                    class="flex-1 h-full bg-transparent border-none px-3 text-black focus:ring-0 sm:text-sm"
                >
                <button type="button" @click="show = !show" class="px-3 text-gray-500">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029"/></svg>
                </button>
            </div>
            <p x-show="passwordTouched && !isPasswordValid && password.length > 0" 
               class="mt-2 text-xs text-red-600 font-medium" x-cloak>
                Password must contain: <span x-text="missingRequirements.join(', ')"></span>.
            </p>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <div class="mt-1 flex items-center w-full h-10 border rounded-md shadow-sm overflow-hidden transition-all duration-200"
                 style="background-color:#F3F3F3;"
                 :style="password_confirmation.length > 0 ? 
                 (isMatch ? 'border-color: #22c55e; border-width: 2px' : 'border-color: #ef4444; border-width: 2px') : 'border-color: #D1D5DB'">
                <input 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    x-model="password_confirmation"
                    :type="show ? 'text' : 'password'" 
                    class="flex-1 h-full bg-transparent border-none px-3 text-black focus:ring-0 sm:text-sm"
                >
                <button type="button" @click="show = !show" class="px-3 text-gray-500">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029"/></svg>
                </button>
            </div>
            <p x-show="password_confirmation.length > 0 && !isMatch" class="mt-2 text-xs text-red-600 font-medium" x-cloak>
                Passwords do not match.
            </p>
            <p x-show="isMatch && isPasswordValid" class="mt-2 text-xs text-green-600 font-medium" x-cloak>
                Passwords match!
            </p>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button
                x-bind:disabled="!canSave"
                ::style="!canSave ? 'opacity: 0.5; cursor: not-allowed;' : 'opacity: 1; cursor: pointer;'"
            >
                {{ __('Save') }}
            </x-primary-button>
        </div>
    </form>
</section>