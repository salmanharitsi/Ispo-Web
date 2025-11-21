@extends('layouts.pekebun')

@section('title', 'Pekebun Data Diri')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="mb-6">
      <div class="flex items-center mb-4">
        <div>
          <h1 class="text-3xl font-bold text-gray-800">Data Diri</h1>
          <p class="text-gray-600 mt-1">Kelola dan perbarui informasi profil Anda</p>
        </div>
      </div>
      
      <!-- Info Alert -->
      <div class="bg-green-50 border border-green-500 p-4 rounded-xl">
        <div class="flex items-start">
          <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
          </svg>
          <div>
            <p class="text-sm font-medium text-green-800">Informasi Penting</p>
            <p class="text-sm text-green-700 mt-1">Pastikan data yang Anda masukkan akurat dan sesuai dengan dokumen resmi. Data ini akan digunakan untuk proses sertifikasi ISPO.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Form Component Container -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      @livewire('data-diri-form')
    </div>
  </div>
</div>
@endsection