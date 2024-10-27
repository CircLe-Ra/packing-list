@props(['id' => 'modal', 'title' => null])

<input type="checkbox" id="{{ $id }}" class="modal-toggle" />
<div class="modal" role="dialog">
    <div {{ $attributes->merge(['class' => 'modal-box']) }}>
        <h3 class="text-lg font-bold">{{ $title ?? __('Modal Title') }}</h3>
        <div class="modal-action">
            <label for="{{ $id }}" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" @click="$dispatch('close-modal-x')">x</label>
        </div>
        {{ $slot }}
    </div>
</div>

{{--gunakan button untuk membuka modal--}}
{{--<label for="idnya" class="btn btn-sm btn-base-200 my-4">Tambah</label>--}}

@once
    @push('scripts')
        @script
            <script>
                $wire.on('close-modal', (event) => {
                    if (event[0]) {
                        const checkbox = document.getElementById(event[0]);
                        if (checkbox) {
                            checkbox.checked = false;
                        }
                    }else{
                        document.getElementById(@js($id)).checked = false
                    }
                })

                $wire.on('open-modal', (event) => {
                    const checkbox = document.getElementById(event[0]);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                })


            </script>
        @endscript
    @endpush
@endonce
