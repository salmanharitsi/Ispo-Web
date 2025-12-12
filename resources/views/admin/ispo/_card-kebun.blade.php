<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 sm:p-6">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
    <div>
      <h2 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 text-xs">
          <i class="fa-solid fa-seedling"></i>
        </span>
        <span>Data Kebun</span>
      </h2>
      <p class="text-xs text-slate-500 mt-1">
        Informasi detail kebun yang diajukan untuk sertifikasi ISPO.
      </p>
    </div>
    <div class="flex flex-wrap gap-1">
      <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 px-3 py-1 text-[11px] font-medium text-slate-500 border border-slate-200">
        <i class="fa-solid fa-location-dot text-[10px]"></i>
        <span>{{ $kebun->lokasi_kebun ?? 'Lokasi belum diisi' }}</span>
      </span>
    </div>
  </div>

  <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs sm:text-sm">
    <div>
      <dt class="text-slate-500">Nama Kebun</dt>
      <dd class="font-semibold text-slate-900">{{ $kebun->nama_kebun ?? '-' }}</dd>
    </div>
    <div>
      <dt class="text-slate-500">Lokasi Kebun</dt>
      <dd class="font-medium text-slate-800">{{ $kebun->lokasi_kebun ?? '-' }}</dd>
    </div>
    <div>
      <dt class="text-slate-500">Luas Lahan</dt>
      <dd class="font-medium text-slate-800">
        @if($kebun->luas_lahan)
          {{ number_format($kebun->luas_lahan, 2, ',', '.') }} Ha
        @else
          -
        @endif
      </dd>
    </div>
    <div>
      <dt class="text-slate-500">Desa</dt>
      <dd class="font-medium text-slate-800">{{ $kebun->desa ?? '-' }}</dd>
    </div>
    <div>
      <dt class="text-slate-500">Kecamatan</dt>
      <dd class="font-medium text-slate-800">{{ $kebun->kecamatan ?? '-' }}</dd>
    </div>
    <div>
      <dt class="text-slate-500">Kabupaten / Kota</dt>
      <dd class="font-medium text-slate-800">
        {{ $kebun->kabupaten ?? '-' }}{{ $kebun->kota ? ', '.$kebun->kota : '' }}
      </dd>
    </div>
    <div>
      <dt class="text-slate-500">Tahun Tanam</dt>
      <dd class="font-medium text-slate-800">{{ $kebun->tahun_tanam ?? '-' }}</dd>
    </div>
    <div>
      <dt class="text-slate-500">Jumlah Pohon</dt>
      <dd class="font-medium text-slate-800">{{ $kebun->jumlah_pohon ?? '-' }}</dd>
    </div>
    <div>
      <dt class="text-slate-500">Jenis Tanah</dt>
      <dd class="font-medium text-slate-800">{{ $kebun->jenis_tanah ?? '-' }}</dd>
    </div>
    <div>
      <dt class="text-slate-500">Asal Lahan</dt>
      <dd class="font-medium text-slate-800">{{ $kebun->asal_lahan ?? '-' }}</dd>
    </div>
    <div>
      <dt class="text-slate-500">Status Lahan</dt>
      <dd class="font-medium text-slate-800">{{ $kebun->status_lahan ?? '-' }}</dd>
    </div>
    <div>
      <dt class="text-slate-500">Dokumen Kepemilikan</dt>
      <dd class="font-medium text-slate-800">{{ $kebun->dokumen_kepemilikan_lahan ?? '-' }}</dd>
    </div>
    <div>
      <dt class="text-slate-500">Jenis Bibit</dt>
      <dd class="font-medium text-slate-800">{{ $kebun->jenis_bibit ?? '-' }}</dd>
    </div>
    <div>
      <dt class="text-slate-500">Frekuensi Panen</dt>
      <dd class="font-medium text-slate-800">{{ $kebun->frekuensi_panen ?? '-' }}</dd>
    </div>
    <div>
      <dt class="text-slate-500">Hasil Panen Dijual ke</dt>
      <dd class="font-medium text-slate-800">{{ $kebun->kepada_siapa_hasil_panen_dijual ?? '-' }}</dd>
    </div>
    <div>
      <dt class="text-slate-500">Harga Jual TBS Terakhir</dt>
      <dd class="font-medium text-slate-800">
        @if($kebun->harga_jual_tbs_terakhir)
          Rp {{ number_format($kebun->harga_jual_tbs_terakhir, 0, ',', '.') }}
        @else
          -
        @endif
      </dd>
    </div>
    <div>
      <dt class="text-slate-500">Pendapatan Bersih</dt>
      <dd class="font-medium text-slate-800">
        @if($kebun->pendapatan_bersih)
          Rp {{ number_format($kebun->pendapatan_bersih, 0, ',', '.') }}
        @else
          -
        @endif
      </dd>
    </div>
    <div>
      <dt class="text-slate-500">Pernyataan STDB</dt>
      <dd class="font-medium text-slate-800">
        @if($kebun->pernyataan_stdb)
          <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 text-emerald-700 px-2 py-0.5 text-[11px] font-medium">
            <i class="fa-solid fa-check text-[10px]"></i> Sudah menyatakan memiliki STDB
          </span>
        @else
          <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 text-slate-600 px-2 py-0.5 text-[11px] font-medium">
            <i class="fa-solid fa-xmark text-[10px]"></i> Belum ada pernyataan STDB
          </span>
        @endif
      </dd>
    </div>
  </dl>

  @if($kebun->catatan_pengecekan)
    <div class="mt-5 border-t border-slate-100 pt-3">
      <h3 class="text-xs font-semibold text-slate-700 mb-1">Catatan Pengecekan Sebelumnya</h3>
      <p class="text-xs text-slate-600 whitespace-pre-line">
        {{ $kebun->catatan_pengecekan }}
      </p>
    </div>
  @endif
</div>
