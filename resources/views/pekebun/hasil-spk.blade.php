@extends('layouts.pekebun')

@section('title', 'Hasil SPK Kesiapan ISPO')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="mb-6">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 flex items-center">
            Hasil SPK Kesiapan ISPO
          </h1>
          <p class="text-gray-600 mt-1">Pantau status pengajuan dan peringkat kesiapan ISPO kebun Anda</p>
        </div>
      </div>
    </div>

    <!-- Table Section -->
    <div class="relative overflow-hidden rounded-2xl shadow-sm bg-white border border-slate-100">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-slate-700">
                <thead class="bg-slate-50 text-sm uppercase text-slate-700 border-b border-slate-100">
                    <tr>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-center w-24">Peringkat</th>
                        <th scope="col" class="px-4 sm:px-6 py-3">Nama Kebun</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-center">Skor Absolut</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-center" title="Nilai Preferensi TOPSIS">Vi (TOPSIS)</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-center">Status Pengajuan</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-center">Saran</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-center">Aksi (Edit & Ajukan Ulang)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($kebuns as $index => $kebun)
                        @php
                            $rankValue = '-';
                            $rankClass = '';
                            $rankIcon = '';
                            $textClass = 'text-slate-500';
                            
                            $rank = $kebun->topsisRanking;

                            if ($rank && !is_null($rank->vi)) {
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
                                {{ $kebun->nama_kebun ?? '-' }}
                                <div class="text-xs text-slate-500 font-normal mt-0.5">Luas: {{ number_format($kebun->luas_lahan, 2, ',', '.') }} Ha</div>
                                @if(in_array($kebun->status_finalisasi, ['tolak', 'revisi']) && $kebun->catatan_pengecekan)
                                    @php
                                        $alertBg = $kebun->status_finalisasi === 'tolak' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-blue-50 text-blue-700 border-blue-200';
                                        $alertTitle = $kebun->status_finalisasi === 'tolak' ? 'Alasan Penolakan:' : 'Informasi:';
                                    @endphp
                                    <div class="mt-2 text-xs {{ $alertBg }} p-2 rounded-md border">
                                        <span class="font-bold">{{ $alertTitle }}</span> {{ $kebun->catatan_pengecekan }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-3 text-center align-middle text-slate-700 font-medium">
                                {{ $rank ? number_format($rank->skor, 2, ',', '.') . '%' : '-' }}
                            </td>
                            <td class="px-4 sm:px-6 py-3 text-center font-bold text-green-700 align-middle">
                                {{ ($rank && !is_null($rank->vi)) ? number_format($rank->vi, 4, ',', '.') : '-' }}
                            </td>
                            <td class="px-4 sm:px-6 py-3 text-center align-middle">
                                @if($kebun->status_finalisasi === 'final')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800 whitespace-nowrap">
                                        <i class="fa-solid fa-clock mr-1"></i> Proses Pengecekan
                                    </span>
                                @elseif($kebun->status_finalisasi === 'tolak')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 whitespace-nowrap">
                                        <i class="fa-solid fa-times-circle mr-1"></i> Ditolak
                                    </span>
                                @elseif($kebun->status_finalisasi === 'revisi')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 whitespace-nowrap">
                                        <i class="fa-solid fa-pen mr-1"></i> Sedang Direvisi
                                    </span>
                                @elseif($kebun->status_finalisasi === 'perankingan')
                                    @if($kebun->status_ispo === 'sudah-layak')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 whitespace-nowrap">
                                            <i class="fa-solid fa-check-circle mr-1"></i> Sudah Layak ISPO
                                        </span>
                                    @elseif($kebun->status_ispo === 'cukup-layak')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 whitespace-nowrap">
                                            <i class="fa-solid fa-exclamation-circle mr-1"></i> Cukup Layak ISPO
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-800 whitespace-nowrap">
                                            <i class="fa-solid fa-times-circle mr-1"></i> Belum Layak ISPO
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-3 text-center align-middle">
                                @if($kebun->status_finalisasi === 'final' || $kebun->status_finalisasi === 'revisi' || $kebun->status_finalisasi === 'tolak')
                                    <span class="text-xs text-slate-400 italic">-</span>
                                @elseif($kebun->kuisioner && count($kebun->kuisioner->saran) > 0)
                                    @php $jumlahSaran = count($kebun->kuisioner->saran); @endphp
                                    <button type="button" onclick='openSaranModal(@json($kebun->kuisioner->saran), "{{ addslashes($kebun->nama_kebun) }}")' class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 hover:border-amber-300 transition-all cursor-pointer group">
                                        <i class="fa-solid fa-lightbulb text-amber-500 group-hover:text-amber-600 transition-colors"></i>
                                        <span class="whitespace-nowrap">{{ $jumlahSaran }} Saran</span> 
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px] opacity-50 group-hover:opacity-100 transition-opacity"></i>
                                    </button>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class="fa-solid fa-circle-check"></i> 
                                        <span class="whitespace-nowrap">Semua Terpenuhi</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-3 text-center align-middle">
                                @if($kebun->status_finalisasi === 'final')
                                    <button disabled class="w-full flex gap-2 items-center justify-center bg-gray-300 text-white font-semibold py-2 px-3 rounded-lg text-xs cursor-not-allowed">
                                        <i class="fas fa-clock"></i> 
                                        <span class="whitespace-nowrap">Proses Pengecekan Admin</span>
                                    </button>
                                @else
                                    <div class="flex flex-col space-y-2">
                                        <div class="flex space-x-2">
                                            <a href="{{ url('/pekebun/daftar-pemetaan/' . $kebun->id) }}" class="flex-1 flex gap-1 items-center justify-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-2 rounded-lg text-xs transition-colors" title="Edit Pemetaan">
                                                <i class="fas fa-location-crosshairs"></i> Pemetaan
                                            </a>
                                            <a href="{{ url('/pekebun/daftar-kuisioner/' . $kebun->id) }}" class="flex-1 flex gap-1 items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-2 rounded-lg text-xs transition-colors" title="Edit Kuisioner">
                                                <i class="fas fa-list"></i> Kuisioner
                                            </a>
                                        </div>
                                        <button type="button" onclick="openFinalizeModal('{{ $kebun->id }}', '{{ addslashes($kebun->nama_kebun) }}')" class="w-full flex gap-2 items-center justify-center bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-3 rounded-lg text-xs transition-colors">
                                            <i class="fas fa-paper-plane"></i> Ajukan Ulang
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 sm:px-6 py-8 text-center text-sm text-slate-500">
                                Belum ada kebun yang diajukan untuk pengecekan kelayakan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4 px-4 pb-4 text-xs text-slate-500 leading-relaxed">
                <i class="fa-solid fa-circle-info text-green-500 mr-1"></i>
                Peringkat yang ditampilkan adalah peringkat sementara berdasarkan kalkulasi TOPSIS terakhir dari admin. Anda dapat memperbaiki data Pemetaan dan Kuisioner lalu <b>Ajukan Ulang</b> agar diverifikasi kembali.
            </div>
        </div>
    </div>
  </div>
</div>

<!-- Saran Detail Modal -->
<div id="saranModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeSaranModal()"></div>
  <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[85vh] flex flex-col overflow-hidden">
    <!-- Modal Header -->
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-orange-50">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center">
          <i class="fa-solid fa-lightbulb text-amber-600"></i>
        </div>
        <div>
          <h3 class="text-base font-bold text-slate-800">Saran Perbaikan</h3>
          <p class="text-xs text-slate-500" id="saranKebunName"></p>
        </div>
      </div>
      <button onclick="closeSaranModal()" class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <!-- Modal Body -->
    <div class="overflow-y-auto px-6 py-4 flex-1">
      <div class="flex items-center gap-2 mb-4">
        <span id="saranCountBadge" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700"></span>
        <span class="text-xs text-slate-400">Perbaiki item berikut untuk meningkatkan skor ISPO</span>
      </div>
      <ol id="saranListContainer" class="space-y-2"></ol>
    </div>
    <!-- Modal Footer -->
    <div class="px-6 py-6 border-t border-slate-100 bg-slate-50/50">
      <button onclick="closeSaranModal()" class="w-full px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold transition-colors">
        Tutup
      </button>
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

      <h3 class="text-2xl font-bold text-gray-800 mb-2">Ajukan Ulang Data Kebun?</h3>

      <p class="text-gray-600 mb-3">
        Setelah diajukan ulang, <span class="font-semibold text-red-600">data kebun tidak dapat diubah lagi</span> sampai diperiksa oleh Admin.
      </p>
      <p class="text-gray-600 mb-6">
        Pastikan semua informasi revisi, pemetaan, dan kuisioner untuk kebun
        <span class="font-semibold" id="modalKebunName"></span> sudah benar.
      </p>

      <div class="grid grid-cols-2 gap-3">
        <button
          type="button"
          onclick="closeFinalizeModal()"
          class="px-4 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition"
        >
          Batal
        </button>

        <form id="finalizeForm" action="" method="POST">
          @csrf
          <button
            type="submit"
            class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition"
          >
            Ya, Ajukan Ulang
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function openSaranModal(saranList, kebunName) {
    document.getElementById('saranKebunName').innerText = kebunName;
    document.getElementById('saranCountBadge').innerText = saranList.length + ' item';

    const container = document.getElementById('saranListContainer');
    container.innerHTML = '';

    saranList.forEach(function(saran, index) {
        const li = document.createElement('li');
        li.className = 'flex gap-3 items-start p-3 rounded-xl bg-slate-50 border border-slate-100 hover:border-amber-200 hover:bg-amber-50/30 transition-all';
        li.innerHTML = `
            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-[11px] font-bold mt-0.5">${index + 1}</span>
            <span class="text-sm text-slate-700 leading-relaxed">${saran}</span>
        `;
        container.appendChild(li);
    });

    document.getElementById('saranModal').classList.remove('hidden');
}

function closeSaranModal() {
    document.getElementById('saranModal').classList.add('hidden');
}

function openFinalizeModal(id, name) {
    document.getElementById('modalKebunName').innerText = name;
    document.getElementById('finalizeForm').action = "{{ url('/pekebun/daftar-kebun') }}/" + id + "/finalisasi?source=hasil_spk";
    document.getElementById('finalizeModal').classList.remove('hidden');
}

function closeFinalizeModal() {
    document.getElementById('finalizeModal').classList.add('hidden');
}
</script>

@endsection
