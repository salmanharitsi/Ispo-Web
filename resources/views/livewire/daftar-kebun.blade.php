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
      <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
        
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
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                </svg>
                Pemetaan
              </span>
              @if($kebun->polygon)
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

            <!-- Status Kuisioner -->
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

            <!-- Status Kuisioner -->
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
              <span class="text-gray-600 text-sm flex items-center">
                <i class="fa-solid fa-sign-hanging w-5 h-5 mr-2 text-green-600"></i>
                Pernyataan STDB
              </span>
              @if($kebun->pernyataan_stdb == true)
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

            <!-- Status ISPO -->
            <div class="flex items-center justify-between py-2">
              <span class="text-gray-600 text-sm flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
                Sertifikasi ISPO
              </span>
              @if($kebun->status_ispo == 'sudah')
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                  Tersertifikasi
                </span>
              @elseif($kebun->status_ispo == 'proses')
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">
                  Proses
                </span>
              @else
                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold">
                  Belum
                </span>
              @endif
            </div>
          </div>

          <!-- Button Lihat Detail -->
          <a href="{{ url('/pekebun/daftar-kebun/' . $kebun->id) }}" class="w-full flex gap-2 items-center justify-center bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition-colors mt-4">
            <i class="fas fa-eye text-lg w-5"></i>
            Lihat Detail
          </a>
        </div>

      </div>
      @endforeach
    </div>
  @else
    @if ($isDataDiriComplete)
      <!-- Empty State -->
      <div class="bg-white rounded-lg shadow-lg p-12 text-center">
        <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Data Kebun</h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
          Anda belum memiliki data kebun. Tambahkan data kebun kelapa sawit Anda untuk memulai proses penilaian kesiapan ISPO.
        </p>
        <button 
          wire:click="openModal"
          class="inline-flex items-center bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition shadow-lg"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Tambah Kebun Pertama
        </button>
      </div>
    @else
      <div class="bg-yellow-50 border border-yellow-600 text-yellow-800 px-4 py-3 rounded-lg mb-6 flex items-center">
        <svg class="w-5 h-5 mr-3 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
        </svg>
        <span class="font-medium">Lengkapi data diri Anda di halaman profil sebelum menambahkan data kebun.</span>
      </div>
    @endif
  @endif

    <!-- Modal Tambah Kebun -->
  @if($showModal)
  <div class="fixed inset-0 z-50 flex items-center justify-center p-4" wire:click.self="closeModal">
    <div class="absolute inset-0 bg-black/50 z-0"></div>
    <div class="relative bg-white rounded-lg shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
      <!-- Modal Header -->
      <div class="sticky top-0 bg-linear-to-r from-green-600 to-green-700 text-white p-6 rounded-t-2xl z-10">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-2xl font-bold">Tambah Data Kebun</h3>
            <p class="text-green-100 text-sm mt-1">Lengkapi informasi kebun kelapa sawit Anda</p>
          </div>
          <button wire:click="closeModal" type="button" class="text-white hover:bg-green-800 p-2 rounded-lg transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Modal Body -->
      <form wire:submit.prevent="save" class="p-6">
        <div class="space-y-5">
          {{-- Identitas Kebun --}}
          <div class="grid md:grid-cols-2 gap-5">
            <!-- Nama Kebun -->
            <div class="col-span-2">
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Nama Kebun <span class="text-red-500">*</span>
              </label>
              <input 
                type="text" 
                wire:model="nama_kebun"
                class="w-full px-4 py-3 border @error('nama_kebun') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                placeholder="Contoh: Kebun Sawit Makmur"
              >
              @error('nama_kebun')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Lokasi Kebun -->
            <div class="col-span-2">
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Lokasi Kebun <span class="text-red-500">*</span>
              </label>
              <input 
                type="text" 
                wire:model="lokasi_kebun"
                class="w-full px-4 py-3 border @error('lokasi_kebun') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                placeholder="Contoh: Jl. Raya Desa Sejahtera"
              >
              @error('lokasi_kebun')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Desa -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Desa/Kelurahan <span class="text-red-500">*</span></label>
              <input 
                type="text" 
                wire:model="desa"
                class="w-full px-4 py-3 border @error('desa') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                placeholder="Nama desa"
              >
              @error('desa')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Kecamatan -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan <span class="text-red-500">*</span></label>
              <input 
                type="text" 
                wire:model="kecamatan"
                class="w-full px-4 py-3 border @error('kecamatan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                placeholder="Nama kecamatan"
              >
              @error('kecamatan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>

          {{-- Luas & Tanaman --}}
          <div class="grid md:grid-cols-3 gap-5">
            <!-- Luas Lahan -->
            <div class="md:col-span-1">
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Luas Lahan (Hektar) <span class="text-red-500">*</span>
              </label>
              <input 
                type="number" 
                step="0.01"
                wire:model="luas_lahan"
                class="w-full px-4 py-3 border @error('luas_lahan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                placeholder="Contoh: 5.50"
              >
              @error('luas_lahan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Tahun Tanam -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Tahun Tanam <span class="text-red-500">*</span>
              </label>
              <input 
                type="number" 
                wire:model="tahun_tanam"
                class="w-full px-4 py-3 border @error('tahun_tanam') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                placeholder="{{ date('Y') }}"
              >
              @error('tahun_tanam')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Jumlah Pohon -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Jumlah Pohon <span class="text-red-500">*</span>
              </label>
              <input 
                type="number" 
                wire:model="jumlah_pohon"
                class="w-full px-4 py-3 border @error('jumlah_pohon') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                placeholder="Contoh: 650"
              >
              @error('jumlah_pohon')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>

          {{-- Info Lahan & Kepemilikan --}}
          <div class="grid md:grid-cols-2 gap-5">
            <!-- Jenis Tanah -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Jenis Tanah <span class="text-red-500">*</span>
              </label>
              <select
                wire:model="jenis_tanah"
                class="w-full px-4 py-3 border @error('jenis_tanah') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition bg-white"
              >
                <option value="">Pilih jenis tanah</option>
                <option value="mineral">Mineral</option>
                <option value="gambut">Gambut</option>
              </select>
              @error('jenis_tanah')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Asal Lahan -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Asal Lahan <span class="text-red-500">*</span>
              </label>
              <select
                wire:model="asal_lahan"
                class="w-full px-4 py-3 border @error('asal_lahan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition bg-white"
              >
                <option value="">Pilih asal lahan</option>
                <option value="bekas hutan">Bekas hutan</option>
                <option value="bekas karet">Bekas karet</option>
                <option value="ladang lama">Ladang lama</option>
                <option value="lainnya">Lainnya</option>
              </select>
              @error('asal_lahan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Status Lahan -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Status Lahan <span class="text-red-500">*</span>
              </label>
              <select
                wire:model="status_lahan"
                class="w-full px-4 py-3 border @error('status_lahan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition bg-white"
              >
                <option value="">Pilih status lahan</option>
                <option value="milik sendiri">Milik sendiri</option>
                <option value="sewa">Sewa</option>
                <option value="warisan">Warisan</option>
                <option value="lainnya">Lainnya</option>
              </select>
              @error('status_lahan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Dokumen Kepemilikan Lahan -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Dokumen Kepemilikan Lahan <span class="text-red-500">*</span>
              </label>
              <select
                wire:model="dokumen_kepemilikan_lahan"
                class="w-full px-4 py-3 border @error('dokumen_kepemilikan_lahan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition bg-white"
              >
                <option value="">Pilih dokumen</option>
                <option value="surat hak milik">Surat hak milik</option>
                <option value="surat keterangan tanah/surat jual beli">Surat keterangan tanah / surat jual beli</option>
                <option value="tidak punya dokumen">Tidak punya dokumen</option>
              </select>
              @error('dokumen_kepemilikan_lahan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>

          {{-- Tanaman & Produksi --}}
          <div class="grid md:grid-cols-2 gap-5">
            <!-- Jenis Bibit -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Jenis Bibit <span class="text-red-500">*</span>
              </label>
              <select
                wire:model="jenis_bibit"
                class="w-full px-4 py-3 border @error('jenis_bibit') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition bg-white"
              >
                <option value="">Pilih jenis bibit</option>
                <option value="bersertifikat">Bersertifikat</option>
                <option value="tidak bersertifikat">Tidak bersertifikat</option>
              </select>
              @error('jenis_bibit')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Frekuensi Panen -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Frekuensi Panen (hari) <span class="text-red-500">*</span>
              </label>
              <input 
                type="integer" 
                wire:model="frekuensi_panen"
                class="w-full px-4 py-3 border @error('frekuensi_panen') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                placeholder="Contoh: 14 hari"
              >
              @error('frekuensi_panen')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Harga Jual TBS Terakhir -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Harga Jual TBS Terakhir (Rp/kg) <span class="text-red-500">*</span>
              </label>
              <input 
                type="number" 
                wire:model="harga_jual_tbs_terakhir"
                class="w-full px-4 py-3 border @error('harga_jual_tbs_terakhir') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                placeholder="Contoh: 2300"
              >
              @error('harga_jual_tbs_terakhir')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Pendapatan Bersih -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Pendapatan Bersih per Bulan (Rp) <span class="text-red-500">*</span>
              </label>
              <input 
                type="number" 
                wire:model="pendapatan_bersih"
                class="w-full px-4 py-3 border @error('pendapatan_bersih') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                placeholder="Contoh: 3000000"
              >
              @error('pendapatan_bersih')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Kepada Siapa Hasil Panen Dijual -->
            <div class="md:col-span-2">
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Kepada Siapa Hasil Panen Dijual <span class="text-red-500">*</span>
              </label>
              <select
                wire:model="kepada_siapa_hasil_panen_dijual"
                class="w-full px-4 py-3 border @error('kepada_siapa_hasil_panen_dijual') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition bg-white"
              >
                <option value="">Pilih tujuan penjualan</option>
                <option value="RAM">RAM</option>
                <option value="PKS langsung">PKS langsung</option>
              </select>
              @error('kepada_siapa_hasil_panen_dijual')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
          <button 
            type="button"
            wire:click="closeModal"
            class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition"
          >
            Batal
          </button>
          <button 
            type="submit" 
            class="px-8 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition shadow-lg flex items-center"
            wire:loading.attr="disabled"
            wire:target="save"
          >
            <span wire:loading.remove>
              <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              Simpan Data
            </span>
            <span wire:loading class="flex items-center">
              Menyimpan...
            </span>
          </button>
        </div>
      </form>
    </div>
  </div>
  @endif

</div>