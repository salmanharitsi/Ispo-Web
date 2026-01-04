<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
  <div class="px-4 sm:px-6 pt-4 pb-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <h2 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 text-xs">
          <i class="fa-solid fa-map-location-dot"></i>
        </span>
        <span>Peta Pemetaan Kebun</span>
      </h2>
      <p class="text-xs text-slate-500 mt-1">
        Menampilkan batas polygon lahan kebun berdasarkan hasil pemetaan.
      </p>
    </div>
    <div class="flex items-center gap-2">
      {{-- Button pilih jenis peta --}}
      <div class="inline-flex rounded-lg border border-slate-200 bg-white p-1 shadow-sm">
        <button
          type="button"
          id="btnMapTypeStreetKebun"
          class="map-type-btn-kebun inline-flex items-center gap-1.5 rounded-md px-2.5 py-1.5 text-xs font-medium transition"
        >
          <i class="fa-solid fa-map text-[11px]"></i>
          <span>Peta</span>
        </button>
        <button
          type="button"
          id="btnMapTypeSatelliteKebun"
          class="map-type-btn-kebun active inline-flex items-center gap-1.5 rounded-md px-2.5 py-1.5 text-xs font-medium transition"
        >
          <i class="fa-solid fa-satellite text-[11px]"></i>
          <span>Satelit</span>
        </button>
      </div>
      
      <div class="text-[11px] text-slate-400">
        @if($kebun->latitude && $kebun->longitude)
          {{ $kebun->latitude }}, {{ $kebun->longitude }}
        @else
          Koordinat belum tersedia
        @endif
      </div>
    </div>
  </div>

  <div class="px-4 sm:px-6 pb-5">
    <div class="relative">
      <div
        id="map-kebun"
        class="w-full h-[320px] sm:h-[420px] rounded-xl border border-slate-200 overflow-hidden z-0"
      ></div>

      <div class="absolute bottom-3 right-3 z-10 bg-white/90 backdrop-blur-sm shadow-md rounded-lg px-3 py-2 text-[11px] text-slate-600 space-y-1 border border-slate-100">
        <div class="flex items-center gap-2">
          <span class="inline-flex h-3 w-3 rounded-full bg-emerald-500"></span>
          <span>Area kebun</span>
        </div>
      </div>
    </div>

    {{-- Ringkasan geometri (centroid, luas, keliling, sisi) --}}
    @php
      $sidesArray = $kebun->polygon_sides ?? [];
      $sidesCount = is_array($sidesArray) ? count($sidesArray) : 0;
    @endphp

    <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-3">

      {{-- Luas --}}
      <div class="inline-flex items-center gap-2 rounded-lg bg-blue-50 px-3 py-2 border border-blue-200">
        <span class="text-[11px] uppercase tracking-wide text-blue-400 font-semibold">Luas Area</span>
        <span class="font-mono text-[11px] text-blue-700">
          @if($kebun->area_m2 && $kebun->area_hectare)
            {{ number_format($kebun->area_m2, 2, ',', '.') }} m²
            ({{ number_format($kebun->area_hectare, 4, ',', '.') }} Ha)
          @else
            -
          @endif
        </span>
      </div>

      {{-- Keliling --}}
      <div class="inline-flex items-center gap-2 rounded-lg bg-purple-50 px-3 py-2 border border-purple-200">
        <span class="text-[11px] uppercase tracking-wide text-purple-400 font-semibold">Keliling</span>
        <span class="font-mono text-[11px] text-purple-700">
          @if($kebun->perimeter_m)
            {{ number_format($kebun->perimeter_m, 2, ',', '.') }} m
          @else
            -
          @endif
        </span>
      </div>

    </div>
  </div>
</div>
