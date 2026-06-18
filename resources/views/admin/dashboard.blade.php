@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Welcome Card --}}
    <div class="bg-linear-to-r from-green-700 to-green-900 rounded-2xl shadow-xl p-6 sm:p-8 mb-6 text-white relative overflow-hidden">
      <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
      <div class="absolute -left-10 -bottom-10 w-52 h-52 bg-green-500/10 rounded-full blur-3xl"></div>

      <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
          <h1 class="text-3xl md:text-4xl font-bold mb-2">
            Selamat Datang, {{ $user->name }}! 👋
          </h1>
          <p class="text-green-100 text-sm sm:text-base">
            Panel kendali sertifikasi ISPO Kabupaten Rokan Hulu
          </p>
          <div class="mt-3 flex flex-wrap items-center text-xs sm:text-sm text-green-100 gap-3">
            <div class="inline-flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
            </div>
            @if(Auth::user()->role === 'admin')
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 text-[11px] uppercase tracking-wide font-semibold">
              Dashboard Admin
            </span>
            @endif
            @if(Auth::user()->role === 'pimpinan')
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 text-[11px] uppercase tracking-wide font-semibold">
              Dashboard Pimpinan
            </span>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex items-center gap-3">
        <div class="h-10 w-10 rounded-full bg-green-50 flex items-center justify-center">
          <i class="fas fa-plant-wilt text-green-600"></i>
        </div>
        <div>
          <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Kebun</p>
          <p class="text-xl font-bold text-slate-900">{{ number_format($totalKebun) }}</p>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex items-center gap-3">
        <div class="h-10 w-10 rounded-full bg-emerald-50 flex items-center justify-center">
          <i class="fas fa-users text-emerald-600"></i>
        </div>
        <div>
          <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Pekebun</p>
          <p class="text-xl font-bold text-slate-900">{{ number_format($totalPekebun) }}</p>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex items-center gap-3">
        <div class="h-10 w-10 rounded-full bg-amber-50 flex items-center justify-center">
          <i class="fas fa-map text-amber-600"></i>
        </div>
        <div>
          <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Luas Lahan</p>
          <p class="text-xl font-bold text-slate-900">
            {{ number_format($totalLuas, 2, ',', '.') }}
            <span class="text-xs text-slate-500 font-normal">Ha</span>
          </p>
        </div>
      </div>

      {{-- CARD: Tersertifikasi ISPO --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex items-center gap-3">
        <div class="h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center">
          <i class="fas fa-star text-blue-600"></i>
        </div>
        <div>
          <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Kebun Layak ISPO</p>
          <p class="text-xl font-bold text-slate-900">
            {{ $ispoSudah }}
          </p>
        </div>
      </div>
    </div>

    {{-- Progress / Status Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-3">
          <p class="text-sm font-semibold text-slate-700">Progress Pemetaan</p>
          <span class="text-xs text-slate-400">Kebun terpetakan</span>
        </div>
        @php
          $pctMapped = $totalKebun > 0 ? round(($kebunMapped / $totalKebun) * 100) : 0;
        @endphp
        <div class="flex items-end justify-between mb-2">
          <p class="text-2xl font-bold text-slate-900">{{ $pctMapped }}%</p>
          <p class="text-xs text-slate-500">{{ $kebunMapped }} dari {{ $totalKebun }} kebun</p>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
          <div class="h-2.5 rounded-full" style="width: {{ $pctMapped }}%; background: linear-gradient(to right, #16a34a, #22C55E);"></div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-3">
          <p class="text-sm font-semibold text-slate-700">Progress Kuisioner</p>
          <span class="text-xs text-slate-400">Kuisioner terisi</span>
        </div>
        @php
          $pctKuisioner = $totalKebun > 0 ? round(($kebunKuisioner / $totalKebun) * 100) : 0;
        @endphp
        <div class="flex items-end justify-between mb-2">
          <p class="text-2xl font-bold text-slate-900">{{ $pctKuisioner }}%</p>
          <p class="text-xs text-slate-500">{{ $kebunKuisioner }} dari {{ $totalKebun }} kebun</p>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
          <div class="h-2.5 rounded-full" style="width: {{ $pctKuisioner }}%; background: linear-gradient(to right, #2563eb, #60A5FA);"></div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-3">
          <p class="text-sm font-semibold text-slate-700">Finalisasi Data</p>
          <span class="text-xs text-slate-400">Status akhir</span>
        </div>
        @php
          $pctFinal = $totalKebun > 0 ? round(($kebunFinal / $totalKebun) * 100) : 0;
        @endphp
        <div class="flex items-end justify-between mb-2">
          <p class="text-2xl font-bold text-slate-900">{{ $pctFinal }}%</p>
          <p class="text-xs text-slate-500">{{ $kebunFinal }} kebun sudah final</p>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
          <div class="h-2.5 rounded-full" style="width: {{ $pctFinal }}%; background: linear-gradient(to right, #d97706, #FACC15);"></div>
        </div>
      </div>
    </div>

    {{-- Chart Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      {{-- Bar Chart: Kebun per Kecamatan --}}
      <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
          <div>
            <h2 class="text-base sm:text-lg font-semibold text-slate-900">Sebaran Kebun per Kecamatan</h2>
            <p class="text-xs sm:text-sm text-slate-500">Top kecamatan dengan jumlah kebun terbanyak</p>
          </div>
        </div>
        <div class="h-64 sm:h-72">
          <canvas id="kecamatanChart"></canvas>
        </div>
      </div>

      {{-- Chart: Status Kelayakan ISPO --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h3 class="text-base font-semibold text-slate-900">
              Status Kelayakan ISPO
            </h3>
            <p class="text-xs text-slate-500">
              Distribusi kebun berdasarkan status kelayakan ISPO
            </p>
          </div>
        </div>

        <div class="h-56">
          <canvas id="ispoChart"></canvas>
        </div>

        <div class="mt-4 flex flex-wrap gap-4 text-xs">
          <div class="flex items-center gap-2">
            <span class="inline-block w-3 h-3 rounded-full" style="background:#E5E7EB;"></span>
            <span>Belum Diajukan ({{ $ispoBelum }})</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="inline-block w-3 h-3 rounded-full" style="background:#F59E0B;"></span>
            <span>Proses Penilaian ({{ $ispoProses }})</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="inline-block w-3 h-3 rounded-full" style="background:#F87171;"></span>
            <span>Belum Layak ({{ $ispoBelumLayak }})</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="inline-block w-3 h-3 rounded-full" style="background:#FDE047;"></span>
            <span>Cukup Layak ({{ $ispoCukupLayak }})</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="inline-block w-3 h-3 rounded-full" style="background:#22C55E;"></span>
            <span>Sudah Layak ({{ $ispoSudah }})</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Data dari controller
    const kecamatanLabels = @json($kecamatanLabels);
    const kecamatanCounts = @json($kecamatanCounts);
    const totalKebunAll   = @json($totalKebun);

    const ispoBelum      = @json($ispoBelum);
    const ispoProses     = @json($ispoProses);
    const ispoSudah      = @json($ispoSudah);
    const ispoCukupLayak = @json($ispoCukupLayak);
    const ispoBelumLayak = @json($ispoBelumLayak);

    // Palet warna pie chart — urutan: abu, amber, merah, kuning, hijau
    const piePalette = ['#E5E7EB', '#F59E0B', '#F87171', '#FDE047', '#22C55E'];

    // ==========================
    // BAR CHART: Kebun per Kecamatan
    // ==========================
    const kecamatanCanvas = document.getElementById('kecamatanChart');
    if (kecamatanCanvas) {
      const kecamatanCtx = kecamatanCanvas.getContext('2d');

      // Tentukan warna tiap batang berdasarkan ranking nilai (tertinggi → hijau, terendah → merah)
      // Palet yang dipakai: hijau, kuning, amber, merah, abu  (diurutkan dari "terbaik" ke "terburuk")
      const barPalette = ['#22C55E', '#FDE047', '#F59E0B', '#F87171', '#E5E7EB'];

      const n = kecamatanCounts.length;
      // Buat array index diurutkan dari nilai terbesar ke terkecil
      const sortedIndices = [...Array(n).keys()].sort((a, b) => kecamatanCounts[b] - kecamatanCounts[a]);
      // Tentukan "rank" tiap bar (0 = tertinggi)
      const rank = new Array(n);
      sortedIndices.forEach((origIdx, rankPos) => { rank[origIdx] = rankPos; });

      // Petakan rank ke warna palet (jika lebih dari 5 bar, siklus warna)
      const barColors = kecamatanCounts.map((_, i) => barPalette[rank[i] % barPalette.length]);
      const barHoverColors = barColors.map(c => c + 'CC'); // sedikit transparan saat hover

      // Hitung persenan tiap kecamatan dari total seluruh kebun
      const totalForPct = totalKebunAll > 0 ? totalKebunAll : (kecamatanCounts.reduce((a, b) => a + b, 0) || 1);
      const kecamatanPct = kecamatanCounts.map(v => ((v / totalForPct) * 100).toFixed(1));

      // Plugin custom: tampilkan label persenan di atas tiap batang
      const barLabelPlugin = {
        id: 'barPercentLabel',
        afterDatasetsDraw(chart) {
          const { ctx, data } = chart;
          chart.getDatasetMeta(0).data.forEach((bar, i) => {
            const pct = kecamatanPct[i];
            ctx.save();
            ctx.font = 'bold 10px sans-serif';
            ctx.fillStyle = '#475569';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';
            ctx.fillText(pct + '%', bar.x, bar.y - 3);
            ctx.restore();
          });
        }
      };

      new Chart(kecamatanCtx, {
        type: 'bar',
        data: {
          labels: kecamatanLabels,
          datasets: [{
            label: 'Jumlah Kebun',
            data: kecamatanCounts,
            backgroundColor: barColors,
            hoverBackgroundColor: barHoverColors,
            borderRadius: 6,
            maxBarThickness: 40,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          layout: { padding: { top: 20 } },
          scales: {
            x: {
              ticks: { color: '#64748b', font: { size: 11 } },
              grid: { display: false },
            },
            y: {
              beginAtZero: true,
              ticks: { color: '#64748b', stepSize: 1 },
              grid: { color: '#e5e7eb' },
            }
          },
          plugins: {
            legend: { display: false },
            tooltip: {
              backgroundColor: '#0f172a',
              padding: 8,
              titleFont: { size: 12 },
              bodyFont: { size: 11 },
              callbacks: {
                label: function(context) {
                  const val  = context.raw || 0;
                  const pct  = kecamatanPct[context.dataIndex];
                  return `Jumlah Kebun: ${val} (${pct}% dari total)`;
                }
              }
            }
          }
        },
        plugins: [barLabelPlugin]
      });
    }

    // ==========================
    // DOUGHNUT CHART: Status Sertifikasi ISPO
    // Plugin: tampilkan persenan langsung di tiap slice
    // ==========================
    const ispoCanvas = document.getElementById('ispoChart');
    if (ispoCanvas) {
      const ispoCtx = ispoCanvas.getContext('2d');
      const total = (ispoBelum + ispoProses + ispoBelumLayak + ispoCukupLayak + ispoSudah) || 1;

      // Plugin custom: render teks persenan di tengah tiap arc
      const doughnutLabelPlugin = {
        id: 'doughnutPercentLabel',
        afterDatasetsDraw(chart) {
          const { ctx, data } = chart;
          const dataset  = chart.getDatasetMeta(0);
          const chartData = data.datasets[0].data;
          const sum = chartData.reduce((a, b) => a + b, 0) || 1;

          dataset.data.forEach((arc, i) => {
            const value = chartData[i];
            if (value === 0) return;
            const pct = ((value / sum) * 100).toFixed(1);

            // Titik tengah arc
            const midAngle  = (arc.startAngle + arc.endAngle) / 2;
            const midRadius = (arc.innerRadius + arc.outerRadius) / 2;
            const x = arc.x + Math.cos(midAngle) * midRadius;
            const y = arc.y + Math.sin(midAngle) * midRadius;

            // Hanya tampilkan jika slice cukup besar (> 5%)
            if (parseFloat(pct) < 5) return;

            ctx.save();
            ctx.font        = 'bold 11px sans-serif';
            ctx.fillStyle   = i === 0 ? '#6B7280' : (i === 3 ? '#78350f' : '#1e293b'); // kuning pakai teks gelap
            ctx.textAlign   = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(pct + '%', x, y);
            ctx.restore();
          });
        }
      };

      new Chart(ispoCtx, {
        type: 'doughnut',
        data: {
          labels: ['Belum Diajukan', 'Proses Penilaian', 'Belum Layak', 'Cukup Layak', 'Sudah Layak'],
          datasets: [{
            data: [ispoBelum, ispoProses, ispoBelumLayak, ispoCukupLayak, ispoSudah],
            backgroundColor: piePalette,
            borderWidth: 2,
            borderColor: '#ffffff',
            hoverOffset: 6,
          }]
        },
        options: {
          cutout: '62%',
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: function (context) {
                  const label   = context.label || '';
                  const value   = context.raw || 0;
                  const percent = ((value / total) * 100).toFixed(1);
                  return `${label}: ${value} kebun (${percent}%)`;
                }
              }
            }
          }
        },
        plugins: [doughnutLabelPlugin]
      });
    }
  });
</script>
@endpush

