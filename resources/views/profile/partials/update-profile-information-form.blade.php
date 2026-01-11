<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Your account profile information and email address.") }}
        </p>
    </header>

    <!-- Email verification form (keep this) -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Name -->
    <div class="mt-6">
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input
            id="name"
            type="text"
            class="mt-1 block w-full bg-white cursor-not-allowed"
            :value="$user->name"
            readonly
        />
    </div>

    <!-- Email -->
    <div class="mt-6">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input
            id="email"
            type="email"
            class="mt-1 block w-full bg-white cursor-not-allowed"
            :value="$user->email"
            readonly
        />

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <button
                        form="send-verification"
                        class="underline text-sm text-gray-600 hover:text-gray-900"
                    >
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    <!-- Position -->
    <div class="mt-6">
        <x-input-label for="position" :value="__('Position')" />
        <x-text-input
            id="position"
            type="text"
            class="mt-1 block w-full bg-white cursor-not-allowed"
            :value="$user->position"
            readonly
        />
    </div>

    <!-- Department -->
    <div class="mt-6">
        <x-input-label for="department" :value="__('Department')" />
        <x-text-input
            id="department"
            type="text"
            class="mt-1 block w-full bg-white cursor-not-allowed"
            :value="$user->department"
            readonly
        />
    </div>
</section>
