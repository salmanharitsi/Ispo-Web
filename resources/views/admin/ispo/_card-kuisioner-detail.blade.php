<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 sm:p-6">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
    <div>
      <h2 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 text-xs">
          <i class="fa-solid fa-list-check"></i>
        </span>
        <span>Detail Jawaban Kuisioner</span>
      </h2>
      <p class="text-xs text-slate-500 mt-1">
        Daftar indikator penilaian dan jawaban pekebun (Ya/Tidak) untuk tiap pertanyaan.
      </p>
    </div>
    <div class="text-[11px] text-slate-400">
      @if(!$kuisioner)
        Kuisioner belum diisi oleh pekebun.
      @else
        Terakhir diisi: {{ $kuisioner->updated_at?->format('d M Y H:i') }}
      @endif
    </div>
  </div>

  @if(!$kuisioner)
    <p class="text-xs text-slate-400 italic">
      Tidak ada data kuisioner untuk kebun ini.
    </p>
  @else
    <div class="overflow-x-auto">
      <table class="min-w-full text-xs sm:text-sm">
        <thead>
          <tr class="border-b border-slate-100 text-left text-[11px] uppercase tracking-wide text-slate-400">
            <th class="py-2 pr-4">Kode</th>
            <th class="py-2 pr-4">Prinsip</th>
            <th class="py-2 pr-4">Indikator</th>
            <th class="py-2 pr-4">Deskripsi Singkat</th>
            <th class="py-2 pr-4 text-center">Jawaban</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @foreach($kuisionerQuestions as $q)
            @php
              $value = (bool) $kuisioner->{$q['field']};
            @endphp
            <tr>
              <td class="py-2 pr-4 font-semibold text-slate-900">{{ $q['kode'] }}</td>
              <td class="py-2 pr-4 text-slate-600">{{ $q['prinsip'] }}</td>
              <td class="py-2 pr-4 text-slate-700">{{ $q['indikator'] }}</td>
              <td class="py-2 pr-4 text-slate-500">{{ $q['label'] }}</td>
              <td class="py-2 pr-4 text-center">
                @if($value)
                  <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 text-emerald-700 px-2 py-0.5 text-[11px] font-medium">
                    <i class="fa-solid fa-check text-[10px]"></i> Ya
                  </span>
                @else
                  <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 text-rose-600 px-2 py-0.5 text-[11px] font-medium">
                    <i class="fa-solid fa-xmark text-[10px]"></i> Tidak
                  </span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
