@extends('layouts.pekebun')

@section('title', 'Pekebun Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Welcome Card -->
    <div class="bg-linear-to-r from-green-600 to-green-700 rounded-lg shadow-xl p-8 mb-6 text-white relative overflow-hidden">
      <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between">
        <div class="mb-4 md:mb-0">
          <h1 class="text-3xl md:text-4xl font-bold mb-2">
            Selamat Datang, {{ $user->name }}! 👋
          </h1>
          <p class="text-green-100 text-lg">
            Platform Sertifikasi ISPO Kabupaten Rokan Hulu
          </p>
          <div class="mt-4 flex items-center text-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
          </div>
        </div>
      </div>
    </div>

    <!-- Timeline Kelengkapan Data -->
    @if(!$allStepsComplete)
    <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
      <div class="flex items-center mb-6">
        <div class="bg-amber-100 p-3 rounded-lg mr-4">
          <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
        </div>
        <div>
          <h2 class="text-2xl font-bold text-gray-800">Kelengkapan Data</h2>
          <p class="text-gray-600 mt-1">Lengkapi data berikut untuk melanjutkan proses sertifikasi ISPO</p>
        </div>
      </div>

      <!-- Timeline Steps -->
      <div class="relative">
        <!-- Vertical Line Background -->
        <div class="absolute left-6 top-12 bottom-0 w-0.5 bg-gray-200"></div>

        <!-- Step 1: Data Diri -->
        <div class="flex items-start mb-6 relative">
          <div class="shrink-0 relative z-10">
            @if($isDataDiriComplete)
              <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
              </div>
            @else
              <div class="w-12 h-12 bg-amber-500 rounded-full flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-lg">1</span>
              </div>
            @endif
          </div>
          
          <div class="ml-6 flex-1">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-2">
              <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Lengkapi Data Diri</h3>
                <p class="text-gray-600 text-sm">Isi informasi pribadi dan kontak Anda</p>
              </div>
              @if($isDataDiriComplete)
                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                  <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  Selesai
                </span>
              @endif
            </div>
            
            @if(!$isDataDiriComplete)
              <div class="mt-4 bg-amber-50 border border-amber-200 rounded-lg p-4">
                <div class="flex items-start">
                  <svg class="w-5 h-5 text-amber-600 mr-3 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                  </svg>
                  <div class="flex-1">
                    <p class="text-amber-800 font-medium mb-2">Data diri Anda belum lengkap!</p>
                    <p class="text-amber-700 text-sm mb-3">Silakan lengkapi semua informasi yang diperlukan untuk melanjutkan.</p>
                    <a href="{{ route('pekebun.data-diri') }}" class="inline-flex items-center bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition text-sm font-semibold">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                      </svg>
                      Lengkapi Data Diri
                    </a>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>

        <!-- Step 2: Data Kebun -->
        <div class="flex items-start mb-6 relative">
          <div class="shrink-0 relative z-10">
            @if($hasKebun)
              <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
              </div>
            @else
              <div class="w-12 h-12 {{ $isDataDiriComplete ? 'bg-amber-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-lg">2</span>
              </div>
            @endif
          </div>
          
          <div class="ml-6 flex-1">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-2">
              <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Tambahkan Data Kebun</h3>
                <p class="text-gray-600 text-sm">Daftarkan minimal 1 kebun kelapa sawit Anda</p>
              </div>
              @if($hasKebun)
                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                  <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  {{ $jumlahKebun }} Kebun
                </span>
              @endif
            </div>
            
            @if(!$hasKebun && $isDataDiriComplete)
              <div class="mt-4 bg-amber-50 border border-amber-200 rounded-lg p-4">
                <div class="flex items-start">
                  <svg class="w-5 h-5 text-amber-600 mr-3 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                  </svg>
                  <div class="flex-1">
                    <p class="text-amber-800 font-medium mb-2">Belum ada data kebun!</p>
                    <p class="text-amber-700 text-sm mb-3">Tambahkan minimal 1 data kebun kelapa sawit untuk melanjutkan proses sertifikasi.</p>
                    <a href="{{ route('pekebun.daftar-kebun') }}" class="inline-flex items-center bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition text-sm font-semibold">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                      </svg>
                      Tambah Data Kebun
                    </a>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>

        <!-- Step 3: Pemetaan Kebun -->
        <div class="flex items-start mb-6 relative">
          <div class="shrink-0 relative z-10">
            @if($hasPemetaan)
              <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
              </div>
            @else
              <div class="w-12 h-12 {{ $hasKebun ? 'bg-amber-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-lg">3</span>
              </div>
            @endif
          </div>
          
          <div class="ml-6 flex-1">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-2">
              <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Pemetaan Kebun</h3>
                <p class="text-gray-600 text-sm">Petakan lokasi kebun menggunakan polygon</p>
              </div>
              @if($hasPemetaan)
                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                  <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  {{ $jumlahKebunTerpetakan }} Terpetakan
                </span>
              @endif
            </div>
            
            @if(!$hasPemetaan && $hasKebun)
              <div class="mt-4 bg-amber-50 border border-amber-200 rounded-lg p-4">
                <div class="flex items-start">
                  <svg class="w-5 h-5 text-amber-600 mr-3 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                  </svg>
                  <div class="flex-1">
                    <p class="text-amber-800 font-medium mb-2">Kebun belum dipetakan!</p>
                    <p class="text-amber-700 text-sm mb-3">Lakukan pemetaan minimal 1 kebun menggunakan polygon untuk melanjutkan.</p>
                    <a href="{{ url('/pekebun/daftar-pemetaan') }}" class="inline-flex items-center bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition text-sm font-semibold">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                      </svg>
                      Petakan Kebun
                    </a>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>

        <!-- Step 4: Kuisioner -->
        <div class="flex items-start mb-6 relative">
          <div class="shrink-0 relative z-10">
            @if($hasKuisioner)
              <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
              </div>
            @else
              <div class="w-12 h-12 {{ $hasPemetaan ? 'bg-amber-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-lg">4</span>
              </div>
            @endif
          </div>
          
          <div class="ml-6 flex-1">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-2">
              <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Isi Kuisioner</h3>
                <p class="text-gray-600 text-sm">Lengkapi kuisioner untuk setiap kebun</p>
              </div>
              @if($hasKuisioner)
                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                  <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  {{ $jumlahKuisionerSelesai }} Selesai
                </span>
              @endif
            </div>
            
            @if(!$hasKuisioner && $hasPemetaan)
              <div class="mt-4 bg-amber-50 border border-amber-200 rounded-lg p-4">
                <div class="flex items-start">
                  <svg class="w-5 h-5 text-amber-600 mr-3 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                  </svg>
                  <div class="flex-1">
                    <p class="text-amber-800 font-medium mb-2">Kuisioner belum diisi!</p>
                    <p class="text-amber-700 text-sm mb-3">Isi kuisioner minimal untuk 1 kebun yang sudah dipetakan.</p>
                    <a href="{{ url('/pekebun/daftar-kuisioner') }}" class="inline-flex items-center bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition text-sm font-semibold">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                      </svg>
                      Isi Kuisioner
                    </a>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>

        <!-- Step 5: Pernyataan STDB -->
        <div class="flex items-start mb-6 relative">
          <div class="shrink-0 relative z-10">
            @if($hasPernyataanStdb)
              <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
              </div>
            @else
              <div class="w-12 h-12 {{ $hasKuisioner ? 'bg-amber-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-lg">5</span>
              </div>
            @endif
          </div>
          
          <div class="ml-6 flex-1">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-2">
              <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Isi Pernyataan STDB</h3>
                <p class="text-gray-600 text-sm">Lengkapi pernyataan stdb untuk setiap kebun</p>
              </div>
              @if($hasPernyataanStdb)
                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                  <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  {{ $jumlahPernyataanStdb }} Selesai
                </span>
              @endif
            </div>
            
            @if(!$hasPernyataanStdb && $hasKuisioner)
              <div class="mt-4 bg-amber-50 border border-amber-200 rounded-lg p-4">
                <div class="flex items-start">
                  <svg class="w-5 h-5 text-amber-600 mr-3 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                  </svg>
                  <div class="flex-1">
                    <p class="text-amber-800 font-medium mb-2">Pernyataan STDB belum diisi!</p>
                    <p class="text-amber-700 text-sm mb-3">Isi pernyataan STDB minimal untuk 1 kebun yang sudah lengkap datanya (data kebun, pemetaan, dan kuisioner) agar dapat melanjutkan ke tahap finalisasi.</p>
                    <a href="{{ url('/pekebun/daftar-kebun') }}" class="inline-flex items-center bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition text-sm font-semibold">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                      </svg>
                      Isi Pernyataan STDB
                    </a>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>

        <!-- Step 6: Finalisasi Data -->
        <div class="flex items-start relative">
          <div class="shrink-0 relative z-10">
            @if($hasFinalisasi)
              <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
              </div>
            @else
              <div class="w-12 h-12 {{ $hasPernyataanStdb ? 'bg-amber-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-lg">6</span>
              </div>
            @endif
          </div>
          
          <div class="ml-6 flex-1">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-2">
              <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Finalisasi Data Kebun</h3>
                <p class="text-gray-600 text-sm">Finalisasi minimal 1 kebun untuk penilaian ISPO</p>
              </div>
              @if($hasFinalisasi)
                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                  <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  {{ $jumlahKebunFinalisasi }} Difinalisasi
                </span>
              @endif
            </div>
            
            @if(!$hasFinalisasi && $hasPernyataanStdb)
              <div class="mt-4 bg-amber-50 border border-amber-200 rounded-lg p-4">
                <div class="flex items-start">
                  <svg class="w-5 h-5 text-amber-600 mr-3 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                  </svg>
                  <div class="flex-1">
                    <p class="text-amber-800 font-medium mb-2">Data kebun belum difinalisasi!</p>
                    <p class="text-amber-700 text-sm mb-3">Finalisasi minimal 1 kebun yang sudah lengkap datanya (data kebun, pemetaan, kuisioner, dan pernyataan STDB) agar dapat dinilai oleh admin untuk sertifikasi ISPO.</p>
                    <a href="{{ route('pekebun.daftar-kebun') }}" class="inline-flex items-center bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition text-sm font-semibold">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      Finalisasi Data Kebun
                    </a>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
      <!-- Total Kebun -->
      <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
        <div class="flex items-center justify-between mb-4">
          <div class="bg-green-100 p-3 rounded-lg">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
        <h3 class="text-gray-600 text-sm font-medium mb-1">Total Kebun</h3>
        <p class="text-3xl font-bold text-gray-800">{{ $jumlahKebun }}</p>
        <p class="text-sm text-gray-500 mt-2">Kebun terdaftar</p>
      </div>

      <!-- Kebun Terpetakan -->
      <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
        <div class="flex items-center justify-between mb-4">
          <div class="bg-blue-100 p-3 rounded-lg">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
            </svg>
          </div>
        </div>
        <h3 class="text-gray-600 text-sm font-medium mb-1">Kebun Terpetakan</h3>
        <p class="text-3xl font-bold text-gray-800">{{ $jumlahKebunTerpetakan }}</p>
        <p class="text-sm text-gray-500 mt-2">Sudah dipetakan</p>
      </div>

      <!-- Kuisioner Selesai -->
      <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
        <div class="flex items-center justify-between mb-4">
          <div class="bg-purple-100 p-3 rounded-lg">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
        </div>
        <h3 class="text-gray-600 text-sm font-medium mb-1">Kuisioner</h3>
        <p class="text-3xl font-bold text-gray-800">{{ $jumlahKuisionerSelesai }}</p>
        <p class="text-sm text-gray-500 mt-2">Sudah diisi</p>
      </div>

      <!-- Kebun Difinalisasi -->
      <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
        <div class="flex items-center justify-between mb-4">
          <div class="bg-indigo-100 p-3 rounded-lg">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
        <h3 class="text-gray-600 text-sm font-medium mb-1">Kebun Difinalisasi</h3>
        <p class="text-3xl font-bold text-gray-800">{{ $jumlahKebunFinalisasi }}</p>
        <p class="text-sm text-gray-500 mt-2">Proses pengecekan</p>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>
        Aksi Cepat
      </h2>
      
      <div class="grid md:grid-cols-3 gap-6">
        <!-- Data Diri -->
        <a href="{{ route('pekebun.data-diri') }}" class="group border-2 border-gray-200 rounded-lg p-6 hover:border-green-500 hover:shadow-lg transition">
          <div class="bg-green-100 w-14 h-14 rounded-lg flex items-center justify-center mb-4 group-hover:bg-green-500 transition">
            <svg class="w-7 h-7 text-green-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
          </div>
          <h3 class="font-semibold text-gray-800 mb-2 group-hover:text-green-600 transition">Kelola Data Diri</h3>
          <p class="text-sm text-gray-600">Update informasi profil dan data pribadi Anda</p>
        </a>

        <!-- Data Kebun -->
        <a href="{{ route('pekebun.daftar-kebun') }}" class="group border-2 border-gray-200 rounded-lg p-6 hover:border-green-500 hover:shadow-lg transition">
          <div class="bg-green-100 w-14 h-14 rounded-lg flex items-center justify-center mb-4 group-hover:bg-green-500 transition">
            <svg class="w-7 h-7 text-green-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="font-semibold text-gray-800 mb-2 group-hover:text-green-600 transition">Data Kebun</h3>
          <p class="text-sm text-gray-600">Kelola data kebun kelapa sawit Anda</p>
        </a>

        <!-- Kuisioner -->
        <a href="{{ route('pekebun.daftar-kuisioner') }}" class="group border-2 border-gray-200 rounded-lg p-6 hover:border-green-500 hover:shadow-lg transition">
          <div class="bg-green-100 w-14 h-14 rounded-lg flex items-center justify-center mb-4 group-hover:bg-green-500 transition">
            <svg class="w-7 h-7 text-green-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <h3 class="font-semibold text-gray-800 mb-2 group-hover:text-green-600 transition">Kuisioner</h3>
          <p class="text-sm text-gray-600">Isi kuisioner untuk proses sertifikasi</p>
        </a>
      </div>
    </div>

    <!-- Info ISPO -->
    <div class="bg-linear-to-r from-green-50 to-emerald-50 rounded-lg shadow-lg p-8 border-2 border-green-100">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
        <div class="mb-6 md:mb-0">
          <h2 class="text-2xl font-bold text-gray-800 mb-3 flex items-center">
            <svg class="w-7 h-7 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Tentang Sertifikasi ISPO
          </h2>
          <p class="text-gray-700 max-w-2xl">
            Indonesian Sustainable Palm Oil (ISPO) adalah standar sertifikasi wajib yang memastikan perkebunan kelapa sawit dikelola secara berkelanjutan dan bertanggung jawab.
          </p>
          <div class="mt-4 flex flex-wrap gap-4">
            <div class="flex items-center text-sm text-gray-600">
              <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
              </svg>
              Meningkatkan daya saing
            </div>
            <div class="flex items-center text-sm text-gray-600">
              <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
              </svg>
              Akses pasar internasional
            </div>
            <div class="flex items-center text-sm text-gray-600">
              <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
              </svg>
              Pengelolaan berkelanjutan
            </div>
          </div>
        </div>
        <a href="/" class="shrink-0 bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition shadow-lg flex items-center">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          Pelajari Lebih Lanjut
        </a>
      </div>
    </div>

  </div>
</div>
@endsection