@extends('layouts.pekebun')

@section('title', 'Pekebun Daftar Kebun')

@section('content')
  <div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
          <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
              Daftar Kebun
            </h1>
            <p class="text-gray-600 mt-1">Kelola informasi kebun kelapa sawit milik Anda</p>
          </div>

          @if ($isDataDiriComplete)
            <button onclick="Livewire.dispatch('openModal')"
              class="inline-flex items-center justify-center bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition shadow-lg">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
              Tambah Kebun
            </button>
          @endif
        </div>

        <div class="space-y-6">
          <!-- Info Alert -->
          <div class="bg-green-50 border border-green-500 p-4 rounded-lg">
            <div class="flex items-start">
              <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                  clip-rule="evenodd"></path>
              </svg>
              <div>
                <p class="text-sm font-medium text-green-800">Informasi</p>
                <p class="text-sm text-green-700 mt-1">Tambahkan minimal 1 kebun untuk melanjutkan proses
                  penilaian kesiapan ISPO. Pastikan data yang diisi akurat dan sesuai kondisi lapangan.</p>
              </div>
            </div>
          </div>
          @if ($needSTDB > 0)
              <div class="bg-purple-50 border border-purple-500 p-4 rounded-lg mb-4">
              <div class="flex items-start">
                <svg class="w-5 h-5 text-purple-600 mt-0.5 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"></path>
                </svg>
                <div>
                  <p class="text-sm font-medium text-purple-800">Peringatan</p>
                  <p class="text-sm text-purple-700 mt-1">
                    Terdapat <span class="font-semibold">{{ $needSTDB }}</span> kebun yang perlu
                    diisi pernyataan STDB, lengkapi pernyataan agar bisa melakukan finalisasi data!
                  </p>
                </div>
              </div>
            </div>
          @endif
          @if ($needFinalisasi > 0)
            <div class="bg-yellow-50 border border-yellow-500 p-4 rounded-lg mb-4">
              <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"></path>
                </svg>
                <div>
                  <p class="text-sm font-medium text-yellow-800">Peringatan</p>
                  <p class="text-sm text-yellow-700 mt-1">
                    Terdapat <span class="font-semibold">{{ $needFinalisasi }}</span> kebun yang perlu
                    difinalisasi, finalisasi data untuk memulai proses pengecekan ISPO!
                  </p>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>

      <!-- Kebun List Component -->
      <div>
        @livewire('daftar-kebun')
      </div>
    </div>
  </div>
@endsection