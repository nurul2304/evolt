<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import AppNavbar from '@/Components/AppNavbar.vue';
import AppFooter from '@/Components/AppFooter.vue';

// Data statis untuk tabel "Daftar Stasiun" untuk mencocokkan desain
const stations = ref([
  {
    id: 1,
    name: 'EV Station Batam Centre',
    coords: '1.0833, 104.0333',
    chargers: ['Fast', 'Regular'],
    hours: '24/7',
    lat: 1.0833,
    lng: 104.0333,
  },
  {
    id: 2,
    name: 'EV Station Nagoya',
    coords: '1.1200, 104.0500',
    chargers: ['Ultra Fast', 'Fast'],
    hours: '06:00-22:00',
    lat: 1.1200,
    lng: 104.0500,
  },
  {
    id: 3,
    name: 'EV Station Sekupang',
    coords: '1.1000, 103.9500',
    chargers: ['Regular'],
    hours: '08:00-20:00',
    lat: 1.1000,
    lng: 103.9500,
  },
  {
    id: 4,
    name: 'EV Station Tanjung Uncang',
    coords: '1.1300, 104.0600',
    chargers: ['Fast'],
    hours: '24/7',
    lat: 1.1300,
    lng: 104.0600,
  },
  {
    id: 5,
    name: 'EV Station Batu Aji',
    coords: '1.0500, 104.0200',
    chargers: ['Ultra Fast'],
    hours: '06:00-22:00',
    lat: 1.0500,
    lng: 104.0200,
  },
  {
    id: 6,
    name: 'EV Station Lubuk Baja',
    coords: '1.0900, 104.0400',
    chargers: ['Regular', 'Fast'],
    hours: '08:00-20:00',
    lat: 1.0900,
    lng: 104.0400,
  },
  {
    id: 7,
    name: 'EV Station Baloi',
    coords: '1.1100, 104.0300',
    chargers: ['Fast'],
    hours: '24/7',
    lat: 1.1100,
    lng: 104.0300,
  },
  {
    id: 8,
    name: 'EV Station Kabil',
    coords: '1.0700, 104.0100',
    chargers: ['Ultra Fast', 'Regular'],
    hours: '06:00-22:00',
    lat: 1.0700,
    lng: 104.0100,
  },
  {
    id: 9,
    name: 'EV Station Sagulung',
    coords: '1.1400, 104.0700',
    chargers: ['Regular'],
    hours: '08:00-20:00',
    lat: 1.1400,
    lng: 104.0700,
  },
  {
    id: 10,
    name: 'EV Station Nongsa',
    coords: '1.1600, 104.0800',
    chargers: ['Fast', 'Ultra Fast'],
    hours: '24/7',
    lat: 1.1600,
    lng: 104.0800,
  },
]);

let map = null;

const loadLeaflet = () => {
  return new Promise((resolve, reject) => {
    if (window.L) return resolve(window.L);

    // load CSS
    if (!document.querySelector('link[data-leaflet]')) {
      const link = document.createElement('link');
      link.rel = 'stylesheet';
      link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
      link.setAttribute('data-leaflet', '1');
      document.head.appendChild(link);
    }

    // load script
    if (!document.querySelector('script[data-leaflet]')) {
      const script = document.createElement('script');
      script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
      script.async = true;
      script.setAttribute('data-leaflet', '1');
      script.onload = () => resolve(window.L);
      script.onerror = reject;
      document.body.appendChild(script);
    } else {
      // script already present but window.L may not be ready yet
      const check = () => {
        if (window.L) resolve(window.L);
        else setTimeout(check, 50);
      };
      check();
    }
  });
};

