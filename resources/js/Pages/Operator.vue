  <script setup>
import { ref, computed, onMounted } from 'vue';
import AppFooter from '@/Components/AppFooter.vue';
import Modal from '@/Components/Modal.vue';

// Verification state
const verified = ref(false);
const showVerificationModal = ref(true);
const verificationCode = ref(['', '', '', '', '']);
const displayCode = ref(['', '', '', '', '']);
const verificationError = ref('');
const codeInputs = ref([]);

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

// Report period selection
const selectedPeriod = ref('weekly');

// Dummy data for operator reports (specific to this station)
const operatorReports = ref([
  {
    id: 1,
    period: 'Minggu 1 (Januari 2025)',
    totalSessions: 45,
    revenue: 'Rp 675,000',
    status: 'Dikirim',
    date: '2025-01-07',
  },
  {
    id: 2,
    period: 'Minggu 2 (Januari 2025)',
    totalSessions: 52,
    revenue: 'Rp 780,000',
    status: 'Dikirim',
    date: '2025-01-14',
  },
  {
    id: 3,
    period: 'Minggu 3 (Januari 2025)',
    totalSessions: 38,
    revenue: 'Rp 570,000',
    status: 'Pending',
    date: '2025-01-21',
  },
  {
    id: 4,
    period: 'Minggu 4 (Januari 2025)',
    totalSessions: 61,
    revenue: 'Rp 915,000',
    status: 'Dikirim',
    date: '2025-01-28',
  },
  {
    id: 5,
    period: 'Minggu 1 (Februari 2025)',
    totalSessions: 49,
    revenue: 'Rp 735,000',
    status: 'Dikirim',
    date: '2025-02-04',
  },
  {
    id: 6,
    period: 'Minggu 2 (Februari 2025)',
    totalSessions: 55,
    revenue: 'Rp 825,000',
    status: 'Dikirim',
    date: '2025-02-11',
  },
  {
    id: 7,
    period: 'Minggu 3 (Februari 2025)',
    totalSessions: 42,
    revenue: 'Rp 630,000',
    status: 'Pending',
    date: '2025-02-18',
  },
  {
    id: 8,
    period: 'Minggu 4 (Februari 2025)',
    totalSessions: 58,
    revenue: 'Rp 870,000',
    status: 'Dikirim',
    date: '2025-02-25',
  },
]);

// Monthly reports
const monthlyReports = ref([
  {
    id: 1,
    period: 'Januari 2025',
    totalSessions: 196,
    revenue: 'Rp 2,940,000',
    status: 'Dikirim',
    date: '2025-01-31',
  },
  {
    id: 2,
    period: 'Februari 2025',
    totalSessions: 204,
    revenue: 'Rp 3,060,000',
    status: 'Dikirim',
    date: '2025-02-29',
  },
  {
    id: 3,
    period: 'Maret 2025',
    totalSessions: 178,
    revenue: 'Rp 2,670,000',
    status: 'Pending',
    date: '2025-03-31',
  },
  {
    id: 4,
    period: 'April 2025',
    totalSessions: 220,
    revenue: 'Rp 3,300,000',
    status: 'Dikirim',
    date: '2025-04-30',
  },
  {
    id: 5,
    period: 'Mei 2025',
    totalSessions: 195,
    revenue: 'Rp 2,925,000',
    status: 'Dikirim',
    date: '2025-05-31',
  },
  {
    id: 6,
    period: 'Juni 2025',
    totalSessions: 210,
    revenue: 'Rp 3,150,000',
    status: 'Pending',
    date: '2025-06-30',
  },
]);

