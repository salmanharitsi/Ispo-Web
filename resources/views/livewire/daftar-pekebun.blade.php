<div class="bg-white rounded-2xl shadow-sm border border-slate-100">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full md:w-1/3">
            <form class="flex items-center">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-search text-lg text-gray-500"></i>
                    </div>
                    <input wire:model.live="search" type="text" id="simple-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2"
                        placeholder="cari berdasarkan nama, email, nik, atau nomor hp" required="">
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-slate-700">
            <thead class="bg-slate-50 text-sm uppercase text-slate-700 border-b border-slate-100">
                <tr>
                    <th class="px-4 sm:px-6 py-3">Pekebun</th>
                    <th class="px-4 sm:px-6 py-3">Kontak</th>
                    <th class="px-4 sm:px-6 py-3">Domisili</th>
                    <th class="px-4 sm:px-6 py-3 text-center">Kebun</th>
                    <th class="px-4 sm:px-6 py-3 text-center">ISPO</th>
                    <th class="px-4 sm:px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($pekebun as $user)
                    <tr class="hover:bg-slate-50/60">
                        {{-- Pekebun --}}
                        <td class="px-4 sm:px-6 py-3 align-middle">
                            <div class="font-semibold text-slate-900">
                                {{ $user->name }}
                            </div>
                            <div class="text-xs text-slate-500 mt-0.5">
                                NIK: <span class="font-mono">{{ $user->nik ?? '-' }}</span>
                            </div>
                            <div class="mt-1 inline-flex items-center gap-1 rounded-full bg-slate-50 px-2 py-0.5 text-[10px] text-slate-500 border border-slate-200">
                                <i class="fa-regular fa-user"></i>
                                <span>{{ $user->jenis_kelamin }}</span>
                                @if($user->jumlah_anggota_keluarga)
                                    <span class="mx-1 text-slate-300">•</span>
                                    <span>{{ $user->jumlah_anggota_keluarga }} anggota keluarga</span>
                                @endif
                            </div>
                        </td>

                        {{-- Kontak --}}
                        <td class="px-4 sm:px-6 py-3 align-middle">
                            <div class="text-sm text-slate-700 flex items-center gap-1">
                                <i class="fa-regular fa-envelope text-slate-400"></i>
                                <span>{{ $user->email }}</span>
                            </div>
                            @if($user->no_hp)
                                <div class="text-sm text-slate-700 flex items-center gap-1 mt-1">
                                    <i class="fa-solid fa-phone text-slate-400"></i>
                                    <span>{{ $user->no_hp }}</span>
                                </div>
                            @endif
                            @if($user->npwp)
                                <div class="text-xs text-slate-500 mt-1">
                                    NPWP: <span class="font-mono">{{ $user->npwp }}</span>
                                </div>
                            @endif
                        </td>

                        {{-- Domisili --}}
                        <td class="px-4 sm:px-6 py-3 align-middle">
                            <div class="text-sm text-slate-700">
                                {{ $user->alamat ?? '-' }}
                            </div>
                            <div class="text-xs text-slate-500 mt-1">
                                @if($user->desa)
                                    Desa {{ $user->desa }},
                                @endif
                                @if($user->kecamatan)
                                    Kec. {{ $user->kecamatan }}
                                @endif
                            </div>
                        </td>

                        {{-- Info Kebun --}}
                        <td class="px-4 sm:px-6 py-3 align-middle text-center">
                            <div class="text-base font-semibold text-slate-900">
                                {{ $user->kebun_count }}
                            </div>
                            <div class="text-xs text-slate-500">
                                kebun
                            </div>
                            <div class="mt-1 text-xs text-emerald-700 font-medium">
                                {{ number_format($user->total_luas_lahan ?? 0, 2, ',', '.') }} Ha
                            </div>
                            <div class="mt-1 flex flex-col gap-0.5 text-[10px] text-slate-500">
                                <span>{{ $user->kebun_mapped_count }} terpetakan</span>
                                <span>{{ $user->kebun_kuisioner_count }} isi kuisioner</span>
                            </div>
                        </td>

                        {{-- Status ISPO --}}
                        <td class="px-4 sm:px-6 py-3 align-middle text-center">
                            <div class="inline-flex flex-col items-center gap-1">
                                @php
                                    $sudah = $user->kebun_ispo_sudah_count;
                                    $total = max($user->kebun_count, 1);
                                    $percent = round(($sudah / $total) * 100);
                                @endphp
                                <span class="text-sm font-semibold text-emerald-600">
                                    {{ $sudah }} / {{ $user->kebun_count }}
                                </span>
                                <span class="text-xs text-slate-500">Sudah sertifikasi</span>
                                <div class="w-20 h-1.5 bg-slate-100 rounded-full overflow-hidden mt-1">
                                    <div
                                        class="h-full bg-emerald-500 rounded-full"
                                        style="width: {{ $percent }}%"
                                    ></div>
                                </div>
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 sm:px-6 py-3 align-middle text-center">
                            <div class="inline-flex items-center gap-2">
                                <button
                                    wire:click="showDetail('{{ $user->id }}')"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-green-600 text-white bg-green-600 hover:bg-white hover:text-green-600 transition cursor-pointer"
                                    title="Lihat detail pekebun"
                                >
                                    <i class="fa-regular fa-eye text-[13px"></i>
                                </button>
                                <button
                                    wire:click="confirmDelete('{{ $user->id }}')"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-red-600 text-white bg-red-600 hover:bg-white hover:text-red-600 transition cursor-pointer"
                                    title="Hapus pekebun"
                                >
                                    <i class="fa-regular fa-trash-can text-[13px]"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 sm:px-6 py-8 text-center text-sm text-slate-500">
                            Tidak ada data pekebun yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $pekebun->links('vendor.pagination.custom-pagination') }}
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
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Hapus Akun Pekebun?</h3>
                    <p class="text-sm text-slate-600 mb-4">
                        Seluruh data terkait pekebun ini akan dihapus permanen:
                    </p>
                    <ul class="text-sm text-slate-500 text-left mb-5 space-y-1">
                        <li>• Data akun pekebun</li>
                        <li>• Seluruh data kebun yang dimiliki</li>
                        <li>• Pemetaan polygon dan koordinat kebun</li>
                        <li>• Seluruh data kuisioner terkait kebun</li>
                    </ul>
                    <div class="grid grid-cols-2 gap-3">
                        <button
                            wire:click="cancelDelete"
                            class="px-4 py-2.5 border border-slate-200 text-slate-700 rounded-lg font-semibold hover:bg-slate-50 transition"
                        >
                            Batal
                        </button>
                        <button
                            wire:click="deleteUser"
                            class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-semibold transition"
                        >
                            Ya, Hapus Semua
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Detail Modal --}}
    @if($detailUser && $detailUserId)
        <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40" wire:click="closeDetail"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Detail Pekebun</h3>
                        <p class="text-sm text-slate-500">
                            Informasi lengkap pekebun dan kebun yang dimiliki.
                        </p>
                    </div>
                    <button
                        wire:click="closeDetail"
                        class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-slate-100 text-slate-500"
                    >
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <div class="px-6 py-5 space-y-6">
                    {{-- Info dasar --}}
                    <div class="grid md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <h4 class="text-sm font-semibold text-slate-700">Data Pribadi</h4>
                            <div class="text-sm text-slate-800 font-semibold">
                                {{ $detailUser->name }}
                            </div>
                            <div class="text-sm text-slate-500">
                                NIK: <span class="font-mono">{{ $detailUser->nik ?? '-' }}</span>
                            </div>
                            <div class="text-sm text-slate-500">
                                NPWP: <span class="font-mono">{{ $detailUser->npwp ?? '-' }}</span>
                            </div>
                            <div class="text-sm text-slate-500">
                                Jenis kelamin:
                                <span class="font-medium">
                                    {{ $detailUser->jenis_kelamin }}
                                </span>
                            </div>
                            <div class="text-sm text-slate-500">
                                Anggota keluarga: <span class="font-medium">{{ $detailUser->jumlah_anggota_keluarga ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <h4 class="text-sm font-semibold text-slate-700">Kontak & Domisili</h4>
                            <div class="text-sm text-slate-700 flex items-center gap-1.5">
                                <i class="fa-regular fa-envelope text-slate-400"></i>
                                <span>{{ $detailUser->email }}</span>
                            </div>
                            @if($detailUser->no_hp)
                                <div class="text-sm text-slate-700 flex items-center gap-1.5">
                                    <i class="fa-solid fa-phone text-slate-400"></i>
                                    <span>{{ $detailUser->no_hp }}</span>
                                </div>
                            @endif
                            <div class="text-sm text-slate-700 mt-2">
                                {{ $detailUser->alamat ?? '-' }}
                            </div>
                            <div class="text-sm text-slate-500">
                                @if($detailUser->desa)
                                    Desa {{ $detailUser->desa }},
                                @endif
                                @if($detailUser->kecamatan)
                                    Kec. {{ $detailUser->kecamatan }}
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Ringkasan Kebun --}}
                    <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 grid sm:grid-cols-3 gap-3 text-center">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Total Kebun</p>
                            <p class="text-lg font-bold text-slate-900">{{ $detailUser->kebun->count() }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Total Luas</p>
                            <p class="text-lg font-bold text-emerald-700">
                                {{ number_format($detailUser->kebun->sum('luas_lahan'), 2, ',', '.') }} <span class="text-sm text-slate-500">Ha</span>
                            </p>
                        </div>
                        <div>
                            @php
                                $sudahIspo = $detailUser->kebun->where('status_ispo', 'sudah')->count();
                            @endphp
                            <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Sertifikasi ISPO</p>
                            <p class="text-lg font-bold text-emerald-700">
                                {{ $sudahIspo }} / {{ $detailUser->kebun->count() }}
                            </p>
                        </div>
                    </div>

                    {{-- List Kebun --}}
                    <div class="space-y-3">
                        <h4 class="text-sm font-semibold text-slate-700">Daftar Kebun</h4>

                        @forelse($detailUser->kebun as $kebun)
                            <div class="border border-slate-100 rounded-xl px-4 py-3 bg-slate-50/60">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">
                                            {{ $kebun->nama_kebun }}
                                        </p>
                                        <p class="text-sm text-slate-500">
                                            {{ $kebun->lokasi_kebun }}
                                            @if($kebun->desa || $kebun->kecamatan)
                                                ·
                                                {{ $kebun->desa ? 'Desa '.$kebun->desa : '' }}
                                                @if($kebun->desa && $kebun->kecamatan) , @endif
                                                {{ $kebun->kecamatan ? 'Kec. '.$kebun->kecamatan : '' }}
                                            @endif
                                        </p>
                                        <div class="mt-1 flex flex-wrap gap-2 text-xs">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-white text-slate-600 border border-slate-200">
                                                <i class="fa-solid fa-ruler-combined text-[10px]"></i>
                                                {{ number_format($kebun->luas_lahan, 2, ',', '.') }} Ha
                                            </span>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-white text-slate-600 border border-slate-200">
                                                <i class="fa-solid fa-tree text-[10px]"></i>
                                                {{ $kebun->jumlah_pohon ?? '-' }} pohon
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-start sm:items-end gap-1 text-xs">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full
                                            @if($kebun->polygon)
                                                bg-emerald-50 text-emerald-700 border border-emerald-100
                                            @else
                                                bg-slate-50 text-slate-500 border border-slate-200
                                            @endif">
                                            <i class="fa-solid fa-map-location-dot text-[10px]"></i>
                                            {{ $kebun->polygon ? 'Sudah dipetakan' : 'Belum dipetakan' }}
                                        </span>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full
                                            @if($kebun->kuisioner)
                                                bg-blue-50 text-blue-700 border border-blue-100
                                            @else
                                                bg-slate-50 text-slate-500 border border-slate-200
                                            @endif">
                                            <i class="fa-regular fa-clipboard text-[10px]"></i>
                                            {{ $kebun->kuisioner ? 'Kuisioner terisi' : 'Kuisioner belum diisi' }}
                                        </span>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full
                                            @if($kebun->status_ispo === 'sudah')
                                                bg-emerald-50 text-emerald-700 border border-emerald-100
                                            @elseif($kebun->status_ispo === 'proses')
                                                bg-amber-50 text-amber-700 border border-amber-100
                                            @else
                                                bg-slate-50 text-slate-500 border border-slate-200
                                            @endif">
                                            <i class="fa-solid fa-award text-[10px]"></i>
                                            @if($kebun->status_ispo === 'sudah')
                                                Sudah sertifikasi ISPO
                                            @elseif($kebun->status_ispo === 'proses')
                                                Proses sertifikasi ISPO
                                            @else
                                                Belum sertifikasi ISPO
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">
                                Pekebun ini belum memiliki data kebun.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
