@extends('layouts.pekebun')
@section('title', 'Detail Kebun')
@section('content')

<div class="min-h-screen bg-gray-50 py-6">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-6">
      
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $kebun->nama_kebun }}</h1>
          <p class="text-gray-600 flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            {{ $kebun->lokasi_kebun }}
          </p>
        </div>
        
        <!-- Action Buttons -->
        @if ($kebun->status_finalisasi == "belum")
          <div class="flex gap-3">
            <button onclick="confirmDelete()" class="inline-flex items-center px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
              </svg>
              Hapus
            </button>
          </div>
        @endif
      </div>
    </div>
  
    <!-- Alert Notifications -->
    <div class="space-y-6 mb-6">
      <!-- Alert Polygon Belum Dipetakan -->
      @if(!$kebun->polygon)
      <div class="bg-yellow-50 border border-yellow-500 p-4 rounded-lg">
        <div class="flex items-start">
          <svg class="w-6 h-6 text-yellow-500 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
          </svg>
          <div class="flex-1">
            <h3 class="text-yellow-800 font-semibold mb-1">Kebun Belum Dipetakan</h3>
            <p class="text-yellow-700 text-sm mb-3">Pemetaan kebun diperlukan untuk penilaian kelayakan ISPO. Silakan lakukan pemetaan lokasi kebun Anda.</p>
            <a href="{{ url('/pekebun/daftar-pemetaan', $kebun->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-semibold rounded-lg transition">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
              </svg>
              Petakan Kebun Sekarang
            </a>
          </div>
        </div>
      </div>
      @endif
  
      <!-- Alert Kuisioner Belum Diisi -->
      @if(!$kebun->kuisioner && $kebun->polygon)
      <div class="bg-blue-50 border border-blue-500 p-4 rounded-lg">
        <div class="flex items-start">
          <svg class="w-6 h-6 text-blue-500 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <div class="flex-1">
            <h3 class="text-blue-800 font-semibold mb-1">Kuisioner Belum Diisi</h3>
            <p class="text-blue-700 text-sm mb-3">Lengkapi kuisioner untuk melengkapi data kebun dan persyaratan penilaian kelayakan ISPO.</p>
            <a href="{{ url('/pekebun/daftar-kuisioner', $kebun->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              Isi Kuisioner Sekarang
            </a>
          </div>
        </div>
      </div>
      @endif

      @if ($kebun->polygon && $kebun->kuisioner && $kebun->pernyataan_stdb == false)
          <div class="bg-green-50 border border-green-500 p-4 rounded-lg">
          <div class="flex items-start">
            <svg class="w-6 h-6 text-green-500 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
              <h3 class="text-green-800 font-semibold mb-1">Pernyataan STDB Belum Diisi!</h3>
              <p class="text-green-700 text-sm mb-3">
                Isi Pernyataan STDB untuk melengkapi data kebun dan melanjutkan ke tahap finalisasi.
              </p>
              <button
                type="button"
                onclick="openSTDBModal()"
                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition cursor-pointer"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Isi Pernyataan STDB
              </button>
            </div>
          </div>
        </div>
      @endif

      @if ($kebun->polygon && $kebun->kuisioner && $kebun->pernyataan_stdb == true && $kebun->status_finalisasi === 'belum')
        <div class="bg-green-50 border border-green-500 p-4 rounded-lg">
          <div class="flex items-start">
            <svg class="w-6 h-6 text-green-500 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
              <h3 class="text-green-800 font-semibold mb-1">Data Sudah Lengkap!</h3>
              <p class="text-green-700 text-sm mb-3">
                Data Anda sudah lengkap. Silahkan finalisasi data untuk melanjutkan ke tahap pengecekan.
              </p>
              <button
                type="button"
                onclick="openFinalizeModal()"
                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition cursor-pointer"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Finalisasi Data Sekarang
              </button>
            </div>
          </div>
        </div>
      @endif

    </div>
  
    <!-- Content Grid -->
    <div class="grid lg:grid-cols-3 gap-6">
      
      <!-- Main Content -->
      <div class="lg:col-span-2 space-y-6">
        
        <!-- Informasi Lahan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
          <div class="bg-linear-to-r from-green-600 to-green-500 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
              <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
              </svg>
              Informasi Lahan
            </h2>
          </div>
          <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Kolom Kiri: Angka Utama -->
              <div class="space-y-5">
                <!-- Luas Lahan -->
                <div class="bg-linear-to-br from-green-50 to-green-100/50 rounded-xl p-5 border border-green-200 hover:border-green-300 transition-colors">
                  <div class="flex items-center justify-between mb-2">
                    <label class="text-xs font-semibold text-green-700 uppercase tracking-wide">Luas Lahan</label>
                    <i class="fas fa-map-marked-alt text-green-600"></i>
                  </div>
                  <div class="flex items-baseline">
                    <p class="text-3xl font-bold text-green-800">
                      {{ number_format($kebun->luas_lahan, 2, ',', '.') }}
                    </p>
                    <span class="text-sm font-medium text-green-600 ml-2">Hektar</span>
                  </div>
                </div>

                <!-- Jumlah Pohon -->
                <div class="bg-linear-to-br from-gray-50 to-gray-100/50 rounded-xl p-5 border border-gray-200 hover:border-gray-300 transition-colors">
                  <div class="flex items-center justify-between mb-2">
                    <label class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Jumlah Pohon</label>
                    <i class="fas fa-tree text-gray-600"></i>
                  </div>
                  <div class="flex items-baseline">
                    <p class="text-3xl font-bold text-gray-800">
                      {{ $kebun->jumlah_pohon ? number_format($kebun->jumlah_pohon, 0, ',', '.') : '-' }}
                    </p>
                    @if($kebun->jumlah_pohon)
                    <span class="text-sm font-medium text-gray-600 ml-2">Pohon</span>
                    @endif
                  </div>
                </div>
              </div>

              <!-- Kolom Kanan: Karakteristik Lahan -->
              <div class="space-y-4">
                <!-- Jenis Tanah -->
                <div class="group">
                  <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5 block">Jenis Tanah</label>
                  <div class="flex items-center bg-gray-50 rounded-lg px-4 py-3 border border-gray-200 group-hover:border-green-300 transition-colors">
                    <p class="text-gray-800 font-medium">
                      {{ $kebun->jenis_tanah ? ucfirst($kebun->jenis_tanah) : '-' }}
                    </p>
                  </div>
                </div>

                <!-- Asal Lahan -->
                <div class="group">
                  <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5 block">Asal Lahan</label>
                  <div class="flex items-center bg-gray-50 rounded-lg px-4 py-3 border border-gray-200 group-hover:border-green-300 transition-colors">
                    <p class="text-gray-800 font-medium">
                      {{ $kebun->asal_lahan ?? '-' }}
                    </p>
                  </div>
                </div>

                <!-- Status Lahan -->
                <div class="group">
                  <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5 block">Status Lahan</label>
                  <div class="flex items-center bg-gray-50 rounded-lg px-4 py-3 border border-gray-200 group-hover:border-green-300 transition-colors">
                    <p class="text-gray-800 font-medium">
                      {{ $kebun->status_lahan ?? '-' }}
                    </p>
                  </div>
                </div>

                <!-- Dokumen Kepemilikan -->
                <div class="group">
                  <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5 block">Dokumen Kepemilikan</label>
                  <div class="flex items-center bg-gray-50 rounded-lg px-4 py-3 border border-gray-200 group-hover:border-green-300 transition-colors">
                    <p class="text-gray-800 font-medium">
                      {{ $kebun->dokumen_kepemilikan_lahan ?? '-' }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Informasi Penanaman & Produksi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
          <div class="bg-linear-to-r from-green-600 to-green-500 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
              <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              Informasi Penanaman & Produksi
            </h2>
          </div>
          <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Kolom Kiri -->
              <div class="space-y-5">
                <!-- Tahun Tanam -->
                <div class="bg-linear-to-br from-green-50 to-green-100/50 rounded-xl p-5 border border-green-200 hover:border-green-300 transition-colors">
                  <div class="flex items-center justify-between mb-3">
                    <label class="text-xs font-semibold text-green-700 uppercase tracking-wide">Tahun Tanam</label>
                    <i class="fas fa-calendar-alt text-green-600"></i>
                  </div>
                  <p class="text-3xl font-bold text-green-900">
                    {{ $kebun->tahun_tanam ?? '-' }}
                  </p>
                </div>

                <!-- Jenis Bibit -->
                <div class="group">
                  <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5 block">Jenis Bibit</label>
                  <div class="flex items-center bg-gray-50 rounded-lg px-4 py-3.5 border border-gray-200 group-hover:border-green-300 transition-colors">
                    <i class="fas fa-seedling text-gray-400 mr-3"></i>
                    <p class="text-gray-800 font-medium">
                      {{ $kebun->jenis_bibit ?? '-' }}
                    </p>
                  </div>
                </div>

                <!-- Frekuensi Panen -->
                <div class="group">
                  <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5 block">Frekuensi Panen</label>
                  <div class="flex items-center bg-gray-50 rounded-lg px-4 py-3.5 border border-gray-200 group-hover:border-green-300 transition-colors">
                    <i class="fas fa-clock text-gray-400 mr-3"></i>
                    <p class="text-gray-800 font-medium">
                      @if($kebun->frekuensi_panen)
                        {{ $kebun->frekuensi_panen }} <span class="text-sm text-gray-500">hari sekali</span>
                      @else
                        -
                      @endif
                    </p>
                  </div>
                </div>

                <!-- Hasil Panen Dijual ke -->
                <div class="group">
                  <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5 block">Hasil Panen Dijual ke</label>
                  <div class="flex items-center bg-gray-50 rounded-lg px-4 py-3.5 border border-gray-200 group-hover:border-green-300 transition-colors">
                    <i class="fas fa-store text-gray-400 mr-3"></i>
                    <p class="text-gray-800 font-medium">
                      {{ $kebun->kepada_siapa_hasil_panen_dijual ?? '-' }}
                    </p>
                  </div>
                </div>
              </div>

              <!-- Kolom Kanan -->
              <div class="space-y-5">
                <!-- Harga Jual TBS -->
                <div class="bg-linear-to-br from-amber-50 to-amber-100/50 rounded-xl p-5 border border-amber-200 hover:border-amber-300 transition-colors">
                  <div class="flex items-center justify-between mb-2">
                    <label class="text-xs font-semibold text-amber-700 uppercase tracking-wide">Harga Jual TBS Terakhir</label>
                    <i class="fas fa-tags text-amber-600"></i>
                  </div>
                  <div class="flex items-baseline">
                    @if($kebun->harga_jual_tbs_terakhir)
                      <p class="text-2xl font-bold text-amber-900">
                        Rp {{ number_format($kebun->harga_jual_tbs_terakhir, 0, ',', '.') }}
                      </p>
                      <span class="text-sm font-medium text-amber-600 ml-2">/ kg</span>
                    @else
                      <p class="text-2xl font-bold text-gray-400">-</p>
                    @endif
                  </div>
                </div>

                <!-- Pendapatan Bersih -->
                <div class="bg-linear-to-br from-emerald-50 to-emerald-100/50 rounded-xl p-5 border border-emerald-200 hover:border-emerald-300 transition-colors">
                  <div class="flex items-center justify-between mb-2">
                    <label class="text-xs font-semibold text-emerald-700 uppercase tracking-wide">Pendapatan per Bulan</label>
                    <i class="fas fa-money-bill-wave text-emerald-600"></i>
                  </div>
                  <div class="flex items-baseline">
                    @if($kebun->pendapatan_bersih)
                      <p class="text-2xl font-bold text-emerald-900">
                        Rp {{ number_format($kebun->pendapatan_bersih, 0, ',', '.') }}
                      </p>
                      <span class="text-sm font-medium text-emerald-600 ml-2">/ bulan</span>
                    @else
                      <p class="text-2xl font-bold text-gray-400">-</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Lokasi Kebun -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
          <div class="bg-linear-to-r from-green-600 to-green-500 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
              <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              Lokasi Kebun
            </h2>
          </div>
          <div class="p-6">
            <div class="space-y-4">
              <!-- Alamat Lengkap -->
              <div class="group">
                <div class="flex flex-col sm:flex-row sm:items-start py-4 border-b border-gray-100 hover:bg-gray-50 rounded-lg px-3 -mx-3 transition-colors">
                  <div class="sm:w-1/3 mb-2 sm:mb-0">
                    <div class="flex items-center">
                      <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                      <span class="text-sm font-semibold text-gray-600">Alamat Lengkap</span>
                    </div>
                  </div>
                  <div class="sm:w-2/3">
                    <p class="text-gray-800 leading-relaxed">{{ $kebun->lokasi_kebun }}</p>
                  </div>
                </div>
              </div>

              @if($kebun->desa)
              <!-- Desa/Kelurahan -->
              <div class="group">
                <div class="flex flex-col sm:flex-row sm:items-start py-4 border-b border-gray-100 hover:bg-gray-50 rounded-lg px-3 -mx-3 transition-colors">
                  <div class="sm:w-1/3 mb-2 sm:mb-0">
                    <div class="flex items-center">
                      <i class="fas fa-home text-green-600 mr-2"></i>
                      <span class="text-sm font-semibold text-gray-600">Desa/Kelurahan</span>
                    </div>
                  </div>
                  <div class="sm:w-2/3">
                    <p class="text-gray-800 font-medium">{{ $kebun->desa }}</p>
                  </div>
                </div>
              </div>
              @endif

              @if($kebun->kecamatan)
              <!-- Kecamatan -->
              <div class="group">
                <div class="flex flex-col sm:flex-row sm:items-start py-4 hover:bg-gray-50 rounded-lg px-3 -mx-3 transition-colors">
                  <div class="sm:w-1/3 mb-2 sm:mb-0">
                    <div class="flex items-center">
                      <i class="fas fa-city text-green-600 mr-2"></i>
                      <span class="text-sm font-semibold text-gray-600">Kecamatan</span>
                    </div>
                  </div>
                  <div class="sm:w-2/3">
                    <p class="text-gray-800 font-medium">{{ $kebun->kecamatan }}</p>
                  </div>
                </div>
              </div>
              @endif
            </div>
          </div>
        </div>

      </div>
  
      <!-- Sidebar -->
      <div class="space-y-6">
        
        <!-- Quick Stats -->
        <div class="bg-linear-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
          <h3 class="text-lg font-bold mb-4">Ringkasan Data</h3>
          <div class="space-y-3">
            <div class="flex items-center justify-between pb-3 border-b border-green-400">
              <span class="text-green-100">Status Pemetaan</span>
              @if($kebun->polygon)
                <span class="bg-white text-green-600 px-3 py-1 rounded-full text-xs font-bold">Sudah</span>
              @else
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Belum</span>
              @endif
            </div>
            <div class="flex items-center justify-between pb-3 border-b border-green-400">
              <span class="text-green-100">Status Kuisioner</span>
              @if($kebun->kuisioner)
                <span class="bg-white text-green-600 px-3 py-1 rounded-full text-xs font-bold">Sudah</span>
              @else
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Belum</span>
              @endif
            </div>
            <div class="flex items-center justify-between pb-3 border-b border-green-400">
              <span class="text-green-100">Status Pernyataan STDB</span>
              @if($kebun->pernyataan_stdb == true)
                <span class="bg-white text-green-600 px-3 py-1 rounded-full text-xs font-bold">Sudah</span>
              @else
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Belum</span>
              @endif
            </div>
            <div class="flex items-center justify-between">
              <span class="text-green-100">Status kelayakan ISPO</span>
              @if($kebun->status_ispo == 'sudah')
                <span class="bg-white text-green-600 px-3 py-1 rounded-full text-xs font-bold">Layak</span>
              @elseif($kebun->status_ispo == 'proses')
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Proses</span>
              @else
                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">Belum</span>
              @endif
            </div>
          </div>
        </div>
  
        <!-- Action Cards -->
        @if (($kebun->polygon || $kebun->kuisioner) && $kebun->status_finalisasi !== 'final')
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Lainnya</h3>
            <div class="space-y-4">
              @if($kebun->polygon)
              <a href="{{ url('/pekebun/daftar-pemetaan', $kebun->id) }}" class="block w-full text-center px-4 py-3 bg-green-50 hover:bg-green-100 text-green-700 font-semibold rounded-lg transition border border-green-200">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                </svg>
                Lihat Pemetaan
              </a>
              @endif
              @if($kebun->kuisioner)
              <a href="{{ url('/pekebun/daftar-kuisioner', $kebun->id) }}" class="block w-full text-center px-4 py-3 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold rounded-lg transition border border-blue-200">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Lihat Kuisioner
              </a>
              @endif
            </div>
          </div>
        @endif

        <!-- Finalization Cards -->
        <div class="bg-white rounded-lg shadow-md p-6">
          <h3 class="text-lg font-bold text-gray-800 mb-4">Finalisasi Data</h3>

          @if ($kebun->status_finalisasi === 'final')
            <div class="flex items-start text-green-600">
              <i class="fas fa-circle-check mr-2 mt-1"></i>
              <p class="text-sm">
                Data kebun ini sudah <span class="font-semibold">difinalisasi</span>. Perubahan data tidak lagi diizinkan.
              </p>
            </div>
          @else
            @if ($kebun->polygon && $kebun->kuisioner && $kebun->pernyataan_stdb == true)
              <div class="space-y-3">
                <div class="text-green-600 flex items-start mb-4">
                  <svg class="w-5 h-5 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <p class="text-sm">
                    Data kebun sudah lengkap, lakukan finalisasi untuk melanjutkan ke tahap pengecekan.
                  </p>
                </div>
                <button
                  type="button"
                  onclick="openFinalizeModal()"
                  class="block w-full text-center px-4 py-3 bg-green-50 hover:bg-green-100 text-green-700 font-semibold rounded-lg transition border border-green-200 cursor-pointer"
                >
                  <i class="fas fa-check mr-2"></i>
                  Finalisasi Data
                </button>
              </div>
            @else
              <div class="text-red-500 flex items-start mb-4">
                <svg class="w-5 h-5 mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm">
                  Lengkapi semua data kebun seperti pemetaan, kuisioner, dan pernyataan STDB untuk melakukan finalisasi, dan melanjutkan proses pengecekan.
                </p>
              </div>
              <button
                disabled
                class="block w-full text-center px-4 py-3 bg-gray-200 text-gray-500 font-semibold rounded-lg border border-gray-300 cursor-not-allowed"
              >
                <i class="fas fa-check mr-2"></i>
                Finalisasi Data
              </button>
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
  <div class="absolute inset-0 bg-black/50" onclick="closeDeleteModal()"></div>
  <div class="relative bg-white rounded-lg shadow-2xl max-w-md w-full p-6">
    <div class="text-center">
      <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
      </div>
      <h3 class="text-2xl font-bold text-gray-800 mb-2">Hapus Data Kebun?</h3>
      <p class="text-gray-600 mb-6">
        Anda yakin ingin menghapus kebun <strong>{{ $kebun->nama_kebun }}</strong>? Tindakan ini tidak dapat dibatalkan dan semua data terkait akan hilang.
      </p>
      <div class="grid grid-cols-2 gap-3">
        <button onclick="closeDeleteModal()" class="px-4 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
          Batal
        </button>
        <form action="{{ route('pekebun.delete-kebun', $kebun->id) }}" method="POST" class="">
          @csrf
          @method('POST')
          <button type="submit" class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">
            Ya, Hapus
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Finalisasi Confirmation Modal -->
<div id="finalizeModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
  <div class="absolute inset-0 bg-black/50" onclick="closeFinalizeModal()"></div>
  <div class="relative bg-white rounded-lg shadow-2xl max-w-xl w-full p-6">
    <div class="text-center">
      <div class="bg-emerald-100 text-green-700 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
        <i class="fa-regular fa-circle-check"></i>
      </div>

      <h3 class="text-2xl font-bold text-gray-800 mb-2">Finalisasi Data Kebun?</h3>

      <p class="text-gray-600 mb-3">
        Setelah difinalisasi, <span class="font-semibold text-red-600">data kebun tidak dapat diubah lagi</span>.
      </p>
      <p class="text-gray-600 mb-6">
        Pastikan semua informasi, pemetaan, dan kuisioner untuk kebun
        <span class="font-semibold">{{ $kebun->nama_kebun }}</span> sudah benar.
      </p>

      <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm rounded-lg px-3 py-2 mb-6">
        Tindakan ini hanya dapat dilakukan <span class="font-semibold">satu kali</span>.
        Jika Anda yakin, lanjutkan dengan finalisasi.
      </div>

      <div class="grid grid-cols-2 gap-3">
        <button
          type="button"
          onclick="closeFinalizeModal()"
          class="px-4 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition"
        >
          Batal
        </button>

        <form action="{{ route('pekebun.finalisasi-kebun', $kebun->id) }}" method="POST">
          @csrf
          <button
            type="submit"
            class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition"
          >
            Ya, Finalisasi
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Pernyataan STDB Modal -->
<div id="stdbModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
  <div class="absolute inset-0 bg-black/50" onclick="closeStdbModal()"></div>
  <div class="relative bg-white rounded-lg shadow-2xl max-w-xl w-full p-6">
    <div class="text-center">
      <div class="bg-emerald-100 text-green-700 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
        <i class="fa-regular fa-circle-check"></i>
      </div>

      <h3 class="text-2xl font-bold text-gray-800 mb-5">Pernyataan Kepemilikan STDB</h3>

      <p class="text-gray-600 text-sm mb-4 text-left">
        Saya yang bertanda tangan sebagai pemilik/pengelola kebun kelapa sawit ini menyatakan bahwa
        kebun <span class="font-semibold">{{ $kebun->nama_kebun }}</span> telah memiliki
        <span class="font-semibold">Surat Tanda Daftar Budidaya (STDB)</span> yang diterbitkan oleh instansi
        berwenang dan STDB tersebut masih berlaku sesuai ketentuan peraturan perundang-undangan.
      </p>

      <p class="text-gray-600 text-sm mb-5 text-left">
        Saya memahami bahwa data dan pernyataan yang saya sampaikan akan digunakan dalam proses
        verifikasi dan penilaian kelayakan ISPO, serta dapat dicek kebenarannya oleh pihak yang berwenang.
      </p>

      <div class="bg-emerald-50 border border-emerald-200 rounded-lg px-3 py-3 mb-5 text-left flex items-start gap-3">
        <input
          id="stdbAgree"
          type="checkbox"
          class="mt-1 h-4 w-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
        >
        <label for="stdbAgree" class="text-xs text-emerald-800 leading-relaxed">
          Dengan mencentang kotak ini, saya menyatakan bahwa seluruh keterangan di atas saya isi
          dengan <span class="font-semibold">benar, jujur, dan dapat dipertanggungjawabkan</span>.
          Saya bersedia menanggung segala konsekuensi apabila di kemudian hari pernyataan ini
          terbukti tidak benar.
        </label>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <button
          type="button"
          onclick="closeStdbModal()"
          class="px-4 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition"
        >
          Batal
        </button>

        <form action="{{ route('pekebun.pernyataan-stdb', $kebun->id) }}" method="POST">
          @csrf
          <button
            id="stdbSubmitBtn"
            type="submit"
            class="w-full px-4 py-3 rounded-lg font-semibold transition
                   bg-gray-200 text-gray-500 border border-gray-300 cursor-not-allowed"
            disabled
          >
            Ya, Saya Menyatakan
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function confirmDelete() {
  document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
  document.getElementById('deleteModal').classList.add('hidden');
}

function openFinalizeModal() {
  const modal = document.getElementById('finalizeModal');
  if (modal) modal.classList.remove('hidden');
}

function closeFinalizeModal() {
  const modal = document.getElementById('finalizeModal');
  if (modal) modal.classList.add('hidden');
}

function openSTDBModal() {
  const modal = document.getElementById('stdbModal');
  if (modal) modal.classList.remove('hidden');
}

function closeStdbModal() {
  const modal = document.getElementById('stdbModal');
  if (modal) modal.classList.add('hidden');
}

// Enable/disable tombol submit STDB berdasarkan checkbox
document.addEventListener('DOMContentLoaded', function () {
  const checkbox = document.getElementById('stdbAgree');
  const submitBtn = document.getElementById('stdbSubmitBtn');

  if (!checkbox || !submitBtn) return;

  function syncStdbButton() {
    if (checkbox.checked) {
      submitBtn.disabled = false;
      submitBtn.classList.remove('bg-gray-200', 'text-gray-500', 'border-gray-300', 'cursor-not-allowed');
      submitBtn.classList.add('bg-green-600', 'hover:bg-green-700', 'text-white', 'border-green-600', 'cursor-pointer');
    } else {
      submitBtn.disabled = true;
      submitBtn.classList.add('bg-gray-200', 'text-gray-500', 'border-gray-300', 'cursor-not-allowed');
      submitBtn.classList.remove('bg-green-600', 'hover:bg-green-700', 'text-white', 'border-green-600', 'cursor-pointer');
    }
  }

  checkbox.addEventListener('change', syncStdbButton);
  syncStdbButton();
});
</script>
@endpush

@endsection