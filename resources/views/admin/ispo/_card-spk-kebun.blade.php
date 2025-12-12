<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 sm:p-6">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
    <div>
      <h2 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-sky-100 text-sky-700 text-xs">
          <i class="fa-solid fa-table-list"></i>
        </span>
        <span>Penilaian Berdasarkan Data Kebun (Bobot Total: 25%)</span>
      </h2>
      <p class="text-xs text-slate-500 mt-1">
        Indikator pendukung dari data kebun yang digunakan sebagai bahan pertimbangan keputusan sertifikasi.
      </p>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full text-xs sm:text-sm">
      <thead>
        <tr class="border-b border-slate-100 text-left text-[11px] uppercase tracking-wide text-slate-400">
          <th class="py-2 pr-4">Kode</th>
          <th class="py-2 pr-4">Nama Indikator</th>
          <th class="py-2 pr-4">Keterangan</th>
          <th class="py-2 pr-4 text-center">Bobot</th>
          <th class="py-2 pr-4">Nilai</th>
          <th class="py-2 pr-4 text-center">Status</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        @foreach($kebunIndicators as $row)
          <tr>
            <td class="py-2 pr-4 font-semibold text-slate-900">{{ $row['kode'] }}</td>
            <td class="py-2 pr-4 text-slate-800">{{ $row['nama'] }}</td>
            <td class="py-2 pr-4 text-slate-500 text-[11px]">{{ $row['keterangan'] }}</td>
            <td class="py-2 pr-4 text-center">
              <span class="inline-flex items-center justify-center rounded-full bg-blue-50 text-blue-700 px-2 py-0.5 text-[11px] font-medium">
                {{ number_format($row['bobot'], 2) }}%
              </span>
            </td>
            <td class="py-2 pr-4 text-slate-700 font-medium">{{ $row['nilai'] }}</td>
            <td class="py-2 pr-4 text-center">
              @php
                $isGood = in_array($row['status'], ['Terisi', 'Ada', 'Disetujui']);
              @endphp
              <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-medium
                {{ $isGood ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-600' }}">
                <i class="fa-solid {{ $isGood ? 'fa-check' : 'fa-triangle-exclamation' }} text-[10px]"></i>
                {{ $row['status'] }}
              </span>
            </td>
          </tr>
        @endforeach
        <tr class="border-t-2 border-slate-200 font-semibold">
          <td colspan="5" class="pt-5 pr-4 text-right text-slate-700">Total Bobot Data Kebun:</td>
          <td class="pt-5 pr-4 text-center">
            <span class="inline-flex items-center justify-center rounded-full bg-sky-100 text-sky-700 px-3 py-1 text-sm font-bold">
              {{ number_format($totalBobotKebun, 3) }}%
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>