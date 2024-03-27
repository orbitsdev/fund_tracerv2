<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">

        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="mt-6">
        <x-authentication-card-logo />
            <div class="flex items-center justify-center mt-6 ">
                    
                <p class="poppins-regular uppercase text-4xl font-bold leading-10 tracking-tight text-primary-600">
                    <span class="relative w-full ">
                        F<span class="absolute top-0 left-0  text-secondary-500">U</span>ND TR<span class="absolute top-0 right-0 mr-1 text-secondary-500">A</span>CER
                    </span>
                </p>
            </div>

            @csrf

            <div class="mt-4">
                <x-label for="email" class="poppins-regular tg6" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full poppins-regular" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"  />
            </div>

            <div class="mt-4">
                <x-label for="password" class="poppins-regular tg6" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full poppins-regular" type="password" name="password" required autocomplete="current-password" />
            </div>

            {{-- <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600 poppins-regular"  >{{ __('Remember me') }}</span>
                </label>
            </div> --}}

            <div class="mt-6">


                <div class="flex items-center justify-end w-full mt-6 ">
                    <x-custom-button type="submit"  class="w-full text-center justify-center poppins-regular">Login</x-custom-button>
                </div>
                {{-- <div class="mt-2">

                    @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                    @endif
                </div> --}}

                <div class="relative mt-6 ">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                      <div class="w-full border-t "></div>
                    </div>
                    <div class="relative flex justify-center text-sm font-medium leading-6">
                      {{-- <span class="bg-white px-6 text-gray-900 poppins-regular tg6">Or continue with</span> --}}
                    </div>
                  </div>
{{-- 
                <div class="poppins-regular mt-6 grid grid-cols-1 gap-4  rounded-lg ">
                    <a href="#" class="flex w-full items-center justify-center gap-3 rounded-md   px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-100 focus-visible:ring-transparent ">
                      <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12.0003 4.75C13.7703 4.75 15.3553 5.36002 16.6053 6.54998L20.0303 3.125C17.9502 1.19 15.2353 0 12.0003 0C7.31028 0 3.25527 2.69 1.28027 6.60998L5.27028 9.70498C6.21525 6.86002 8.87028 4.75 12.0003 4.75Z" fill="#EA4335" />
                        <path d="M23.49 12.275C23.49 11.49 23.415 10.73 23.3 10H12V14.51H18.47C18.18 15.99 17.34 17.25 16.08 18.1L19.945 21.1C22.2 19.01 23.49 15.92 23.49 12.275Z" fill="#4285F4" />
                        <path d="M5.26498 14.2949C5.02498 13.5699 4.88501 12.7999 4.88501 11.9999C4.88501 11.1999 5.01998 10.4299 5.26498 9.7049L1.275 6.60986C0.46 8.22986 0 10.0599 0 11.9999C0 13.9399 0.46 15.7699 1.28 17.3899L5.26498 14.2949Z" fill="#FBBC05" />
                        <path d="M12.0004 24.0001C15.2404 24.0001 17.9654 22.935 19.9454 21.095L16.0804 18.095C15.0054 18.82 13.6204 19.245 12.0004 19.245C8.8704 19.245 6.21537 17.135 5.2654 14.29L1.27539 17.385C3.25539 21.31 7.3104 24.0001 12.0004 24.0001Z" fill="#34A853" />
                      </svg>
                      <span class="text-sm font-semibold leading-6 poppins-regular">Google</span>
                    </a>


                  </div> --}}
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
