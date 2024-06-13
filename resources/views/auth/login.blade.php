<x-guest-layout>
    <style>
        .text-blue {
            color:  #035ba4; /* Warna biru */
        }
        .bg-blue {
            background-color:  #035ba4; /* Warna biru */
        }
        .border-blue {
            border-color:  #035ba4; /* Warna biru */
        }
    </style>

    <!-- Status Sesi -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="p-8 rounded-md shadow-md">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-blue text-sm font-bold mb-2">{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full border-gray-300 p-2 rounded text-blue" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-blue text-sm font-bold mb-2">{{ __('Password') }}</label>
            <input id="password" class="block mt-1 w-full border-gray-300 p-2 rounded text-blue"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue shadow-sm focus:ring focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-blue">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mb-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-blue hover:text-blue-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit" class="ms-3 bg-blue hover:bg-blue-800 text-white py-2 px-4 rounded">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</x-guest-layout>
