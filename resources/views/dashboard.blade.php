<x-app-layout>
    <x-slot:title>
        {{ __('Dashboard') }}
    </x-slot>
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="max-h-96  overflow-hidden rounded-lg mb-4">
                <img src="{{ asset('img/gas.png') }}" alt="Welcome Image" class="w-full h-full object-cover" />
            </div>
            <div class="shadow-sm sm:rounded-lg grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-4">
                <div class="p-10 rounded-xl text-base-content bg-base-300 flex justify-between items-center">
                    <div class="font-bold">
                        {{ __('Total Consumers') }}
                        <h1 class="text-2xl ">{{ $totalConsumers ?? '0' }}</h1>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 20 20">
                            <g fill="currentColor">
                                <g opacity="0.2">
                                    <path d="M9.75 7.75a3 3 0 1 1-6 0a3 3 0 0 1 6 0" />
                                    <path fill-rule="evenodd"
                                        d="M6.75 8.75a1 1 0 1 0 0-2a1 1 0 0 0 0 2m0 2a3 3 0 1 0 0-6a3 3 0 0 0 0 6"
                                        clip-rule="evenodd" />
                                    <path fill-rule="evenodd"
                                        d="M6.8 11.5A1.5 1.5 0 0 0 5.3 13v1.5a1 1 0 0 1-2 0V13a3.5 3.5 0 0 1 7 0v.5a1 1 0 1 1-2 0V13a1.5 1.5 0 0 0-1.5-1.5"
                                        clip-rule="evenodd" />
                                    <path d="M12.75 7.75a3 3 0 1 0 6 0a3 3 0 0 0-6 0" />
                                    <path fill-rule="evenodd"
                                        d="M15.75 8.75a1 1 0 1 1 0-2a1 1 0 0 1 0 2m0 2a3 3 0 1 1 0-6a3 3 0 0 1 0 6"
                                        clip-rule="evenodd" />
                                    <path fill-rule="evenodd"
                                        d="M15.7 11.5a1.5 1.5 0 0 1 1.5 1.5v1.5a1 1 0 1 0 2 0V13a3.5 3.5 0 0 0-7 0v.5a1 1 0 1 0 2 0V13a1.5 1.5 0 0 1 1.5-1.5"
                                        clip-rule="evenodd" />
                                    <path fill-rule="evenodd"
                                        d="M11.3 14.25a1.5 1.5 0 0 0-1.5 1.5v1.5a1 1 0 0 1-2 0v-1.5a3.5 3.5 0 0 1 7 0v1.5a1 1 0 1 1-2 0v-1.5a1.5 1.5 0 0 0-1.5-1.5"
                                        clip-rule="evenodd" />
                                    <path d="M14.25 10.5a3 3 0 1 1-6 0a3 3 0 0 1 6 0" />
                                    <path fill-rule="evenodd"
                                        d="M11.25 11.5a1 1 0 1 0 0-2a1 1 0 0 0 0 2m0 2a3 3 0 1 0 0-6a3 3 0 0 0 0 6"
                                        clip-rule="evenodd" />
                                    <path d="M4.25 11.5h5v4h-5zm9 0h5v4h-5z" />
                                    <path d="M9.25 13.5h4l.5 4.75h-5z" />
                                </g>
                                <path fill-rule="evenodd"
                                    d="M5 9a2 2 0 1 0 0-4a2 2 0 0 0 0 4m0 1a3 3 0 1 0 0-6a3 3 0 0 0 0 6"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M3.854 8.896a.5.5 0 0 1 0 .708l-.338.337A3.47 3.47 0 0 0 2.5 12.394v1.856a.5.5 0 1 1-1 0v-1.856a4.47 4.47 0 0 1 1.309-3.16l.337-.338a.5.5 0 0 1 .708 0m11.792-.3a.5.5 0 0 0 0 .708l.338.337A3.47 3.47 0 0 1 17 12.094v2.156a.5.5 0 0 0 1 0v-2.156a4.47 4.47 0 0 0-1.309-3.16l-.337-.338a.5.5 0 0 0-.708 0"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M14 9a2 2 0 1 1 0-4a2 2 0 0 1 0 4m0 1a3 3 0 1 1 0-6a3 3 0 0 1 0 6m-4.5 3.25a2.5 2.5 0 0 0-2.5 2.5v1.3a.5.5 0 0 1-1 0v-1.3a3.5 3.5 0 0 1 7 0v1.3a.5.5 0 1 1-1 0v-1.3a2.5 2.5 0 0 0-2.5-2.5"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M9.5 11.75a2 2 0 1 0 0-4a2 2 0 0 0 0 4m0 1a3 3 0 1 0 0-6a3 3 0 0 0 0 6"
                                    clip-rule="evenodd" />
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="p-10 rounded-xl text-base-content bg-base-300 flex justify-between items-center">
                    <div class="font-bold">
                        {{ __('Total Drivers') }}
                        <h1 class="text-2xl ">{{ $totalDrivers ?? '0' }}</h1>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 48 48">
                            <path fill="currentColor" fill-rule="evenodd"
                                d="M15 9.5c0-.437 4.516-3.5 9-3.5s9 3.063 9 3.5c0 1.56-.166 2.484-.306 2.987c-.093.33-.402.513-.745.513H16.051c-.343 0-.652-.183-.745-.513C15.166 11.984 15 11.06 15 9.5m7.5-.5a1 1 0 1 0 0 2h3a1 1 0 0 0 0-2zm-6.462 10.218c-3.33-1.03-2.49-2.87-1.22-4.218H33.46c1.016 1.298 1.561 3.049-1.51 4.097q.05.445.05.903a8 8 0 1 1-15.962-.782m7.69.782c2.642 0 4.69-.14 6.26-.384q.012.19.012.384a6 6 0 1 1-11.992-.315c1.463.202 3.338.315 5.72.315m8.689 14.6A9.99 9.99 0 0 0 24 30a9.99 9.99 0 0 0-8.42 4.602a2.5 2.5 0 0 0-1.447-1.05l-1.932-.517a2.5 2.5 0 0 0-3.062 1.767L8.363 37.7a2.5 2.5 0 0 0 1.768 3.062l1.931.518A2.5 2.5 0 0 0 14 41.006A1 1 0 0 0 16 41v-1q0-.572.078-1.123l5.204 1.395a3 3 0 0 0 5.436 0l5.204-1.395q.077.551.078 1.123v1a1 1 0 0 0 2 .01c.56.336 1.252.453 1.933.27l1.932-.517a2.5 2.5 0 0 0 1.768-3.062l-.777-2.898a2.5 2.5 0 0 0-3.062-1.767l-1.932.517a2.5 2.5 0 0 0-1.445 1.046m-15.814 2.347A8.01 8.01 0 0 1 23 32.062v4.109a3 3 0 0 0-1.88 1.987zm14.794 0A8.01 8.01 0 0 0 25 32.062v4.109c.904.32 1.61 1.06 1.88 1.987zM24 40a1 1 0 1 0 0-2a1 1 0 0 0 0 2"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="p-10 rounded-xl text-base-content bg-base-300 flex justify-between items-center">
                    <div class="font-bold">
                        {{ __('Total Shipments') }}
                        <h1 class="text-2xl ">{{ $totalShipments ?? '0' }}</h1>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M80 23v18h23v14h18V41h23V23zm-8.2 50L42.38 279H135V144.5H95.5v-49H135V73zM185 137v46h78v-46zm96 0v46h78v-46zm96 0v46h78v-46zm-192 64v46h78v-46zm96 0v46h78v-46zm96 0v46h78v-46zm-192 64v46h78v-46zm96 0v46h19.3l32-32H359v-14zm96 0v14h78v-14zM27.22 297l24.11 108.5C76.75 398.1 105.7 391 128 391c24.2 0 46.2 8.6 67.2 16.6s41 15.4 60.8 15.4s39.8-7.4 60.8-15.4c19-7.2 38.9-15 60.5-16.4l-44.1-14.7l5.6-17l36.2 12V345h-17v-18h17v-30h-35.3l-32 32H154.4l-16-32zM393 297v30h17v18h-17v26.5l36.2-12l5.6 17l-44 14.7c12.1.7 25.7 3.1 39.4 6.2c5.4-7.1 10.8-15.3 16.1-24c14.9-24.9 28.2-53.9 36.8-76.4zM128 407c-24.2 0-56.26 8.3-83.09 16.4c-10.02 3-19.26 6-26.91 8.7v19c8.36-3 19.57-6.7 32.11-10.5C76.28 432.7 108.2 425 128 425s39.8 7.4 60.8 15.4s43 16.6 67.2 16.6s46.2-8.6 67.2-16.6s41-15.4 60.8-15.4s51.7 7.7 77.9 15.6c12.5 3.8 23.7 7.5 32.1 10.5v-19c-7.7-2.6-16.9-5.7-26.9-8.7c-26.8-8.1-58.9-16.4-83.1-16.4s-46.2 8.6-67.2 16.6s-41 15.4-60.8 15.4s-39.8-7.4-60.8-15.4s-43-16.6-67.2-16.6m0 36c-24.2 0-56.26 8.3-83.09 16.4c-10.02 3-19.26 6-26.91 8.7v19c8.36-3 19.57-6.7 32.11-10.5C76.28 468.7 108.2 461 128 461s39.8 7.4 60.8 15.4s43 16.6 67.2 16.6s46.2-8.6 67.2-16.6s41-15.4 60.8-15.4s51.7 7.7 77.9 15.6c12.5 3.8 23.7 7.5 32.1 10.5v-19c-7.7-2.6-16.9-5.7-26.9-8.7c-26.8-8.1-58.9-16.4-83.1-16.4s-46.2 8.6-67.2 16.6s-41 15.4-60.8 15.4s-39.8-7.4-60.8-15.4s-43-16.6-67.2-16.6" />
                        </svg>
                    </div>
                </div>
                <div class="p-10 rounded-xl text-base-content bg-base-300 flex justify-between items-center">
                    <div class="font-bold">
                        {{ __('Total Containers') }}
                        <h1 class="text-2xl ">{{ $totalContainers ?? '0' }}</h1>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 256 256">
                            <g fill="currentColor">
                                <path d="M240 86v84a8 8 0 0 1-5.8 7.69L128 208V48l106.2 30.34A8 8 0 0 1 240 86"
                                    opacity="0.2" />
                                <path
                                    d="M236.4 70.65L130.2 40.31a8 8 0 0 0-3.33-.23L21.74 55.1A16.08 16.08 0 0 0 8 70.94v114.12a16.08 16.08 0 0 0 13.74 15.84l105.13 15a8.5 8.5 0 0 0 1.13.1a8 8 0 0 0 2.2-.31l106.2-30.34A16.07 16.07 0 0 0 248 170V86a16.07 16.07 0 0 0-11.6-15.35M96 120H80V62.94l40-5.72v141.56l-40-5.72V136h16a8 8 0 0 0 0-16M24 70.94l40-5.72V120H48a8 8 0 0 0 0 16h16v54.78l-40-5.72Zm112 126.45V58.61L232 86v84Z" />
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="shadow-sm sm:rounded-lg grid grid-cols-1 xl:grid-cols-2 gap-4">
                <div class="p-10 rounded-xl text-base-content bg-base-300">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Destination') }}</th>
                                    <th>{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($driverWorks->count() > 0)
                                    @foreach ($driverWorks as $key => $driverWork)
                                        <tr>
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <div class="avatar">
                                                        <div class="mask mask-squircle h-12 w-12">
                                                            <img src="{{ $driverWork->user->profile_photo_url ? asset('storage/' . $driverWork->user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . $driverWork->user->name }}"
                                                                alt="Avatar Tailwind CSS Component" />
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-bold">{{ $driverWork->name }}</div>
                                                        <div class="text-sm opacity-50">
                                                            {{ $driverWork->vehicle_number }}</div>
                                                        <div class="text-xs opacity-50">{{ $driverWork->phone }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="w-1/3">
                                                @foreach ($driverWork->deliveries as $key => $delivery)
                                                    {{ $delivery->consumer->address }}
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($driverWork->deliveries as $key => $delivery)
                                                    {{ $delivery->status == 'delivered' ? 'Proses Pengiriman' : '' }}
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">{{ __('No Data') }}</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="p-10 rounded-xl text-base-content bg-base-300" wire:ignore>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    @pushonce('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                const calendarEl = document.querySelector('#calendar');

                // Pastikan plugin tersedia di window
                if (!window.dayGridPlugin || !window.timeGridPlugin || !window.listPlugin) {
                    console.error('Plugin FullCalendar tidak tersedia.');
                    return;
                }
                const calendar = new window.Calendar(calendarEl, {
                    locales: window.allLocales,
                    locale: 'id',
                    plugins: [window.dayGridPlugin, window.listPlugin, window.multiMonthPlugin],
                    initialView: 'dayGridMonth',
                    timeZone: 'Asia/Jayapura',
                    dayMaxEvents: true,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,listMonth'
                    },
                    events: '/api/get-shipment-date',
                });

                calendar.render();

            });
        </script>
    @endpushonce

</x-app-layout>

