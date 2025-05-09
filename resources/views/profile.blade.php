<x-app-layout>
    <x-slot:title>
        {{ __('Profile') }}
    </x-slot>
    <div class="py-12">
        <div class=" sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-base-300 shadow sm:rounded-lg">
                <div class="">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-base-300 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

{{--            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">--}}
{{--                <div class="max-w-xl">--}}
{{--                    <livewire:profile.delete-user-form />--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
</x-app-layout>
