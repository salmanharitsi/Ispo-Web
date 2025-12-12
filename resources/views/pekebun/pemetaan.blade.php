@extends('layouts.pekebun')

@section('title', 'Pemetaan Kebun')

@section('content')
  <div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
          <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
              Pemetaan Lahan
            </h1>
            <p class="text-gray-600 mt-1">
              Petakan area kebun
              <span class="font-bold text-gray-900">{{ $kebun->nama_kebun }}</span>
              di peta interaktif
            </p>
          </div>
        </div>

        <!-- Info Alert -->
        <div class="bg-green-50 border border-green-500 p-4 rounded-lg">
          <div class="flex items-start">
            <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                clip-rule="evenodd"></path>
            </svg>
            <div>
              <p class="text-sm font-medium text-green-800">Cara Pemetaan</p>
              <p class="text-sm text-green-700 mt-1">
                1. Klik tombol <strong>Polygon</strong> di toolbar kiri peta<br>
                2. Klik titik demi titik mengikuti batas lahan Anda<br>
                3. <strong>Jarak dan arah (bearing)</strong> akan ditampilkan otomatis di setiap sisi<br>
                4. Klik titik awal untuk menutup area<br>
                5. Area hijau yang terbentuk adalah lahan Anda, kemudian klik <strong>Simpan Peta Lahan</strong>
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Card peta -->
      <div class="bg-white rounded-lg shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h2 class="text-base font-semibold text-slate-900 flex items-center gap-2">
              <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 text-xs">
                <i class="fa-solid fa-pen-ruler"></i>
              </span>
              <span>Gambar Area Lahan</span>
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
              Pilih tool <span class="font-semibold">Polygon</span>, lalu klik titik demi titik mengikuti
              batas lahan Anda. Jarak dan bearing akan ditampilkan otomatis.
            </p>
          </div>
          <button type="button" id="getCurrentLocation"
            class="inline-flex items-center justify-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1 transition">
            <i class="fa-solid fa-location-crosshairs text-[11px]"></i>
            <span>Gunakan lokasi saya</span>
          </button>
        </div>

        <div class="px-5 sm:px-5 pb-5">
          <div class="relative">
            <div id="map" class="z-1"></div>

            <!-- Legenda -->
            <div class="absolute bottom-3 right-3 bg-white/90 backdrop-blur-sm shadow-md rounded-lg px-3 py-2 text-[11px] text-slate-600 space-y-1 border border-slate-100 z-10">
              <div class="flex items-center gap-2">
                <span class="inline-flex h-3 w-3 rounded-full bg-emerald-500"></span>
                <span>Lahan Anda</span>
              </div>
              <div class="flex items-center gap-2">
                <span class="inline-flex h-3 w-3 rounded-full bg-blue-500"></span>
                <span>Lahan pekebun lain</span>
              </div>
            </div>
          </div>

          <!-- Form simpan -->
          <form action="{{ route('pekebun.pemetaan.simpan', $kebun->id) }}" method="POST"
            class="mt-4 flex flex-col gap-3" id="pemetaan-form">
            @csrf

            <input type="hidden" name="geometry" id="geometry">
            <input type="hidden" name="polygon_sides" id="polygon_sides">
            <input type="hidden" name="centroid_lat" id="centroid_lat">
            <input type="hidden" name="centroid_lng" id="centroid_lng">
            <input type="hidden" name="area_m2" id="area_m2">
            <input type="hidden" name="area_hectare" id="area_hectare">
            <input type="hidden" name="perimeter_m" id="perimeter_m">

            <!-- Info Polygon -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div class="inline-flex items-center gap-2 rounded-lg bg-slate-50 px-3 py-2 border border-slate-200">
                <span class="text-[11px] uppercase tracking-wide text-slate-400 font-semibold">Centroid</span>
                <span class="font-mono text-[11px] text-emerald-700">
                  <span id="latDisplay">-</span>, <span id="lngDisplay">-</span>
                </span>
              </div>
              
              <div class="inline-flex items-center gap-2 rounded-lg bg-blue-50 px-3 py-2 border border-blue-200">
                <span class="text-[11px] uppercase tracking-wide text-blue-400 font-semibold">Luas Area</span>
                <span class="font-mono text-[11px] text-blue-700">
                  <span id="areaDisplay">-</span> m² (<span id="areaHectareDisplay">-</span> Ha)
                </span>
              </div>

              <div class="inline-flex items-center gap-2 rounded-lg bg-purple-50 px-3 py-2 border border-purple-200">
                <span class="text-[11px] uppercase tracking-wide text-purple-400 font-semibold">Keliling</span>
                <span class="font-mono text-[11px] text-purple-700">
                  <span id="perimeterDisplay">-</span> m
                </span>
              </div>

              <div class="inline-flex items-center gap-2 rounded-lg bg-amber-50 px-3 py-2 border border-amber-200">
                <span class="text-[11px] uppercase tracking-wide text-amber-400 font-semibold">Jumlah Sisi</span>
                <span class="font-mono text-[11px] text-amber-700">
                  <span id="sidesCountDisplay">-</span>
                </span>
              </div>
            </div>

            <div class="flex items-center gap-2 justify-end">
              <button type="submit" id="saveBtn"
                class="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-4 py-2 text-xs sm:text-sm font-medium text-white shadow-md shadow-emerald-500/30 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1 disabled:bg-slate-300 disabled:shadow-none disabled:cursor-not-allowed transition"
                disabled>
                <i class="fa-solid fa-floppy-disk text-[11px]"></i>
                <span>Simpan Peta Lahan</span>
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Ringkasan info kebun -->
      <div class="mt-5 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg border border-slate-100 px-5 py-3.5 shadow-sm">
          <p class="text-[11px] uppercase tracking-wide text-slate-400 font-semibold mb-1.5">
            Lokasi Kebun
          </p>
          <p class="text-sm font-medium text-slate-800">
            {{ $kebun->lokasi_kebun }}
          </p>
          @if ($kebun->desa || $kebun->kecamatan)
            <p class="text-xs text-slate-500 mt-0.5">
              {{ $kebun->desa ? $kebun->desa . ', ' : '' }}{{ $kebun->kecamatan }}
            </p>
          @endif
        </div>
        <div class="bg-white rounded-lg border border-slate-100 px-4 py-3.5 shadow-sm">
          <p class="text-[11px] uppercase tracking-wide text-slate-400 font-semibold mb-1.5">
            Luas Lahan (Ha)
          </p>
          <p class="text-sm font-semibold text-slate-800">
            {{ number_format($kebun->luas_lahan, 2, ',', '.') }}
          </p>
          <p class="text-xs text-slate-500 mt-0.5">
            Data diambil dari input data lengkap
          </p>
        </div>
        <div class="bg-white rounded-lg border border-slate-100 px-4 py-3.5 shadow-sm">
          <p class="text-[11px] uppercase tracking-wide text-slate-400 font-semibold mb-1.5">
            Status Pemetaan
          </p>
          @if ($kebun->polygon)
            <p class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">
              <i class="fa-solid fa-check-circle"></i>
              <span>Sudah dalam bentuk polygon</span>
            </p>
          @elseif($kebun->latitude && $kebun->longitude)
            <p class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700">
              <i class="fa-solid fa-map-marker-alt"></i>
              <span>Hanya berupa titik</span>
            </p>
          @else
            <p class="inline-flex items-center gap-1.5 rounded-full bg-slate-50 px-3 py-1 text-xs font-medium text-slate-500">
              <i class="fa-regular fa-circle"></i>
              <span>Belum dipetakan</span>
            </p>
          @endif
        </div>
      </div>
    </div>
  </div>

  <script>
    const defaultLat = 0.8833;
    const defaultLng = 100.4833;

    const allKebun = @json($allKebun ?? []);
    const currentKebunId = @json($kebun->id);

    const otherPolygons = (allKebun || [])
      .filter(item => item.id !== currentKebunId && item.polygon)
      .map(item => ({
        type: 'Feature',
        geometry: item.polygon,
        properties: item,
      }));

    let mapInstance = null;
    let drawnItems = null;
    let othersLayer = null;
    let distanceLabels = [];
    const MIN_ZOOM_FOR_LABELS = 14; // Label muncul di zoom 14 ke atas

    // Fungsi untuk menghitung jarak (Haversine formula)
    function calculateDistance(lat1, lon1, lat2, lon2) {
      const R = 6371000; // Radius bumi dalam meter
      const dLat = (lat2 - lat1) * Math.PI / 180;
      const dLon = (lon2 - lon1) * Math.PI / 180;
      const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      return R * c;
    }

    // Fungsi untuk menghitung bearing
    function calculateBearing(lat1, lon1, lat2, lon2) {
      const dLon = (lon2 - lon1) * Math.PI / 180;
      const y = Math.sin(dLon) * Math.cos(lat2 * Math.PI / 180);
      const x = Math.cos(lat1 * Math.PI / 180) * Math.sin(lat2 * Math.PI / 180) -
        Math.sin(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.cos(dLon);
      let bearing = Math.atan2(y, x) * 180 / Math.PI;
      return (bearing + 360) % 360;
    }

    // Fungsi untuk mendapatkan arah kompas dari bearing
    function getCompassDirection(bearing) {
      const directions = ['U', 'TL', 'T', 'BD', 'S', 'BDy', 'B', 'BLy'];
      const index = Math.round(bearing / 45) % 8;
      return directions[index];
    }

    // Fungsi untuk menghitung luas polygon menggunakan turf
    function calculatePolygonArea(coords) {
      if (typeof turf !== 'undefined' && turf.area) {
        const polygon = turf.polygon([coords]);
        return turf.area(polygon);
      }
      return 0;
    }

    // Fungsi untuk menambahkan label jarak dan bearing
    function addDistanceLabels(layer) {
      // Hapus label lama
      distanceLabels.forEach(label => mapInstance.removeLayer(label));
      distanceLabels = [];

      // Cek zoom level, jika terlalu jauh (zoom < 14) maka tidak tampilkan label
      const currentZoom = mapInstance.getZoom();
      if (currentZoom < MIN_ZOOM_FOR_LABELS) {
        return; // Tidak tampilkan label saat zoom jauh
      }

      const latlngs = layer.getLatLngs()[0];
      
      for (let i = 0; i < latlngs.length; i++) {
        const start = latlngs[i];
        const end = latlngs[(i + 1) % latlngs.length];
        
        const distance = calculateDistance(start.lat, start.lng, end.lat, end.lng);
        const bearing = calculateBearing(start.lat, start.lng, end.lat, end.lng);
        const direction = getCompassDirection(bearing);
        
        // Titik tengah untuk label
        const midLat = (start.lat + end.lat) / 2;
        const midLng = (start.lng + end.lng) / 2;
        
        const labelHtml = `
          <div class="distance-label">
            <span class="distance">${distance.toFixed(2)} m</span>
            <span class="bearing">${bearing.toFixed(1)}° (${direction})</span>
          </div>
        `;
        
        const label = L.marker([midLat, midLng], {
          icon: L.divIcon({
            className: '',
            html: labelHtml,
            iconSize: [80, 40],
            iconAnchor: [40, 20]
          })
        }).addTo(mapInstance);
        
        distanceLabels.push(label);
      }
    }

    // Fungsi untuk toggle visibility label berdasarkan zoom
    function toggleDistanceLabelsVisibility() {
      const currentZoom = mapInstance.getZoom();
      
      distanceLabels.forEach(label => {
        if (currentZoom < MIN_ZOOM_FOR_LABELS) {
          // Sembunyikan label
          if (mapInstance.hasLayer(label)) {
            mapInstance.removeLayer(label);
          }
        } else {
          // Tampilkan label
          if (!mapInstance.hasLayer(label)) {
            label.addTo(mapInstance);
          }
        }
      });
    }

    // Fungsi untuk refresh label saat zoom berubah
    function refreshDistanceLabels() {
      if (drawnItems.getLayers().length > 0) {
        const layer = drawnItems.getLayers()[0];
        addDistanceLabels(layer);
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
      initMap();
      initGeolocationButton();
    });

    function initMap() {
      const mapEl = document.getElementById('map');
      if (!mapEl) return;

      mapInstance = L.map('map').setView([defaultLat, defaultLng], 10);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19
      }).addTo(mapInstance);

      drawnItems = new L.FeatureGroup();
      othersLayer = new L.FeatureGroup();

      mapInstance.addLayer(drawnItems);
      mapInstance.addLayer(othersLayer);

      let totalBounds = null;

      (allKebun || []).forEach(function(item) {
        if (!item.polygon) return;

        const feature = {
          type: 'Feature',
          geometry: item.polygon,
          properties: item,
        };

        const isCurrent = item.id === currentKebunId;

        const style = isCurrent ? {
          color: '#16a34a',
          weight: 2,
          fillColor: '#bbf7d0',
          fillOpacity: 0.45,
        } : {
          color: '#2563eb',
          weight: 1.5,
          dashArray: '4 3',
          fillColor: '#bfdbfe',
          fillOpacity: 0.25,
        };

        const polyLayer = L.geoJSON(feature, {
          style
        });

        polyLayer.eachLayer(function(layer) {
          const bounds = layer.getBounds();

          if (!totalBounds) {
            totalBounds = bounds;
          } else {
            totalBounds.extend(bounds);
          }

          if (isCurrent) {
            drawnItems.addLayer(layer);
            persistPolygon(layer);
            addDistanceLabels(layer); // Tambahkan label untuk polygon yang ada
          } else {
            othersLayer.addLayer(layer);
          }

          let markerLat = item.centroid && item.centroid[0] ? item.centroid[0] : bounds.getCenter().lat;
          let markerLng = item.centroid && item.centroid[1] ? item.centroid[1] : bounds.getCenter().lng;

          const iconHtml = `
            <div class="kebun-marker-pin ${isCurrent ? 'kebun-marker-pin--current' : 'kebun-marker-pin--other'}">
              <i class="fa-solid fa-location-dot"></i>
            </div>
          `;

          const icon = L.divIcon({
            html: iconHtml,
            className: '',
            iconSize: [26, 26],
            iconAnchor: [13, 26],
          });

          const marker = L.marker([markerLat, markerLng], {
            icon
          }).addTo(mapInstance);

          const luas = item.luas_lahan ? `${parseFloat(item.luas_lahan).toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          })} Ha` : '-';

          const tooltipHtml = `
            <div class="text-[11px]">
              <div class="font-semibold text-slate-800 mb-0.5">${item.nama_kebun || 'Kebun Tanpa Nama'}</div>
              <div class="text-slate-500">Pemilik: <span class="font-medium">${item.pemilik || '-'}</span></div>
              <div class="text-slate-500">Luas: <span class="font-medium">${luas}</span></div>
              ${isCurrent ? '<div class="mt-0.5 text-emerald-600 font-semibold">Kebun Anda</div>' : ''}
            </div>
          `;

          marker.bindTooltip(tooltipHtml, {
            direction: 'top',
            offset: [0, -14],
            opacity: 0.95,
            sticky: false,
          });
        });
      });

      if (totalBounds) {
        mapInstance.fitBounds(totalBounds, {
          padding: [24, 24]
        });
      }

      const drawControl = new L.Control.Draw({
        edit: {
          featureGroup: drawnItems,
          remove: true,
        },
        draw: {
          polygon: {
            allowIntersection: false,
            showArea: true,
            shapeOptions: {
              color: '#16a34a',
              weight: 2,
              fillColor: '#bbf7d0',
              fillOpacity: 0.45,
            },
          },
          polyline: false,
          rectangle: false,
          circle: false,
          marker: false,
          circlemarker: false,
        },
      });

      mapInstance.addControl(drawControl);

      // Event listener untuk zoom: toggle visibility label
      mapInstance.on('zoomend', function() {
        refreshDistanceLabels();
      });

      mapInstance.on(L.Draw.Event.CREATED, function(event) {
        const layer = event.layer;
        drawnItems.clearLayers();
        drawnItems.addLayer(layer);
        persistPolygon(layer);
        addDistanceLabels(layer);
      });

      mapInstance.on(L.Draw.Event.EDITED, function(event) {
        event.layers.eachLayer(function(layer) {
          persistPolygon(layer);
          addDistanceLabels(layer);
        });
      });

      mapInstance.on(L.Draw.Event.DELETED, function() {
        document.getElementById('geometry').value = '';
        document.getElementById('polygon_sides').value = '';
        document.getElementById('centroid_lat').value = '';
        document.getElementById('centroid_lng').value = '';
        document.getElementById('area_m2').value = '';
        document.getElementById('area_hectare').value = '';
        document.getElementById('perimeter_m').value = '';
        
        document.getElementById('latDisplay').textContent = '-';
        document.getElementById('lngDisplay').textContent = '-';
        document.getElementById('areaDisplay').textContent = '-';
        document.getElementById('areaHectareDisplay').textContent = '-';
        document.getElementById('perimeterDisplay').textContent = '-';
        document.getElementById('sidesCountDisplay').textContent = '-';
        document.getElementById('saveBtn').setAttribute('disabled', 'disabled');
        
        distanceLabels.forEach(label => mapInstance.removeLayer(label));
        distanceLabels = [];
      });
    }

    function intersectsOtherKebun(newGeometry) {
      if (!newGeometry || newGeometry.type !== 'Polygon') return false;

      if (typeof turf === 'undefined' || !turf.booleanIntersects) {
        console.warn('Turf.js belum dimuat');
        return false;
      }

      const newFeature = {
        type: 'Feature',
        geometry: newGeometry,
        properties: {},
      };

      for (const other of otherPolygons) {
        if (turf.booleanIntersects(newFeature, other)) {
          return true;
        }
      }

      return false;
    }

    function persistPolygon(layer) {
      const geojson = layer.toGeoJSON();

      if (!geojson.geometry || geojson.geometry.type !== 'Polygon') {
        alert('Bentuk lahan harus berupa polygon.');
        return;
      }

      if (intersectsOtherKebun(geojson.geometry)) {
        alert('Area lahan yang Anda gambar bertumpuk dengan lahan pekebun lain. Silakan sesuaikan batasnya.');
        if (drawnItems && drawnItems.hasLayer(layer)) {
          drawnItems.removeLayer(layer);
        }
        return;
      }

      const coords = geojson.geometry.coordinates[0];
      if (!Array.isArray(coords) || coords.length < 3) {
        alert('Polygon lahan minimal memiliki 3 titik.');
        return;
      }

      // Hitung centroid
      let sumLat = 0;
      let sumLng = 0;
      let count = coords.length;

      coords.forEach(function(pair) {
        sumLat += pair[1];
        sumLng += pair[0];
      });

      const centroidLat = sumLat / count;
      const centroidLng = sumLng / count;

      // Hitung data setiap sisi
      const sides = [];
      let totalPerimeter = 0;

      for (let i = 0; i < coords.length - 1; i++) {
        const from = {
          lat: coords[i][1],
          lng: coords[i][0]
        };
        const to = {
          lat: coords[i + 1][1],
          lng: coords[i + 1][0]
        };
        
        const distance = calculateDistance(from.lat, from.lng, to.lat, to.lng);
        const bearing = calculateBearing(from.lat, from.lng, to.lat, to.lng);
        const direction = getCompassDirection(bearing);
        
        totalPerimeter += distance;
        
        sides.push({
          from: from,
          to: to,
          distance: parseFloat(distance.toFixed(2)),
          bearing: parseFloat(bearing.toFixed(2)),
          direction: direction
        });
      }

      // Hitung luas area
      const area = calculatePolygonArea(coords);
      const areaHectare = area / 10000;

      // Set nilai ke form
      document.getElementById('geometry').value = JSON.stringify(geojson.geometry);
      document.getElementById('polygon_sides').value = JSON.stringify(sides);
      document.getElementById('centroid_lat').value = centroidLat;
      document.getElementById('centroid_lng').value = centroidLng;
      document.getElementById('area_m2').value = area.toFixed(2);
      document.getElementById('area_hectare').value = areaHectare.toFixed(4);
      document.getElementById('perimeter_m').value = totalPerimeter.toFixed(2);

      // Update tampilan
      document.getElementById('latDisplay').textContent = centroidLat.toFixed(6);
      document.getElementById('lngDisplay').textContent = centroidLng.toFixed(6);
      document.getElementById('areaDisplay').textContent = area.toFixed(2);
      document.getElementById('areaHectareDisplay').textContent = areaHectare.toFixed(4);
      document.getElementById('perimeterDisplay').textContent = totalPerimeter.toFixed(2);
      document.getElementById('sidesCountDisplay').textContent = sides.length;

      document.getElementById('saveBtn').removeAttribute('disabled');
    }

    function initGeolocationButton() {
      const btn = document.getElementById('getCurrentLocation');
      if (!btn) return;

      btn.addEventListener('click', function() {
        if (!navigator.geolocation) {
          alert('Browser Anda tidak mendukung geolocation.');
          return;
        }

        btn.disabled = true;
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-[11px]"></i><span>Mencari lokasi...</span>';

        navigator.geolocation.getCurrentPosition(
          function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            if (mapInstance) {
              mapInstance.setView([lat, lng], 15);
            }

            btn.disabled = false;
            btn.innerHTML = originalHtml;
          },
          function(error) {
            alert('Gagal mendapatkan lokasi: ' + error.message);
            btn.disabled = false;
            btn.innerHTML = originalHtml;
          }, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0,
          }
        );
      });
    }
  </script>
@endsection