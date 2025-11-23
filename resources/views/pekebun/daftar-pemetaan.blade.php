@extends('layouts.pekebun')

@section('title', 'Pekebun Daftar Pemetaan Kebun')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="mb-6">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
        <div class="mb-4 md:mb-0">
          <h1 class="text-3xl font-bold text-gray-800 flex items-center">
            Pemetaan Kebun
          </h1>
          <p class="text-gray-600 mt-1">Segera petakan kebun kelapa sawit milik Anda</p>
        </div>

        <a 
            href="{{ url('/pekebun/daftar-pemetaan/semua-pemetaan') }}"
            class="inline-flex gap-2 items-center justify-center space-x-2 bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition shadow-lg"
          >
            <i class="fas fa-eye text-lg w-5"></i>
            Lihat Pemetaan
        </a>
      </div>

      <!-- Info Alert -->
      <div class="space-y-6">
        <div class="bg-green-50 border border-green-500 p-4 rounded-lg">
          <div class="flex items-start">
            <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div>
              <p class="text-sm font-medium text-green-800">Informasi</p>
              <p class="text-sm text-green-700 mt-1">Petakan kebun untuk melanjutkan proses sertifikasi ISPO. Pilih kebun yang ingin dipetakan!</p>
            </div>
          </div>
        </div>
        @if($needPemetaan > 0)
          <div class="bg-yellow-50 border border-yellow-500 p-4 rounded-lg mb-4">
            <div class="flex items-start">
              <svg class="w-6 h-6 text-yellow-500 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
              </svg>
              <div>
                <p class="text-sm font-medium text-yellow-800">Peringatan</p>
                <p class="text-sm text-yellow-700 mt-1">
                  Terdapat <span class="font-semibold">{{ $needPemetaan }}</span> kebun yang belum dipetakan, petakan area kebun segera!
                </p>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>

    <!-- Kebun List Component -->
    <div>
      @livewire('daftar-pemetaan')
    </div>
  </div>
</div>
@endsection