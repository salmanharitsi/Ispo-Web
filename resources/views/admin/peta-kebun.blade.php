@extends('layouts.admin')

@section('title', 'Peta Kebun - ' . $kebun->nama_kebun)

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
      <div>
        <p class="text-xs uppercase tracking-wide text-emerald-600 font-semibold mb-1">
          Peta Lahan Kebun
        </p>
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900">
          {{ $kebun->nama_kebun }}
        </h1>
        <p class="text-sm text-slate-500 mt-1">
          Menampilkan batas polygon lahan kebun berdasarkan hasil pemetaan.
        </p>
      </div>
      <a href="{{ url('/admin/daftar-kebun') }}"
        class="inline-flex items-center gap-2 rounded-lg bg-white border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition shadow-sm">
        <i class="fa-solid fa-arrow-left text-xs"></i>
        <span>Kembali ke Daftar Kebun</span>
      </a>
    </div>

    {{-- Info Kebun & Pemilik --}}
    <div class="grid md:grid-cols-2 gap-5">

      {{-- Info Kebun --}}
      <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-3">
        <h2 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
          <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 text-xs">
            <i class="fa-solid fa-seedling"></i>
          </span>
          Informasi Kebun
        </h2>
        <div class="space-y-2 text-sm">
          <div class="text-slate-800 font-semibold">{{ $kebun->nama_kebun }}</div>
          <div class="text-slate-500">
            Lokasi: <span class="font-medium text-slate-700">{{ $kebun->lokasi_kebun }}</span>
          </div>
          @php
            $lokasiParts = [];
            if ($kebun->desa) $lokasiParts[] = 'Desa ' . $kebun->desa;
            if ($kebun->kecamatan) $lokasiParts[] = 'Kec. ' . $kebun->kecamatan;
          @endphp
          @if(count($lokasiParts))
            <div class="text-slate-500">{{ implode(', ', $lokasiParts) }}</div>
          @endif
          @if($kebun->tahun_tanam)
            <div class="text-slate-500">
              Tahun tanam: <span class="font-medium">{{ $kebun->tahun_tanam }}</span>
            </div>
          @endif

          {{-- Status ISPO --}}
          <div class="pt-1">
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-medium border
              {{ $kebun->status_ispo === 'sudah'
                  ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                  : ($kebun->status_ispo === 'proses'
                      ? 'bg-amber-50 text-amber-700 border-amber-100'
                      : 'bg-slate-50 text-slate-500 border-slate-200') }}">
              <i class="fa-solid fa-award"></i>
              @if($kebun->status_ispo === 'sudah')
                Sudah layak
              @elseif($kebun->status_ispo === 'proses')
                Proses penilaian
              @else
                Belum dinilai
              @endif
            </span>
          </div>
        </div>
      </div>

      {{-- Pemilik --}}
      <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-3">
        <h2 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
          <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-100 text-blue-700 text-xs">
            <i class="fa-solid fa-user"></i>
          </span>
          Pemilik Kebun
        </h2>
        @if($kebun->user)
          <div class="space-y-2 text-sm">
            <div class="text-slate-800 font-semibold">{{ $kebun->user->name }}</div>
            <div class="text-slate-500 flex items-center gap-1.5">
              <i class="fa-regular fa-envelope text-slate-400"></i>
              {{ $kebun->user->email }}
            </div>
            @if($kebun->user->no_hp)
              <div class="text-slate-500 flex items-center gap-1.5">
                <i class="fa-solid fa-phone text-slate-400"></i>
                {{ $kebun->user->no_hp }}
              </div>
            @endif
          </div>
        @else
          <p class="text-sm text-slate-400">Data pemilik tidak ditemukan.</p>
        @endif
      </div>
    </div>

    {{-- Ringkasan Statistik --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm px-4 py-3">
      <div class="grid sm:grid-cols-4 gap-3 text-center">
        <div>
          <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Luas (input)</p>
          <p class="text-lg font-bold text-emerald-700">
            {{ number_format($kebun->luas_lahan, 2, ',', '.') }}
            <span class="text-sm text-slate-500 font-normal">Ha</span>
          </p>
        </div>
        <div>
          <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Luas (GPS)</p>
          <p class="text-lg font-bold text-slate-900">
            {{ $kebun->area_hectare ? number_format($kebun->area_hectare, 4, ',', '.') . ' Ha' : '-' }}
          </p>
        </div>
        <div>
          <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Jumlah Pohon</p>
          <p class="text-lg font-bold text-slate-900">
            {{ $kebun->jumlah_pohon ? number_format($kebun->jumlah_pohon) : '-' }}
          </p>
        </div>
        <div>
          <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Keliling (GPS)</p>
          <p class="text-lg font-bold text-slate-900">
            {{ $kebun->perimeter_m ? number_format($kebun->perimeter_m, 0, ',', '.') . ' m' : '-' }}
          </p>
        </div>
      </div>
    </div>

    {{-- Peta Kebun --}}
    @include('admin.ispo._card-peta', ['kebun' => $kebun])

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

  function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371000;
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

  function getCompassDirection(bearing) {
    const directions = ['U', 'TL', 'T', 'BD', 'S', 'BDy', 'B', 'BLy'];
    const index = Math.round(bearing / 45) % 8;
    return directions[index];
  }

  function addDistanceLabelsForKebunLayer(layer) {
    if (!kebunMapInstance) return;
    const map = kebunMapInstance;

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

    // Compass rose control
    const CompassControl = L.Control.extend({
      options: { position: 'topright' },
      onAdd: function () {
        const container = L.DomUtil.create('div', 'leaflet-compass-rose');
        container.innerHTML = '<img src="/images/arah-mata-angin.png" alt="Arah Mata Angin" style="width:90px;height:90px;opacity:0.85;pointer-events:none;">';
        container.style.cssText = 'background:transparent;border:none;box-shadow:none;';
        return container;
      }
    });
    map.addControl(new CompassControl());

    streetLayerKebun = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors',
      maxZoom: 19,
    });

    satelliteLayerKebun = L.tileLayer(
      'https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',
      {
        attribution: 'Map data ©2024 Google',
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
      }
    );

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

    map.on('zoomend', toggleKebunDistanceLabelsVisibility);

    initMapTypeToggleKebun();
  }
</script>
@endpush
