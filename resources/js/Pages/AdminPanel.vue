<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import AppNavbar from '@/Components/AppNavbar.vue';
import AppFooter from '@/Components/AppFooter.vue';
import Modal from '@/Components/Modal.vue';

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
    city: 'Batam',
  },
  {
    id: 2,
    name: 'EV Station Nagoya',
    coords: '1.1200, 104.0500',
    chargers: ['Ultra Fast', 'Fast'],
    hours: '06:00-22:00',
    lat: 1.1200,
    lng: 104.0500,
    city: 'Batam',
  },
  {
    id: 3,
    name: 'EV Station Sekupang',
    coords: '1.1000, 103.9500',
    chargers: ['Regular'],
    hours: '08:00-20:00',
    lat: 1.1000,
    lng: 103.9500,
    city: 'Batam',
  },
  {
    id: 4,
    name: 'EV Station Tanjung Uncang',
    coords: '1.1300, 104.0600',
    chargers: ['Fast'],
    hours: '24/7',
    lat: 1.1300,
    lng: 104.0600,
    city: 'Batam',
  },
  {
    id: 5,
    name: 'EV Station Batu Aji',
    coords: '1.0500, 104.0200',
    chargers: ['Ultra Fast'],
    hours: '06:00-22:00',
    lat: 1.0500,
    lng: 104.0200,
    city: 'Batam',
  },
  {
    id: 6,
    name: 'EV Station Lubuk Baja',
    coords: '1.0900, 104.0400',
    chargers: ['Regular', 'Fast'],
    hours: '08:00-20:00',
    lat: 1.0900,
    lng: 104.0400,
    city: 'Batam',
  },
  {
    id: 7,
    name: 'EV Station Baloi',
    coords: '1.1100, 104.0300',
    chargers: ['Fast'],
    hours: '24/7',
    lat: 1.1100,
    lng: 104.0300,
    city: 'Batam',
  },
  {
    id: 8,
    name: 'EV Station Kabil',
    coords: '1.0700, 104.0100',
    chargers: ['Ultra Fast', 'Regular'],
    hours: '06:00-22:00',
    lat: 1.0700,
    lng: 104.0100,
    city: 'Batam',
  },
  {
    id: 9,
    name: 'EV Station Sagulung',
    coords: '1.1400, 104.0700',
    chargers: ['Regular'],
    hours: '08:00-20:00',
    lat: 1.1400,
    lng: 104.0700,
    city: 'Batam',
  },
  {
    id: 10,
    name: 'EV Station Nongsa',
    coords: '1.1600, 104.0800',
    chargers: ['Fast', 'Ultra Fast'],
    hours: '24/7',
    lat: 1.1600,
    lng: 104.0800,
    city: 'Batam',
  },
]);

// Dummy data for operator reports
const operatorReports = ref([
  {
    id: 1,
    stationName: 'EV Station Batam Centre',
    week: 'Minggu 1 (Januari)',
    totalSessions: 150,
    revenue: 'Rp 2,500,000',
    status: 'Dikirim',
  },
  {
    id: 2,
    stationName: 'EV Station Nagoya',
    week: 'Minggu 1 (Januari)',
    totalSessions: 120,
    revenue: 'Rp 1,800,000',
    status: 'Dikirim',
  },
  {
    id: 3,
    stationName: 'EV Station Sekupang',
    week: 'Minggu 1 (Januari)',
    totalSessions: 80,
    revenue: 'Rp 1,200,000',
    status: 'Pending',
  },
  {
    id: 4,
    stationName: 'EV Station Tanjung Uncang',
    week: 'Minggu 1 (Januari)',
    totalSessions: 95,
    revenue: 'Rp 1,500,000',
    status: 'Dikirim',
  },
  {
    id: 5,
    stationName: 'EV Station Batu Aji',
    week: 'Minggu 1 (Januari)',
    totalSessions: 110,
    revenue: 'Rp 1,700,000',
    status: 'Dikirim',
  },
  {
    id: 6,
    stationName: 'EV Station Lubuk Baja',
    week: 'Minggu 1 (Januari)',
    totalSessions: 90,
    revenue: 'Rp 1,350,000',
    status: 'Dikirim',
  },
  {
    id: 7,
    stationName: 'EV Station Baloi',
    week: 'Minggu 1 (Januari)',
    totalSessions: 75,
    revenue: 'Rp 1,125,000',
    status: 'Pending',
  },
  {
    id: 8,
    stationName: 'EV Station Kabil',
    week: 'Minggu 1 (Januari)',
    totalSessions: 85,
    revenue: 'Rp 1,275,000',
    status: 'Dikirim',
  },
  {
    id: 9,
    stationName: 'EV Station Sagulung',
    week: 'Minggu 1 (Januari)',
    totalSessions: 65,
    revenue: 'Rp 975,000',
    status: 'Dikirim',
  },
  {
    id: 10,
    stationName: 'EV Station Nongsa',
    week: 'Minggu 1 (Januari)',
    totalSessions: 100,
    revenue: 'Rp 1,500,000',
    status: 'Pending',
  },
  {
    id: 11,
    stationName: 'EV Station Batam Centre',
    week: 'Minggu 2 (Januari)',
    totalSessions: 160,
    revenue: 'Rp 2,400,000',
    status: 'Dikirim',
  },
  {
    id: 12,
    stationName: 'EV Station Nagoya',
    week: 'Minggu 2 (Januari)',
    totalSessions: 130,
    revenue: 'Rp 1,950,000',
    status: 'Dikirim',
  },
  {
    id: 13,
    stationName: 'EV Station Sekupang',
    week: 'Minggu 2 (Januari)',
    totalSessions: 85,
    revenue: 'Rp 1,275,000',
    status: 'Pending',
  },
  {
    id: 14,
    stationName: 'EV Station Tanjung Uncang',
    week: 'Minggu 2 (Januari)',
    totalSessions: 105,
    revenue: 'Rp 1,575,000',
    status: 'Dikirim',
  },
  {
    id: 15,
    stationName: 'EV Station Batu Aji',
    week: 'Minggu 2 (Januari)',
    totalSessions: 115,
    revenue: 'Rp 1,725,000',
    status: 'Dikirim',
  },
]);

