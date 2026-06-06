<div class="relative overflow-hidden rounded-2xl shadow-sm bg-white border border-slate-100">
    @php
        $ahpFinalExists = \App\Models\AhpFinal::first() !== null;
    @endphp
    <!-- Action Bar -->
    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full md:w-1/3">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fas fa-search text-lg text-gray-500"></i>
                </div>
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2"
                    placeholder="Cari nama pekebun atau kebun..."
                >
            </div>
        </div>

        <div class="flex items-center space-x-2">
            <button wire:click="calculateTopsis" @if(!$ahpFinalExists) disabled @endif class="px-4 py-2 {{ $ahpFinalExists ? 'bg-green-600 hover:bg-green-700' : 'bg-slate-400 cursor-not-allowed' }} text-white rounded-lg text-sm transition font-semibold flex items-center">
                <span wire:loading.remove wire:target="calculateTopsis"><i class="fas fa-sync-alt mr-2"></i> Kalkulasi Ulang Ranking</span>
                <span wire:loading wire:target="calculateTopsis"><i class="fas fa-spinner fa-spin mr-2"></i> Mengkalkulasi...</span>
            </button>
        </div>
    </div>

    @if(session()->has('warning'))
        <div class="px-4 pb-4">
            <div class="bg-amber-50 text-amber-800 p-3 rounded-lg text-sm border border-amber-200 flex items-start">
                <i class="fas fa-exclamation-triangle mt-0.5 mr-2"></i>
                <span>{{ session('warning') }}</span>
            </div>
        </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-slate-700">
            <thead class="bg-slate-50 text-sm uppercase text-slate-700 border-b border-slate-100">
                <tr>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-center w-24">Peringkat</th>
                    <th scope="col" class="px-4 sm:px-6 py-3">Nama Pekebun</th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-center">Skor Absolut</th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-center" title="Nilai Preferensi TOPSIS">Vi (TOPSIS)</th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-center">Status ISPO</th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($rankings as $index => $rank)
                    @php
                        $rankValue = '-';
                        $rankClass = '';
                        $rankIcon = '';
                        $textClass = 'text-slate-500';
                        $rankNumber = null;

                        if (!is_null($rank->vi)) {
                            $rankNumber = $allVi->search($rank->vi) + 1;
                            $rankValue = $rankNumber;
                            
                            if ($rankNumber == 1) {
                                $rankClass = 'bg-amber-50/80';
                                $rankIcon = '🥇';
                                $textClass = 'text-amber-600';
                            } elseif ($rankNumber == 2) {
                                $rankClass = 'bg-slate-100/80';
                                $rankIcon = '🥈';
                                $textClass = 'text-slate-500';
                            } elseif ($rankNumber == 3) {
                                $rankClass = 'bg-orange-50/70';
                                $rankIcon = '🥉';
                                $textClass = 'text-orange-700';
                            }
                        }
                    @endphp
                    <tr class="hover:bg-slate-50/60 {{ $rankClass }}">
                        <td class="px-4 sm:px-6 py-3 text-center font-bold align-middle {{ $textClass }}">
                            @if($rankIcon)
                                <span class="text-lg mr-1">{{ $rankIcon }}</span>
                            @endif
                            {{ $rankValue }}
                        </td>
                        <td class="px-4 sm:px-6 py-3 font-medium text-slate-900 align-middle">
                            {{ $rank->kebun->user->name ?? 'User terhapus' }}
                            <div class="text-xs text-slate-500 font-normal mt-0.5">{{ $rank->kebun->nama_kebun ?? '-' }}</div>
                        </td>
                        <td class="px-4 sm:px-6 py-3 text-center align-middle text-slate-700 font-medium">
                            {{ number_format($rank->skor, 2, ',', '.') }}%
                        </td>
                        <td class="px-4 sm:px-6 py-3 text-center font-bold text-blue-700 align-middle">
                            {{ !is_null($rank->vi) ? number_format($rank->vi, 4, ',', '.') : '-' }}
                        </td>
                        <td class="px-4 sm:px-6 py-3 text-center align-middle">
                            @if($rank->kebun->status_ispo === 'sudah-layak')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                    <i class="fa-solid fa-check-circle mr-1"></i> Sudah Layak
                                </span>
                            @elseif($rank->kebun->status_ispo === 'cukup-layak')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fa-solid fa-exclamation-circle mr-1"></i> Cukup Layak
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-800">
                                    <i class="fa-solid fa-times-circle mr-1"></i> Belum Layak
                                </span>
                            @endif
                        </td>
                        <td class="px-4 sm:px-6 py-3 text-center align-middle">
                            <button wire:click="showDetail('{{ $rank->kebun_id }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-blue-600 text-white bg-blue-600 hover:bg-white hover:text-blue-600 transition cursor-pointer" title="Lihat Detail Kebun">
                                <i class="fa-regular fa-eye text-[13px]"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 sm:px-6 py-8 text-center text-sm text-slate-500">
                            Belum ada data yang masuk ke tahap perankingan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $rankings->links('vendor.pagination.custom-pagination') }}
        
        <div class="mt-4 px-4 pb-4 text-xs text-slate-500 leading-relaxed">
            <i class="fa-solid fa-circle-info text-blue-500 mr-1"></i>
            Status ISPO ditentukan berdasarkan skor absolut kuesioner masing-masing pekebun terhadap nilai maksimal, bukan berdasarkan perbandingan antar pekebun. Kolom Peringkat dan Vi (TOPSIS) hanya menunjukkan urutan relatif antar pekebun.
        </div>
    </div>
    
    {{-- Detail Modal --}}
    @if($detailKebun && $detailKebunId)
        <div class="fixed inset-0 z-40 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40" wire:click="closeDetail"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 sticky top-0 bg-white z-10">
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
                            {{ $detailKebun->status_ispo === 'sudah-layak'
                                ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                                : ($detailKebun->status_ispo === 'proses'
                                    ? 'bg-amber-50 text-amber-700 border-amber-100'
                                    : 'bg-slate-50 text-slate-500 border-slate-200') }}">
                            <i class="fa-solid fa-award"></i>
                            @if($detailKebun->status_ispo === 'sudah-layak') Layak ISPO
                            @elseif($detailKebun->status_ispo === 'proses') Proses Kelayakan ISPO
                            @else Belum Layak ISPO
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
