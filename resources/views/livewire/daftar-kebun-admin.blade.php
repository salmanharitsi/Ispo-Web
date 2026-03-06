<div class="relative overflow-hidden rounded-2xl shadow-sm bg-white border border-slate-100">

    {{-- Toolbar --}}
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-3 p-4">

        {{-- Search --}}
        <div class="w-full md:w-1/3">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fas fa-search text-lg text-gray-500"></i>
                </div>
                <input
                    wire:model.live="search"
                    type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2"
                    placeholder="cari nama kebun, lokasi, pemilik..."
                >
            </div>
        </div>

        {{-- Filters --}}
        <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">

            {{-- Status ISPO --}}
            <select
                wire:model.live="filterStatusIspo"
                class="border border-slate-300 rounded-lg text-xs px-2 py-1 bg-white focus:ring-green-500 focus:border-green-500"
            >
                <option value="">Semua ISPO</option>
                <option value="belum">Belum sertifikasi</option>
                <option value="proses">Proses sertifikasi</option>
                <option value="sudah">Sudah sertifikasi</option>
            </select>

            {{-- Status Finalisasi --}}
            <select
                wire:model.live="filterStatusFinalisasi"
                class="border border-slate-300 rounded-lg text-xs px-2 py-1 bg-white focus:ring-green-500 focus:border-green-500"
            >
                <option value="">Semua finalisasi</option>
                <option value="belum">Belum final</option>
                <option value="final">Sudah final</option>
            </select>

            {{-- Status Pemetaan --}}
            <select
                wire:model.live="filterPetakan"
                class="border border-slate-300 rounded-lg text-xs px-2 py-1 bg-white focus:ring-green-500 focus:border-green-500"
            >
                <option value="">Semua pemetaan</option>
                <option value="sudah">Sudah dipetakan</option>
                <option value="belum">Belum dipetakan</option>
            </select>

            {{-- Per page --}}
            <div class="flex items-center gap-1">
                <span>Tampil</span>
                <select
                    wire:model.live="perPage"
                    class="border border-slate-300 rounded-lg text-xs px-2 py-1 bg-white focus:ring-green-500 focus:border-green-500"
                >
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span>baris</span>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-slate-700">
            <thead class="bg-slate-50 text-sm uppercase text-slate-700 border-b border-slate-100">
                <tr>
                    <th class="px-4 sm:px-6 py-3">Kebun</th>
                    <th class="px-4 sm:px-6 py-3">Pemilik</th>
                    <th class="px-4 sm:px-6 py-3">Lokasi</th>
                    <th class="px-4 sm:px-6 py-3 text-center">Lahan</th>
                    <th class="px-4 sm:px-6 py-3 text-center">Status</th>
                    <th class="px-4 sm:px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($kebun as $k)
                    <tr class="hover:bg-slate-50/60">

                        {{-- Kebun --}}
                        <td class="px-4 sm:px-6 py-3 align-middle">
                            <div class="font-semibold text-slate-900">{{ $k->nama_kebun }}</div>

                            @if($k->tahun_tanam)
                                <div class="text-xs text-slate-500 mt-0.5">
                                    Tahun tanam: <span class="font-medium">{{ $k->tahun_tanam }}</span>
                                </div>
                            @endif

                            <div class="mt-1 flex flex-wrap gap-1">
                                {{-- Pemetaan --}}
                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] border
                                    {{ $k->polygon
                                        ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                                        : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                    {{ $k->polygon ? 'Terpetakan' : 'Belum dipetakan' }}
                                </span>

                                {{-- Kuisioner --}}
                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] border
                                    {{ $k->kuisioner_exists
                                        ? 'bg-blue-50 text-blue-700 border-blue-100'
                                        : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                                    <i class="fa-regular fa-clipboard"></i>
                                    {{ $k->kuisioner_exists ? 'Kuisioner terisi' : 'Belum isi kuisioner' }}
                                </span>
                            </div>
                        </td>

                        {{-- Pemilik --}}
                        <td class="px-4 sm:px-6 py-3 align-middle">
                            @if($k->user)
                                <div class="font-semibold text-slate-900 text-sm">{{ $k->user->name }}</div>
                                <div class="text-xs text-slate-500 flex items-center gap-1 mt-0.5">
                                    <i class="fa-regular fa-envelope text-slate-400"></i>
                                    {{ $k->user->email }}
                                </div>
                                @if($k->user->no_hp)
                                    <div class="text-xs text-slate-500 flex items-center gap-1 mt-0.5">
                                        <i class="fa-solid fa-phone text-slate-400"></i>
                                        {{ $k->user->no_hp }}
                                    </div>
                                @endif
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>

                        {{-- Lokasi --}}
                        <td class="px-4 sm:px-6 py-3 align-middle">
                            <div class="text-sm text-slate-700">{{ $k->lokasi_kebun }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">
                                @if($k->desa)
                                    Desa {{ $k->desa }}
                                @endif
                                @if($k->desa && $k->kecamatan)
                                    ·
                                @endif
                                @if($k->kecamatan)
                                    Kec. {{ $k->kecamatan }}
                                @endif
                            </div>
                            @if($k->latitude && $k->longitude)
                                <div class="text-[10px] text-slate-400 mt-1 font-mono">
                                    {{ number_format($k->latitude, 6) }}, {{ number_format($k->longitude, 6) }}
                                </div>
                            @endif
                        </td>

                        {{-- Lahan --}}
                        <td class="px-4 sm:px-6 py-3 align-middle text-center">
                            <div class="text-base font-semibold text-emerald-700">
                                {{ number_format($k->luas_lahan, 2, ',', '.') }}
                                <span class="text-xs text-slate-500 font-normal">Ha</span>
                            </div>
                            @if($k->area_hectare)
                                <div class="text-[10px] text-slate-400 mt-0.5">
                                    GPS: {{ number_format($k->area_hectare, 4, ',', '.') }} Ha
                                </div>
                            @endif
                            @if($k->jumlah_pohon)
                                <div class="text-xs text-slate-500 mt-1 flex items-center justify-center gap-1">
                                    <i class="fa-solid fa-tree text-[10px]"></i>
                                    {{ number_format($k->jumlah_pohon) }} pohon
                                </div>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-4 sm:px-6 py-3 align-middle text-center">
                            <div class="flex flex-col items-center gap-1.5">
                                {{-- ISPO --}}
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] border whitespace-nowrap
                                    {{ $k->status_ispo === 'sudah'
                                        ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                                        : ($k->status_ispo === 'proses'
                                            ? 'bg-amber-50 text-amber-700 border-amber-100'
                                            : 'bg-slate-50 text-slate-500 border-slate-200') }}">
                                    <i class="fa-solid fa-award"></i>
                                    @if($k->status_ispo === 'sudah')
                                        Sudah ISPO
                                    @elseif($k->status_ispo === 'proses')
                                        Proses ISPO
                                    @else
                                        Belum ISPO
                                    @endif
                                </span>

                                {{-- Finalisasi --}}
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] border whitespace-nowrap
                                    {{ $k->status_finalisasi === 'final'
                                        ? 'bg-violet-50 text-violet-700 border-violet-100'
                                        : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                                    <i class="fa-solid fa-circle-check"></i>
                                    {{ $k->status_finalisasi === 'final' ? 'Final' : 'Belum final' }}
                                </span>
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 sm:px-6 py-3 align-middle text-center">
                            <div class="inline-flex items-center gap-2">
                                <button
                                    wire:click="showDetail('{{ $k->id }}')"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-green-600 text-white bg-green-600 hover:bg-white hover:text-green-600 transition cursor-pointer"
                                    title="Lihat detail kebun"
                                >
                                    <i class="fa-regular fa-eye text-[13px]"></i>
                                </button>
                                @if($k->polygon)
                                    <a
                                        href="{{ url('/admin/daftar-kebun/' . $k->id . '/peta') }}"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-blue-600 text-white bg-blue-600 hover:bg-white hover:text-blue-600 transition cursor-pointer"
                                        title="Lihat peta lahan"
                                    >
                                        <i class="fa-solid fa-map-location-dot text-[13px]"></i>
                                    </a>
                                @endif
                                <button
                                    wire:click="confirmDelete('{{ $k->id }}')"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-red-600 text-white bg-red-600 hover:bg-white hover:text-red-600 transition cursor-pointer"
                                    title="Hapus kebun"
                                >
                                    <i class="fa-regular fa-trash-can text-[13px]"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 sm:px-6 py-8 text-center text-sm text-slate-500">
                            Tidak ada data kebun yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $kebun->links('vendor.pagination.custom-pagination') }}
    </div>

    {{-- Delete Confirmation Modal --}}
    @if($confirmingDeleteId)
        <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40" wire:click="cancelDelete"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                <div class="text-center">
                    <div class="bg-rose-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Hapus Data Kebun?</h3>
                    <p class="text-sm text-slate-600 mb-4">
                        Data kebun ini akan dihapus permanen, termasuk:
                    </p>
                    <ul class="text-sm text-slate-500 text-left mb-5 space-y-1">
                        <li>• Data kebun dan seluruh informasinya</li>
                        <li>• Data pemetaan polygon dan koordinat</li>
                        <li>• Seluruh data kuisioner terkait kebun ini</li>
                    </ul>
                    <div class="grid grid-cols-2 gap-3">
                        <button
                            wire:click="cancelDelete"
                            class="px-4 py-2.5 border border-slate-200 text-slate-700 rounded-lg font-semibold hover:bg-slate-50 transition"
                        >
                            Batal
                        </button>
                        <button
                            wire:click="deleteKebun"
                            class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-semibold transition"
                        >
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Detail Modal --}}
    @if($detailKebun && $detailKebunId)
        <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40" wire:click="closeDetail"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 sticky top-0 bg-white">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Detail Kebun</h3>
                        <p class="text-sm text-slate-500">Informasi lengkap kebun dan pemiliknya.</p>
                    </div>
                    <button
                        wire:click="closeDetail"
                        class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-slate-100 text-slate-500"
                    >
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <div class="px-6 py-5 space-y-6">

                    {{-- Info dasar & pemilik --}}
                    <div class="grid md:grid-cols-2 gap-5">

                        {{-- Info Kebun --}}
                        <div class="space-y-2">
                            <h4 class="text-sm font-semibold text-slate-700">Informasi Kebun</h4>
                            <div class="text-sm text-slate-800 font-semibold">{{ $detailKebun->nama_kebun }}</div>
                            <div class="text-sm text-slate-500">
                                Lokasi: <span class="font-medium text-slate-700">{{ $detailKebun->lokasi_kebun }}</span>
                            </div>
                            @php
                                $lokasiParts = [];
                                if ($detailKebun->desa) $lokasiParts[] = 'Desa ' . $detailKebun->desa;
                                if ($detailKebun->kecamatan) $lokasiParts[] = 'Kec. ' . $detailKebun->kecamatan;
                            @endphp
                            @if(count($lokasiParts))
                                <div class="text-sm text-slate-500">
                                    {{ implode(', ', $lokasiParts) }}
                                </div>
                            @endif
                            @if($detailKebun->tahun_tanam)
                                <div class="text-sm text-slate-500">
                                    Tahun tanam: <span class="font-medium">{{ $detailKebun->tahun_tanam }}</span>
                                </div>
                            @endif
                            @if($detailKebun->catatan_pengecekan)
                                <div class="text-sm text-slate-500 mt-1 p-2 bg-amber-50 border border-amber-100 rounded-lg">
                                    <span class="font-semibold text-amber-700">Catatan:</span>
                                    {{ $detailKebun->catatan_pengecekan }}
                                </div>
                            @endif
                        </div>

                        {{-- Pemilik --}}
                        <div class="space-y-2">
                            <h4 class="text-sm font-semibold text-slate-700">Pemilik Kebun</h4>
                            @if($detailKebun->user)
                                <div class="text-sm text-slate-800 font-semibold">{{ $detailKebun->user->name }}</div>
                                <div class="text-sm text-slate-700 flex items-center gap-1.5">
                                    <i class="fa-regular fa-envelope text-slate-400"></i>
                                    {{ $detailKebun->user->email }}
                                </div>
                                @if($detailKebun->user->no_hp)
                                    <div class="text-sm text-slate-700 flex items-center gap-1.5">
                                        <i class="fa-solid fa-phone text-slate-400"></i>
                                        {{ $detailKebun->user->no_hp }}
                                    </div>
                                @endif
                                @if($detailKebun->user->alamat)
                                    <div class="text-sm text-slate-500 mt-1">
                                        {{ $detailKebun->user->alamat }}
                                    </div>
                                @endif
                                @php
                                    $domParts = [];
                                    if ($detailKebun->user->kecamatan) $domParts[] = 'Kec. ' . $detailKebun->user->kecamatan;
                                    if ($detailKebun->user->kabupaten) $domParts[] = 'Kab. ' . $detailKebun->user->kabupaten;
                                @endphp
                                @if(count($domParts))
                                    <div class="text-sm text-slate-500">{{ implode(' · ', $domParts) }}</div>
                                @endif
                            @else
                                <p class="text-sm text-slate-400">Data pemilik tidak ditemukan.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Ringkasan statistik --}}
                    <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 grid sm:grid-cols-4 gap-3 text-center">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Luas (input)</p>
                            <p class="text-lg font-bold text-emerald-700">
                                {{ number_format($detailKebun->luas_lahan, 2, ',', '.') }}
                                <span class="text-sm text-slate-500 font-normal">Ha</span>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Luas (GPS)</p>
                            <p class="text-lg font-bold text-slate-900">
                                {{ $detailKebun->area_hectare ? number_format($detailKebun->area_hectare, 4, ',', '.') . ' Ha' : '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Jumlah Pohon</p>
                            <p class="text-lg font-bold text-slate-900">
                                {{ $detailKebun->jumlah_pohon ? number_format($detailKebun->jumlah_pohon) : '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Keliling (GPS)</p>
                            <p class="text-lg font-bold text-slate-900">
                                {{ $detailKebun->perimeter_m ? number_format($detailKebun->perimeter_m, 0, ',', '.') . ' m' : '-' }}
                            </p>
                        </div>
                    </div>

                    {{-- Status badges --}}
                    <div class="flex flex-wrap gap-2">
                        {{-- Pemetaan --}}
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border
                            {{ $detailKebun->polygon
                                ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                                : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                            <i class="fa-solid fa-map-location-dot"></i>
                            {{ $detailKebun->polygon ? 'Sudah dipetakan' : 'Belum dipetakan' }}
                        </span>

                        {{-- Kuisioner --}}
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border
                            {{ $detailKebun->kuisioner
                                ? 'bg-blue-50 text-blue-700 border-blue-100'
                                : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                            <i class="fa-regular fa-clipboard"></i>
                            {{ $detailKebun->kuisioner ? 'Kuisioner terisi' : 'Kuisioner belum diisi' }}
                        </span>

                        {{-- ISPO --}}
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border
                            {{ $detailKebun->status_ispo === 'sudah'
                                ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                                : ($detailKebun->status_ispo === 'proses'
                                    ? 'bg-amber-50 text-amber-700 border-amber-100'
                                    : 'bg-slate-50 text-slate-500 border-slate-200') }}">
                            <i class="fa-solid fa-award"></i>
                            @if($detailKebun->status_ispo === 'sudah') Sudah sertifikasi ISPO
                            @elseif($detailKebun->status_ispo === 'proses') Proses sertifikasi ISPO
                            @else Belum sertifikasi ISPO
                            @endif
                        </span>

                        {{-- Finalisasi --}}
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border
                            {{ $detailKebun->status_finalisasi === 'final'
                                ? 'bg-violet-50 text-violet-700 border-violet-100'
                                : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ $detailKebun->status_finalisasi === 'final' ? 'Data sudah final' : 'Belum final' }}
                        </span>

                        {{-- STDB --}}
                        @if(!is_null($detailKebun->pernyataan_stdb))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border
                                {{ $detailKebun->pernyataan_stdb
                                    ? 'bg-teal-50 text-teal-700 border-teal-100'
                                    : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                                <i class="fa-solid fa-file-shield"></i>
                                {{ $detailKebun->pernyataan_stdb ? 'Pernyataan STDB: Ya' : 'Pernyataan STDB: Tidak' }}
                            </span>
                        @endif
                    </div>

                    {{-- Detail lahan & kepemilikan --}}
                    <div>
                        <h4 class="text-sm font-semibold text-slate-700 mb-3">Informasi Lahan & Kepemilikan</h4>
                        <div class="grid sm:grid-cols-2 gap-2 text-sm">
                            @if($detailKebun->jenis_tanah)
                                <div class="flex items-center gap-2 p-2 bg-slate-50 rounded-lg border border-slate-100">
                                    <i class="fa-solid fa-mountain text-slate-400 w-4 text-center"></i>
                                    <span class="text-slate-500">Jenis tanah:</span>
                                    <span class="font-medium text-slate-800">{{ ucfirst($detailKebun->jenis_tanah) }}</span>
                                </div>
                            @endif
                            @if($detailKebun->asal_lahan)
                                <div class="flex items-center gap-2 p-2 bg-slate-50 rounded-lg border border-slate-100">
                                    <i class="fa-solid fa-leaf text-slate-400 w-4 text-center"></i>
                                    <span class="text-slate-500">Asal lahan:</span>
                                    <span class="font-medium text-slate-800">{{ ucfirst($detailKebun->asal_lahan) }}</span>
                                </div>
                            @endif
                            @if($detailKebun->status_lahan)
                                <div class="flex items-center gap-2 p-2 bg-slate-50 rounded-lg border border-slate-100">
                                    <i class="fa-solid fa-house-chimney text-slate-400 w-4 text-center"></i>
                                    <span class="text-slate-500">Status lahan:</span>
                                    <span class="font-medium text-slate-800">{{ ucfirst($detailKebun->status_lahan) }}</span>
                                </div>
                            @endif
                            @if($detailKebun->dokumen_kepemilikan_lahan)
                                <div class="flex items-center gap-2 p-2 bg-slate-50 rounded-lg border border-slate-100">
                                    <i class="fa-solid fa-file-contract text-slate-400 w-4 text-center"></i>
                                    <span class="text-slate-500">Dokumen:</span>
                                    <span class="font-medium text-slate-800">{{ $detailKebun->dokumen_kepemilikan_lahan }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Detail tanaman & ekonomi --}}
                    <div>
                        <h4 class="text-sm font-semibold text-slate-700 mb-3">Informasi Tanaman & Ekonomi</h4>
                        <div class="grid sm:grid-cols-2 gap-2 text-sm">
                            @if($detailKebun->jenis_bibit)
                                <div class="flex items-center gap-2 p-2 bg-slate-50 rounded-lg border border-slate-100">
                                    <i class="fa-solid fa-seedling text-slate-400 w-4 text-center"></i>
                                    <span class="text-slate-500">Jenis bibit:</span>
                                    <span class="font-medium text-slate-800">{{ ucfirst($detailKebun->jenis_bibit) }}</span>
                                </div>
                            @endif
                            @if(!is_null($detailKebun->frekuensi_panen))
                                <div class="flex items-center gap-2 p-2 bg-slate-50 rounded-lg border border-slate-100">
                                    <i class="fa-solid fa-clock-rotate-left text-slate-400 w-4 text-center"></i>
                                    <span class="text-slate-500">Frekuensi panen:</span>
                                    <span class="font-medium text-slate-800">tiap {{ $detailKebun->frekuensi_panen }} hari</span>
                                </div>
                            @endif
                            @if($detailKebun->kepada_siapa_hasil_panen_dijual)
                                <div class="flex items-center gap-2 p-2 bg-slate-50 rounded-lg border border-slate-100">
                                    <i class="fa-solid fa-industry text-slate-400 w-4 text-center"></i>
                                    <span class="text-slate-500">Dijual ke:</span>
                                    <span class="font-medium text-slate-800">{{ $detailKebun->kepada_siapa_hasil_panen_dijual }}</span>
                                </div>
                            @endif
                            @if(!is_null($detailKebun->harga_jual_tbs_terakhir))
                                <div class="flex items-center gap-2 p-2 bg-slate-50 rounded-lg border border-slate-100">
                                    <i class="fa-solid fa-coins text-slate-400 w-4 text-center"></i>
                                    <span class="text-slate-500">Harga TBS:</span>
                                    <span class="font-medium text-slate-800">
                                        Rp {{ number_format($detailKebun->harga_jual_tbs_terakhir, 0, ',', '.') }}/kg
                                    </span>
                                </div>
                            @endif
                            @if(!is_null($detailKebun->pendapatan_bersih))
                                <div class="flex items-center gap-2 p-2 bg-slate-50 rounded-lg border border-slate-100">
                                    <i class="fa-solid fa-money-bill-wave text-slate-400 w-4 text-center"></i>
                                    <span class="text-slate-500">Pendapatan bersih:</span>
                                    <span class="font-medium text-slate-800">
                                        Rp {{ number_format($detailKebun->pendapatan_bersih, 0, ',', '.') }}/bulan
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Koordinat GPS --}}
                    @if($detailKebun->latitude && $detailKebun->longitude)
                        <div>
                            <h4 class="text-sm font-semibold text-slate-700 mb-2">Koordinat GPS</h4>
                            <div class="flex flex-wrap gap-2 text-xs font-mono">
                                <span class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-700">
                                    Lat: {{ $detailKebun->latitude }}
                                </span>
                                <span class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-700">
                                    Lng: {{ $detailKebun->longitude }}
                                </span>
                                @if($detailKebun->area_m2)
                                    <span class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-700">
                                        Luas: {{ number_format($detailKebun->area_m2, 2, ',', '.') }} m²
                                    </span>
                                @endif
                                @if($detailKebun->perimeter_m)
                                    <span class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-700">
                                        Keliling: {{ number_format($detailKebun->perimeter_m, 2, ',', '.') }} m
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    @endif
</div>
