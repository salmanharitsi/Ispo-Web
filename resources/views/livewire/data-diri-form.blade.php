<div class="p-8">
  <!-- Success Message -->
  @if (session()->has('message'))
  <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
    <div class="flex items-center">
      <svg class="w-5 h-5 mr-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
      </svg>
      <span class="font-medium">{{ session('message') }}</span>
    </div>
    <button @click="show = false" class="text-green-600 hover:text-green-800">
      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
      </svg>
    </button>
  </div>
  @endif

  <form wire:submit.prevent="save">
    <!-- Foto Profil Section -->
    <div class="mb-8 pb-8 border-b border-gray-200">
      <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        Foto Profil <span class="text-red-500">*</span>
      </h3>
      
      <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
        <!-- Preview Image -->
        <div class="relative">
          @if ($foto_profil)
            <img src="{{ $foto_profil->temporaryUrl() }}" class="w-32 h-32 rounded-full object-cover border-4 border-green-100 shadow-lg">
          @elseif ($existing_foto)
            <img src="{{ Storage::url($existing_foto) }}" class="w-32 h-32 rounded-full object-cover border-4 border-green-100 shadow-lg">
          @else
            <div class="w-32 h-32 rounded-full bg-linear-to-br from-green-100 to-green-200 flex items-center justify-center border-4 border-green-100 shadow-lg">
              <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </div>
          @endif
        </div>

        <!-- Upload Controls -->
        <div class="flex-1">
          <div class="flex flex-wrap gap-3">
            <label class="cursor-pointer inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-md">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
              </svg>
              <span wire:loading.remove wire:target="foto_profil">Upload Foto</span>
              <span wire:loading wire:target="foto_profil">Uploading...</span>
              <input type="file" wire:model="foto_profil" accept="image/*" class="hidden">
            </label>

            @if ($existing_foto || $foto_profil)
            <button type="button" wire:click="removeFoto" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-md">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
              </svg>
              Hapus Foto
            </button>
            @endif
          </div>
          
          <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG, atau JPEG. Maksimal 2MB</p>
          
          @error('foto_profil')
            <p class="mt-2 text-sm text-red-600 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
              {{ $message }}
            </p>
          @enderror
        </div>
      </div>
    </div>

    <!-- Data Pribadi Section -->
    <div class="mb-8 pb-8 border-b border-gray-200">
      <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Data Pribadi
      </h3>

      <div class="grid md:grid-cols-2 gap-6">
        <!-- Nama Lengkap -->
        <div class="col-span-2 md:col-span-1">
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Nama Lengkap <span class="text-red-500">*</span>
          </label>
          <input 
            type="text" 
            wire:model.live="name"
            class="w-full px-4 py-3 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
            placeholder="Masukkan nama lengkap"
          >
          @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Email -->
        <div class="col-span-2 md:col-span-1">
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Email <span class="text-red-500">*</span>
          </label>
          <input 
            type="email" 
            wire:model.live="email"
            class="w-full px-4 py-3 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg bg-gray-200 transition"
            placeholder="contoh@email.com"
            disabled
          >
        </div>

        <!-- Jenis Kelamin -->
        <div class="col-span-2">
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Jenis Kelamin <span class="text-red-500">*</span>
          </label>
          <div class="flex gap-6 mt-3">
            <label class="flex items-center cursor-pointer">
              <input 
                type="radio" 
                wire:model="jenis_kelamin" 
                value="Laki-laki"
                class="w-4 h-4 text-green-600 focus:ring-green-500 border-gray-300"
              >
              <span class="ml-2 text-gray-700">Laki-laki</span>
            </label>
            <label class="flex items-center cursor-pointer">
              <input 
                type="radio" 
                wire:model="jenis_kelamin" 
                value="Perempuan"
                class="w-4 h-4 text-green-600 focus:ring-green-500 border-gray-300"
              >
              <span class="ml-2 text-gray-700">Perempuan</span>
            </label>
          </div>
          @error('jenis_kelamin')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- No HP -->
        <div class="col-span-2 md:col-span-1">
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Nomor HP <span class="text-red-500">*</span>
          </label>
          <input 
            type="number" 
            wire:model.live="no_hp"
            class="w-full px-4 py-3 border @error('no_hp') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
            placeholder="08xxxxxxxxxx"
          >
          @error('no_hp')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Jumlah Anggota Keluarga -->
        <div class="col-span-2 md:col-span-1">
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Jumlah Anggota Keluarga <span class="text-red-500">*</span>
          </label>
          <input 
            type="number" 
            wire:model.live="jumlah_anggota_keluarga"
            min="1"
            class="w-full px-4 py-3 border @error('jumlah_anggota_keluarga') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
            placeholder="Contoh: 4"
          >
          @error('jumlah_anggota_keluarga')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- NIK -->
        <div class="col-span-2 md:col-span-1">
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            NIK (16 Digit) <span class="text-red-500">*</span>
          </label>
          <input 
            type="number" 
            wire:model.live="nik"
            maxlength="16"
            class="w-full px-4 py-3 border @error('nik') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
            placeholder="16 digit NIK"
          >
          @error('nik')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- NPWP -->
        <div class="col-span-2 md:col-span-1">
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            NPWP <span class="text-red-500">*</span>
          </label>
          <input 
            type="number" 
            wire:model.live="npwp"
            class="w-full px-4 py-3 border @error('npwp') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
            placeholder="Nomor NPWP"
          >
          @error('npwp')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>
    </div>

    <!-- Alamat Section -->
    <div class="mb-8">
      <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        Alamat
      </h3>

      <div class="grid md:grid-cols-2 gap-6">
        <!-- Alamat Lengkap -->
        <div class="md:col-span-2">
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Alamat Lengkap <span class="text-red-500">*</span>
          </label>
          <textarea 
            wire:model.live="alamat"
            rows="3"
            class="w-full px-4 py-3 border @error('alamat') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
            placeholder="Masukkan alamat lengkap"
          ></textarea>
          @error('alamat')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Desa -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Desa/Kelurahan <span class="text-red-500">*</span>
          </label>
          <input 
            type="text" 
            wire:model.live="desa"
            class="w-full px-4 py-3 border @error('desa') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
            placeholder="Nama desa/kelurahan"
          >
          @error('desa')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Kecamatan -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Kecamatan <span class="text-red-500">*</span>
          </label>
          <input 
            type="text" 
            wire:model.live="kecamatan"
            class="w-full px-4 py-3 border @error('kecamatan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
            placeholder="Nama kecamatan"
          >
          @error('kecamatan')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="flex flex-col-reverse md:flex-row justify-end gap-4 pt-6 border-t border-gray-200">
      <button 
        type="submit" 
        class="px-8 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition shadow-lg flex items-center justify-center"
        wire:loading.attr="disabled"
        wire:target="save"
      >
        <span wire:loading.remove wire:target="save">
          <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          Simpan Perubahan
        </span>
        <span wire:loading wire:target="save" class="flex items-center">
          Menyimpan...
        </span>
      </button>
    </div>
  </form>
</div>