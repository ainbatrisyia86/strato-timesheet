<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input 
            id="name" 
            class="block mt-1 w-full" 
            type="text" 
            style="background-color:#F3F3F3;"
            name="name" 
            :value="old('name')" 
            required 
            autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input 
            id="email" 
            class="block mt-1 w-full" 
            style="background-color:#F3F3F3;"
            type="email" 
            name="email" 
            :value="old('email')" 
            required 
            autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

       <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div style="position: relative;">
                <x-text-input
                    id="password"
                    class="block mt-1 w-full pr-10"
                    style="background-color:#F3F3F3;"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                />

                <!-- Eye icon button -->
                <span id="toggle-password" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); cursor:pointer; opacity:0.6;">
                    <!-- Eye open -->
                    <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5
                            c4.478 0 8.268 2.943 9.542 7
                            -1.274 4.057-5.064 7-9.542 7
                            -4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>

                    <!-- Eye closed -->
                    <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20" style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19 c-4.478 0-8.268-2.943-9.543-7 a9.97 9.97 0 012.188-3.264"/>
                    </svg>
                </span>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <div style="position: relative;">
                <x-text-input
                    id="password_confirmation"
                    class="block mt-1 w-full pr-10"
                    style="background-color:#F3F3F3;"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <!-- Eye icon button -->
                <span id="toggle-password-confirm" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); cursor:pointer; opacity:0.6;">
                    <!-- Eye open -->
                    <svg id="eye-open-confirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5
                            c4.478 0 8.268 2.943 9.542 7
                            -1.274 4.057-5.064 7-9.542 7
                            -4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>

                    <!-- Eye closed -->
                    <svg id="eye-closed-confirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20" style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19 c-4.478 0-8.268-2.943-9.543-7 a9.97 9.97 0 012.188-3.264"/>
                    </svg>
                </span>
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>


            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 " href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function setupEyeToggle(inputId, toggleId, eyeOpenId, eyeClosedId) {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(toggleId);
            const eyeOpen = document.getElementById(eyeOpenId);
            const eyeClosed = document.getElementById(eyeClosedId);

            toggle.addEventListener('click', () => {
                if (input.type === 'password') {
                    input.type = 'text';
                    eyeOpen.style.display = 'none';
                    eyeClosed.style.display = 'block';
                } else {
                    input.type = 'password';
                    eyeOpen.style.display = 'block';
                    eyeClosed.style.display = 'none';
                }
            });
        }

        // Initialize toggles
        setupEyeToggle('password', 'toggle-password', 'eye-open', 'eye-closed');
        setupEyeToggle('password_confirmation', 'toggle-password-confirm', 'eye-open-confirm', 'eye-closed-confirm');
    </script>



</x-guest-layout>
