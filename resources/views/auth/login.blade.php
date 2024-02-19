<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="">
                <x-label for="email" class="poppins-regular" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full poppins-regular" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"  />
            </div>

            <div class="mt-4">
                <x-label for="password" class="poppins-regular" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full poppins-regular" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600 poppins-regular"  >{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="">


                <div class="flex items-center justify-end w-full mt-2 ">
                    <x-custom-button type="submit"  class="w-full text-center justify-center poppins-regular">Login</x-custom-button>
                </div>
                {{-- <div class="mt-2">

                    @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                    @endif
                </div> --}}
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
