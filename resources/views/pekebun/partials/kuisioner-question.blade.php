@props(['label', 'model'])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div class="sm:w-2/3">
        <p class="text-sm font-medium text-slate-800">
            {{ $label }}
        </p>
    </div>
    <div class="sm:w-1/3">
        <div class="flex items-center gap-4">
            <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                <input
                    type="radio"
                    class="h-4 w-4 text-emerald-600 border-slate-300 focus:ring-emerald-500"
                    wire:model="{{ $model }}"
                    value="1"
                >
                <span>Ya</span>
            </label>
            <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                <input
                    type="radio"
                    class="h-4 w-4 text-emerald-600 border-slate-300 focus:ring-emerald-500"
                    wire:model="{{ $model }}"
                    value="0"
                >
                <span>Tidak</span>
            </label>
        </div>
        @error($model)
            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
