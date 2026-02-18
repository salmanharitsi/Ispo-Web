<div class="bg-white rounded-lg shadow-2xl p-8 md:p-10">
  <!-- Header -->
  <div class="text-center mb-8">
    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
      <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
      </svg>
    </div>
    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Buat Akun Baru</h2>
    <p class="text-gray-600">Lengkapi form di bawah untuk mendaftar</p>
  </div>

  <!-- Register Form -->
  <form wire:submit.prevent="register" class="space-y-5">
    <!-- Name Input -->
    <div>
      <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
        Nama Lengkap <span class="text-red-500">*</span>
      </label>
      <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
        </div>
        <input 
          type="text" 
          id="name" 
          wire:model.live="name"
          class="block w-full pl-10 pr-3 py-3 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
          placeholder="Masukkan nama lengkap Anda"
        >
      </div>
      @error('name')
        <p class="mt-2 text-sm text-red-600 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
      @enderror
    </div>

    <!-- Email Input -->
    <div>
      <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
        Email/No.Hp <span class="text-red-500">*</span>
      </label>
      <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
          </svg>
        </div>
        <input 
          type="email" 
          id="email" 
          wire:model.live="email"
          class="block w-full pl-10 pr-3 py-3 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
          placeholder="masukkan Email/No.Hp"
        >
      </div>
      @error('email')
        <p class="mt-2 text-sm text-red-600 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
      @enderror
    </div>

    <!-- Password Input -->
    <div>
      <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
        Password <span class="text-red-500">*</span>
      </label>
      <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
          </svg>
        </div>
        <input 
          type="password" 
          id="password" 
          wire:model.live="password"
          class="block w-full pl-10 pr-3 py-3 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
          placeholder="Minimal 8 karakter"
        >
      </div>
      @error('password')
        <p class="mt-2 text-sm text-red-600 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
      @else
        <p class="mt-2 text-xs text-gray-500 flex items-center">
          <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
          </svg>
          Gunakan minimal 8 karakter dengan kombinasi huruf dan angka
        </p>
      @enderror
    </div>

    <!-- Password Confirmation Input -->
    <div>
      <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
        Konfirmasi Password <span class="text-red-500">*</span>
      </label>
      <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
          </svg>
        </div>
        <input 
          type="password" 
          id="password_confirmation" 
          wire:model.live="password_confirmation"
          class="block w-full pl-10 pr-3 py-3 border @error('password_confirmation') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
          placeholder="Ulangi password Anda"
        >
      </div>
      @error('password_confirmation')
        <p class="mt-2 text-sm text-red-600 flex items-center">
          <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
          {{ $message }}
        </p>
      @enderror
    </div>

    <!-- Submit Button -->
    <button
      type="submit"
      wire:loading.attr="disabled"
      wire:target="register"
      class="w-full m-0 bg-green-700 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 transition transform hover:scale-[1.02] active:scale-[0.98] shadow-lg disabled:opacity-60 disabled:cursor-not-allowed"
    >
      <span wire:loading.remove wire:target="register">
        Register
      </span>

      <span wire:loading wire:target="register" class="inline-flex items-center justify-center gap-2">
        Proses...
      </span>
    </button>

    <!-- Divider -->
    <div class="relative my-6">
      <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-gray-300"></div>
      </div>
      <div class="relative flex justify-center text-sm">
        <span class="px-4 bg-white text-gray-500">Sudah punya akun?</span>
      </div>
    </div>

    <!-- Login Link -->
    <a 
      href="/login" 
      class="block w-full text-center border-2 border-green-700 text-green-700 py-3 px-4 rounded-lg font-semibold hover:bg-green-50 transition"
    >
      Login
    </a>
  </form>

  <!-- Help Text -->
  <div class="mt-6 text-center">
    <p class="text-sm text-gray-600">
      Butuh bantuan? 
      <a href="/kontak" class="text-green-700 font-semibold hover:text-green-800">Hubungi kami</a>
    </p>
  </div>
</div>