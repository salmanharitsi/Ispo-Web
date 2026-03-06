@extends('layouts.admin')

@section('title', 'Admin Peta Semua Kebun')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
  <div class="max-w-7xl mx-auto p-5 space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
      <div>
        <p class="text-xs uppercase tracking-wide text-emerald-600 font-semibold mb-1">
          Peta Semua Lahan Kebun
        </p>
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900">
          Sebaran Lahan Seluruh Pekebun
        </h1>
        <p class="text-sm text-slate-500 mt-1">
          Menampilkan seluruh lahan kebun yang sudah dipetakan di Kabupaten Rokan Hulu.
          Warna area menunjukkan status penilaian ISPO.
        </p>
      </div>
      <div class="flex flex-col items-start md:items-end gap-2">
        <a href="{{ url('/admin/daftar-kebun') }}"
          class="inline-flex items-center gap-2 rounded-lg bg-white border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition shadow-sm">
          <i class="fa-solid fa-arrow-left text-xs"></i>
          <span>Kembali ke Daftar Kebun</span>
        </a>
      </div>
    </div>

    {{-- Card Peta --}}
    <div class="bg-white rounded-lg border border-slate-100 shadow-sm overflow-hidden">
      <div class="px-5 pt-5 pb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
          <h2 class="text-base font-semibold text-slate-900 flex items-center gap-2">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 text-xs">
              <i class="fa-solid fa-map-location-dot"></i>
            </span>
            <span>Peta Lahan Kebun</span>
          </h2>
          <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Arahkan kursor ke pin pada peta untuk melihat nama kebun, pemilik, dan luas lahannya.
          </p>
        </div>
        <div class="flex items-center gap-2">
          {{-- Button pilih jenis peta --}}
          <div class="inline-flex rounded-lg border border-slate-200 bg-white p-1 shadow-sm">
            <button
              type="button"
              id="btnMapTypeStreet"
              class="map-type-btn inline-flex items-center gap-1.5 rounded-md px-2.5 py-1.5 text-xs font-medium transition"
            >
              <i class="fa-solid fa-map text-[11px]"></i>
              <span>Peta</span>
            </button>
            <button
              type="button"
              id="btnMapTypeSatellite"
              class="map-type-btn active inline-flex items-center gap-1.5 rounded-md px-2.5 py-1.5 text-xs font-medium transition"
            >
              <i class="fa-solid fa-satellite text-[11px]"></i>
              <span>Satelit</span>
            </button>
          </div>
          
          <button
            type="button"
            id="getCurrentLocation"
            class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1 transition"
          >
            <i class="fa-solid fa-location-crosshairs text-[11px]"></i>
            <span>Fokus ke lokasi saya</span>
          </button>
        </div>
      </div>

      <div class="px-5 pb-5">
        <div class="relative">
          <div
            id="map-all-kebun"
            class="w-full h-[420px] sm:h-[520px] rounded-lg border border-slate-200 overflow-hidden z-0"
          ></div>

          {{-- Legenda --}}
          <div class="absolute bottom-3 right-3 z-10 bg-white/90 backdrop-blur-sm shadow-md rounded-lg px-3 py-2 text-[11px] text-slate-600 border border-slate-100 space-y-2">
            {{-- Status ISPO --}}
            <p class="text-[10px] uppercase tracking-wide text-slate-400 font-semibold pb-1 border-b border-slate-100">Status Penilaian</p>
            <div class="space-y-1">
              <div class="flex items-center gap-2">
                <span class="inline-flex h-3 w-5 rounded-sm bg-red-300 border border-red-600"></span>
                <span>Belum dinilai</span>
              </div>
              <div class="flex items-center gap-2">
                <span class="inline-flex h-3 w-5 rounded-sm bg-amber-200 border border-amber-500"></span>
                <span>Proses penilaian</span>
              </div>
              <div class="flex items-center gap-2">
                <span class="inline-flex h-3 w-5 rounded-sm bg-emerald-300 border border-emerald-600"></span>
                <span>Sudah dinilai</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Ringkasan Data Kebun --}}
    <div class="bg-white rounded-lg border border-slate-100 shadow-sm px-4 py-4 sm:px-6 sm:py-5">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
        <h2 class="text-sm font-semibold text-slate-900">
          Ringkasan Data Kebun
        </h2>
        <p class="text-xs text-slate-400">
          Total kebun dipetakan:
          <span class="font-semibold text-slate-700">{{ count($allKebun) }}</span>
        </p>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full text-xs sm:text-sm">
          <thead>
            <tr class="border-b border-slate-100 text-left text-[11px] uppercase tracking-wide text-slate-400">
              <th class="py-2 pr-4">Nama Kebun</th>
              <th class="py-2 pr-4">Pemilik</th>
              <th class="py-2 pr-4">Luas (Ha)</th>
              <th class="py-2">Status ISPO</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @forelse($allKebun as $row)
              <tr>
                <td class="py-2 pr-4 text-slate-800 font-medium">
                  {{ $row['nama_kebun'] ?? 'Kebun tanpa nama' }}
                </td>
                <td class="py-2 pr-4 text-slate-600">
                  {{ $row['pemilik'] ?? '-' }}
                </td>
                <td class="py-2 pr-4 text-slate-700">
                  @if($row['luas_lahan'])
                    {{ number_format($row['luas_lahan'], 2, ',', '.') }}
                  @else
                    -
                  @endif
                </td>
                <td class="py-2">
                  @php $status = $row['status_ispo'] ?? 'belum'; @endphp
                  @if($status === 'sudah')
                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 text-emerald-700 px-2 py-0.5 text-[11px] font-medium">
                      <i class="fa-solid fa-award text-[10px]"></i>
                      Sudah ISPO
                    </span>
                  @elseif($status === 'proses')
                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 text-amber-700 px-2 py-0.5 text-[11px] font-medium">
                      <i class="fa-solid fa-clock text-[10px]"></i>
                      Proses
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 text-slate-600 px-2 py-0.5 text-[11px] font-medium">
                      <i class="fa-regular fa-circle text-[10px]"></i>
                      Belum
                    </span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="py-3 text-center text-slate-400 text-xs">
                  Belum ada kebun yang dipetakan.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<style>
  .map-type-btn {
    color: #64748b;
    background-color: transparent;
  }
  
  .map-type-btn:hover {
    color: #334155;
    background-color: #f1f5f9;
  }
  
  .map-type-btn.active {
    color: #059669;
    background-color: #d1fae5;
    font-weight: 600;
  }
