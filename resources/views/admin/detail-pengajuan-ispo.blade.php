@extends('layouts.admin')

@section('title', 'Admin Detail Pengajuan ISPO')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Header --}}
    <div class="mb-4">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-3">
        <div>
          <h1 class="text-2xl md:text-3xl font-bold text-slate-900">
            Pemeriksaan Kelayakan Sertifikasi ISPO
          </h1>
          <p class="text-sm text-slate-500 mt-3 max-w-2xl">
            Halaman ini menampilkan ringkasan data pekebun, data kebun, hasil kuisioner, dan penilaian
            pendukung sebagai dasar keputusan sertifikasi ISPO.
          </p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 sm:items-center sm:justify-end">
          {{-- Status Finalisasi --}}
          <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-[11px] font-medium
            @if($kebun->status_finalisasi === 'final')
              bg-emerald-100 text-emerald-700 border border-emerald-200
            @else
              bg-yellow-50 text-yellow-700 border border-yellow-200
            @endif">
            <i class="fa-solid fa-clipboard-check text-[10px]"></i>
            <span>
              Finalisasi:
              {{ $kebun->status_finalisasi === 'final' ? 'Sudah final' : 'Belum final' }}
            </span>
          </span>

          {{-- Status ISPO --}}
          <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-[11px] font-medium
            @if($kebun->status_ispo === 'sudah')
              bg-emerald-100 text-emerald-700 border border-emerald-200
            @elseif($kebun->status_ispo === 'proses')
              bg-sky-100 text-sky-700 border border-sky-200
            @else
              bg-slate-100 text-slate-600 border border-slate-200
            @endif">
            <i class="fa-solid fa-certificate text-[10px]"></i>
            <span>
              Status ISPO:
              @switch($kebun->status_ispo)
                @case('sudah') Sudah tersertifikasi @break
                @case('proses') Dalam proses @break
                @default Belum tersertifikasi
              @endswitch
            </span>
          </span>
        </div>
      </div>
    </div>

    {{-- 1. Data Pekebun --}}
    @include('admin.ispo._card-pekebun', ['kebun' => $kebun])

    {{-- 2. Data Kebun --}}
    @include('admin.ispo._card-kebun', ['kebun' => $kebun])

    {{-- 3. Peta Kebun --}}
    @include('admin.ispo._card-peta', ['kebun' => $kebun])
    
    {{-- 4. Detail Jawaban Kuisioner (tabel) --}}
    @include('admin.ispo._card-kuisioner-detail', [
        'kuisioner'         => $kuisioner,
        'kuisionerQuestions'=> $kuisionerQuestions,
    ])

    {{-- 5. Ringkasan Kuisioner (SPK dari kuisioner) --}}
    @include('admin.ispo._card-kuisioner-summary', [
        'kuisionerSummary'  => $kuisionerSummary,
        'overallPercentage' => $overallPercentage,
        'totalBobotKuisioner' => $totalBobotKuisioner,
    ])

    {{-- 6. Penilaian SPK Berdasarkan Data Kebun --}}
    @include('admin.ispo._card-spk-kebun', [
        'kebunIndicators' => $kebunIndicators,
        'totalBobotKebun' => $totalBobotKebun,
    ])

    {{-- 7. CARD TOTAL PERHITUNGAN NILAI SPK (AHP) --}}
    @include('admin.ispo._card-total-nilai', [
        'totalBobotKuisioner' => $totalBobotKuisioner,
        'totalBobotKebun' => $totalBobotKebun,
        'totalNilaiPersentase' => $totalNilaiPersentase,
        'totalNilaiDesimal' => $totalNilaiDesimal,
    ])

    {{-- 8. Aksi Keputusan --}}
    @include('admin.ispo._card-actions', ['kebun' => $kebun])

  </div>
</div>
@endsection

@push('scripts')
@php
  $kebunDataArray = [
    'nama_kebun'     => $kebun->nama_kebun,
    'pemilik'        => optional($kebun->user)->name,
    'luas_lahan'     => $kebun->luas_lahan,
    'polygon'        => $kebun->polygon,
    'latitude'       => $kebun->latitude,
    'longitude'      => $kebun->longitude,
  ];
