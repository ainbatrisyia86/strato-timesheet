<section>

    {{-- Email verification form (keep this for logic) --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-500 ml-1" />

            <div class="relative mt-1">
                <input id="name" type="text" 
                    class="block w-full border-transparent text-black cursor-not-allowed rounded-md pr-10 focus:ring-0 focus:border-transparent shadow-none ring-0" 
                    style="background-color: #DCDCDC;"
                    value="{{ $user->name }}" 
                    readonly>
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-500 ml-1" />
            <div class="relative mt-1">
                <input id="email" type="email" 
                    class="block w-full border-transparent bg-gray-200/50 text-black cursor-not-allowed rounded-md pr-10 focus:ring-0 focus:border-transparent shadow-none ring-0" 
                    style="background-color: #DCDCDC;"
                    value="{{ $user->email }}" 
                    readonly>
            </div>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900">
                            {{ __('Click here to re-send verification.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="position" :value="__('Position')" class="text-gray-500 ml-1" />
            <div class="relative mt-1">
                <input id="position" type="text" 
                    class="block w-full border-transparent bg-gray-200/50 text-black cursor-not-allowed rounded-md pr-10 focus:ring-0 focus:border-transparent shadow-none ring-0" 
                    style="background-color: #DCDCDC;"
                    value="{{ $user->position ?? 'Not Assigned' }}" 
                    readonly>
            </div>
        </div>

        <div>
            <x-input-label for="department" :value="__('Department')" class="text-gray-500 ml-1" />
            <div class="relative mt-1">
                <input id="department" type="text" 
                    class="block w-full border-transparent bg-gray-200/50 text-black cursor-not-allowed rounded-md pr-10 focus:ring-0 focus:border-transparent shadow-none ring-0" 
                    style="background-color: #DCDCDC;"
                    value="{{ $user->department ?? 'Not Assigned' }}" 
                    readonly>
            </div>
        </div>
    </div>
</section>