</style>

<script>
  const defaultLatAll = 0.8833;
  const defaultLngAll = 100.4833;

  const allKebunAll = @json($allKebun ?? []);

  let mapAllInstance = null;
  let distanceLabelsAll = [];
  let currentBaseLayer = null;
  let streetLayer = null;
  let satelliteLayer = null;
  const MIN_ZOOM_FOR_LABELS_ALL = 14;

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
    const directions = ["U", "TL", "T", "BD", "S", "BDy", "B", "BLy"];
    const index = Math.round(bearing / 45) % 8;
    return directions[index];
  }

  function addDistanceLabelsForLayer(layer) {
    const latlngs = layer.getLatLngs()[0];
    if (!latlngs || latlngs.length < 2) return;

    const currentZoom = mapAllInstance.getZoom();

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
          className: "",
          html: labelHtml,
          iconSize: [80, 40],
          iconAnchor: [40, 20],
        }),
      });

      distanceLabelsAll.push(marker);

      if (currentZoom >= MIN_ZOOM_FOR_LABELS_ALL) {
        marker.addTo(mapAllInstance);
      }
    }
  }

  function toggleDistanceLabelsVisibilityAll() {
    const currentZoom = mapAllInstance.getZoom();

    distanceLabelsAll.forEach((label) => {
      const isOnMap = mapAllInstance.hasLayer(label);

      if (currentZoom < MIN_ZOOM_FOR_LABELS_ALL && isOnMap) {
        mapAllInstance.removeLayer(label);
      } else if (currentZoom >= MIN_ZOOM_FOR_LABELS_ALL && !isOnMap) {
        label.addTo(mapAllInstance);
      }
    });
  }

  function initMapTypeToggle() {
    const btnStreet = document.getElementById("btnMapTypeStreet");
    const btnSatellite = document.getElementById("btnMapTypeSatellite");

    if (!btnStreet || !btnSatellite) return;

    btnStreet.addEventListener("click", function () {
      if (currentBaseLayer !== streetLayer) {
        mapAllInstance.removeLayer(currentBaseLayer);
        streetLayer.addTo(mapAllInstance);
        currentBaseLayer = streetLayer;

        btnStreet.classList.add("active");
        btnSatellite.classList.remove("active");
      }
    });

    btnSatellite.addEventListener("click", function () {
      if (currentBaseLayer !== satelliteLayer) {
        mapAllInstance.removeLayer(currentBaseLayer);
        satelliteLayer.addTo(mapAllInstance);
        currentBaseLayer = satelliteLayer;

        btnSatellite.classList.add("active");
        btnStreet.classList.remove("active");
      }
    });
  }

  document.addEventListener("DOMContentLoaded", function () {
    initAllKebunMap();
    initAllKebunGeolocationButton();
  });

  function initAllKebunMap() {
    const mapEl = document.getElementById("map-all-kebun");
    if (!mapEl) return;

    mapAllInstance = L.map("map-all-kebun").setView(
      [defaultLatAll, defaultLngAll],
      10
    );

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
    mapAllInstance.addControl(new CompassControl());

    streetLayer = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: "&copy; OpenStreetMap contributors",
      maxZoom: 19,
    });

    satelliteLayer = L.tileLayer(
      'https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',
      {
        attribution: 'Map data ©2024 Google',
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
      }
    );

    currentBaseLayer = satelliteLayer;
    currentBaseLayer.addTo(mapAllInstance);

    let totalBounds = null;

    (allKebunAll || []).forEach(function (item) {
      if (!item.polygon) return;

      const feature = {
        type: "Feature",
        geometry: item.polygon,
        properties: item,
      };

      // Warna area berdasarkan status ISPO
      const statusStyle = {
        belum: { fillColor: "#fca5a5", color: "#dc2626" },
        proses: { fillColor: "#fde68a", color: "#d97706" },
        sudah: { fillColor: "#6ee7b7", color: "#059669" },
      };

      const status = item.status_ispo || 'belum';
      const { fillColor, color: borderColor } = statusStyle[status] ?? statusStyle['belum'];

      const style = {
        color: borderColor,
        weight: 2,
        fillColor: fillColor,
        fillOpacity: 0.45,
      };

      const polyLayer = L.geoJSON(feature, { style });

      polyLayer.eachLayer(function (layer) {
        const bounds = layer.getBounds();

        if (!totalBounds) {
          totalBounds = bounds;
        } else {
          totalBounds.extend(bounds);
        }

        let markerLat =
          item.centroid && item.centroid[0]
            ? item.centroid[0]
            : bounds.getCenter().lat;
        let markerLng =
          item.centroid && item.centroid[1]
            ? item.centroid[1]
            : bounds.getCenter().lng;

        const iconHtml = `
          <div class="kebun-marker-pin kebun-marker-pin--mine">
            <i class="fa-solid fa-location-dot"></i>
          </div>
        `;

        const icon = L.divIcon({
          html: iconHtml,
          className: "",
          iconSize: [26, 26],
          iconAnchor: [13, 26],
        });

        const marker = L.marker([markerLat, markerLng], { icon }).addTo(
          mapAllInstance
        );

        const luas = item.luas_lahan
          ? `${parseFloat(item.luas_lahan).toLocaleString("id-ID", {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2,
            })} Ha`
          : "-";

        const tooltipHtml = `
          <div class="text-[11px]">
            <div class="font-semibold text-slate-800 mb-0.5">
              ${item.nama_kebun || "Kebun Tanpa Nama"}
            </div>
            <div class="text-slate-500">
              Pemilik: <span class="font-medium">${item.pemilik || "-"}</span>
            </div>
            <div class="text-slate-500">
              Luas: <span class="font-medium">${luas}</span>
            </div>
          </div>
        `;

        marker.bindTooltip(tooltipHtml, {
          direction: "top",
          offset: [0, -14],
          opacity: 0.95,
          sticky: false,
        });

        addDistanceLabelsForLayer(layer);
      });

      polyLayer.addTo(mapAllInstance);
    });

    if (totalBounds) {
      mapAllInstance.fitBounds(totalBounds, { padding: [24, 24] });
    }

    mapAllInstance.on("zoomend", toggleDistanceLabelsVisibilityAll);

    initMapTypeToggle();
  }

  function initAllKebunGeolocationButton() {
    const btn = document.getElementById("getCurrentLocation");
    if (!btn) return;

    btn.addEventListener("click", function () {
      if (!navigator.geolocation) {
        alert("Browser Anda tidak mendukung geolocation.");
        return;
      }

      btn.disabled = true;
      const originalHtml = btn.innerHTML;
      btn.innerHTML =
        '<i class="fa-solid fa-spinner fa-spin text-[11px]"></i><span>Mencari lokasi...</span>';

      navigator.geolocation.getCurrentPosition(
        function (position) {
          const lat = position.coords.latitude;
          const lng = position.coords.longitude;

          if (mapAllInstance) {
            mapAllInstance.setView([lat, lng], 14);
          }

          btn.disabled = false;
          btn.innerHTML = originalHtml;
        },
        function (error) {
          alert(
            "Gagal mendapatkan lokasi: " +
              error.message +
              "\nPastikan Anda mengizinkan akses lokasi di browser."
          );
          btn.disabled = false;
          btn.innerHTML = originalHtml;
        },
        {
          enableHighAccuracy: true,
          timeout: 10000,
          maximumAge: 0,
        }
      );
    });
  }
</script>
@endpush