onMounted(async () => {
  try {
    const L = await loadLeaflet();

    // initialize map centered on Batam
    map = L.map('map').setView([1.0833, 104.0333], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // add markers for stations with coordinates using dynamic colored icons
    stations.value.forEach(s => {
      if (s.lat && s.lng) {
        const color = getMarkerColor(s.chargers);
        const pinSvg = createPinSvg(color);
        const iconUrl = `data:image/svg+xml;charset=UTF-8,${pinSvg}`;

        const customIcon = L.icon({
          iconUrl,
          iconSize: [28, 42],
          iconAnchor: [14, 42],
          popupAnchor: [0, -38]
        });

        const marker = L.marker([s.lat, s.lng], { icon: customIcon }).addTo(map);
        marker.bindPopup(`<div class="font-medium">${s.name}</div><div class="text-sm text-gray-600">${s.coords}</div><div class="text-sm text-gray-500">Status: Aktif</div>`);
      }
    });
  } catch (err) {
    console.error('Failed to load Leaflet:', err);
  }
});

onBeforeUnmount(() => {
  if (map) {
    map.remove();
    map = null;
  }
});

// Helper function untuk memberikan kelas warna pada jenis charger
const getChargerClass = (type) => {
  switch (type) {
    case 'Fast':
      return 'bg-blue-100 text-blue-800';
    case 'Ultra Fast':
      return 'bg-purple-100 text-purple-800';
    case 'Regular':
      return 'bg-gray-100 text-gray-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
};

// Helper function untuk mendapatkan warna marker berdasarkan jenis charger tertinggi
const getMarkerColor = (chargers) => {
  if (chargers.includes('Ultra Fast')) return '#9333ea'; // purple-600
  if (chargers.includes('Fast')) return '#3b82f6'; // blue-500
  if (chargers.includes('Regular')) return '#6b7280'; // gray-500
  return '#00C853'; // default green
};

// Helper function untuk membuat SVG pin dengan warna dinamis
const createPinSvg = (color) => {
  return encodeURIComponent(`
    <svg width="32" height="48" viewBox="0 0 24 36" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 0C7 0 3.5 3.5 3.5 8.5 3.5 15.5 12 25.5 12 25.5s8.5-10 8.5-17C20.5 3.5 17 0 12 0z" fill="${color}"/>
      <circle cx="12" cy="8.5" r="3.5" fill="white"/>
    </svg>
  `);
};
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <AppNavbar />

    <main class="flex-grow py-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Panel -->
        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-900">Admin Panel - EV Charging Stations</h1>
          <p class="mt-1 text-md text-gray-600">Kelola stasiun pengisian EV dan pantau laporan pengisian</p>
        </div>

        <!-- Grid Kartu Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

          <!-- Card 1: Total Stasiun -->
          <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex justify-between items-start">
            <div>
              <p class="text-sm font-medium text-gray-500">Total Stasiun</p>
              <p class="text-3xl font-bold text-gray-900 mt-1">10</p>
              <p class="text-xs text-gray-400 mt-1">Stasiun terdaftar</p>
            </div>
            <div class="text-gray-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
          </div>

          <!-- Card 2: Stasiun Aktif -->
          <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex justify-between items-start">
            <div>
              <p class="text-sm font-medium text-gray-500">Stasiun Aktif</p>
              <p class="text-3xl font-bold text-gray-900 mt-1">3</p>
              <p class="text-xs text-gray-400 mt-1">Beroperasi normal</p>
            </div>
            <div class="text-gray-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
              </svg>
            </div>
          </div>

          <!-- Card 3: 24/7 Stations -->
          <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex justify-between items-start">
            <div>
              <p class="text-sm font-medium text-gray-500">24/7 Stations</p>
              <p class="text-3xl font-bold text-gray-900 mt-1">3</p>
              <p class="text-xs text-gray-400 mt-1">Buka 24 jam</p>
            </div>
            <div class="text-gray-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Peta Stasiun -->
        <div class="mt-8 bg-white p-6 rounded-xl shadow-lg border border-gray-100">
          <div class="flex flex-col sm:flex-row justify-between sm:items-center">
            <div>
              <h3 class="text-lg font-semibold text-gray-900">Peta Stasiun EV</h3>
              <p class="text-sm text-gray-500">10 Lokasi</p>
            </div>
            <!-- Legenda Peta -->
            <div class="flex items-center space-x-4 text-sm mt-3 sm:mt-0">
              <span class="font-medium text-gray-600">Jenis Charger:</span>
              <div class="flex items-center">
                <span class="h-3 w-3 rounded-full bg-gray-400 mr-1.5"></span>
                <span class="text-gray-600">Regular</span>
              </div>
              <div class="flex items-center">
                <span class="h-3 w-3 rounded-full bg-blue-500 mr-1.5"></span>
                <span class="text-gray-600">Fast</span>
              </div>
              <div class="flex items-center">
                <span class="h-3 w-3 rounded-full bg-purple-600 mr-1.5"></span>
                <span class="text-gray-600">Ultra Fast</span>
              </div>
            </div>
          </div>
          <!-- Placeholder Peta -->
          <div class="mt-4 bg-lime-50 rounded-lg h-80 flex items-center justify-center relative border border-lime-200" style="background-image: linear-gradient(rgba(0,0,0,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.02) 1px, transparent 1px); background-size: 20px 20px;">
            <div class="absolute inset-0">
              <div class="w-full h-full relative">
                <!-- Center label -->
                <div class="absolute left-1/2 top-4 transform -translate-x-1/2 text-center">
                  <h3 class="text-lg font-medium text-gray-800">Peta Sementara (Dummy)</h3>
                  <p class="text-sm text-gray-600">Markers are sample locations — interaksi akan dilakukan di implementasi nyata.</p>
                </div>

                <!-- Leaflet map will render here -->
                <div id="map" class="w-full h-full"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Daftar Stasiun -->
        <div class="mt-8 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
          <div class="p-6">
            <div class="flex flex-col sm:flex-row justify-between sm:items-start">
              <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Stasiun</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola semua stasiun pengisian EV yang terdaftar</p>
              </div>
              <div class="mt-4 sm:mt-0">
                <button type="button" class="inline-flex items-center bg-[#00C853] text-white font-semibold px-5 py-2.5 rounded-lg shadow-lg hover:bg-[#00A142] transition duration-300 focus:outline-none focus:ring-4 focus:ring-lime-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                  </svg>
                  Tambah Stasiun Baru
                </button>
              </div>
            </div>
          </div>

          <!-- Tabel Stasiun -->
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Stasiun</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Koordinat</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Charger</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Operasional</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="station in stations" :key="station.id" class="hover:bg-gray-50 transition-colors duration-150">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ station.name }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-700">{{ station.coords }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex space-x-2">
                      <span v-for="charger in station.chargers" :key="charger"
                            class="px-2.5 py-0.5 rounded-full text-xs font-medium"
                            :class="getChargerClass(charger)">
                        {{ charger }}
                      </span>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-700">{{ station.hours }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-3">
                      <button class="text-gray-400 hover:text-blue-600 transition duration-150" title="Lihat">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                          <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                      </button>
                      <button class="text-gray-400 hover:text-green-600 transition duration-150" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                      </button>
                      <button class="text-gray-400 hover:text-red-600 transition duration-150" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </main>

    <AppFooter />
  </div>
</template>
