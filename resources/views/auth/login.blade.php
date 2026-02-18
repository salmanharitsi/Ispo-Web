<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - ISPO Rokan Hulu</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  @vite('resources/css/app.css')
  @livewireStyles
  <style>
    .bg-gradient-primary {
      background: linear-gradient(135deg, #15803d 0%, #166534 100%);
    }

    .bg-pattern {
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .animate-float {
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(-20px);
      }
    }
  </style>
</head>

<body class="bg-gray-50">

  @include('_message')
  
  <!-- Navbar -->
  <nav class="bg-white shadow-md fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <a href="/" class="flex items-center">
          <img src="{{ asset('images/ppsks-logo.jpg') }}" class="h-10 w-10" alt="PPSKS logo">
          <div class="ml-3">
            <span class="text-xl font-bold text-gray-800">ISPO Rokan Hulu</span>
            <p class="text-xs text-gray-600">Indonesian Sustainable Palm Oil</p>
          </div>
        </a>
        <div class="hidden md:block">
          <a href="{{ url('/') }}" class="bg-green-700 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-800 transition">
            Kembali
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Login Section -->
  <section class="pt-24 pb-16 bg-gradient-primary bg-pattern relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-green-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float"></div>
    <div class="absolute bottom-20 right-10 w-72 h-72 bg-emerald-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 1s;"></div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="w-full">
        @livewire('login-form')
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row justify-between items-center">
        <p class="text-gray-400 text-sm mb-4 md:mb-0">
          &copy; 2025 ISPO Rokan Hulu. All rights reserved.
        </p>
      </div>
    </div>
  </footer>

  @livewireScripts
</body>

</html>