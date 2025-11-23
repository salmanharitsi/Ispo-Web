<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sertifikasi ISPO - Kabupaten Rokan Hulu</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  @vite('resources/css/app.css')
  <style>
    .bg-gradient-primary {
      background: linear-gradient(135deg, #15803d 0%, #166534 100%);
    }

    .bg-gradient-secondary {
      background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    }

    .bg-pattern {
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .hover-scale {
      transition: transform 0.3s ease;
    }

    .hover-scale:hover {
      transform: translateY(-5px);
    }

    .animate-float {
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-20px);
      }
    }

    .palm-leaf {
      fill: #22c55e;
    }
  </style>
</head>

<body class="bg-gray-50">
  <!-- Navbar -->
  <nav class="bg-white shadow-md fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center">
          <svg class="h-10 w-10 text-green-700" viewBox="0 0 48 48" fill="none" stroke="currentColor">
            <path d="M24 40 L24 20 M24 20 L16 12 M24 20 L32 12 M18 28 L12 22 M30 28 L36 22" stroke-width="2.5"
              stroke-linecap="round" />
            <circle cx="24" cy="40" r="3" fill="currentColor" />
          </svg>
          <div class="ml-3">
            <span class="text-xl font-bold text-gray-800">ISPO Rokan Hulu</span>
            <p class="text-xs text-gray-600">Indonesian Sustainable Palm Oil</p>
          </div>
        </div>
        <div class="hidden md:flex space-x-8">
          <a href="#beranda" class="text-gray-700 hover:text-green-700 font-medium">Beranda</a>
          <a href="#ispo" class="text-gray-700 hover:text-green-700 font-medium">Tentang ISPO</a>
          <a href="#manfaat" class="text-gray-700 hover:text-green-700 font-medium">Manfaat</a>
          <a href="#kontak" class="text-gray-700 hover:text-green-700 font-medium">Kontak</a>
        </div>
        <div class="hidden md:block">
          <a href="{{ url('/login') }}" class="bg-green-700 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-800 transition">
            Masuk
          </a>
        </div>
        <div class="md:hidden">
          <button id="mobile-menu-btn" class="text-gray-700">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
      <div class="px-4 pt-2 pb-4 space-y-2">
        <a href="#beranda" class="block py-2 text-gray-700 hover:text-green-700">Beranda</a>
        <a href="#ispo" class="block py-2 text-gray-700 hover:text-green-700">Tentang ISPO</a>
        <a href="#manfaat" class="block py-2 text-gray-700 hover:text-green-700">Manfaat</a>
        <a href="#kontak" class="block py-2 text-gray-700 hover:text-green-700">Kontak</a>
        <button
          class="w-full bg-green-700 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-800 transition mt-2">
          Masuk
        </button>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section id="beranda" class="pt-36 pb-16 bg-gradient-primary bg-pattern relative overflow-hidden"
    style="background-image: url('{{ asset('images/sawit-hero.png') }}'); background-size: cover; background-position: center;">
    <!-- Black Overlay 50% -->
    <div class="absolute inset-0 bg-black opacity-60"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div class="text-white">
          <div class="inline-block bg-green-700 bg-opacity-30 px-4 py-2 rounded-full mb-4">
            <span class="text-sm font-semibold">🌴 Indonesian Sustainable Palm Oil</span>
          </div>
          <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
            Platform Sertifikasi ISPO Kabupaten Rokan Hulu
          </h1>
          <p class="text-lg md:text-xl mb-8 text-green-50">
            Tingkatkan daya saing perkebunan kelapa sawit Anda dengan sertifikasi ISPO yang diakui nasional
            dan internasional. Proses mudah, cepat, dan terpercaya.
          </p>
          <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ url('/login') }}"
              class="bg-white text-green-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg text-center">
              Daftar Sertifikasi
            </a>
            <a href="#ispo"
              class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-700 transition text-center">
              Pelajari ISPO
            </a>
          </div>
          <div class="mt-8 flex items-center space-x-6">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                </path>
              </svg>
              <span class="text-sm">Sertifikasi Wajib</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span class="text-sm">Standar Nasional</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        <div class="text-center">
          <div class="text-3xl md:text-4xl font-bold text-green-700 mb-2">850+</div>
          <div class="text-gray-600">Perkebunan Tersertifikasi</div>
        </div>
        <div class="text-center">
          <div class="text-3xl md:text-4xl font-bold text-green-700 mb-2">12,000+</div>
          <div class="text-gray-600">Hektar Sawit</div>
        </div>
        <div class="text-center">
          <div class="text-3xl md:text-4xl font-bold text-green-700 mb-2">95%</div>
          <div class="text-gray-600">Tingkat Kepatuhan</div>
        </div>
        <div class="text-center">
          <div class="text-3xl md:text-4xl font-bold text-green-700 mb-2">24/7</div>
          <div class="text-gray-600">Layanan Online</div>
        </div>
      </div>
    </div>
  </section>

  <!-- What is ISPO Section -->
  <section id="ispo" class="py-16 bg-linear-to-br from-green-50 to-emerald-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <div class="inline-block bg-green-700 text-white px-6 py-2 rounded-full mb-4 font-semibold">
          Indonesian Sustainable Palm Oil
        </div>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Apa itu Sertifikasi ISPO?</h2>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
          ISPO adalah standar sertifikasi wajib yang memastikan perkebunan kelapa sawit di Indonesia dikelola
          secara berkelanjutan dan bertanggung jawab
        </p>
      </div>

      <div class="grid md:grid-cols-2 gap-8 mb-12">
        <div class="bg-white rounded-lg shadow-lg p-8">
          <div class="flex items-start mb-4">
            <div class="bg-green-100 p-3 rounded-lg mr-4">
              <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">Definisi ISPO</h3>
              <p class="text-gray-600">
                Sertifikasi ISPO adalah jaminan tertulis bahwa usaha perkebunan kelapa sawit telah
                memenuhi prinsip dan kriteria keberlanjutan yang ditetapkan oleh pemerintah Indonesia.
                Sertifikasi ini bersifat <strong>wajib</strong> bagi semua pelaku usaha kelapa sawit
                untuk meningkatkan daya saing dan kredibilitas produk sawit di pasar nasional maupun
                internasional.
              </p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
          <div class="flex items-start mb-4">
            <div class="bg-amber-100 p-3 rounded-lg mr-4">
              <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                </path>
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">Tujuan Sertifikasi</h3>
              <ul class="space-y-2 text-gray-600">
                <li class="flex items-start">
                  <span class="text-green-600 mr-2">•</span>
                  <span>Memastikan pengelolaan perkebunan sesuai prinsip dan kriteria ISPO</span>
                </li>
                <li class="flex items-start">
                  <span class="text-green-600 mr-2">•</span>
                  <span>Meningkatkan daya saing produk sawit Indonesia di pasar global</span>
                </li>
                <li class="flex items-start">
                  <span class="text-green-600 mr-2">•</span>
                  <span>Mempercepat penurunan emisi gas rumah kaca</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Legal Basis -->
      <div class="bg-gradient-primary text-white rounded-lg shadow-xl p-8 mb-12">
        <div class="flex items-center mb-6">
          <svg class="w-10 h-10 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
          </svg>
          <h3 class="text-2xl font-bold">Dasar Hukum ISPO</h3>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
          <div class="bg-linear-to-br from-emerald-500 to-teal-600 bg-opacity-10 rounded-lg p-6">
            <div class="flex items-center mb-3">
              <div class="bg-linear-to-tr from-emerald-500 to-teal-600 bg-opacity-20 rounded-full p-2 mr-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
                </svg>
              </div>
              <h4 class="font-bold text-lg">Peraturan Presiden</h4>
            </div>
            <p class="text-green-100">Peraturan Presiden Nomor 44 Tahun 2020 tentang Sistem Sertifikasi
              Perkebunan Kelapa Sawit Berkelanjutan Indonesia</p>
          </div>
          <div class="bg-linear-to-br from-green-500 to-green-600 bg-opacity-10 rounded-lg p-6">
            <div class="flex items-center mb-3">
              <div class="bg-linear-to-tr from-green-500 to-green-600 bg-opacity-20 rounded-full p-2 mr-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
                </svg>
              </div>
              <h4 class="font-bold text-lg">Peraturan Menteri</h4>
            </div>
            <p class="text-green-100">Peraturan Menteri Pertanian Nomor 38 Tahun 2020 sebagai petunjuk
              teknis pelaksanaan sertifikasi ISPO</p>
          </div>
        </div>
      </div>

      <!-- ISPO Principles -->
      <div>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 text-center">Prinsip dan Kriteria ISPO
        </h3>
        <div class="grid md:grid-cols-3 gap-6">
          <div class="bg-white rounded-xl shadow-lg p-6 hover-scale">
            <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
              <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                </path>
              </svg>
            </div>
            <h4 class="font-bold text-lg text-gray-800 mb-3">Kepatuhan Hukum</h4>
            <p class="text-gray-600 text-sm">Memastikan kepatuhan penuh terhadap semua peraturan
              perundang-undangan yang berlaku di Indonesia terkait perkebunan kelapa sawit.</p>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-6 hover-scale">
            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
              <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
              </svg>
            </div>
            <h4 class="font-bold text-lg text-gray-800 mb-3">Pengelolaan Lingkungan</h4>
            <p class="text-gray-600 text-sm">Konservasi sumber daya alam, keanekaragaman hayati, kesuburan
              tanah, kualitas air, dan perlindungan ekosistem.</p>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-6 hover-scale">
            <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
              <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                </path>
              </svg>
            </div>
            <h4 class="font-bold text-lg text-gray-800 mb-3">Efisiensi & Emisi</h4>
            <p class="text-gray-600 text-sm">Optimalisasi penggunaan energi, pengurangan emisi gas rumah
              kaca, dan penerapan teknologi ramah lingkungan.</p>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-6 hover-scale">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
              <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
              </svg>
            </div>
            <h4 class="font-bold text-lg text-gray-800 mb-3">Kesejahteraan Pekerja</h4>
            <p class="text-gray-600 text-sm">Memastikan kondisi kerja yang layak, upah yang adil, kesehatan
              dan keselamatan kerja, serta dampak sosial positif.</p>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-6 hover-scale">
            <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
              <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                </path>
              </svg>
            </div>
            <h4 class="font-bold text-lg text-gray-800 mb-3">Peningkatan Berkelanjutan</h4>
            <p class="text-gray-600 text-sm">Penerapan praktik perkebunan yang baik secara berkelanjutan
              dengan peningkatan terus-menerus.</p>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-6 hover-scale">
            <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
              <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                </path>
              </svg>
            </div>
            <h4 class="font-bold text-lg text-gray-800 mb-3">Transparansi</h4>
            <p class="text-gray-600 text-sm">Pelaksanaan operasi yang transparan dan terbuka dengan
              akuntabilitas penuh kepada stakeholder.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Benefits Section -->
  <section id="manfaat" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Manfaat Sertifikasi ISPO</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Dapatkan berbagai keuntungan dengan memiliki sertifikasi ISPO untuk perkebunan Anda
        </p>
      </div>

      <div class="grid md:grid-cols-3 gap-8 mb-12">
        <!-- Benefits for Business -->
        <div class="bg-linear-to-br from-green-500 to-green-600 rounded-lg shadow-xl p-8 text-white">
          <div
            class="bg-linear-to-tr from-green-500 to-green-600 bg-opacity-20 w-16 h-16 rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
              </path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold mb-4">Manfaat Bagi Pelaku Usaha</h3>
          <ul class="space-y-3">
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Meningkatkan akses ke pasar nasional dan internasional</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Peningkatan produktivitas dan efisiensi operasional</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Mendapatkan harga jual yang lebih kompetitif</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Meningkatkan pendapatan dan kesejahteraan petani</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Memperkuat citra dan reputasi perusahaan</span>
            </li>
          </ul>
        </div>

        <!-- Benefits for Environment -->
        <div class="bg-linear-to-br from-emerald-500 to-teal-600 rounded-lg shadow-xl p-8 text-white">
          <div
            class="bg-linear-to-tr from-emerald-500 to-teal-600 bg-opacity-20 w-16 h-16 rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
              </path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold mb-4">Manfaat Bagi Lingkungan</h3>
          <ul class="space-y-3">
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Mengurangi dampak negatif terhadap lingkungan</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Menjaga kelestarian keanekaragaman hayati</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Konservasi tanah dan sumber daya air</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Pengurangan emisi gas rumah kaca secara signifikan</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Pengelolaan limbah yang lebih baik dan berkelanjutan</span>
            </li>
          </ul>
        </div>

        <!-- Benefits for Government -->
        <div class="bg-linear-to-br from-blue-500 to-indigo-600 rounded-lg shadow-xl p-8 text-white">
          <div
            class="bg-linear-to-tr from-blue-500 to-indigo-600 bg-opacity-20 w-16 h-16 rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
              </path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold mb-4">Manfaat Bagi Pemerintah</h3>
          <ul class="space-y-3">
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Memfasilitasi pemantauan dan evaluasi perkebunan</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Memastikan penerapan standar keberlanjutan nasional</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Meningkatkan kontribusi sektor sawit pada ekonomi</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Memperkuat posisi Indonesia di pasar global</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-2 shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>Mendukung target pengurangan emisi nasional</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Process Section -->
  <section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Proses Sertifikasi ISPO</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Ikuti 6 langkah mudah untuk mendapatkan sertifikasi ISPO perkebunan kelapa sawit Anda
        </p>
      </div>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="text-center">
          <div
            class="bg-green-700 text-white w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">
            1</div>
          <h3 class="font-bold text-gray-800 mb-2 text-lg">Registrasi Akun</h3>
          <p class="text-gray-600 text-sm">Buat akun dan lengkapi profil perkebunan Anda di platform</p>
        </div>
        <div class="text-center">
          <div
            class="bg-green-700 text-white w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">
            2</div>
          <h3 class="font-bold text-gray-800 mb-2 text-lg">Pengisian Data</h3>
          <p class="text-gray-600 text-sm">Isi formulir data perkebunan dan upload dokumen pendukung</p>
        </div>
        <div class="text-center">
          <div
            class="bg-green-700 text-white w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">
            3</div>
          <h3 class="font-bold text-gray-800 mb-2 text-lg">Verifikasi Dokumen</h3>
          <p class="text-gray-600 text-sm">Tim kami melakukan verifikasi kelengkapan dokumen</p>
        </div>
        <div class="text-center">
          <div
            class="bg-green-700 text-white w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">
            4</div>
          <h3 class="font-bold text-gray-800 mb-2 text-lg">Audit Lapangan</h3>
          <p class="text-gray-600 text-sm">Auditor bersertifikat melakukan pemeriksaan lapangan</p>
        </div>
        <div class="text-center">
          <div
            class="bg-green-700 text-white w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">
            5</div>
          <h3 class="font-bold text-gray-800 mb-2 text-lg">Evaluasi & Perbaikan</h3>
          <p class="text-gray-600 text-sm">Evaluasi hasil audit dan perbaikan jika diperlukan</p>
        </div>
        <div class="text-center">
          <div
            class="bg-green-700 text-white w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-lg">
            6</div>
          <h3 class="font-bold text-gray-800 mb-2 text-lg">Penerbitan Sertifikat</h3>
          <p class="text-gray-600 text-sm">Sertifikat ISPO resmi siap diunduh dan digunakan</p>
        </div>
      </div>

      <div class="mt-12 bg-green-50 rounded-lg p-8 border border-green-200">
        <div class="flex items-start">
          <div class="bg-green-600 rounded-full p-3 mr-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div>
            <h4 class="font-bold text-gray-800 text-lg mb-2">Estimasi Waktu Proses</h4>
            <p class="text-gray-600">Proses sertifikasi ISPO umumnya memakan waktu <strong>3-6
                bulan</strong> tergantung kelengkapan dokumen dan kesiapan perkebunan. Dengan platform
              digital kami, proses dapat dipercepat hingga <strong>30%</strong> lebih cepat.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="kontak" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Hubungi Kami</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Punya pertanyaan tentang sertifikasi ISPO? Tim kami siap membantu Anda
        </p>
      </div>
      <div class="grid md:grid-cols-3 gap-8 mb-12">
        <div class="text-center p-6 bg-white rounded-xl shadow-md hover-scale">
          <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
              </path>
            </svg>
          </div>
          <h3 class="font-bold text-gray-800 mb-2">Telepon</h3>
          <p class="text-gray-600">+62 812-3456-7890</p>
          <p class="text-gray-500 text-sm mt-1">Senin - Jumat, 08:00 - 17:00 WIB</p>
        </div>
        <div class="text-center p-6 bg-white rounded-xl shadow-md hover-scale">
          <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
              </path>
            </svg>
          </div>
          <h3 class="font-bold text-gray-800 mb-2">Email</h3>
          <p class="text-gray-600">ispo@rokanhulu.go.id</p>
          <p class="text-gray-500 text-sm mt-1">Respon dalam 1x24 jam</p>
        </div>
        <div class="text-center p-6 bg-white rounded-xl shadow-md hover-scale">
          <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
              </path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
          </div>
          <h3 class="font-bold text-gray-800 mb-2">Alamat Kantor</h3>
          <p class="text-gray-600">Jl. Sudirman No. 123</p>
          <p class="text-gray-500 text-sm mt-1">Pasir Pengaraian, Rokan Hulu, Riau</p>
        </div>
      </div>

      <div class="bg-gradient-secondary rounded-lg shadow-xl p-8 text-white text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
          Siap Mendapatkan Sertifikasi ISPO?
        </h2>
        <p class="text-xl text-green-50 mb-8">
          Bergabunglah dengan ratusan pekebun kelapa sawit di Rokan Hulu yang telah tersertifikasi ISPO dan
          tingkatkan daya saing produk Anda di pasar global
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="{{ url('/login') }}"
            class="bg-white text-green-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg text-lg">
            Daftar Sekarang
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <div>
          <div class="flex items-center mb-4">
            <svg class="h-10 w-10 text-green-500" viewBox="0 0 48 48" fill="none" stroke="currentColor">
              <path d="M24 40 L24 20 M24 20 L16 12 M24 20 L32 12 M18 28 L12 22 M30 28 L36 22" stroke-width="2.5"
                stroke-linecap="round" />
              <circle cx="24" cy="40" r="3" fill="currentColor" />
            </svg>
            <div class="ml-3">
              <span class="text-xl font-bold">ISPO Rokan Hulu</span>
              <p class="text-xs text-gray-400">Sertifikasi Sawit Berkelanjutan</p>
            </div>
          </div>
          <p class="text-gray-400 text-sm">
            Platform resmi sertifikasi ISPO untuk perkebunan kelapa sawit berkelanjutan di Kabupaten Rokan
            Hulu, Riau.
          </p>
        </div>
        <div>
          <h3 class="font-bold text-lg mb-4 mt-4">Kontak</h3>
          <ul class="space-y-2 text-gray-400 text-sm">
            <li>Jl. Sudirman No.123 Pasir Pengaraian, Rokan Hulu, Riau, 28457</li>
            <li class="mt-4">+62 812-3456-7890</li>
            <li>ispo@rokanhulu.go.id</li>
          </ul>
          <div class="mt-4">
            <h4 class="font-semibold mb-2 text-sm">Jam Operasional:</h4>
            <p class="text-gray-400 text-xs">Senin - Jumat: 08:00 - 17:00 WIB</p>
            <p class="text-gray-400 text-xs">Sabtu: 08:00 - 12:00 WIB</p>
          </div>
        </div>
      </div>
      <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
        <p class="text-gray-400 text-sm mb-4 md:mb-0">
          &copy; 2025 ISPO Rokan Hulu. All rights reserved. Powered by Dinas Pertanian Kabupaten Rokan Hulu.
        </p>
        <div class="flex space-x-6">
          <a href="#" class="text-gray-400 hover:text-green-500 transition">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
            </svg>
          </a>
          <a href="#" class="text-gray-400 hover:text-green-500 transition">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
            </svg>
          </a>
          <a href="#" class="text-gray-400 hover:text-green-500 transition">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
            </svg>
          </a>
          <a href="#" class="text-gray-400 hover:text-green-500 transition">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
          mobileMenu.classList.add('hidden');
        }
      });
    });

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
      const nav = document.querySelector('nav');
      if (window.scrollY > 50) {
        nav.classList.add('shadow-lg');
      } else {
        nav.classList.remove('shadow-lg');
      }
    });
  </script>
</body>

</html>