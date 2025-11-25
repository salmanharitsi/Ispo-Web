<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pekebun - ISPO Rokan Hulu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Leaflet + Leaflet.Draw --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    @stack('styles')
</head>

<body class="min-h-screen">

    @include('_message')

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden transition-opacity duration-300">
    </div>

    <div class="flex">
        <!-- Desktop Sidebar -->
        <aside id="sidebar"
            class="sidebar-transition sidebar-expanded desktop-sidebar hidden lg:flex bg-white shadow-2xl z-40 h-screen flex-col">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between px-6 py-[18px] border-b border-gray-100">
                <div class="flex items-center space-x-3" id="logo-section">
                    <div
                        class="w-10 h-10 bg-linear-to-r from-green-600 to-emerald-600 rounded-lg flex items-center justify-center shadow-lg shrink-0">
                        <i class="fas fa-seedling text-white text-lg shrink-0"></i>
                    </div>
                    <div class="sidebar-text">
                        <h1 class="text-xl font-bold text-gray-800">SPK ISPO</h1>
                        <p class="text-xs text-gray-500">Dashboard v1.0</p>
                    </div>
                </div>
                <button id="collapse-btn"
                    class="sidebar-text flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors duration-200 shrink-0">
                    <i class="fas fa-chevron-left text-gray-600 text-sm transition-transform duration-300"
                        id="collapse-icon"></i>
                </button>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 p-4 custom-scrollbar overflow-y-auto">
                <div class="mb-8">
                    <h2 class="sidebar-text text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-3">Home
                    </h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ url('/pekebun') }}"
                                class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ menuActive('pekebun') }}">
                                <i class="fas fa-home text-lg w-5 shrink-0 {{ iconColor('pekebun') }}"></i>
                                <span class="sidebar-text font-medium">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- MENU Section -->
                <div class="mb-8">
                    <h2 class="sidebar-text text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-3">Menu
                    </h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ url('/pekebun/daftar-kebun') }}"
                                class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ menuActive(['pekebun.daftar-kebun', 'pekebun.detail-data-kebun']) }}">
                                <i
                                    class="fas fa-plant-wilt text-lg w-5 shrink-0 {{ iconColor(['pekebun.daftar-kebun', 'pekebun.detail-data-kebun']) }}"></i>
                                <span class="sidebar-text font-medium">Daftar Kebun</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/pekebun/daftar-pemetaan') }}"
                                class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ menuActive(['pekebun.daftar-pemetaan', 'pekebun.pemetaan-kebun', 'pekebun.allPemetaan']) }}">
                                <i
                                    class="fas fa-map text-lg w-5 shrink-0 {{ iconColor(['pekebun.daftar-pemetaan', 'pekebun.pemetaan-kebun', 'pekebun.allPemetaan']) }}"></i>
                                <span class="sidebar-text font-medium">Pemetaan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/pekebun/daftar-kuisioner') }}"
                                class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ menuActive(['pekebun.daftar-kuisioner', 'pekebun.kuisioner-kebun']) }}">
                                <i
                                    class="fas fa-list-check text-lg w-5 shrink-0 {{ iconColor(['pekebun.daftar-kuisioner', 'pekebun.kuisioner-kebun']) }}"></i>
                                <span class="sidebar-text font-medium">Kuisioner</span>
                            </a>
                        </li>
                        <li>
                            <a href=""
                                class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ menuActive('riwayat-presensi-guru') }}">
                                <i
                                    class="fas fa-chart-line text-lg w-5 shrink-0 {{ iconColor('riwayat-presensi-guru') }}"></i>
                                <span class="sidebar-text font-medium">Hasil SPK</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/pekebun/data-diri') }}"
                                class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ menuActive('pekebun.data-diri') }}">
                                <i class="fas fa-user-circle text-lg w-5 shrink-0 {{ iconColor('pekebun.data-diri') }}"></i>
                                <span class="sidebar-text font-medium">Data Diri</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-gray-100 bg-white mt-auto">
                <a href="{{ url('/logout') }}"
                    class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 transition-all duration-200 hover-lift">
                    <i class="fas fa-sign-out-alt text-lg w-5 shrink-0"></i>
                    <span class="sidebar-text font-medium">Keluar</span>
                </a>
            </div>
        </aside>

        <!-- Mobile Sidebar -->
        <aside id="mobile-sidebar" class="mobile-sidebar lg:hidden bg-white shadow-2xl">
            <!-- Mobile Sidebar Header -->
            <div class="flex items-center justify-between px-6 py-[18px] border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-linear-to-r from-green-600 to-emerald-600 rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-seedling text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">SPK ISPO</h1>
                        <p class="text-xs text-gray-500">Dashboard v1.0</p>
                    </div>
                </div>
                <button id="mobile-close-btn" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <nav class="flex-1 p-4 custom-scrollbar overflow-y-auto">
                <div class="mb-8">
                    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-3">Home</h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ url('/pekebun') }}"
                                class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ menuActive('pekebun') }}">
                                <i class="fas fa-home text-lg w-5 {{ iconColor('pekebun') }}"></i>
                                <span class="font-medium">Dashboard</span>
                                @if (request()->routeIs('pekebun'))
                                    <div class="ml-auto">
                                        <span class="w-2 h-2 bg-white bg-opacity-60 rounded-full inline-block"></span>
                                    </div>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mb-8">
                    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-3">Menu</h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ url('/pekebun/daftar-kebun') }}"
                                class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ menuActive(['pekebun.daftar-kebun', 'pekebun.detail-data-kebun']) }}">
                                <i class="fas fa-list-check text-lg w-5 {{ iconColor(['pekebun.daftar-kebun', 'pekebun.detail-data-kebun']) }}"></i>
                                <span class="font-medium">Daftar Kebun</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/pekebun/daftar-pemetaan') }}"
                                class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ menuActive(['pekebun.daftar-pemetaan', 'pekebun.pemetaan-kebun', 'pekebun.allPemetaan']) }}">
                                <i class="fas fa-map text-lg w-5 {{ iconColor(['pekebun.daftar-pemetaan', 'pekebun.pemetaan-kebun', 'pekebun.allPemetaan']) }}"></i>
                                <span class="font-medium">Pemetaan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/pekebun/daftar-kuisioner') }}"
                                class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ menuActive(['pekebun.daftar-kuisioner', 'pekebun.kuisioner-kebun']) }}">
                                <i class="fas fa-list-check text-lg w-5 {{ iconColor(['pekebun.daftar-kuisioner', 'pekebun.kuisioner-kebun']) }}"></i>
                                <span class="font-medium">Kuisioner</span>
                            </a>
                        </li>
                        <li>
                            <a href=""
                                class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ menuActive('riwayat-presensi-guru') }}">
                                <i class="fas fa-chart-line text-lg w-5 {{ iconColor('riwayat-presensi-guru') }}"></i>
                                <span class="font-medium">Hasil SPK</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/pekebun/data-diri') }}"
                                class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ menuActive('pekebun.data-diri') }}">
                                <i class="fas fa-user-circle text-lg w-5 {{ iconColor('pekebun.data-diri') }}"></i>
                                <span class="font-medium">Data Diri</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Mobile Sidebar Footer -->
            <div class="p-4 border-t border-gray-100 bg-white mt-auto">
                <a href="{{ url('/logout') }}"
                    class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 transition-all duration-200 hover-lift">
                    <i class="fas fa-sign-out-alt text-lg w-5"></i>
                    <span class="font-medium">Keluar</span>
                </a>
            </div>
        </aside>


        <!-- Main Content -->
        <div class="flex-1 transition-all duration-300 min-h-screen" id="main-content">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-30 w-full">
                <div class="flex items-center justify-between px-6 py-2">
                    <!-- Left Section -->
                    <div class="flex items-center space-x-4">
                        <!-- Mobile Menu Button -->
                        <button id="mobile-menu-btn"
                            class="lg:hidden p-2 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class="fas fa-bars text-2xl text-gray-600"></i>
                        </button>

                        <!-- Expand Button (for collapsed sidebar on desktop) -->
                        <button id="expand-btn"
                            class="hidden p-2 rounded-lg bg-green-100 hover:bg-green-200 transition-colors text-green-600">
                            <i class="fas fa-chevron-right text-sm"></i>
                        </button>

                        <!-- Breadcrumb -->
                        <div class="hidden md:flex items-center space-x-2 text-sm">
                            <a href="{{ url("/pekebun") }}" class="text-gray-500 hover:text-green-600 transition-colors">Home</a>

                            @foreach (breadcrumb() as $item)
                                <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                                @if (isset($item['route']))
                                    <a href="{{ route($item['route']) }}"
                                        class="text-gray-500 hover:text-green-600 transition-colors">
                                        {{ $item['label'] }}
                                    </a>
                                @else
                                    <span class="text-gray-800 font-medium">{{ $item['label'] }}</span>
                                @endif
                            @endforeach
                        </div>

                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center space-x-4">

                        <!-- User Menu -->
                        <div class="relative">
                            <button id="user-menu-btn"
                                class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                @if (Auth::user()->foto_profil)
                                    <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="foto_profil"
                                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-100">
                                @else
                                    <div
                                        class="w-8 h-8 bg-linear-to-r from-green-600 to-emerald-600 rounded-full flex items-center justify-center">
                                        <span
                                            class="text-white font-semibold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                                    </div>
                                @endif
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ \Illuminate\Support\Str::limit(Auth::user()->name, 15) }}
                                    </p>
                                    <p class="text-xs text-gray-500">Pekebun</p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                            </button>

                            <!-- User Dropdown -->
                            <div id="user-dropdown"
                                class="hidden absolute right-0 mt-2 w-[345px] bg-white rounded-lg shadow-2xl z-50">
                                <!-- Profile Header -->
                                <div class="p-4 bg-linear-to-r from-green-600 to-emerald-600 rounded-t-xl">
                                    <div class="flex items-center space-x-3">
                                        @if (Auth::user()->foto_profil)
                                            <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}"
                                                alt="foto_profil"
                                                class="w-12 h-12 rounded-full object-cover border-2 border-white/30">
                                        @else
                                            <div
                                                class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                                                <span
                                                    class="text-green-700 font-semibold text-md">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-white font-semibold">
                                                {{ \Illuminate\Support\Str::limit(Auth::user()->name, 28) }}
                                            </p>
                                            <p class="text-green-100 text-sm">
                                                {{ \Illuminate\Support\Str::limit(Auth::user()->email, 28) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Menu Items -->
                                <div class="p-2">
                                    <a href="{{ url('/pekebun/data-diri') }}"
                                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-green-50 transition-colors">
                                        <i class="fas fa-user-circle text-green-600"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Data Diri</p>
                                            <p class="text-xs text-gray-500">Kelola informasi data diri</p>
                                        </div>
                                    </a>
                                    <a href=""
                                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-amber-50 transition-colors">
                                        <i class="fas fa-key text-amber-500"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Ganti Password</p>
                                            <p class="text-xs text-gray-500">Update keamanan akun</p>
                                        </div>
                                    </a>
                                    <hr class="my-2 text-gray-200">
                                    <a href="{{ url('/logout') }}"
                                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-red-50 text-red-600 transition-colors">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <div>
                                            <p class="text-sm font-medium">Keluar</p>
                                            <p class="text-xs opacity-75">Logout dari sistem</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="">
                <!-- Content Container -->
                <div id="content-area">
                    <!-- Laravel Blade Yield Content -->
                    <div>
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
    {{-- Leaflet + Leaflet.Draw --}}
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6.5.0/turf.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>

</body>

</html>
