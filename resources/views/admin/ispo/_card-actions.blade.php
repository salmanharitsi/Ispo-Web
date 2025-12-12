<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
  <div class="mb-4">
    <h2 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
      <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-violet-100 text-violet-700 text-xs">
        <i class="fa-solid fa-gavel"></i>
      </span>
      <span>Keputusan Sertifikasi ISPO</span>
    </h2>
    <p class="text-xs text-slate-500 mt-1">
      Berdasarkan hasil penilaian di atas, tentukan keputusan sertifikasi untuk kebun ini.
    </p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
    {{-- Tombol Tolak --}}
    <button 
      onclick="openTolakModal()" 
      class="px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-sm hover:shadow-md"
    >
      <i class="fa-solid fa-times-circle"></i>
      Tolak Sertifikasi
    </button>

    {{-- Tombol Setujui --}}
    <button 
      onclick="openSetujuModal()" 
      class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-sm hover:shadow-md"
    >
      <i class="fa-solid fa-check-circle"></i>
      Setujui Sertifikasi
    </button>
  </div>
</div>

{{-- Modal Tolak Sertifikasi --}}
<div id="tolakModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
  <div class="absolute inset-0 bg-black/50" onclick="closeTolakModal()"></div>
  <div class="relative bg-white rounded-lg shadow-2xl max-w-md w-full p-6">
    <div class="text-center">
      <div class="bg-rose-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
      </div>
      <h3 class="text-2xl font-bold text-gray-800 mb-2">Tolak Sertifikasi?</h3>
      <p class="text-gray-600 mb-6">
        Anda yakin ingin menolak sertifikasi untuk kebun <strong>{{ $kebun->nama_kebun }}</strong>? Silakan berikan alasan penolakan.
      </p>

      {{-- Form Tolak --}}
      {{-- <form action="{{ route('admin.tolak-sertifikasi', $kebun->id) }}" method="POST"> --}}
      <form action="" method="POST">
        @csrf
        <div class="mb-4 text-left">
          <label for="komentar_tolak" class="block text-sm font-medium text-gray-700 mb-2">
            Alasan Penolakan <span class="text-rose-600">*</span>
          </label>
          <textarea 
            name="komentar_tolak" 
            id="komentar_tolak" 
            rows="4" 
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm"
            placeholder="Tuliskan alasan penolakan sertifikasi..."
          ></textarea>
        </div>

        <div class="grid grid-cols-2 gap-3">
          <button 
            type="button"
            onclick="closeTolakModal()" 
            class="px-4 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition"
          >
            Batal
          </button>
          <button 
            type="submit" 
            class="px-4 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-semibold transition"
          >
            Ya, Tolak
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Setujui Sertifikasi --}}
<div id="setujuModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
  <div class="absolute inset-0 bg-black/50" onclick="closeSetujuModal()"></div>
  <div class="relative bg-white rounded-lg shadow-2xl max-w-md w-full p-6">
    <div class="text-center">
      <div class="bg-emerald-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      <h3 class="text-2xl font-bold text-gray-800 mb-2">Setujui Sertifikasi?</h3>
      <p class="text-gray-600 mb-6">
        Anda yakin ingin menyetujui sertifikasi ISPO untuk kebun <strong>{{ $kebun->nama_kebun }}</strong>? Tindakan ini akan mengubah status kebun menjadi "Sudah tersertifikasi".
      </p>

      <div class="grid grid-cols-2 gap-3">
        <button 
          onclick="closeSetujuModal()" 
          class="px-4 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition"
        >
          Batal
        </button>
        {{-- <form action="{{ route('admin.setujui-sertifikasi', $kebun->id) }}" method="POST" class=""> --}}
        <form action="" method="POST" class="">
          @csrf
          <button 
            type="submit" 
            class="w-full px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold transition"
          >
            Ya, Setujui
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function openTolakModal() {
    document.getElementById('tolakModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeTolakModal() {
    document.getElementById('tolakModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
  }

  function openSetujuModal() {
    document.getElementById('setujuModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeSetujuModal() {
    document.getElementById('setujuModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
  }

  // Close modal dengan ESC key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeTolakModal();
      closeSetujuModal();
    }
  });
</script>