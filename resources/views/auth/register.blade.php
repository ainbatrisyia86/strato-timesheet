<x-guest-layout>
    <form method="POST" action="{{ route('register') }}"
        x-data="{ 
            name: '{{ old('name') }}',
            email: '{{ old('email') }}',
            password: '', 
            password_confirmation: '',
            passwordTouched: false,
            showPassword: false,
            showConfirm: false,

            get missingRequirements() {
                let requirements = [];
                if (this.password.length < 8) requirements.push('at least 8 characters');
                if (!/[a-z]/.test(this.password) || !/[A-Z]/.test(this.password)) requirements.push('uppercase and lowercase letters');
                if (!/[@$!%*?&]/.test(this.password)) requirements.push('at least one symbol (@$!%*?&)');
                return requirements;
            },
            get isPasswordValid() { return this.password.length > 0 && this.missingRequirements.length === 0 },
            get isMatch() { return this.password === this.password_confirmation && this.password_confirmation.length > 0 },
            get canSubmit() { 
                return this.name.trim() !== '' && 
                       this.email.trim() !== '' && 
                       this.isPasswordValid && 
                       this.isMatch 
            }
        }"
    >
        @csrf

        <div>
            <x-input-label for="name">
                {{ __('Name') }} <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" 
                x-model="name" style="background-color:#F3F3F3;" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email">
                {{ __('Email') }} <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" 
                x-model="email" style="background-color:#F3F3F3;" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password">
                {{ __('Password') }} <span class="text-red-500">*</span>
            </x-input-label>

            <div class="mt-1 flex items-center overflow-hidden border rounded-md shadow-sm transition-all duration-200"
                 :style="password.length > 0 ? 
                        (isPasswordValid ? 'border-color: #22c55e; border-width: 2px;' : (passwordTouched ? 'border-color: #ef4444; border-width: 2px;' : 'border-color: #D1D5DB;')) : 'border-color: #D1D5DB;'"
                 style="background-color:#F3F3F3;">
                
                <input 
                    id="password" 
                    name="password" 
                    x-model="password"
                    @blur="passwordTouched = true"
                    :type="showPassword ? 'text' : 'password'"
                    style="background-color:#F3F3F3;"
                    class="flex-1 border-none bg-transparent px-3 py-2 focus:ring-0 sm:text-sm"
                    required
                >
                
                <button type="button" @click="showPassword = !showPassword" 
                    class="flex items-center justify-center px-4 py-2 border-l transition-colors"
                    
                    :style="password.length > 0 ? 
                            (isPasswordValid ? 'border-color: #22c55e;' : (passwordTouched ? 'border-color: #ef4444;' : 'border-color: #D1D5DB;')) : 'border-color: #D1D5DB;'"
                    
                            style="background-color:#F3F3F3;">
                    <svg x-show="!showPassword" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="showPassword" x-cloak class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029"/></svg>
                </button>
            </div>
            
            <p x-show="passwordTouched && !isPasswordValid && password.length > 0" class="mt-2 text-xs text-red-600 font-medium" x-cloak>
                Password must contain: <span x-text="missingRequirements.join(', ')"></span>.
            </p>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation">
                {{ __('Confirm Password') }} <span class="text-red-500">*</span>
            </x-input-label>

            <div class="mt-1 flex items-center overflow-hidden border rounded-md shadow-sm transition-all duration-200"
                 :style="password_confirmation.length > 0 ? (isMatch ? 'border-color: #22c55e; border-width: 2px;' : 'border-color: #ef4444; border-width: 2px;') : 'border-color: #D1D5DB;'"
                 style="background-color:#F3F3F3;">
                
                <input 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    x-model="password_confirmation"
                    :type="showConfirm ? 'text' : 'password'"
                    style="background-color:#F3F3F3;"
                    class="flex-1 border-none bg-transparent px-3 py-2 focus:ring-0 sm:text-sm"
                    required
                >
                
                <button type="button" @click="showConfirm = !showConfirm" 
                    class="flex items-center justify-center px-4 py-2 border-l transition-colors"
                    :style="password_confirmation.length > 0 ? (isMatch ? 'border-color: #22c55e;' : 'border-color: #ef4444;') : 'border-color: #D1D5DB;'"
                    style="background-color: #F3F3F3;">
                    <svg x-show="!showConfirm" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="showConfirm" x-cloak class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029"/></svg>
                </button>
            </div>

            <p x-show="password_confirmation.length > 0 && !isMatch" class="mt-2 text-xs text-red-600 font-medium" x-cloak>
                Passwords do not match.
            </p>
            <p x-show="isMatch && isPasswordValid" class="mt-2 text-xs text-green-600 font-medium" x-cloak>
                Passwords match!
            </p>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button 
                x-bind:disabled="!canSubmit"
                ::style="!canSubmit ? 'opacity: 0.5; cursor: not-allowed;' : 'opacity: 1; cursor: pointer;'"
                class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>