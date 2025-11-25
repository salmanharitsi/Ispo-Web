<div>
  <!-- Search Bar -->
  <div class="mb-6">
    <div class="relative">
      <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
      </div>
      <input 
        type="text" 
        wire:model.live.debounce.300ms="search"
        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
        placeholder="Cari kebun berdasarkan nama, lokasi, desa, atau kecamatan..."
      >
    </div>
    @if($search)
    <p class="mt-6 text-sm text-gray-600">
      Ditemukan <span class="font-semibold text-green-600">{{ $kebuns->count() }}</span> kebun
    </p>
    @endif
  </div>

  @if($kebuns->count() > 0)
    <!-- Kebun Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($kebuns as $kebun)
      <div class="h-fit bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
        
        <!-- Header dengan Nama Kebun -->
        <div class="bg-linear-to-r from-green-600 to-green-700 p-5 text-white">
          <h3 class="text-lg font-bold mb-2">{{ $kebun->nama_kebun }}</h3>
          <div class="flex items-center text-green-50 text-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            {{ $kebun->lokasi_kebun }}
          </div>
        </div>

        <!-- Body Card -->
        <div class="p-5">
          
          <!-- Info Luas Lahan (Highlight) -->
          <div class="bg-green-50 rounded-lg p-4 mb-4 text-center border border-green-200">
            <p class="text-gray-600 text-sm mb-1">Luas Lahan</p>
            <p class="text-3xl font-bold text-green-700">
              {{ number_format($kebun->luas_lahan, 2) }}
              <span class="text-lg font-normal text-gray-600">Ha</span>
            </p>
          </div>

          <!-- Informasi Tambahan -->
          <div class="space-y-3 mb-4">
            @if($kebun->jumlah_pohon)
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
              <span class="text-gray-600 text-sm flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Jumlah Pohon
              </span>
              <span class="font-semibold text-gray-800">{{ number_format($kebun->jumlah_pohon) }}</span>
            </div>
            @endif

            @if($kebun->umur_tanaman)
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
              <span class="text-gray-600 text-sm flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Umur Tanaman
              </span>
              <span class="font-semibold text-gray-800">{{ $kebun->umur_tanaman }} Tahun</span>
            </div>
            @endif

            <!-- Status Pemetaan -->
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
              <span class="text-gray-600 text-sm flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Kuisioner
              </span>
              @if($kebun->kuisioner)
                <span class="text-green-600 font-semibold text-sm flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                  Sudah
                </span>
              @else
                <span class="text-gray-400 font-semibold text-sm">Belum</span>
              @endif
            </div>
          </div>

          @if ($kebun->status_finalisasi == "belum" && $kebun->polygon)
            <a href="{{ url('/pekebun/daftar-kuisioner/' . $kebun->id) }}" class="w-full flex gap-2 items-center justify-center bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition-colors mt-4">
              <i class="fas fa-list text-lg w-5"></i>
              Isi Kuisioner
            </a>
          @elseif ($kebun->status_finalisasi == "belum" && !$kebun->polygon)
            <div>
                <div class="p-3 bg-red-50 border border-red-400 rounded-lg text-center">
                  <p class="text-xs text-red-600 font-semibold">Anda perlu memetakan area kebun terlebih dahulu sebelum mengisi kuisioner.</p>
                </div>
                <a href="{{ url('/pekebun/daftar-pemetaan/' . $kebun->id) }}" class="w-full flex gap-2 items-center justify-center bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition-colors mt-4">
                    <i class="fas fa-location-crosshairs text-lg w-5"></i>
                    Petakan area
                </a>
            </div>
          @else
            <button disabled class="w-full flex gap-2 items-center justify-center bg-gray-300 text-white font-semibold py-3 rounded-lg mt-4 cursor-not-allowed">
              <i class="fas fa-clock text-lg w-5"></i>
              Proses pengecekan
            </button>
          @endif
        </div>

      </div>
      @endforeach
    </div>
  @else
    <!-- Empty State -->
    <div class="bg-white rounded-lg shadow-lg p-12 text-center">
        <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Data Kebun</h3>
        <p class="text-gray-600 max-w-md mx-auto">
        Anda belum memiliki data kebun. Tambahkan data kebun kelapa sawit Anda untuk memulai proses sertifikasi ISPO.
        </p>
    </div>
  @endif
</div>