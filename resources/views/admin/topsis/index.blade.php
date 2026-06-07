@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto p-5 space-y-6">
    <!-- Header Section -->
      <div class="col-span-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
          <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
              Perhitungan TOPSIS
            </h1>
            <p class="text-gray-600 mt-1">Kelola persetujuan pengajuan dan hasil perankingan kesiapan ISPO pekebun.</p>
          </div>
        </div>
      </div>

    @php
        $ahpFinalExists = \App\Models\AhpFinal::first() !== null;
    @endphp

    @if (!$ahpFinalExists && Auth::user()->role === 'admin')
        <div class="mb-6 p-4 rounded-lg border bg-yellow-50 border-yellow-400 text-yellow-800 flex items-start shadow-sm">
            <div class="mr-3 mt-0.5">
                <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
            </div>
            <div class="flex-1">
                <p class="font-bold mb-1">Prasyarat Belum Terpenuhi:</p>
                <div class="text-sm">
                    <p>Untuk dapat menyetujui pengajuan atau melakukan kalkulasi ranking, Anda harus meng-generate <b>Pembobotan Final (AHP)</b> terlebih dahulu.</p>
                    <a href="{{ url('/admin/ahp/final') }}" class="inline-block mt-2 font-bold text-amber-800 hover:text-amber-900 underline">Pergi ke Pembobotan Final &rarr;</a>
                </div>
            </div>
        </div>
    @endif

    <div class="space-y-8">
        @if(Auth::user()->role === 'admin')
        <!-- Tabel Pengajuan Pengecekan (Data Finalisasi) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-clipboard-check text-green-600 mr-2"></i> Pengajuan Pengecekan
                </h2>
            </div>
            <div class="p-0">
                @livewire('admin.topsis.pengajuan-table')
            </div>
        </div>
        @endif

        <!-- Tabel Perankingan (Data TOPSIS) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-medal text-yellow-500 mr-2"></i> Hasil Perankingan (TOPSIS)
                </h2>
            </div>
            <div class="p-0">
                @livewire('admin.topsis.perankingan-table')
            </div>
        </div>
    </div>
</div>
@endsection
