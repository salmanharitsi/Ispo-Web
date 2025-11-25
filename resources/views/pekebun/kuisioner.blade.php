@extends('layouts.pekebun')

@section('title', 'Kuisioner Kebun')

@section('content')
  <div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
          <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
              Pengisian Kuisioner
            </h1>
            <p class="text-gray-600 mt-1">
              lengkapi kuisioner kebun
              <span class="font-bold text-gray-900">{{ $kebun->nama_kebun }}</span>
              di bawah ini
            </p>
          </div>
        </div>

        <!-- Info Alert -->
        <div class="bg-green-50 border border-green-500 p-4 rounded-lg">
          <div class="flex items-start">
            <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                clip-rule="evenodd"></path>
            </svg>
            <div>
              <p class="text-sm font-medium text-green-800">Panduan Pengisian Kuisioner</p>
              <p class="text-sm text-green-700 mt-1">
                1. Baca setiap pertanyaan dengan saksama, lalu pilih jawaban <strong>Ya</strong> atau <strong>Tidak</strong> sesuai kondisi kebun Anda.<br>
                2. Jawablah secara <strong>jujur</strong>, karena data ini digunakan sebagai dasar penilaian kesiapan sertifikasi ISPO.<br>
                3. Anda dapat memperbarui jawaban kuisioner di kemudian hari jika terdapat perubahan kondisi kebun.<br>
                4. Setelah semua pertanyaan terisi, klik tombol <strong>Simpan Kuisioner</strong> di bagian bawah halaman.
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-slate-100 overflow-hidden">
        @livewire('kuisioner-form', ['kebunId' => $kebun->id])
      </div>
    </div>
  </div>
@endsection