<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import AppNavbar from '@/Components/AppNavbar.vue';
import AppFooter from '@/Components/AppFooter.vue';

// Reactive state for the form
const formState = ref({
  brand: '',
  type: '',
  date: '',
  domicile: '',
  station: '',
  time: '',
});

// --- START: Custom dropdown data & helpers (added) ---
const brandOptions = ['Hyundai', 'Wuling', 'Tesla', 'BYD', 'Kia'];
const typeOptions = ['SUV', 'City Car', 'Hatchback', 'Sedan', 'MPV'];
const domicileOptions = [
  'Batam Center', 'Nagoya', 'Harbour Bay', 'Sekupang', 'Batu Aji',
  'Lubuk Baja', 'Tiban', 'Kabil', 'Batu Ampar', 'Galang', 'Bulang'
];
const stationOptions = [
  'SPKLU Mega Mall','SPKLU Grand Batam Mall','SPKLU Nagoya Hill','SPKLU Harbour Bay',
  'SPKLU Batam Center','SPKLU Batam City Square','SPKLU Kepri Mall','SPKLU Batam View','SPKLU Nagoya City'
];

const isBrandOpen = ref(false);
const isTypeOpen = ref(false);
const isDomicileOpen = ref(false);
const isStationOpen = ref(false);

const closeAllCustomDropdowns = () => {
  isBrandOpen.value = false;
  isTypeOpen.value = false;
  isDomicileOpen.value = false;
  isStationOpen.value = false;
};

const openOnly = (which) => {
  // Toggle the requested dropdown; close the others
  if (which === 'brand') {
    isBrandOpen.value = !isBrandOpen.value;
    isTypeOpen.value = false;
    isDomicileOpen.value = false;
    isStationOpen.value = false;
  } else if (which === 'type') {
    isTypeOpen.value = !isTypeOpen.value;
    isBrandOpen.value = false;
    isDomicileOpen.value = false;
    isStationOpen.value = false;
  } else if (which === 'domicile') {
    isDomicileOpen.value = !isDomicileOpen.value;
    isBrandOpen.value = false;
    isTypeOpen.value = false;
    isStationOpen.value = false;
  } else if (which === 'station') {
    isStationOpen.value = !isStationOpen.value;
    isBrandOpen.value = false;
    isTypeOpen.value = false;
    isDomicileOpen.value = false;
  }

  // keep date/time closed when toggling custom dropdowns
  isDateDropdownOpen.value = false;
  isTimeDropdownOpen.value = false;
};

const selectOption = (field, value) => {
  formState.value[field] = value;
  closeAllCustomDropdowns();
};
// --- END: Custom dropdown data & helpers ---

// --- DATE & TIME PICKER LOGIC ---
const today = new Date();
today.setHours(0, 0, 0, 0);

const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
const dayNames = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];

// DATE STATE
const isDateDropdownOpen = ref(false);
const selectedDate = ref(new Date(today)); // Tanggal yang dipilih
const calendarDisplayDate = ref(new Date(today)); // Bulan/Tahun yang ditampilkan di kalender

// TIME STATE
const isTimeDropdownOpen = ref(false);
const selectedTime = ref(''); // Jam yang dipilih (e.g., "10:30")

// Format tanggal untuk tampilan
const formatDate = (date) => `${date.getDate()} ${monthNames[date.getMonth()]} ${date.getFullYear()}`;

// Teks yang ditampilkan di input tanggal
const datePickerText = computed(() => {
    return selectedDate.value ? formatDate(selectedDate.value) : 'Pilih Tanggal';
});

// GENERATE CALENDAR GRID (Logic remains the same)
const calendarDays = computed(() => {
    const year = calendarDisplayDate.value.getFullYear();
    const month = calendarDisplayDate.value.getMonth();
    const firstDayIndex = new Date(year, month, 1).getDay(); 
    const lastDate = new Date(year, month + 1, 0).getDate();
    
    let days = [];
    
    for(let i = 0; i < firstDayIndex; i++) {
        days.push({ number: null, classes: 'text-gray-300' });
    }

    for (let i = 1; i <= lastDate; i++) {
        const currentDate = new Date(year, month, i);
        const isSelected = selectedDate.value && currentDate.toDateString() === selectedDate.value.toDateString();
        const isDisabled = currentDate < today;
        
        let classes = 'day-number w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition duration-100';
        if (isDisabled) {
            classes += ' text-gray-400 cursor-not-allowed';
        } else if (isSelected) {
            classes += ' bg-lime-600 text-white shadow-md';
        } else {
            classes += ' text-gray-800 hover:bg-lime-100 cursor-pointer';
        }
        
        days.push({ number: i, date: currentDate, classes, isDisabled });
    }
    return days;
});

