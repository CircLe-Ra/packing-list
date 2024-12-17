<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
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
    <div class="navbar bg-base-300">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg x-cloak xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                    <li>
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <rect width="24" height="24" fill="none" />
                                <path fill="currentColor"
                                    d="M19 5v2h-4V5zM9 5v6H5V5zm10 8v6h-4v-6zM9 17v2H5v-2zM21 3h-8v6h8zM11 3H3v10h8zm10 8h-8v10h8zm-10 4H3v6h8z" />
                            </svg>
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    </li>
                    @role('admin')
                    <li>
                        <details class="{{ request()->routeIs('master-data.*') ? 'font-bold bg-neutral text-neutral-content rounded-lg' : '' }}">
                            <summary>
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <rect width="24" height="24" fill="none" />
                                    <path fill="currentColor"
                                          d="M6 12.45V9.64c1.47.83 3.61 1.36 6 1.36s4.53-.53 6-1.36v1.41c.17-.02.33-.05.5-.05c.53 0 1.03.1 1.5.26V7c0-2.21-3.58-4-8-4S4 4.79 4 7v10c0 2.21 3.59 4 8 4c.34 0 .67 0 1-.03v-2.02c-.32.05-.65.05-1 .05c-3.87 0-6-1.5-6-2v-2.23c1.61.78 3.72 1.23 6 1.23c.41 0 .81-.03 1.21-.06c.19-.48.47-.91.86-1.24c.06-.31.16-.61.27-.9c-.74.13-1.53.2-2.34.2c-2.42 0-4.7-.6-6-1.55M12 5c3.87 0 6 1.5 6 2s-2.13 2-6 2s-6-1.5-6-2s2.13-2 6-2m9 11v-.5a2.5 2.5 0 0 0-5 0v.5c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1h5c.55 0 1-.45 1-1v-4c0-.55-.45-1-1-1m-1 0h-3v-.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5z" />
                                </svg> Master Data
                            </summary>
                            <ul class="w-40 p-2">
                                <li>
                                    <x-nav-link :href="route('master-data.consumer')" :active="request()->routeIs('master-data.consumer*')" wire:navigate>
                                        {{ __('Data Consumers') }}
                                    </x-nav-link>

                                </li>
                                <li>
                                    <x-nav-link :href="route('master-data.driver')" :active="request()->routeIs('master-data.driver*')" wire:navigate>
                                        {{ __('Data Drivers') }}
                                    </x-nav-link>
                                </li>
                                <li>
                                    <x-nav-link :href="route('master-data.container')" :active="request()->routeIs('master-data.container*')" wire:navigate>
                                        {{ __('Data Containers') }}
                                    </x-nav-link>
                                </li>
                                <li>
                                    <x-nav-link :href="route('master-data.user')" :active="request()->routeIs('master-data.user*')" wire:navigate>
                                        {{ __('User Management') }}
                                    </x-nav-link>
                                </li>
                                <li>
                                    <x-nav-link :href="route('master-data.role')" :active="request()->routeIs('master-data.role*')" wire:navigate>
                                        {{ __('Role Management') }}
                                    </x-nav-link>
                                </li>
                            </ul>
                        </details>
                    </li>
                    <li>
                        <x-nav-link :href="route('shipments')" :active="request()->routeIs('shipments*')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 14 14">
                                <rect width="14" height="14" fill="none" />
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M7 .5v4m-6.5 0h13v8a1 1 0 0 1-1 1h-11a1 1 0 0 1-1-1z" />
                                    <path d="M.5 4.5L2 1.61A2 2 0 0 1 3.74.5h6.52a2 2 0 0 1 1.79 1.11L13.5 4.5M7 11.346V6.734m1.75 1.721L7 6.705l-1.75 1.75" />
                                </g>
                            </svg>
                            {{ __('Shipments') }}
                        </x-nav-link>
                    </li>
                    <li>
                        <details class="{{ request()->routeIs('submissions.admin.*') ? 'font-bold bg-neutral text-neutral-content rounded-lg' : '' }}">
                            <summary>
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <rect width="24" height="24" fill="none" />
                                    <path fill="currentColor" d="M2 20V4h20v16zm2-2h16V8H4zm6.95-1.45L7.4 13l1.45-1.45l2.1 2.1l4.2-4.2l1.45 1.45zM4 18V6z" />
                                </svg>
                                {{ __('Verification')}}
                            </summary>
                            <ul class="w-40 p-2">
                                <li>
                                    <x-nav-link :href="route('submissions.admin.verify')" :active="request()->routeIs('submissions.admin.verify*')" wire:navigate>
                                        {{ __('Delivery Order') }}
                                    </x-nav-link>
                                </li>
                            </ul>
                        </details>
                    </li>
                    @endrole
                    @role('fieldagen')
                    <li>
                        <x-nav-link :href="route('distribution')" :active="request()->routeIs('distribution*')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                <rect width="16" height="16" fill="none" />
                                <path fill="currentColor" fill-rule="evenodd" d="M3 2h7v2h3.25L15 6.333V12.5h-1.063a2 2 0 0 1-3.874 0H5.437a2 2 0 1 1 0-1h4.626a2 2 0 0 1 3.874 0H14V7H9V3H3zm3.5 4H2V5h4.5zm-1 3H1V8h4.5zm-2 2a1 1 0 1 0 0 2a1 1 0 0 0 0-2m8.5 0a1 1 0 1 0 0 2a1 1 0 0 0 0-2" clip-rule="evenodd" />
                            </svg>
                            {{ __('Distribution') }}
                        </x-nav-link>
                    </li>
                    <li>
                        <details class="{{ request()->routeIs('submissions.delivery*') ? 'font-bold bg-neutral text-neutral-content rounded-lg' : '' }}">
                            <summary>
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <rect width="24" height="24" fill="none" />
                                    <path fill="currentColor" d="M15.25 18.75q.3 0 .525-.225T16 18t-.225-.525t-.525-.225t-.525.225T14.5 18t.225.525t.525.225m2.75 0q.3 0 .525-.225T18.75 18t-.225-.525T18 17.25t-.525.225t-.225.525t.225.525t.525.225m2.75 0q.3 0 .525-.225T21.5 18t-.225-.525t-.525-.225t-.525.225T20 18t.225.525t.525.225M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v6.7q-.475-.225-.975-.387T19 11.075V5H5v14h6.05q.075.55.238 1.05t.387.95zm0-3v1V5v6.075V11zm2-1h4.075q.075-.525.238-1.025t.362-.975H7zm0-4h6.1q.8-.75 1.788-1.25T17 11.075V11H7zm0-4h10V7H7zm11 14q-2.075 0-3.537-1.463T13 18t1.463-3.537T18 13t3.538 1.463T23 18t-1.463 3.538T18 23" />
                                </svg>
                                {{ __ ('Submissions')}}
                            </summary>
                            <ul class="w-40 p-2">
                                <li>
                                    <x-nav-link :href="route('submissions.delivery-order')" :active="request()->routeIs('submissions.delivery-order*')" wire:navigate>
                                        {{ __('Delivery Order') }}
                                    </x-nav-link>
                                </li>
                            </ul>
                        </details>
                    </li>
                    @endrole
                    @role('driver')
                    <li>
                        <x-nav-link :href="route('driver.deliveries')" :active="request()->routeIs('driver*')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M7.5 2h14v9.5h-2V4h-2v5.618l-3-1.5l-3 1.5V4h-2v5.5h-2zm6 2v2.382l1-.5l1 .5V4zm-5.065 9.25a1.25 1.25 0 0 0-.885.364l-2.05 2.05V19.5h5.627l5.803-1.45l3.532-1.508a.555.555 0 0 0-.416-1.022l-.02.005L13.614 17H10v-2h3.125a.875.875 0 1 0 0-1.75zm7.552 1.152l3.552-.817a2.56 2.56 0 0 1 3.211 2.47a2.56 2.56 0 0 1-1.414 2.287l-.027.014l-3.74 1.595l-6.196 1.549H0v-7.25h4.086l2.052-2.052a3.25 3.25 0 0 1 2.3-.948h.002h-.002h4.687a2.875 2.875 0 0 1 2.862 3.152M3.5 16.25H2v3.25h1.5z"/></svg>
                            {{ __('Delivery') }}
                        </x-nav-link>
                    </li>
                    @endrole
                    @role('leader')
                    <li>
                        <x-nav-link :href="route('report')" :active="request()->routeIs('report*')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path fill="currentColor" d="M10 18h8v2h-8zm0-5h12v2H10zm0 10h5v2h-5z"/><path fill="currentColor" d="M25 5h-3V4a2 2 0 0 0-2-2h-8a2 2 0 0 0-2 2v1H7a2 2 0 0 0-2 2v21a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2M12 4h8v4h-8Zm13 24H7V7h3v3h12V7h3Z"/></svg>
                            {{ __('Reports') }}
                        </x-nav-link>
                    </li>
                    @endrole
                </ul>
            </div>
            <a class="text-xl btn btn-ghost" x-cloak>Packing-List</a>
        </div>
        <div class="z-50 hidden navbar-center lg:flex">
            <ul class="px-1 menu menu-horizontal ">
                <li>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <rect width="24" height="24" fill="none" />
                            <path fill="currentColor"
                                d="M19 5v2h-4V5zM9 5v6H5V5zm10 8v6h-4v-6zM9 17v2H5v-2zM21 3h-8v6h8zM11 3H3v10h8zm10 8h-8v10h8zm-10 4H3v6h8z" />
                        </svg>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </li>
                @role('admin')
                <li>
                    <details class="{{ request()->routeIs('master-data.*') ? 'font-bold bg-neutral text-neutral-content rounded-lg' : '' }}">
                        <summary>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <rect width="24" height="24" fill="none" />
                                <path fill="currentColor"
                                    d="M6 12.45V9.64c1.47.83 3.61 1.36 6 1.36s4.53-.53 6-1.36v1.41c.17-.02.33-.05.5-.05c.53 0 1.03.1 1.5.26V7c0-2.21-3.58-4-8-4S4 4.79 4 7v10c0 2.21 3.59 4 8 4c.34 0 .67 0 1-.03v-2.02c-.32.05-.65.05-1 .05c-3.87 0-6-1.5-6-2v-2.23c1.61.78 3.72 1.23 6 1.23c.41 0 .81-.03 1.21-.06c.19-.48.47-.91.86-1.24c.06-.31.16-.61.27-.9c-.74.13-1.53.2-2.34.2c-2.42 0-4.7-.6-6-1.55M12 5c3.87 0 6 1.5 6 2s-2.13 2-6 2s-6-1.5-6-2s2.13-2 6-2m9 11v-.5a2.5 2.5 0 0 0-5 0v.5c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1h5c.55 0 1-.45 1-1v-4c0-.55-.45-1-1-1m-1 0h-3v-.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5z" />
                            </svg> Master Data
                        </summary>
                        <ul class="w-40 p-2">
                            <li>
                                <x-nav-link :href="route('master-data.consumer')" :active="request()->routeIs('master-data.consumer*')" wire:navigate>
                                    {{ __('Data Consumers') }}
                                </x-nav-link>

                            </li>
                            <li>
                                <x-nav-link :href="route('master-data.driver')" :active="request()->routeIs('master-data.driver*')" wire:navigate>
                                    {{ __('Data Drivers') }}
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('master-data.container')" :active="request()->routeIs('master-data.container*')" wire:navigate>
                                    {{ __('Data Containers') }}
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('master-data.user')" :active="request()->routeIs('master-data.user*')" wire:navigate>
                                    {{ __('User Management') }}
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('master-data.role')" :active="request()->routeIs('master-data.role*')" wire:navigate>
                                    {{ __('Role Management') }}
                                </x-nav-link>
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <x-nav-link :href="route('shipments')" :active="request()->routeIs('shipments*')" wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 14 14">
                            <rect width="14" height="14" fill="none" />
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M7 .5v4m-6.5 0h13v8a1 1 0 0 1-1 1h-11a1 1 0 0 1-1-1z" />
                                <path d="M.5 4.5L2 1.61A2 2 0 0 1 3.74.5h6.52a2 2 0 0 1 1.79 1.11L13.5 4.5M7 11.346V6.734m1.75 1.721L7 6.705l-1.75 1.75" />
                            </g>
                        </svg>
                        {{ __('Shipments') }}
                    </x-nav-link>
                </li>
                <li>
                    <details class="{{ request()->routeIs('submissions.admin.*') ? 'font-bold bg-neutral text-neutral-content rounded-lg' : '' }}">
                        <summary>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <rect width="24" height="24" fill="none" />
                                <path fill="currentColor" d="M2 20V4h20v16zm2-2h16V8H4zm6.95-1.45L7.4 13l1.45-1.45l2.1 2.1l4.2-4.2l1.45 1.45zM4 18V6z" />
                            </svg>
                            {{ __('Verification')}}
                        </summary>
                        <ul class="w-40 p-2">
                            <li>
                                <x-nav-link :href="route('submissions.admin.verify')" :active="request()->routeIs('submissions.admin.verify*')" wire:navigate>
                                    {{ __('Delivery Order') }}
                                </x-nav-link>
                            </li>
                        </ul>
                    </details>
                </li>
                @endrole
                @role('fieldagen')
                <li>
                    <x-nav-link :href="route('distribution')" :active="request()->routeIs('distribution*')" wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                            <rect width="16" height="16" fill="none" />
                            <path fill="currentColor" fill-rule="evenodd" d="M3 2h7v2h3.25L15 6.333V12.5h-1.063a2 2 0 0 1-3.874 0H5.437a2 2 0 1 1 0-1h4.626a2 2 0 0 1 3.874 0H14V7H9V3H3zm3.5 4H2V5h4.5zm-1 3H1V8h4.5zm-2 2a1 1 0 1 0 0 2a1 1 0 0 0 0-2m8.5 0a1 1 0 1 0 0 2a1 1 0 0 0 0-2" clip-rule="evenodd" />
                        </svg>
                        {{ __('Distribution') }}
                    </x-nav-link>
                </li>

                <li>
                    <details class="{{ request()->routeIs('submissions.delivery*') ? 'font-bold bg-neutral text-neutral-content rounded-lg' : '' }}">
                        <summary>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <rect width="24" height="24" fill="none" />
                                <path fill="currentColor" d="M15.25 18.75q.3 0 .525-.225T16 18t-.225-.525t-.525-.225t-.525.225T14.5 18t.225.525t.525.225m2.75 0q.3 0 .525-.225T18.75 18t-.225-.525T18 17.25t-.525.225t-.225.525t.225.525t.525.225m2.75 0q.3 0 .525-.225T21.5 18t-.225-.525t-.525-.225t-.525.225T20 18t.225.525t.525.225M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v6.7q-.475-.225-.975-.387T19 11.075V5H5v14h6.05q.075.55.238 1.05t.387.95zm0-3v1V5v6.075V11zm2-1h4.075q.075-.525.238-1.025t.362-.975H7zm0-4h6.1q.8-.75 1.788-1.25T17 11.075V11H7zm0-4h10V7H7zm11 14q-2.075 0-3.537-1.463T13 18t1.463-3.537T18 13t3.538 1.463T23 18t-1.463 3.538T18 23" />
                            </svg>
                            {{ __ ('Submissions')}}
                        </summary>
                        <ul class="w-40 p-2">
                            <li>
                                <x-nav-link :href="route('submissions.delivery-order')" :active="request()->routeIs('submissions.delivery-order*')" wire:navigate>
                                    {{ __('Delivery Order') }}
                                </x-nav-link>
                            </li>
                        </ul>
                    </details>
                </li>
                @endrole
                @role('driver')
                <li>
                    <x-nav-link :href="route('driver.deliveries')" :active="request()->routeIs('driver*')" wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M7.5 2h14v9.5h-2V4h-2v5.618l-3-1.5l-3 1.5V4h-2v5.5h-2zm6 2v2.382l1-.5l1 .5V4zm-5.065 9.25a1.25 1.25 0 0 0-.885.364l-2.05 2.05V19.5h5.627l5.803-1.45l3.532-1.508a.555.555 0 0 0-.416-1.022l-.02.005L13.614 17H10v-2h3.125a.875.875 0 1 0 0-1.75zm7.552 1.152l3.552-.817a2.56 2.56 0 0 1 3.211 2.47a2.56 2.56 0 0 1-1.414 2.287l-.027.014l-3.74 1.595l-6.196 1.549H0v-7.25h4.086l2.052-2.052a3.25 3.25 0 0 1 2.3-.948h.002h-.002h4.687a2.875 2.875 0 0 1 2.862 3.152M3.5 16.25H2v3.25h1.5z"/></svg>
                        {{ __('Delivery') }}
                    </x-nav-link>
                </li>
                @endrole
                @role('leader')
                <li>
                    <x-nav-link :href="route('report')" :active="request()->routeIs('report*')" wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path fill="currentColor" d="M10 18h8v2h-8zm0-5h12v2H10zm0 10h5v2h-5z"/><path fill="currentColor" d="M25 5h-3V4a2 2 0 0 0-2-2h-8a2 2 0 0 0-2 2v1H7a2 2 0 0 0-2 2v21a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2M12 4h8v4h-8Zm13 24H7V7h3v3h12V7h3Z"/></svg>
                        {{ __('Reports') }}
                    </x-nav-link>
                </li>
                @endrole
            </ul>
        </div>
        <div class="navbar-end">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="m-1 bg-transparent border-0 shadow-none btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                        <rect width="24" height="24" fill="none" />
                        <path fill="currentColor"
                            d="M7.5 2c-1.79 1.15-3 3.18-3 5.5s1.21 4.35 3.03 5.5C4.46 13 2 10.54 2 7.5A5.5 5.5 0 0 1 7.5 2m11.57 1.5l1.43 1.43L4.93 20.5L3.5 19.07zm-6.18 2.43L11.41 5L9.97 6l.42-1.7L9 3.24l1.75-.12l.58-1.65L12 3.1l1.73.03l-1.35 1.13zm-3.3 3.61l-1.16-.73l-1.12.78l.34-1.32l-1.09-.83l1.36-.09l.45-1.29l.51 1.27l1.36.03l-1.05.87zM19 13.5a5.5 5.5 0 0 1-5.5 5.5c-1.22 0-2.35-.4-3.26-1.07l7.69-7.69c.67.91 1.07 2.04 1.07 3.26m-4.4 6.58l2.77-1.15l-.24 3.35zm4.33-2.7l1.15-2.77l2.2 2.54zm1.15-4.96l-1.14-2.78l3.34.24zM9.63 18.93l2.77 1.15l-2.53 2.19z" />
                    </svg>
                    <svg width="12px" height="12px" class="inline-block w-2 h-2 fill-current opacity-60"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2048 2048">
                        <path d="M1799 349l242 241-1017 1017L7 590l242-241 775 775 775-775z"></path>
                    </svg>
                </div>
                <ul tabindex="0"
                    class="dropdown-content bg-base-300 rounded-box z-[1] w-52 p-2 shadow-2xl max-h-60 overflow-y-auto">
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Light"
                            value="light" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Dark"
                            value="dark" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Cupcake"
                            value="cupcake" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                            aria-label="Bumblebee" value="bumblebee" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Emerald"
                            value="emerald" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                            aria-label="Corporate" value="corporate" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                            aria-label="Synthwave" value="synthwave" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                            aria-label="Halloween" value="halloween" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Garden"
                            value="garden" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Forest"
                            value="forest" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Lofi"
                            value="lofi" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Pastel"
                            value="pastel" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Fantasy"
                            value="fantasy" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                            aria-label="Wireframe" value="wireframe" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Black"
                            value="black" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Luxury"
                            value="luxury" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Dracula"
                            value="dracula" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="CMYK"
                            value="cmyk" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Autumn"
                            value="autumn" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                            aria-label="Business" value="business" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Acid"
                            value="acid" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost"
                            aria-label="Lemonade" value="lemonade" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Night"
                            value="night" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Coffee"
                            value="coffee" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Winter"
                            value="winter" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Dim"
                            value="dim" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Nord"
                            value="nord" />
                    </li>
                    <li>
                        <input type="radio" name="theme-dropdown"
                            class="justify-start theme-controller btn btn-sm btn-block btn-ghost" aria-label="Sunset"
                            value="sunset" />
                    </li>

                </ul>
            </div>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img x-data="{{ json_encode(['profile_photo_path' => auth()->user()->profile_photo_path, 'name' => auth()->user()->name]) }}" x-on:refresh-image.window="profile_photo_path = $event.detail.path"
                            alt="Tailwind CSS Navbar component"
                             x-bind:src="profile_photo_path ? '/storage/' + profile_photo_path : 'https://ui-avatars.com/api/?name=' + name" />
                    </div>
                </div>
                <ul
                    tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow-xl">
                    <li class="my-1">
                        <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                    </li>
                    <li class="my-1">
                        <a href="{{route('profile')}}" wire:navigate>
                            {{ __('Profile') }}
                        </a>
                    </li>
                    <li class="my-1">
                        <button wire:click="logout" >
                            {{ __('Log Out') }}
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</nav>