// Dummy data for user reports
const userReports = ref([
  {
    id: 1,
    userName: 'Ahmad Rahman',
    email: 'ahmad.rahman@example.com',
    totalCharges: 25,
    lastDate: '2024-01-15',
    status: 'Aktif',
  },
  {
    id: 2,
    userName: 'Siti Nurhaliza',
    email: 'siti.nurhaliza@example.com',
    totalCharges: 18,
    lastDate: '2024-01-14',
    status: 'Aktif',
  },
  {
    id: 3,
    userName: 'Budi Santoso',
    email: 'budi.santoso@example.com',
    totalCharges: 32,
    lastDate: '2024-01-13',
    status: 'Aktif',
  },
  {
    id: 4,
    userName: 'Maya Sari',
    email: 'maya.sari@example.com',
    totalCharges: 15,
    lastDate: '2024-01-12',
    status: 'Tidak Aktif',
  },
  {
    id: 5,
    userName: 'Rizki Pratama',
    email: 'rizki.pratama@example.com',
    totalCharges: 28,
    lastDate: '2024-01-11',
    status: 'Aktif',
  },
  {
    id: 6,
    userName: 'Dewi Kartika',
    email: 'dewi.kartika@example.com',
    totalCharges: 22,
    lastDate: '2024-01-10',
    status: 'Aktif',
  },
  {
    id: 7,
    userName: 'Hendra Gunawan',
    email: 'hendra.gunawan@example.com',
    totalCharges: 19,
    lastDate: '2024-01-09',
    status: 'Aktif',
  },
  {
    id: 8,
    userName: 'Lina Sari',
    email: 'lina.sari@example.com',
    totalCharges: 35,
    lastDate: '2024-01-08',
    status: 'Aktif',
  },
  {
    id: 9,
    userName: 'Fajar Nugroho',
    email: 'fajar.nugroho@example.com',
    totalCharges: 12,
    lastDate: '2024-01-07',
    status: 'Tidak Aktif',
  },
  {
    id: 10,
    userName: 'Rina Amelia',
    email: 'rina.amelia@example.com',
    totalCharges: 27,
    lastDate: '2024-01-06',
    status: 'Aktif',
  },
  {
    id: 11,
    userName: 'Tono Widodo',
    email: 'tono.widodo@example.com',
    totalCharges: 30,
    lastDate: '2024-01-05',
    status: 'Aktif',
  },
  {
    id: 12,
    userName: 'Sari Indah',
    email: 'sari.indah@example.com',
    totalCharges: 16,
    lastDate: '2024-01-04',
    status: 'Aktif',
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

// Modal state
const showModal = ref(false);

// Form data for new station
const newStation = ref({
  name: '',
  chargerType: '',
  latitude: '',
  longitude: '',
  city: '',
  email: '',
});

// Function to open modal
const openAddStationModal = () => {
  showModal.value = true;
};

// Function to close modal
const closeModal = () => {
  showModal.value = false;
  // Reset form
  newStation.value = {
    name: '',
    chargerType: '',
    latitude: '',
    longitude: '',
    city: '',
    email: '',
  };
};

// Function to add new station (placeholder for now)
const addStation = () => {
  // Here you would typically send data to backend
  console.log('Adding new station:', newStation.value);
  // For now, just add to local array
  const id = stations.value.length + 1;
  const newStationData = {
    id,
    name: newStation.value.name,
    coords: `${newStation.value.latitude}, ${newStation.value.longitude}`,
    chargers: [newStation.value.chargerType],
    hours: '24/7', // Default
    lat: parseFloat(newStation.value.latitude),
    lng: parseFloat(newStation.value.longitude),
    city: newStation.value.city,
  };
  stations.value.push(newStationData);

  // Add marker to map if map is loaded
  if (map && newStationData.lat && newStationData.lng) {
    const color = getMarkerColor(newStationData.chargers);
    const pinSvg = createPinSvg(color);
    const iconUrl = `data:image/svg+xml;charset=UTF-8,${pinSvg}`;

    const customIcon = L.icon({
      iconUrl,
      iconSize: [28, 42],
      iconAnchor: [14, 42],
      popupAnchor: [0, -38]
    });

    const marker = L.marker([newStationData.lat, newStationData.lng], { icon: customIcon }).addTo(map);
    marker.bindPopup(`<div class="font-medium">${newStationData.name}</div><div class="text-sm text-gray-600">${newStationData.coords}</div><div class="text-sm text-gray-500">Status: Aktif</div>`);
  }

  closeModal();
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
          <div class="mt-4 bg-lime-50 rounded-lg h-80 flex items-center justify-center relative border-2 border-green-500" style="background-image: linear-gradient(rgba(0,0,0,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.02) 1px, transparent 1px); background-size: 20px 20px;">
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
                <button type="button" @click="openAddStationModal" class="inline-flex items-center bg-[#00C853] text-white font-semibold px-5 py-2.5 rounded-lg shadow-lg hover:bg-[#00A142] transition duration-300 focus:outline-none focus:ring-4 focus:ring-lime-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                  </svg>
                  Tambah Stasiun Baru
                </button>
              </div>
            </div>
          </div>

          <!-- Tabel Stasiun -->
          <div class="overflow-x-auto max-h-96 overflow-y-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50 sticky top-0">
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

        <!-- Laporan Operator Mingguan -->
        <div class="mt-8 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
          <div class="p-6">
            <div class="flex flex-col sm:flex-row justify-between sm:items-start">
              <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">Laporan Operator Mingguan</h3>
                <p class="text-sm text-gray-500 mt-1">Laporan mingguan dari operator stasiun pengisian</p>
              </div>
            </div>
          </div>

          <!-- Tabel Laporan Operator -->
          <div class="overflow-x-auto max-h-96 overflow-y-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50 sticky top-0">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Stasiun</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Minggu</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Sesi</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendapatan</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="report in operatorReports" :key="report.id" class="hover:bg-gray-50 transition-colors duration-150">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ report.stationName }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-700">{{ report.week }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-700">{{ report.totalSessions }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-700">{{ report.revenue }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium"
                          :class="report.status === 'Dikirim' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'">
                      {{ report.status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Laporan Pengguna -->
        <div class="mt-8 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
          <div class="p-6">
            <div class="flex flex-col sm:flex-row justify-between sm:items-start">
              <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">Laporan Pengguna</h3>
                <p class="text-sm text-gray-500 mt-1">Laporan aktivitas pengisian pengguna</p>
              </div>
            </div>
          </div>

          <!-- Tabel Laporan Pengguna -->
          <div class="overflow-x-auto max-h-96 overflow-y-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50 sticky top-0">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengguna</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pengisian</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Terakhir</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="report in userReports" :key="report.id" class="hover:bg-gray-50 transition-colors duration-150">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ report.userName }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-700">{{ report.email }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-700">{{ report.totalCharges }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-700">{{ report.lastDate }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium"
                          :class="report.status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                      {{ report.status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </main>

    <!-- Modal for adding new station -->
    <Modal :show="showModal" @close="closeModal">
      <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Stasiun Baru</h3>
        <form @submit.prevent="addStation" class="space-y-4">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Stasiun</label>
            <input
              v-model="newStation.name"
              type="text"
              id="name"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
              required
            />
          </div>
          <div>
            <label for="chargerType" class="block text-sm font-medium text-gray-700">Jenis Charger</label>
            <select
              v-model="newStation.chargerType"
              id="chargerType"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
              required
            >
              <option value="">Pilih Jenis Charger</option>
              <option value="Regular">Regular</option>
              <option value="Fast">Fast</option>
              <option value="Ultra Fast">Ultra Fast</option>
            </select>
          </div>
          <div>
            <label for="city" class="block text-sm font-medium text-gray-700">Kota</label>
            <input
              v-model="newStation.city"
              type="text"
              id="city"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
              required
            />
          </div>
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              v-model="newStation.email"
              type="email"
              id="email"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
              required
            />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
              <input
                v-model="newStation.latitude"
                type="number"
                step="0.0001"
                id="latitude"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
                required
              />
            </div>
            <div>
              <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
              <input
                v-model="newStation.longitude"
                type="number"
                step="0.0001"
                id="longitude"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-lime-500 focus:border-lime-500"
                required
              />
            </div>
          </div>
          <div class="flex justify-end space-x-3">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
              Batal
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-[#00C853] text-white rounded-md text-sm font-medium hover:bg-[#00A142]"
            >
              Tambah Stasiun
            </button>
          </div>
        </form>
      </div>
    </Modal>

    <AppFooter />
  </div>
</template>