// NAVIGATION LOGIC (Logic remains the same)
const prevMonth = () => {
    const newDate = new Date(calendarDisplayDate.value);
    newDate.setMonth(newDate.getMonth() - 1);
    calendarDisplayDate.value = newDate;
};

const nextMonth = () => {
    const newDate = new Date(calendarDisplayDate.value);
    newDate.setMonth(newDate.getMonth() + 1);
    calendarDisplayDate.value = newDate;
};

const selectDay = (day) => {
    if (!day.isDisabled) {
        selectedDate.value = day.date;
        formState.value.date = day.date.toISOString().split('T')[0];
        selectedTime.value = ''; 
        formState.value.time = ''; 
        isDateDropdownOpen.value = false;
    }
};

// GENERATE TIME SLOTS (Logic remains the same)
const timeSlots = computed(() => {
    const slots = [];
    const now = new Date();
    const isToday = selectedDate.value.toDateString() === new Date(now).toDateString();
    
    for(let h = 0; h < 24; h++) {
        for(let m = 0; m < 60; m += 30) {
            const timeString = `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
            let isDisabled = false;

            if (isToday) {
                if (h < now.getHours() || (h === now.getHours() && m < now.getMinutes())) {
                    isDisabled = true;
                }
            }
            
            slots.push({ time: timeString, isDisabled });
        }
    }
    return slots;
});

const selectTime = (slot) => {
    if (!slot.isDisabled) {
        selectedTime.value = slot.time;
        formState.value.time = slot.time;
        isTimeDropdownOpen.value = false;
    }
};

// --- MODAL LOGIC ---
const openModal = () => {
    document.getElementById('search-modal').classList.remove('hidden');
};

const closeModal = () => {
    document.getElementById('search-modal').classList.add('hidden');
};

const searchStations = () => {
  console.log('Mencari stasiun dengan data:', formState.value);
  openModal(); 
};

// --- GLOBAL EVENT LISTENER FIX (PENTING UNTUK MOBILE) ---
// Membuat fungsi lebih spesifik agar klik di dalam kalender tidak menutup dropdown
const closePickersOnOutsideClick = (event) => {
    // Menutup Date Picker
    if (isDateDropdownOpen.value && !event.target.closest('#date-picker-trigger') && !event.target.closest('.date-picker-content')) {
        isDateDropdownOpen.value = false;
    }
    // Menutup Time Picker
    if (isTimeDropdownOpen.value && !event.target.closest('#time-picker-trigger') && !event.target.closest('.time-picker-content')) {
        isTimeDropdownOpen.value = false;
    }

    // close custom dropdowns when clicking outside
    if (isBrandOpen.value && !event.target.closest('#brand-trigger') && !event.target.closest('.brand-dropdown-content')) {
        isBrandOpen.value = false;
    }
    if (isTypeOpen.value && !event.target.closest('#type-trigger') && !event.target.closest('.type-dropdown-content')) {
        isTypeOpen.value = false;
    }
    if (isDomicileOpen.value && !event.target.closest('#domicile-trigger') && !event.target.closest('.domicile-dropdown-content')) {
        isDomicileOpen.value = false;
    }
    if (isStationOpen.value && !event.target.closest('#station-trigger') && !event.target.closest('.station-dropdown-content')) {
        isStationOpen.value = false;
    }
};

onMounted(() => {
    // Ganti window listener menjadi document.body listener untuk stabilitas
    document.body.addEventListener('click', closePickersOnOutsideClick);
    
    // Set nilai tanggal awal di form state
    formState.value.date = selectedDate.value.toISOString().split('T')[0];
});

onBeforeUnmount(() => {
    // Bersihkan listener saat komponen akan dihancurkan
    document.body.removeEventListener('click', closePickersOnOutsideClick);
});
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <AppNavbar />

    <main class="flex-grow relative z-0"> 
      
      <section class="bg-[#B6F500] pt-16 pb-64 relative overflow-visible">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          <div class="flex flex-col lg:flex-row items-center justify-between">
            
            <div class="lg:w-1/2 mb-12 lg:mb-0 lg:pr-10">
              <h2 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-[#333] leading-tight mb-4">
                Menghubungkan <span class="text-[#398300]">pengendara</span> Dengan Stasiun Pengecasan Cerdas
              </h2>
              <p class="text-xl text-gray-800 mb-8">
                Temukan, reservasi, dan isi daya dengan mudah di mana saja.
              </p>
              
              <div class="flex space-x-4">
                <button @click="searchStations" 
                        class="bg-[#00C853] text-white font-medium px-8 py-3 rounded-lg shadow-lg hover:bg-[#00A142] transition duration-300 focus:outline-none focus:ring-4 focus:ring-lime-300">
                  Mulai Sekarang
                </button>
                
                <button class="bg-white border-2 border-[#00C853] text-[#00C853] font-medium px-6 py-3 rounded-lg hover:bg-gray-100  transition duration-300 focus:outline-none focus:ring-4 focus:ring-lime-300">
                  Pelajari Lebih Lanjut
                </button>
              </div>
            </div>

            <div class="lg:w-1/2 flex justify-center lg:justify-end">
              <img 
                src="images/mobil.png" 
                alt="Placeholder Mobil EV" 
                class="w-full max-w-xs sm:max-w-sm lg:max-w-full"
              >
            </div>
          </div>
        </div>

        <div class="absolute left-1/2 bottom-0 transform -translate-x-1/2 translate-y-1/2 w-full max-w-6xl px-4 sm:px-6 lg:px-8 z-20">
          <form @submit.prevent="searchStations" class="bg-white p-6 md:p-8 rounded-2xl shadow-2xl border border-gray-100">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">Cari EV Charge Station</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              
              <!-- BRAND: custom dropdown (replaces select) -->
              <div class="relative">
                <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Merk Mobil</label>
                <div id="brand-trigger"
                     @click.stop="openOnly('brand')"
                     class="w-full p-3 border border-gray-300 rounded-xl cursor-pointer flex justify-between items-center bg-white transition duration-150"
                     :class="{'ring-2 ring-lime-500 border-lime-500 shadow-md': isBrandOpen}"
                >
                  <span class="text-gray-800">{{ formState.brand || 'Pilih Merk Mobil' }}</span>
                  <svg class="w-5 h-5 text-gray-500 transform" :class="{'rotate-180': isBrandOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <div v-if="isBrandOpen" @click.stop class="brand-dropdown-content absolute top-full mt-2 w-full bg-white rounded-xl shadow-2xl border border-gray-100 z-30 left-0 max-h-48 overflow-y-auto">
                  <div class="py-2">
                    <div v-for="opt in brandOptions" :key="opt"
                         @click="selectOption('brand', opt)"
                         class="px-4 py-2 hover:bg-lime-50 cursor-pointer transition-colors duration-150"
                         :class="{'bg-lime-50 font-semibold text-lime-800': formState.brand === opt}">
                      {{ opt }}
                    </div>
                  </div>
                </div>
              </div>

              <!-- TYPE: custom dropdown (replaces select) -->
              <div class="relative">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Mobil</label>
                <div id="type-trigger"
                     @click.stop="openOnly('type')"
                     class="w-full p-3 border border-gray-300 rounded-xl cursor-pointer flex justify-between items-center bg-white transition duration-150"
                     :class="{'ring-2 ring-lime-500 border-lime-500 shadow-md': isTypeOpen}"
                >
                  <span class="text-gray-800">{{ formState.type || 'Pilih Tipe Mobil' }}</span>
                  <svg class="w-5 h-5 text-gray-500 transform" :class="{'rotate-180': isTypeOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <div v-if="isTypeOpen" @click.stop class="type-dropdown-content absolute top-full mt-2 w-full bg-white rounded-xl shadow-2xl border border-gray-100 z-30 left-0 max-h-48 overflow-y-auto">
                  <div class="py-2">
                    <div v-for="opt in typeOptions" :key="opt"
                         @click="selectOption('type', opt)"
                         class="px-4 py-2 hover:bg-lime-50 cursor-pointer transition-colors duration-150"
                         :class="{'bg-lime-50 font-semibold text-lime-800': formState.type === opt}">
                      {{ opt }}
                    </div>
                  </div>
                </div>
              </div>

              <!-- DATE picker (leave unchanged) -->
              <div class="relative">
                <label for="date-picker-trigger" class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                <div 
                  id="date-picker-trigger"
                  @click.stop="isDateDropdownOpen = !isDateDropdownOpen; isTimeDropdownOpen = false"
                  class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lime-500 focus:border-lime-500 cursor-pointer flex justify-between items-center bg-white transition duration-150"
                  :class="{'ring-2 ring-lime-500 border-lime-500 shadow-md': isDateDropdownOpen}"
                >
                  <span class="text-gray-800">{{ datePickerText }}</span>
                  <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                </div>

                <div v-if="isDateDropdownOpen" @click.stop 
                     class="date-picker-content absolute top-full mt-2 w-full sm:w-72 p-4 bg-white rounded-xl shadow-2xl border border-gray-100 z-30 left-0 sm:right-0 sm:transform sm:-translate-x-1/4">
                  <div class="flex justify-between items-center mb-4">
                    <button type="button" @click="prevMonth" class="p-2 rounded-full hover:bg-gray-100">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <span class="font-semibold text-gray-900">{{ monthNames[calendarDisplayDate.getMonth()] }} {{ calendarDisplayDate.getFullYear() }}</span>
                    <button type="button" @click="nextMonth" class="p-2 rounded-full hover:bg-gray-100">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                  </div>
                  
                  <div class="grid grid-cols-7 text-center gap-1">
                    <div v-for="day in dayNames" :key="day" class="text-xs font-semibold text-gray-500">{{ day }}</div>
                    <div v-for="(day, index) in calendarDays" :key="index" :class="day.classes" @click="selectDay(day)">
                      {{ day.number }}
                    </div>
                  </div>
                </div>
              </div>

              <!-- DOMICILE: custom dropdown (replaces select) -->
              <div class="relative">
                <label for="domicile" class="block text-sm font-medium text-gray-700 mb-2">Domisili</label>
                <div id="domicile-trigger"
                     @click.stop="openOnly('domicile')"
                     class="w-full p-3 border border-gray-300 rounded-xl cursor-pointer flex justify-between items-center bg-white transition duration-150"
                     :class="{'ring-2 ring-lime-500 border-lime-500 shadow-md': isDomicileOpen}"
                >
                  <span class="text-gray-800">{{ formState.domicile || 'Pilih Domisili' }}</span>
                  <svg class="w-5 h-5 text-gray-500 transform" :class="{'rotate-180': isDomicileOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <div v-if="isDomicileOpen" @click.stop class="domicile-dropdown-content absolute top-full mt-2 w-full bg-white rounded-xl shadow-2xl border border-gray-100 z-30 left-0 max-h-48 overflow-y-auto">
                  <div class="py-2">
                    <div v-for="opt in domicileOptions" :key="opt"
                         @click="selectOption('domicile', opt)"
                         class="px-4 py-2 hover:bg-lime-50 cursor-pointer transition-colors duration-150"
                         :class="{'bg-lime-50 font-semibold text-lime-800': formState.domicile === opt}">
                      {{ opt }}
                    </div>
                  </div>
                </div>
              </div>

              <!-- STATION: custom dropdown (replaces select) -->
              <div class="relative">
                <label for="station" class="block text-sm font-medium text-gray-700 mb-2">Stasiun Charger</label>
                <div id="station-trigger"
                     @click.stop="openOnly('station')"
                     class="w-full p-3 border border-gray-300 rounded-xl cursor-pointer flex justify-between items-center bg-white transition duration-150"
                     :class="{'ring-2 ring-lime-500 border-lime-500 shadow-md': isStationOpen}"
                >
                  <span class="text-gray-800">{{ formState.station || 'Pilih Stasiun' }}</span>
                  <svg class="w-5 h-5 text-gray-500 transform" :class="{'rotate-180': isStationOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <div v-if="isStationOpen" @click.stop class="station-dropdown-content absolute top-full mt-2 w-full bg-white rounded-xl shadow-2xl border border-gray-100 z-30 left-0 max-h-48 overflow-y-auto">
                  <div class="py-2">
                    <div v-for="opt in stationOptions" :key="opt"
                         @click="selectOption('station', opt)"
                         class="px-4 py-2 hover:bg-lime-50 cursor-pointer transition-colors duration-150"
                         :class="{'bg-lime-50 font-semibold text-lime-800': formState.station === opt}">
                      {{ opt }}
                    </div>
                  </div>
                </div>
              </div>

              <!-- TIME picker (leave unchanged) -->
              <div class="relative">
                <label for="time-picker-trigger" class="block text-sm font-medium text-gray-700 mb-2">Jam</label>
                <div 
                  id="time-picker-trigger"
                  @click.stop="isTimeDropdownOpen = !isTimeDropdownOpen; isDateDropdownOpen = false"
                  class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lime-500 focus:border-lime-500 cursor-pointer flex justify-between items-center bg-white transition duration-150"
                  :class="{'ring-2 ring-lime-500 border-lime-500 shadow-md': isTimeDropdownOpen}"
                >
                  <span class="text-gray-800">{{ selectedTime || 'Pilih Jam' }}</span>
                  <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l3 3a1 1 0 001.414-1.414L10 10.586V6z" clip-rule="evenodd"></path></svg>
                </div>

                <div v-if="isTimeDropdownOpen" @click.stop
                     class="time-picker-content absolute top-full mt-2 w-full max-h-48 overflow-y-auto bg-white rounded-xl shadow-2xl border border-gray-100 z-30 left-0">
                  <div v-for="slot in timeSlots" :key="slot.time"
                       :class="{
                         'p-2 hover:bg-lime-100 cursor-pointer transition duration-100': !slot.isDisabled,
                         'text-gray-400 cursor-not-allowed bg-gray-50': slot.isDisabled,
                         'bg-lime-50 text-lime-800 font-semibold': slot.time === selectedTime
                       }"
                       @click="selectTime(slot)">
                    {{ slot.time }}
                  </div>
                </div>
              </div>
            </div>
            
            <div class="text-end mt-6">
                <a href="/map-results" class="inline-block bg-[#00C853] text-white font-semibold px-8 py-3 rounded-lg shadow-lg hover:bg-[#00A142] transition duration-300 focus:outline-none focus:ring-4 focus:ring-lime-300">
                 Cari Jadwal
                </a>
            </div>
          </form>
        </div>
      </section>
      


      <!-- Step -->
      <section class="pt-56 pb-24 bg-gray-50 md:mt-[-8rem]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col lg:flex-row items-center gap-12">
            <div class="lg:w-1/2">
              <span class="text-sm font-semibold text-lime-600 uppercase tracking-widest block mb-2">Langkah 1</span>
              <h2 class="text-3xl font-semibold text-gray-900 mb-4">
                Pencarian Stasiun <span class="text-lime-600">Terdekat</span>
              </h2>
              <p class="text-gray-600 leading-relaxed text-lg">
                **Lorem ipsum** is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.
              </p>
            </div>
            <div class="lg:w-1/2 flex justify-center relative mt-12">
              <img src="https://placehold.co/400x500/f0f9ff/000?text=App+Screenshot" alt="Mobile App" class="w-full max-w-sm rounded-3xl shadow-2xl rotate-3" loading="lazy">
              <div class="absolute inset-0 bg-indigo-50 opacity-40 rounded-full filter blur-3xl z-0 -rotate-12"></div>
            </div>
          </div>
        </div>
      </section>

      <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col lg:flex-row-reverse items-center gap-12">
            <div class="lg:w-1/2">
              <span class="text-sm font-semibold text-lime-600 uppercase tracking-widest block mb-2">Langkah 2</span>
              <h2 class="text-3xl font-semibold text-gray-900 mb-4">
                Reservasi Slot <span class="text-lime-600">Real-Time</span>
              </h2>
              <p class="text-gray-600 leading-relaxed text-lg">
                **Lorem ipsum** is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.
              </p>
            </div>
            <div class="lg:w-1/2 flex justify-center relative">
              <img src="https://placehold.co/500x350/ffffff/333?text=Stacked+UI+Cards" alt="Stacked Cards UI" class="w-full max-w-md rounded-2xl shadow-xl transform -rotate-3" loading="lazy">
            </div>
          </div>
        </div>
      </section>

      <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col lg:flex-row items-center gap-12">
            <div class="lg:w-1/2">
              <span class="text-sm font-semibold text-lime-600 uppercase tracking-widest block mb-2">Langkah 3</span>
              <h2 class="text-3xl font-semibold text-gray-900 mb-4">
                Integrasi <span class="text-lime-600">Teknologi</span> Terbaru
              </h2>
              <p class="text-gray-600 leading-relaxed text-lg">
                **Lorem ipsum** is simply dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It is a long established fact that a reader will be distracted.
              </p>
            </div>
            <div class="lg:w-1/2 flex justify-center relative">
              <img src="https://placehold.co/500x350/a7f3d0/000?text=VR+Experience" alt="VR User" class="w-full max-w-lg rounded-2xl shadow-xl transform scale-105" loading="lazy">
            </div>
          </div>
        </div>
      </section>

      <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
              <h3 class="text-2xl font-semibold text-gray-900 mb-4">
                "Pengalaman Pengecasan Terbaik"
              </h3>
              <p class="text-gray-600 mb-6">
                Ini adalah kutipan testimonial dari pengguna kami. Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
              </p>
               <button class="bg-[#00C853] text-white font-semibold px-6 py-3 rounded-lg shadow-xl hover:bg-[#00A142] transition duration-300 focus:outline-none focus:ring-4 focus:ring-lime-300">
                  Lihat Testimoni
                </button>
            </div>
            <div class="bg-[#00C853] p-8 rounded-2xl shadow-lg text-white relative overflow-hidden">
                <h3 class="text-2xl font-semibold mb-4">
                Siap Bergabung?
              </h3>
              <p class="mb-6 text-lime-100">
                Daftar sekarang dan nikmati kemudahan menemukan stasiun pengisian daya di seluruh Indonesia.
              </p>
              <button class="bg-[#212121] text-white font-semibold px-6 py-3 rounded-lg shadow-xl hover:bg-[#2a2a2a] transition duration-300 focus:outline-none focus:ring-4 focus:ring-white">
                Daftar Gratis
              </button>
            </div>
          </div>
        </div>
      </section>

      <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h3 class="text-xl font-medium text-gray-500 mb-10">
            Dipercaya oleh banyak perusahaan hebat
          </h3>
          <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 grayscale opacity-60">
            <img src="https://cdn.worldvectorlogo.com/logos/tesla-9.svg" alt="Tesla Logo" class="h-10 transition duration-300 hover:grayscale-0 hover:opacity-100">
            <img src="https://upload.wikimedia.org/wikipedia/commons/e/e2/BYD_Auto_2022_logo.svg" alt="BYD Logo" class="h-10 transition duration-300 hover:grayscale-0 hover:opacity-100">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Hyundai_Motor_Company_logo.svg" alt="Hyundai Logo" class="h-10 transition duration-300 hover:grayscale-0 hover:opacity-100">
            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b6/KIA_logo3.svg" alt="Kia Logo" class="h-10 transition duration-300 hover:grayscale-0 hover:opacity-100">
            <img src="https://upload.wikimedia.org/wikipedia/commons/1/16/Wuling-logo.svg" alt="Wuling Logo" class="h-10 transition duration-300 hover:grayscale-0 hover:opacity-100">
          </div>
        </div>
      </section>
      
      <div id="search-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex justify-center items-center" @click.self="closeModal">
          <div class="bg-white p-6 rounded-xl shadow-2xl max-w-sm w-full m-4">
              <h4 class="text-xl font-bold text-gray-900 mb-4">Pencarian Diproses (Simulasi)</h4>
              <p class="text-gray-700 mb-6">
                  Stasiun pengisian daya sedang dicari berdasarkan data: <br>
                  <strong class="text-lime-600">Merk:</strong> {{ formState.brand || 'Tidak Dipilih' }}
                  <br>
                  <strong class="text-lime-600">Tanggal:</strong> {{ formState.date || 'Tidak Dipilih' }}
                  <br>
                  <strong class="text-lime-600">Jam:</strong> {{ formState.time || 'Tidak Dipilih' }}
              </p>
              <button @click="closeModal" class="w-full bg-lime-600 text-white font-semibold py-2 rounded-lg hover:bg-lime-700 transition duration-300 focus:outline-none focus:ring-4 focus:ring-lime-300">
                  Tutup
              </button>
          </div>
      </div>

    </main>

    <AppFooter />
  </div>
</template>