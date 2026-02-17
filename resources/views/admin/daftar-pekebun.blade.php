@extends('layouts.admin')

@section('title', 'Admin Kelola Pekebun')

@section('content')
  <div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="col-span-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
          <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
              Kelola Akun Pekebun
            </h1>
            <p class="text-gray-600 mt-1">Kelola seluruh akun pekebun yang terdaftar pada sistem</p>
          </div>
        </div>
      </div>

      <div class="col-span-4">
        @livewire('daftar-pekebun')
      </div>
    </div>
  </div>
@endsection