// Computed property to get current reports based on selected period
const currentReports = computed(() => {
  return selectedPeriod.value === 'weekly' ? operatorReports.value : monthlyReports.value;
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
  // For now, just log the action
  closeModal();
};

// Function to handle keydown and auto-focus next field
const handleKey = (index, event) => {
  const key = event.key;
  if (key.length === 1 && /^[0-9]$/.test(key)) {
    event.preventDefault();
    verificationCode.value[index] = key;
    // Generate random letter for display
    const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    displayCode.value[index] = letters[Math.floor(Math.random() * letters.length)];
    if (index < 4) {
      document.getElementById(`code-${index + 1}`).focus();
    }
  }
};

// Verification function
const verifyCode = () => {
  const code = verificationCode.value.join('');
  if (code === '12345') {
    verified.value = true;
    showVerificationModal.value = false;
    verificationError.value = '';
  } else {
    verificationError.value = 'Kode verifikasi salah. Coba lagi.';
    verificationCode.value = ['', '', '', '', ''];
    displayCode.value = ['', '', '', '', ''];
    document.getElementById('code-0').focus();
  }
};

// Mount hook to show verification modal
onMounted(() => {
  showVerificationModal.value = true;
});
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <!-- Verification Modal -->
    <div class="fixed inset-0 bg-[#B6F500] bg-opacity-90 flex items-center justify-center z-50" v-if="showVerificationModal">
      <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full mx-4 border border-[#00C853]">
        <h3 class="text-xl font-bold text-gray-900 mb-2 text-center">Verifikasi Akses</h3>
        <p class="text-sm text-gray-600 mb-6 text-center">Masukkan kode verifikasi untuk mengakses halaman Operator.</p>
        <form @submit.prevent="verifyCode" class="space-y-6">
          <div class="flex justify-center space-x-2">
            <div
              v-for="(letter, index) in displayCode"
              :key="index"
              class="relative w-12 h-12"
            >
              <div class="w-full h-full text-center text-xl font-bold border-2 border-gray-500 rounded-md bg-white text-gray-900 flex items-center justify-center">
                {{ verificationCode[index] ? '' : letter }}
              </div>
              <input
                :id="`code-${index}`"
                :value="displayCode[index]"
                type="text"
                maxlength="1"
                @keydown="handleKey(index, $event)"
                class="absolute inset-0 w-full h-full text-center text-xl font-bold bg-transparent border-none outline-none text-[#00C853]"
                required
              />
            </div>
          </div>
          <p v-if="verificationError" class="text-sm text-red-400 text-center">{{ verificationError }}</p>
          <div class="flex justify-center">
            <button
              type="submit"
              class="px-6 py-2 bg-[#00C853] text-white rounded-md text-sm font-medium hover:bg-[#00A142] transition-colors"
            >
              Verifikasi
            </button>
          </div>
        </form>
      </div>
    </div>

    <div v-if="verified">
    <main class="flex-grow py-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Panel -->
        <div class="mb-8">
          <div class="mb-4">
            <div class="text-4xl font-bold text-[#00C853]">
              E-<span class="text-gray-900">VOLT</span>
            </div>
          </div>
          <div class="mb-4">
            <p class="text-lg text-gray-700">Halo EV Station Batam Centre</p>
          </div>
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Operator Panel - EV Charging Stations</h1>
            <p class="mt-1 text-md text-gray-600">Kelola stasiun pengisian EV dan pantau laporan pengisian</p>
          </div>
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

        <!-- Reports Section -->
        <div class="mt-12">
          <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
              <h2 class="text-2xl font-bold text-gray-900">Laporan Pengisian</h2>
              <div class="flex space-x-2">
                <button
                  @click="selectedPeriod = 'weekly'"
                  :class="[
                    'px-4 py-2 rounded-md text-sm font-medium transition-colors',
                    selectedPeriod === 'weekly'
                      ? 'bg-[#00C853] text-white'
                      : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                  ]"
                >
                  Mingguan
                </button>
                <button
                  @click="selectedPeriod = 'monthly'"
                  :class="[
                    'px-4 py-2 rounded-md text-sm font-medium transition-colors',
                    selectedPeriod === 'monthly'
                      ? 'bg-[#00C853] text-white'
                      : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                  ]"
                >
                  Bulanan
                </button>
              </div>
            </div>

            <div class="overflow-auto max-h-96">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0 z-10">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Periode
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Total Sesi
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Pendapatan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Tanggal
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="report in currentReports" :key="report.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                      {{ report.period }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      {{ report.totalSessions }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      {{ report.revenue }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        :class="[
                          'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                          report.status === 'Dikirim'
                            ? 'bg-green-100 text-green-800'
                            : 'bg-yellow-100 text-yellow-800'
                        ]"
                      >
                        {{ report.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      {{ report.date }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
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
  </div>
</template>
