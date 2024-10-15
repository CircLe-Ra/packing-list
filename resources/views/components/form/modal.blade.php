@props(['id' => 'modal'])

<dialog id="{{ $id }}" class="modal">
    <div {{ $attributes->merge(['class' => 'modal-box']) }} >
        <h3 class="text-lg font-bold -mb-6">Pemesanan</h3>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
        </div>
        {{ $slot }}
    </div>
</dialog>

{{--gunakan button untuk membuka modal--}}
{{--<button class="btn" onclick="modal.showModal()">Tambah</button>--}}


@once
    @push('scripts')
        <script>
            window.addEventListener('close-modal', event => {
                document.getElementById(@js($id)).close();
            });
        </script>
    @endpush
@endonce
