<div class="bg-white rounded-2xl shadow-sm border border-slate-100">
  {{-- Header & Search --}}
  <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
    <div class="w-full md:w-1/3">
      <form class="flex items-center">
        <label for="pengajuan-search" class="sr-only">Search</label>
        <div class="relative w-full">
          <div class="absolute inset-y-0 left-0 flex items-center pl-3">
            <i class="fas fa-search text-lg text-gray-500"></i>
          </div>
          <input
            wire:model.live="search"
            type="text"
            id="pengajuan-search"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2"
            placeholder="cari nama pemilik, nama kebun, atau lokasi"
          >
        </div>
      </form>
    </div>

    <div class="flex items-center space-x-2 text-xs text-slate-500">
      <span>Menampilkan</span>
      <select
        wire:model.live="perPage"
        class="border border-slate-300 rounded-lg text-xs px-2 py-1 bg-white focus:ring-green-500 focus:border-green-500"
      >
        <option value="10">10 baris</option>
        <option value="25">25 baris</option>
        <option value="50">50 baris</option>
      </select>
      <span>per halaman</span>
    </div>
  </div>

  {{-- Table --}}
  <div class="overflow-x-auto">
    <table class="min-w-full text-left text-slate-700">
      <thead class="bg-slate-50 text-sm uppercase text-slate-700 border-b border-slate-100">
        <tr>
          <th class="px-4 sm:px-6 py-3">Pemilik Kebun</th>
          <th class="px-4 sm:px-6 py-3">Nama Kebun</th>
          <th class="px-4 sm:px-6 py-3">Lokasi</th>
          <th class="px-4 sm:px-6 py-3 text-center">Luas & Pohon</th>
          <th class="px-4 sm:px-6 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        @forelse ($pengajuan as $kebun)
          <tr class="hover:bg-slate-50/60">
            {{-- Pemilik --}}
            <td class="px-4 sm:px-6 py-3 align-middle">
              <div class="font-semibold text-slate-900">
                {{ $kebun->user->name ?? '-' }}
              </div>
              <div class="text-xs text-slate-500 mt-0.5">
                {{ $kebun->user->email ?? '-' }}
              </div>
            </td>

            {{-- Nama Kebun --}}
            <td class="px-4 sm:px-6 py-3 align-middle">
              <div class="font-medium text-green-700 bg-green-50 border border-green-700 px-3 py-1 rounded-lg text-sm w-fit text-center">
                {{ $kebun->nama_kebun }}
              </div>
            </td>

            {{-- Lokasi --}}
            <td class="px-4 sm:px-6 py-3 align-middle">
              <div class="text-sm text-slate-700">
                {{ $kebun->lokasi_kebun }}
              </div>
              <div class="text-xs text-slate-500 mt-1">
                @if($kebun->desa)
                  Desa {{ $kebun->desa }},
                @endif
                @if($kebun->kecamatan)
                  Kec. {{ $kebun->kecamatan }}
                @endif
              </div>
            </td>

            {{-- Luas & Pohon --}}
            <td class="px-4 sm:px-6 py-3 align-middle text-center">
              <div class="text-base font-semibold text-emerald-700">
                {{ number_format($kebun->luas_lahan, 2, ',', '.') }} <span class="text-xs text-slate-500">Ha</span>
              </div>
              <div class="text-xs text-slate-600 mt-1">
                {{ number_format($kebun->jumlah_pohon ?? 0, 0, ',', '.') }} pohon
              </div>
            </td>

            {{-- Aksi --}}
            <td class="px-4 sm:px-6 py-3 align-middle text-center">
              <a
                href="{{ url('/admin/pengajuan-ispo', $kebun->id) }}"
                class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition cursor-pointer"
              >
                <i class="fa-solid fa-calculator mr-2 text-[11px]"></i>
                Hitung SPK
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="px-4 sm:px-6 py-8 text-center text-sm text-slate-500">
              Belum ada pengajuan ISPO dengan status <span class="font-semibold">final</span> &amp; <span class="font-semibold">proses sertifikasi</span>.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
    {{ $pengajuan->links('vendor.pagination.custom-pagination') }}
  </div>
</div>