@endphp

<style>
  .map-type-btn-kebun {
    color: #64748b;
    background-color: transparent;
  }
  
  .map-type-btn-kebun:hover {
    color: #334155;
    background-color: #f1f5f9;
  }
  
  .map-type-btn-kebun.active {
    color: #059669;
    background-color: #d1fae5;
    font-weight: 600;
  }
</style>

<script>
  const kebunData = @json($kebunDataArray);

  let kebunMapInstance = null;
  let kebunDistanceLabels = [];
  let currentBaseLayerKebun = null;
  let streetLayerKebun = null;
  let satelliteLayerKebun = null;
  const MIN_ZOOM_FOR_LABELS = 14;

  // === Util: hitung jarak (Haversine) ===
  function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371000; // meter
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a =
      Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(lat1 * Math.PI / 180) *
        Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) *
        Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
  }

  // === Util: hitung bearing ===
  function calculateBearing(lat1, lon1, lat2, lon2) {
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const y = Math.sin(dLon) * Math.cos(lat2 * Math.PI / 180);
    const x =
      Math.cos(lat1 * Math.PI / 180) * Math.sin(lat2 * Math.PI / 180) -
      Math.sin(lat1 * Math.PI / 180) *
        Math.cos(lat2 * Math.PI / 180) *
        Math.cos(dLon);
    let bearing = (Math.atan2(y, x) * 180) / Math.PI;
    return (bearing + 360) % 360;
  }

  // === Util: arah kompas dari bearing ===
  function getCompassDirection(bearing) {
    const directions = ['U', 'TL', 'T', 'BD', 'S', 'BDy', 'B', 'BLy'];
    const index = Math.round(bearing / 45) % 8;
    return directions[index];
  }

  // === Tambah label jarak + bearing untuk 1 polygon ===
  function addDistanceLabelsForKebunLayer(layer) {
    if (!kebunMapInstance) return;
    const map = kebunMapInstance;

    // hapus label lama dulu
    kebunDistanceLabels.forEach(label => {
      if (map.hasLayer(label)) map.removeLayer(label);
    });
    kebunDistanceLabels = [];

    const latlngs = layer.getLatLngs()[0];
    if (!latlngs || latlngs.length < 2) return;

    const currentZoom = map.getZoom();

    for (let i = 0; i < latlngs.length; i++) {
      const start = latlngs[i];
      const end = latlngs[(i + 1) % latlngs.length];

      const distance = calculateDistance(start.lat, start.lng, end.lat, end.lng);
      const bearing = calculateBearing(start.lat, start.lng, end.lat, end.lng);
      const direction = getCompassDirection(bearing);

      // titik tengah sisi
      const midLat = (start.lat + end.lat) / 2;
      const midLng = (start.lng + end.lng) / 2;

      const labelHtml = `
        <div class="distance-label">
          <span class="distance">${distance.toFixed(2)} m</span>
          <span class="bearing">${bearing.toFixed(1)}° (${direction})</span>
        </div>
      `;

      const marker = L.marker([midLat, midLng], {
        icon: L.divIcon({
          className: '',
          html: labelHtml,
          iconSize: [80, 40],
          iconAnchor: [40, 20],
        }),
      });

      kebunDistanceLabels.push(marker);

      if (currentZoom >= MIN_ZOOM_FOR_LABELS) {
        marker.addTo(map);
      }
    }
  }

  // === Show/hide label ketika zoom berubah ===
  function toggleKebunDistanceLabelsVisibility() {
    if (!kebunMapInstance) return;
    const map = kebunMapInstance;
    const currentZoom = map.getZoom();

    kebunDistanceLabels.forEach(label => {
      const isOnMap = map.hasLayer(label);
      if (currentZoom < MIN_ZOOM_FOR_LABELS && isOnMap) {
        map.removeLayer(label);
      } else if (currentZoom >= MIN_ZOOM_FOR_LABELS && !isOnMap) {
        label.addTo(map);
      }
    });
  }

  // === Initialize Map Type Toggle ===
  function initMapTypeToggleKebun() {
    const btnStreet = document.getElementById("btnMapTypeStreetKebun");
    const btnSatellite = document.getElementById("btnMapTypeSatelliteKebun");

    if (!btnStreet || !btnSatellite || !kebunMapInstance) return;

    btnStreet.addEventListener("click", function () {
      if (currentBaseLayerKebun !== streetLayerKebun) {
        kebunMapInstance.removeLayer(currentBaseLayerKebun);
        streetLayerKebun.addTo(kebunMapInstance);
        currentBaseLayerKebun = streetLayerKebun;

        btnStreet.classList.add("active");
        btnSatellite.classList.remove("active");
      }
    });

    btnSatellite.addEventListener("click", function () {
      if (currentBaseLayerKebun !== satelliteLayerKebun) {
        kebunMapInstance.removeLayer(currentBaseLayerKebun);
        satelliteLayerKebun.addTo(kebunMapInstance);
        currentBaseLayerKebun = satelliteLayerKebun;

        btnSatellite.classList.add("active");
        btnStreet.classList.remove("active");
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    initKebunMap();
  });

  function initKebunMap() {
    const mapEl = document.getElementById('map-kebun');
    if (!mapEl || !kebunData || !kebunData.polygon) return;

    const defaultLat = kebunData.latitude || 0.8833;
    const defaultLng = kebunData.longitude || 100.4833;

    kebunMapInstance = L.map('map-kebun').setView([defaultLat, defaultLng], 14);
    const map = kebunMapInstance;

    // Layer OpenStreetMap
    streetLayerKebun = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors',
      maxZoom: 19,
    });

    // Layer Satelit (Esri World Imagery)
    satelliteLayerKebun = L.tileLayer(
      'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
      {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
        maxZoom: 19,
      }
    );

    // Set default layer (SATELIT)
    currentBaseLayerKebun = satelliteLayerKebun;
    currentBaseLayerKebun.addTo(map);

    const feature = {
      type: 'Feature',
      geometry: kebunData.polygon,
      properties: kebunData,
    };

    const style = {
      color: '#16a34a',
      weight: 2,
      fillColor: '#bbf7d0',
      fillOpacity: 0.45,
    };

    const polyLayer = L.geoJSON(feature, { style }).addTo(map);

    let bounds = null;
    polyLayer.eachLayer(function (layer) {
      const b = layer.getBounds();
      if (!bounds) {
        bounds = b;
      } else {
        bounds.extend(b);
      }

      // Tambah label jarak + bearing untuk polygon ini
      addDistanceLabelsForKebunLayer(layer);
    });

    if (bounds) {
      map.fitBounds(bounds, { padding: [24, 24] });
    }

    const center = bounds ? bounds.getCenter() : map.getCenter();

    const iconHtml = `
      <div class="kebun-marker-pin kebun-marker-pin--mine">
        <i class="fa-solid fa-location-dot"></i>
      </div>
    `;

    const icon = L.divIcon({
      html: iconHtml,
      className: '',
      iconSize: [26, 26],
      iconAnchor: [13, 26],
    });

    const marker = L.marker([center.lat, center.lng], { icon }).addTo(map);

    const luas = kebunData.luas_lahan
      ? kebunData.luas_lahan.toLocaleString('id-ID', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2,
        }) + ' Ha'
      : '-';

    const tooltipHtml = `
      <div class="text-[11px]">
        <div class="font-semibold text-slate-800 mb-0.5">
          ${kebunData.nama_kebun || 'Kebun Tanpa Nama'}
        </div>
        <div class="text-slate-500">
          Pemilik: <span class="font-medium">${kebunData.pemilik || '-'}</span>
        </div>
        <div class="text-slate-500">
          Luas: <span class="font-medium">${luas}</span>
        </div>
      </div>
    `;

    marker.bindTooltip(tooltipHtml, {
      direction: 'top',
      offset: [0, -14],
      opacity: 0.95,
      sticky: false,
    });

    // refresh visibilitas label saat zoom berubah
    map.on('zoomend', toggleKebunDistanceLabelsVisibility);

    // Initialize map type toggle
    initMapTypeToggleKebun();
  }
</script>
@endpush