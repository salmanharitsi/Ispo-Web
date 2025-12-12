@php
  $pekebun = $kebun->user;
@endphp

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 sm:p-6">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
    <div>
      <h2 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 text-xs">
          <i class="fa-regular fa-user"></i>
        </span>
        <span>Data Pekebun</span>
      </h2>
      <p class="text-xs text-slate-500 mt-1">
        Informasi identitas pekebun pemilik kebun yang diajukan untuk sertifikasi ISPO.
      </p>
    </div>
  </div>

  @if(!$pekebun)
    <p class="text-xs text-red-500">Data pekebun tidak ditemukan.</p>
  @else
    <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs sm:text-sm">
      <div>
        <dt class="text-slate-500">Nama Lengkap</dt>
        <dd class="font-semibold text-slate-900">{{ $pekebun->name }}</dd>
      </div>
      <div>
        <dt class="text-slate-500">Email</dt>
        <dd class="font-medium text-slate-800">{{ $pekebun->email }}</dd>
      </div>
      <div>
        <dt class="text-slate-500">No. HP</dt>
        <dd class="font-medium text-slate-800">{{ $pekebun->no_hp ?? '-' }}</dd>
      </div>
      <div>
        <dt class="text-slate-500">Tempat, Tanggal Lahir</dt>
        <dd class="font-medium text-slate-800">
          {{ $pekebun->tempat_lahir ?? '-' }},
          {{ $pekebun->tanggal_lahir ? \Carbon\Carbon::parse($pekebun->tanggal_lahir)->format('d M Y') : '-' }}
        </dd>
      </div>
      <div>
        <dt class="text-slate-500">Pendidikan Terakhir</dt>
        <dd class="font-medium text-slate-800">{{ $pekebun->pendidikan_terakhir ?? '-' }}</dd>
      </div>
      <div>
        <dt class="text-slate-500">Jenis Kelamin</dt>
        <dd class="font-medium text-slate-800">{{ $pekebun->jenis_kelamin ?? '-' }}</dd>
      </div>
      <div class="sm:col-span-2 lg:col-span-3">
        <dt class="text-slate-500">Alamat Lengkap</dt>
        <dd class="font-medium text-slate-800">
          {{ $pekebun->alamat ?? '-' }}
          @if($pekebun->rt_rw)
            <span class="text-slate-500"> (RT/RW {{ $pekebun->rt_rw }})</span>
          @endif
          @if($pekebun->desa)
            , Desa {{ $pekebun->desa }}
          @endif
          @if($pekebun->kecamatan)
            , Kec. {{ $pekebun->kecamatan }}
          @endif
          @if($pekebun->kabupaten)
            , Kab. {{ $pekebun->kabupaten }}
          @endif
          @if($pekebun->kota)
            , {{ $pekebun->kota }}
          @endif
        </dd>
      </div>
      <div>
        <dt class="text-slate-500">Jumlah Anggota Keluarga</dt>
        <dd class="font-medium text-slate-800">
          {{ $pekebun->jumlah_anggota_keluarga ?? '-' }}
        </dd>
      </div>
      <div>
        <dt class="text-slate-500">Peran di Sistem</dt>
        <dd class="font-medium text-slate-800 capitalize">{{ $pekebun->role }}</dd>
      </div>
    </dl>
  @endif
</div>
