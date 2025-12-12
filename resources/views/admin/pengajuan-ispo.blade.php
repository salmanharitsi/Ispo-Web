@extends('layouts.admin')

@section('title', 'Admin Pengajuan ISPO')

@section('content')
  <div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
          <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
              Daftar Pengajuan ISPO
            </h1>
            <p class="text-gray-600 mt-1">Periksa data pengajuan untuk meyetujui dan memberikan status kelayak ISPO</p>
          </div>
        </div>
      </div>

      <div>
        @livewire('daftar-pengajuan-ispo')
      </div>
    </div>
  </div>
@endsection