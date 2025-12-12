<div class="bg-linear-to-br from-purple-50 via-blue-50 to-emerald-50 rounded-2xl border-2 border-purple-200 shadow-lg p-6">
  <div class="mb-4">
    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
      <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-linear-to-br from-purple-500 to-blue-500 text-white text-sm shadow-md">
        <i class="fa-solid fa-calculator"></i>
      </span>
      <span>Total Perhitungan Nilai SPK (AHP)</span>
    </h2>
    <p class="text-xs text-slate-600 mt-1">
      Hasil penjumlahan bobot dari penilaian kuisioner (75%) dan kelengkapan data kebun (25%)
    </p>
  </div>

  {{-- Perhitungan --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
    {{-- Nilai Kuisioner --}}
    <div class="bg-white rounded-xl p-5 shadow-sm border border-emerald-200">
      <div class="flex items-center justify-between mb-2">
        <p class="text-[11px] uppercase tracking-wider text-slate-500 font-semibold">Nilai Kuisioner</p>
        <span class="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-medium">Bobot 75%</span>
      </div>
      <p class="text-3xl font-extrabold text-emerald-600">{{ number_format($totalBobotKuisioner, 3) }}<span class="text-lg">%</span></p>
      <p class="text-[10px] text-slate-500 mt-1">Dari maksimal 75.000%</p>
    </div>

    {{-- Nilai Data Kebun --}}
    <div class="bg-white rounded-xl p-5 shadow-sm border border-sky-200">
      <div class="flex items-center justify-between mb-2">
        <p class="text-[11px] uppercase tracking-wider text-slate-500 font-semibold">Nilai Data Kebun</p>
        <span class="text-[10px] bg-sky-100 text-sky-700 px-2 py-0.5 rounded-full font-medium">Bobot 25%</span>
      </div>
      <p class="text-3xl font-extrabold text-sky-600">{{ number_format($totalBobotKebun, 3) }}<span class="text-lg">%</span></p>
      <p class="text-[10px] text-slate-500 mt-1">Dari maksimal 25.000%</p>
    </div>

    {{-- Total Nilai --}}
    <div class="bg-linear-to-br from-yellow-50 to-orange-50 rounded-xl p-5 shadow-md border-2 border-yellow-300">
      <div class="flex items-center justify-between mb-2">
        <p class="text-[11px] uppercase tracking-wider text-orange-700 font-bold">Total Nilai Akhir</p>
        <span class="text-[10px] bg-orange-200 text-orange-800 px-2 py-0.5 rounded-full font-bold">100%</span>
      </div>
      <div class="flex items-baseline gap-2 mb-1">
        <p class="text-3xl font-extrabold text-orange-600">{{ number_format($totalNilaiPersentase, 3) }}<span class="text-lg">%</span></p>
      </div>
      <div class="flex items-center gap-2 text-orange-700">
        <span class="text-[10px] font-medium">Nilai AHP (desimal):</span>
        <span class="text-lg font-bold">{{ number_format($totalNilaiDesimal, 3) }}</span>
      </div>
    </div>
  </div>

  {{-- Formula Perhitungan --}}
  <div class="bg-white/70 backdrop-blur-sm rounded-xl p-4 border border-purple-100 mb-4">
    <p class="text-[11px] text-slate-500 mb-2 font-semibold uppercase tracking-wide">
      <i class="fa-solid fa-calculator text-purple-500"></i> Formula Perhitungan:
    </p>
    <div class="flex flex-wrap items-center gap-2 text-sm">
      <span class="bg-emerald-100 text-emerald-800 px-3 py-1.5 rounded-lg font-bold">{{ number_format($totalBobotKuisioner, 3) }}%</span>
      <span class="text-slate-400 font-bold">+</span>
      <span class="bg-sky-100 text-sky-800 px-3 py-1.5 rounded-lg font-bold">{{ number_format($totalBobotKebun, 3) }}%</span>
      <span class="text-slate-400 font-bold">=</span>
      <span class="bg-orange-100 text-orange-800 px-3 py-1.5 rounded-lg font-bold">{{ number_format($totalNilaiPersentase, 3) }}%</span>
      <span class="text-slate-400 font-bold">→</span>
      <span class="bg-purple-100 text-purple-800 px-3 py-1.5 rounded-lg font-bold">{{ number_format($totalNilaiDesimal, 3) }}</span>
      <span class="text-[11px] text-slate-500">(skala 0-1)</span>
    </div>
  </div>

  {{-- Status Badge --}}
  <div class="flex items-center justify-between bg-white/70 backdrop-blur-sm rounded-xl p-4 border border-purple-100">
    <div class="flex items-center gap-2">
      <i class="fa-solid fa-chart-line text-purple-500"></i>
      <p class="text-xs text-slate-700 font-medium">Status Kelayakan Sertifikasi:</p>
    </div>
    @php
      $statusClass = '';
      $statusText = '';
      $statusIcon = '';
      
      if ($totalNilaiPersentase >= 80) {
        $statusClass = 'bg-emerald-500 text-white border-emerald-600';
        $statusText = 'Sangat Layak';
        $statusIcon = 'fa-check-circle';
      } elseif ($totalNilaiPersentase >= 60) {
        $statusClass = 'bg-blue-500 text-white border-blue-600';
        $statusText = 'Layak';
        $statusIcon = 'fa-check';
      } elseif ($totalNilaiPersentase >= 40) {
        $statusClass = 'bg-yellow-500 text-white border-yellow-600';
        $statusText = 'Cukup Layak';
        $statusIcon = 'fa-exclamation-triangle';
      } else {
        $statusClass = 'bg-rose-500 text-white border-rose-600';
        $statusText = 'Kurang Layak';
        $statusIcon = 'fa-times-circle';
      }
    @endphp
    <span class="inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-bold border-2 shadow-sm {{ $statusClass }}">
      <i class="fa-solid {{ $statusIcon }}"></i>
      {{ $statusText }}
    </span>
  </div>
</div>