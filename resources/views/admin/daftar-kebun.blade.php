
@extends('layouts.admin')

@section('title', 'Admin Daftar Kebun')

@section('content')
  <div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="col-span-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
          <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
              Daftar Kebun
            </h1>
            <p class="text-gray-600 mt-1">Data seluruh kebun yang terdaftar pada sistem</p>
          </div>
          <a 
            href="{{ url('/admin/daftar-kebun/semua-pemetaan') }}"
            class="inline-flex gap-2 items-center justify-center bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition shadow-lg"
          >
            <i class="fa-solid fa-map-location-dot text-lg w-5"></i>
            Lihat Seluruh Pemetaan
          </a>
        </div>
      </div>

      <div class="col-span-4">
        @livewire('daftar-kebun-admin')
      </div>
    </div>
  </div>
@endsection