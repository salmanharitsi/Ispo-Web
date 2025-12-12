<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 sm:p-6">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
    <div>
      <h2 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 text-xs">
          <i class="fa-solid fa-clipboard-list"></i>
        </span>
        <span>Ringkasan Penilaian Kuisioner (Bobot Total: 75%)</span>
      </h2>
      <p class="text-xs text-slate-500 mt-1">
        Rekap jumlah jawaban "Ya" per prinsip sebagai dasar penilaian kesiapan sertifikasi.
      </p>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full text-xs sm:text-sm">
      <thead>
        <tr class="border-b border-slate-100 text-left text-[11px] uppercase tracking-wide text-slate-400">
          <th class="py-2 pr-4">Prinsip</th>
          <th class="py-2 pr-4">Nama Prinsip</th>
          <th class="py-2 pr-4 text-center">Jumlah Soal</th>
          <th class="py-2 pr-4 text-center">Bobot/Soal</th>
          <th class="py-2 pr-4 text-center">Jawaban "Ya"</th>
          <th class="py-2 pr-4 text-center">Jawaban "Tidak"</th>
          <th class="py-2 pr-4 text-center">Bobot Diperoleh</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        @foreach($kuisionerSummary as $row)
          <tr>
            <td class="py-2 pr-4 font-semibold text-slate-900">{{ $row['kode'] }}</td>
            <td class="py-2 pr-4 text-slate-700">{{ $row['nama'] }}</td>
            <td class="py-2 pr-4 text-center text-slate-600">{{ $row['jumlahSoal'] }}</td>
            <td class="py-2 pr-4 text-center">
              <span class="inline-flex items-center justify-center rounded-full bg-blue-50 text-blue-700 px-2 py-0.5 text-[11px] font-medium">
                {{ number_format($row['bobotPerSoal'], 3) }}%
              </span>
            </td>
            <td class="py-2 pr-4 text-center">
              <span class="inline-flex items-center justify-center rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5 text-[11px] font-medium">
                {{ $row['yes'] }}
              </span>
            </td>
            <td class="py-2 pr-4 text-center">
              <span class="inline-flex items-center justify-center rounded-full bg-slate-50 text-slate-600 px-2 py-0.5 text-[11px] font-medium">
                {{ $row['no'] }}
              </span>
            </td>
            <td class="py-2 pr-4 text-center">
              <span class="inline-flex items-center justify-center rounded-full
                {{ $row['bobotDiperoleh'] >= ($row['bobotPerSoal'] * $row['jumlahSoal'] * 0.7) ? 'bg-emerald-50 text-emerald-700' : 'bg-yellow-50 text-yellow-700' }}
                px-2 py-0.5 text-[11px] font-semibold">
                {{ number_format($row['bobotDiperoleh'], 3) }}%
              </span>
            </td>
          </tr>
        @endforeach
        <tr class="border-t-2 border-slate-200 font-semibold">
          <td colspan="6" class="pt-5 pr-4 text-right text-slate-700">Total Bobot Kuisioner:</td>
          <td class="pt-5 pr-4 text-center">
            <span class="inline-flex items-center justify-center rounded-full bg-emerald-100 text-emerald-700 px-3 py-1 text-sm font-bold">
              {{ number_format($totalBobotKuisioner, 3) }}%
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>