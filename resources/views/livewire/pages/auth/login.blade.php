<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <x-auth-session-status class="mb-4" :status="session('status')" />
        <div>
            <h1 class="text-2xl font-semibold mb-4 text-center">Login</h1>
        </div>
        <div class="divide-y divide-gray-200">
        <form wire:submit="login" class="">
            <!-- Email Address -->
            <div>
                <x-text-input-4 :title="__('Email')" wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('form.email')" />
            </div>

            <!-- Password -->
            <div x-data="{ show: false }" class="relative mt-4">
                <!-- Input field -->
                <input
                    :type="show ? 'text' : 'password'"
                    class="input input-bordered w-full"
                    id="password"
                    name="password"
                    wire:model="form.password"
                    required
                    autocomplete="current-password"
                />

                <!-- Toggle button -->
                <button
                    type="button"
                    @click="show = !show"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 "
                >
                    <span x-text="show ? 'Hide' : 'Show'" class="text-gray-500 cursor-pointer"></span>
                </button>
            </div>


            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember" class="inline-flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
{{--                @if (Route::has('password.request'))--}}
{{--                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>--}}
{{--                        {{ __('Forgot your password?') }}--}}
{{--                    </a>--}}
{{--                @endif--}}

                <x-primary-button class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
</div>
</div>
