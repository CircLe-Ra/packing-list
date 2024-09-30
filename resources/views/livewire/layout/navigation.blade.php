<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav>
    <!-- Primary Navigation Menu -->
    {{-- <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block w-auto text-gray-800 fill-current h-9" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div> --}}

    <!-- Responsive Navigation Menu -->
    {{-- <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div> --}}

    <div class="navbar bg-base-300">
        <div class="navbar-start">
          <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h8m-8 6h16" />
              </svg>
            </div>
            <ul
              tabindex="0"
              class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
              <li>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <rect width="24" height="24" fill="none" />
                            <path fill="currentColor" d="M19 5v2h-4V5zM9 5v6H5V5zm10 8v6h-4v-6zM9 17v2H5v-2zM21 3h-8v6h8zM11 3H3v10h8zm10 8h-8v10h8zm-10 4H3v6h8z" />
                        </svg>
                    {{ __('Dashboard') }}
                </x-nav-link>
            </li>
              <li>
                <a><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <rect width="24" height="24" fill="none" />
                        <path fill="currentColor" d="M6 12.45V9.64c1.47.83 3.61 1.36 6 1.36s4.53-.53 6-1.36v1.41c.17-.02.33-.05.5-.05c.53 0 1.03.1 1.5.26V7c0-2.21-3.58-4-8-4S4 4.79 4 7v10c0 2.21 3.59 4 8 4c.34 0 .67 0 1-.03v-2.02c-.32.05-.65.05-1 .05c-3.87 0-6-1.5-6-2v-2.23c1.61.78 3.72 1.23 6 1.23c.41 0 .81-.03 1.21-.06c.19-.48.47-.91.86-1.24c.06-.31.16-.61.27-.9c-.74.13-1.53.2-2.34.2c-2.42 0-4.7-.6-6-1.55M12 5c3.87 0 6 1.5 6 2s-2.13 2-6 2s-6-1.5-6-2s2.13-2 6-2m9 11v-.5a2.5 2.5 0 0 0-5 0v.5c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1h5c.55 0 1-.45 1-1v-4c0-.55-.45-1-1-1m-1 0h-3v-.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5z" />
                    </svg>
                    Master Data</a>
                <ul class="p-2">
                  <li><a href="{{ route('master-data.consumer') }}" wire:navigate>Data Konsumen</a></li>
                  <li><a href="{{ route('master-data.driver') }}"  wire:navigate>Data Sopir</a></li>
                  <li><a href="{{ route('master-data.container') }}"  wire:navigate>Data Kontainer</a></li>
                </ul>
              </li>
              <li><a>Item 3</a></li>
            </ul>
          </div>
          <a class="text-xl btn btn-ghost">daisyUI</a>
        </div>
        <div class="z-50 hidden navbar-center lg:flex">
          <ul class="px-1 menu menu-horizontal ">
            <li >
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate >
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <rect width="24" height="24" fill="none" />
                        <path fill="currentColor" d="M19 5v2h-4V5zM9 5v6H5V5zm10 8v6h-4v-6zM9 17v2H5v-2zM21 3h-8v6h8zM11 3H3v10h8zm10 8h-8v10h8zm-10 4H3v6h8z" />
                    </svg>
                {{ __('Dashboard') }}
            </x-nav-link>
        </li>
            <li>
              <details class="{{ request()->routeIs('master-data.*') ? 'font-bold' : '' }}">
                <summary>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <rect width="24" height="24" fill="none" />
                        <path fill="currentColor" d="M6 12.45V9.64c1.47.83 3.61 1.36 6 1.36s4.53-.53 6-1.36v1.41c.17-.02.33-.05.5-.05c.53 0 1.03.1 1.5.26V7c0-2.21-3.58-4-8-4S4 4.79 4 7v10c0 2.21 3.59 4 8 4c.34 0 .67 0 1-.03v-2.02c-.32.05-.65.05-1 .05c-3.87 0-6-1.5-6-2v-2.23c1.61.78 3.72 1.23 6 1.23c.41 0 .81-.03 1.21-.06c.19-.48.47-.91.86-1.24c.06-.31.16-.61.27-.9c-.74.13-1.53.2-2.34.2c-2.42 0-4.7-.6-6-1.55M12 5c3.87 0 6 1.5 6 2s-2.13 2-6 2s-6-1.5-6-2s2.13-2 6-2m9 11v-.5a2.5 2.5 0 0 0-5 0v.5c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1h5c.55 0 1-.45 1-1v-4c0-.55-.45-1-1-1m-1 0h-3v-.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5z" />
                    </svg> Master Data
                </summary>
                <ul class="w-40 p-2">
                    <li><a href="{{ route('master-data.consumer') }}" wire:navigate>Data Konsumen</a></li>
                  <li><a href="{{ route('master-data.driver') }}"  wire:navigate>Data Sopir</a></li>
                  <li><a href="{{ route('master-data.container') }}"  wire:navigate>Data Kontainer</a></li>
                </ul>
              </details>
            </li>
            <li><a>Item 3</a></li>
          </ul>
        </div>
            <div class="navbar-end">
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="m-1 bg-transparent border-0 shadow-none btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                            <rect width="24" height="24" fill="none" />
                            <path fill="currentColor" d="M7.5 2c-1.79 1.15-3 3.18-3 5.5s1.21 4.35 3.03 5.5C4.46 13 2 10.54 2 7.5A5.5 5.5 0 0 1 7.5 2m11.57 1.5l1.43 1.43L4.93 20.5L3.5 19.07zm-6.18 2.43L11.41 5L9.97 6l.42-1.7L9 3.24l1.75-.12l.58-1.65L12 3.1l1.73.03l-1.35 1.13zm-3.3 3.61l-1.16-.73l-1.12.78l.34-1.32l-1.09-.83l1.36-.09l.45-1.29l.51 1.27l1.36.03l-1.05.87zM19 13.5a5.5 5.5 0 0 1-5.5 5.5c-1.22 0-2.35-.4-3.26-1.07l7.69-7.69c.67.91 1.07 2.04 1.07 3.26m-4.4 6.58l2.77-1.15l-.24 3.35zm4.33-2.7l1.15-2.77l2.2 2.54zm1.15-4.96l-1.14-2.78l3.34.24zM9.63 18.93l2.77 1.15l-2.53 2.19z" />
                        </svg>
                        <svg
                            width="12px"
                            height="12px"
                            class="inline-block w-2 h-2 fill-current opacity-60"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 2048 2048">
                            <path d="M1799 349l242 241-1017 1017L7 590l242-241 775 775 775-775z"></path>
                        </svg>
                        </div>
                        <ul tabindex="0" class="dropdown-content bg-base-300 rounded-box z-[1] w-52 p-2 shadow-2xl max-h-60 overflow-y-auto">
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Light"
                                value="light" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Dark"
                                value="dark" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Cupcake"
                                value="cupcake" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Bumblebee"
                                value="bumblebee" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Emerald"
                                value="emerald" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Corporate"
                                value="corporate" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Synthwave"
                                value="synthwave" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Halloween"
                                value="halloween" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Garden"
                                value="garden" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Forest"
                                value="forest" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Lofi"
                                value="lofi" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Pastel"
                                value="pastel" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Fantasy"
                                value="fantasy" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Wireframe"
                                value="wireframe" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Black"
                                value="black" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Luxury"
                                value="luxury" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Dracula"
                                value="dracula" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="CMYK"
                                value="cmyk" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Autumn"
                                value="autumn" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Business"
                                value="business" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Acid"
                                value="acid" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Lemonade"
                                value="lemonade" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Night"
                                value="night" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Coffee"
                                value="coffee" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Winter"
                                value="winter" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Dim"
                                value="dim" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Nord"
                                value="nord" />
                            </li>
                            <li>
                                <input
                                type="radio"
                                name="theme-dropdown"
                                class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                                aria-label="Sunset"
                                value="sunset" />
                            </li>

                        </ul>
                </div>
            </div>
        </div>
      </div>


</nav>
