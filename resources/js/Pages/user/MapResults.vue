<script setup>
import { ref, computed, onMounted, onBeforeUnmount, watch } from 'vue';

import Navbar from '@/Components/NavbarUser.vue';
import Footer from '@/Components/Footer.vue';

// -----------------------------------------------------------------------------------

const showSearchModal = ref(false);
const showConfirmationModal = ref(false);
const showQrisPaymentModal = ref(false); 
const showReceiptModal = ref(false);    
const showPrintModal = ref(false);     
const selectedStation = ref(null);
const hasStartedBooking = ref(false); 

// --- LOGIC DRAG-TO-DISMISS (SWIPE DOWN) ---
const dragOffset = ref(0);
const isDragging = ref(false);
let startY = 0;

// Mulai sentuh pada Handle Bar
const onTouchStart = (e) => {
    isDragging.value = true;
    startY = e.touches[0].clientY;
};

// Saat jari bergerak
const onTouchMove = (e) => {
    if (!isDragging.value) return;
    const currentY = e.touches[0].clientY;
    const diff = currentY - startY;
    
    // Hanya izinkan drag ke bawah (diff positif)
    if (diff > 0) {
        dragOffset.value = diff;
    }
};

// Saat jari dilepas
const onTouchEnd = () => {
    isDragging.value = false;
    // Jika ditarik lebih dari 100px, tutup modal yang sedang aktif
    if (dragOffset.value > 100) {
        if (showSearchModal.value) {
            closeModal();
        } else {
            cancelProcess(); // Tutup modal konfirmasi
        }
    } else {
        // Jika kurang, kembalikan ke posisi semula (snap back)
        dragOffset.value = 0;
    }
};
// ------------------------------------------

const selectedPort = ref('');
const selectedDuration = ref('60'); 
const durationOptions = [
    { label: '30 menit', value: '30', multiplier: 0.5 },
    { label: '1 jam', value: '60', multiplier: 1 },
    { label: '1.5 jam', value: '90', multiplier: 1.5 },
    { label: '2 jam', value: '120', multiplier: 2 }
];

const portOptions = computed(() => {
    return availablePorts.value.map(port => ({
        label: `Port ${port.id.split('-')[1]} - ${port.type} (${port.power})`,
        value: port.id
    }));
});

const availablePorts = computed(() => {
    if (!selectedStation.value) return [];
    return selectedStation.value.chargers.map((charger, index) => ({
        id: `port-${index + 1}`,
        type: charger,
        power: selectedStation.value.power,
        status: selectedStation.value.status
    }));
});

const anyModalOpen = computed(() => showSearchModal.value || showConfirmationModal.value || showQrisPaymentModal.value || showReceiptModal.value);

const formState = ref({
    brand: '',
    type: '',
    date: new Date().toISOString().split('T')[0],
    domicile: '',
    station: '',
    time: '12:00',
});

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
const isPortOpen = ref(false);
const isDurationOpen = ref(false);

const closeAllCustomDropdowns = () => {
    isBrandOpen.value = false;
    isTypeOpen.value = false;
    isDomicileOpen.value = false;
    isStationOpen.value = false;
    isPortOpen.value = false;
    isDurationOpen.value = false;
};

const openOnly = (which) => {
    if (which === 'brand') {
        isBrandOpen.value = !isBrandOpen.value;
        isTypeOpen.value = false; isDomicileOpen.value = false; isStationOpen.value = false; isPortOpen.value = false; isDurationOpen.value = false;
    } else if (which === 'type') {
        isTypeOpen.value = !isTypeOpen.value;
        isBrandOpen.value = false; isDomicileOpen.value = false; isStationOpen.value = false; isPortOpen.value = false; isDurationOpen.value = false;
    } else if (which === 'domicile') {
        isDomicileOpen.value = !isDomicileOpen.value;
        isBrandOpen.value = false; isTypeOpen.value = false; isStationOpen.value = false; isPortOpen.value = false; isDurationOpen.value = false;
    } else if (which === 'station') {
        isStationOpen.value = !isStationOpen.value;
        isBrandOpen.value = false; isTypeOpen.value = false; isDomicileOpen.value = false; isPortOpen.value = false; isDurationOpen.value = false;
    } else if (which === 'port') {
        isPortOpen.value = !isPortOpen.value;
        isBrandOpen.value = false; isTypeOpen.value = false; isDomicileOpen.value = false; isStationOpen.value = false; isDurationOpen.value = false;
    } else if (which === 'duration') {
        isDurationOpen.value = !isDurationOpen.value;
        isBrandOpen.value = false; isTypeOpen.value = false; isDomicileOpen.value = false; isStationOpen.value = false; isPortOpen.value = false;
    }
    isDateDropdownOpen.value = false;
    isTimeDropdownOpen.value = false;
};

const selectOption = (field, value) => {
    if (field === 'port') {
        selectedPort.value = value;
    } else if (field === 'duration') {
        selectedDuration.value = value;
    } else {
        formState.value[field] = value;
    }
    closeAllCustomDropdowns();
};

const openModal = () => {
    showSearchModal.value = true;
};

const closeModal = () => {
    showSearchModal.value = false;
    // Reset Drag state saat tutup
    dragOffset.value = 0;
    isDragging.value = false;
};

const submitSearch = () => {
    console.log('Searching with:', formState.value);
    closeModal();
};

const stations = ref([
    { id: 1, name: 'SPKLU Nagoya Hill', location: 'Nagoya Hill, Batam', distance: '2.5km', chargers: ['Fast'], power: '80 kW', status: 'Tersedia', bookingTime: '2025-10-22 12:00', duration: '60 menit', price: 50000, serviceFee: 10000, isBookable: true, bookingNumber: 'BK1001', lat: 1.1324, lng: 104.0383 },
    { id: 2, name: 'SPKLU Mega Mall Batam', location: 'Mega Mall, Batam Center', distance: '1.2km', chargers: ['Regular'], power: '22 kW', status: 'Tersedia', bookingTime: '2025-10-22 12:30', duration: '60 menit', price: 40000, serviceFee: 8000, isBookable: true, bookingNumber: 'BK1002', lat: 1.1225, lng: 104.0417 },
    { id: 3, name: 'SPKLU Harbour Bay', location: 'Harbour Bay, Batam', distance: '3.8km', chargers: ['Fast', 'Ultra Fast'], power: '100 kW', status: 'Penuh', bookingTime: '2025-10-22 14:00', duration: '30 menit', price: 120000, serviceFee: 15000, isBookable: false, bookingNumber: 'BK1003', lat: 1.1145, lng: 104.0522 },
    { id: 4, name: 'SPKLU Batam Center', location: 'Batam Center', distance: '0.5km', chargers: ['Regular'], power: '50 kW', status: 'Tersedia', bookingTime: '2025-10-22 10:00', duration: '90 menit', price: 60000, serviceFee: 12000, isBookable: true, bookingNumber: 'BK1004', lat: 1.1278, lng: 104.0302 },
    { id: 5, name: 'SPKLU Batam City Square', location: 'Batam City Square', distance: '1.8km', chargers: ['Regular'], power: '11 kW', status: 'Penuh', bookingTime: '2025-10-22 10:00', duration: '90 menit', price: 30000, serviceFee: 8000, isBookable: false, bookingNumber: 'BK1005', lat: 1.1210, lng: 104.0335 },
    { id: 6, name: 'SPKLU Kepri Mall', location: 'Kepri Mall', distance: '2.1km', chargers: ['Regular'], power: '22 kW', status: 'Tersedia', bookingTime: '2025-10-22 11:00', duration: '60 menit', price: 45000, serviceFee: 9000, isBookable: true, bookingNumber: 'BK1006', lat: 1.1122, lng: 104.0450 },
    { id: 7, name: 'SPKLU Batam View', location: 'Batam View', distance: '4.0km', chargers: ['Ultra Fast'], power: '150 kW', status: 'Tersedia', bookingTime: '2025-10-22 13:00', duration: '45 menit', price: 90000, serviceFee: 10000, isBookable: true, bookingNumber: 'BK1007', lat: 1.1390, lng: 104.0480 },
    { id: 9, name: 'SPKLU Tiban', location: 'Tiban', distance: '5.5km', chargers: ['Fast'], power: '50 kW', status: 'Penuh', bookingTime: '2025-10-22 15:00', duration: '30 menit', price: 80000, serviceFee: 10000, isBookable: false, bookingNumber: 'BK1009', lat: 1.0956, lng: 104.0103 },
    { id: 10, name: 'SPKLU Sekupang', location: 'Sekupang', distance: '7.2km', chargers: ['Regular'], power: '22 kW', status: 'Tersedia', bookingTime: '2025-10-22 08:00', duration: '60 menit', price: 35000, serviceFee: 7000, isBookable: true, bookingNumber: 'BK1010', lat: 1.0552, lng: 103.9824 },
    { id: 11, name: 'SPKLU Batu Ampar', location: 'Batu Ampar', distance: '6.0km', chargers: ['Regular'], power: '11 kW', status: 'Tersedia', bookingTime: '2025-10-22 10:30', duration: '90 menit', price: 30000, serviceFee: 7000, isBookable: true, bookingNumber: 'BK1011', lat: 1.0873, lng: 104.0128 },
    { id: 12, name: 'SPKLU Nagoya City', location: 'Nagoya City', distance: '2.8km', chargers: ['Fast'], power: '80 kW', status: 'Tersedia', bookingTime: '2025-10-22 12:45', duration: '60 menit', price: 100000, serviceFee: 12000, isBookable: true, bookingNumber: 'BK1012', lat: 1.1290, lng: 104.0405 },
    { id: 13, name: 'SPKLU Batam Harbor', location: 'Batam Harbor', distance: '4.5km', chargers: ['Fast'], power: '100 kW', status: 'Penuh', bookingTime: '2025-10-22 14:30', duration: '30 menit', price: 150000, serviceFee: 15000, isBookable: false, bookingNumber: 'BK1013', lat: 1.1067, lng: 104.0622 },
    { id: 14, name: 'SPKLU Gajah Mada', location: 'Gajah Mada, Batam', distance: '1.5km', chargers: ['Regular'], power: '22 kW', status: 'Tersedia', bookingTime: '2025-10-22 09:30', duration: '60 menit', price: 40000, serviceFee: 8000, isBookable: true, bookingNumber: 'BK1014', lat: 1.1255, lng: 104.0280 },
    { id: 15, name: 'SPKLU Waterfront City', location: 'Waterfront City', distance: '3.2km', chargers: ['Regular'], power: '22 kW', status: 'Tersedia', bookingTime: '2025-10-22 11:15', duration: '60 menit', price: 45000, serviceFee: 9000, isBookable: true, bookingNumber: 'BK1015', lat: 1.1312, lng: 104.0588 },
]);

const availableStations = computed(() => stations.value.filter(s => s.status === 'Tersedia'));

const nearestStations = computed(() => {
    return stations.value.filter(s => s.status === 'Tersedia').slice().sort((a, b) => {
        const distA = parseFloat(a.distance.replace('km', ''));
        const distB = parseFloat(b.distance.replace('km', ''));
        return distA - distB;
    });
});

let map = null;

const loadLeaflet = () => {
    return new Promise((resolve, reject) => {
        if (window.L) return resolve(window.L);
        if (!document.querySelector('link[data-leaflet]')) {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
            link.setAttribute('data-leaflet', '1');
            document.head.appendChild(link);
        }
        if (!document.querySelector('script[data-leaflet]')) {
            const script = document.createElement('script');
            script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
            script.async = true;
            script.setAttribute('data-leaflet', '1');
            script.onload = () => resolve(window.L);
            script.onerror = reject;
            document.body.appendChild(script);
        } else {
            const check = () => {
                if (window.L) resolve(window.L);
                else setTimeout(check, 50);
            };
            check();
        }
    });
};

// Date & Time picker helpers
const today = new Date();
today.setHours(0,0,0,0);
const isDateDropdownOpen = ref(false);
const isTimeDropdownOpen = ref(false);

// Close pickers
const closePickersOnOutsideClick = (event) => {
    if (isBrandOpen.value && !event.target.closest('#brand-trigger') && !event.target.closest('.brand-dropdown-content')) isBrandOpen.value = false;
    if (isTypeOpen.value && !event.target.closest('#type-trigger') && !event.target.closest('.type-dropdown-content')) isTypeOpen.value = false;
    if (isDomicileOpen.value && !event.target.closest('#domicile-trigger') && !event.target.closest('.domicile-dropdown-content')) isDomicileOpen.value = false;
    if (isStationOpen.value && !event.target.closest('#station-trigger') && !event.target.closest('.station-dropdown-content')) isStationOpen.value = false;
    if (isPortOpen.value && !event.target.closest('#port-trigger') && !event.target.closest('.port-dropdown-content')) isPortOpen.value = false;
    if (isDurationOpen.value && !event.target.closest('#duration-trigger') && !event.target.closest('.duration-dropdown-content')) isDurationOpen.value = false;
};

onMounted(async () => {
    document.body.addEventListener('click', closePickersOnOutsideClick);
    window.addEventListener('popstate', handleBackButton);

    try {
        const L = await loadLeaflet();
        map = L.map('map', { zoomControl: false }).setView([1.126, 104.030], 12); 
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        stations.value.filter(s => s.status === 'Tersedia' && s.lat && s.lng).forEach(s => {
            const color = getMarkerColor(s.chargers);
            const pinSvg = createPinSvg(color);
            const iconUrl = `data:image/svg+xml;charset=UTF-8,${pinSvg}`;
            const customIcon = L.icon({
                iconUrl, iconSize: [28, 42], iconAnchor: [14, 42], popupAnchor: [0, -38]
            });
            const marker = L.marker([s.lat, s.lng], { icon: customIcon }).addTo(map);
            marker.bindPopup(`
                <div class="font-sans text-center">
                    <div class="font-bold text-base text-gray-800 mb-1">${s.name}</div>
                    <div class="text-xs text-gray-500 mb-2">${s.location}</div>
                    <button onclick="openMapsLocation(${s.lat}, ${s.lng})" class="w-full py-1.5 px-3 bg-[#00C853] text-white font-bold rounded-lg hover:bg-[#00A142] text-xs shadow-sm">
                        Buka Peta
                    </button>
                </div>
            `);
        });
    } catch (err) {
        console.error('Failed to load Leaflet:', err);
    }
});

const handleBackButton = (event) => {
    if (showReceiptModal.value) { closeReceiptModal(); event.preventDefault(); }
    else if (showQrisPaymentModal.value) { cancelProcess(); event.preventDefault(); }
    else if (showConfirmationModal.value) { cancelProcess(); event.preventDefault(); }
    else if (showSearchModal.value) { closeModal(); event.preventDefault(); }
    else if (hasStartedBooking.value) { event.preventDefault(); }
};

onBeforeUnmount(() => {
    document.body.removeEventListener('click', closePickersOnOutsideClick);
    document.body.classList.remove('modal-open');
    document.body.style.top = '';
});

watch(anyModalOpen, (isOpen) => {
    if (window.innerWidth <= 768) {
        if (isOpen) {
            const scrollY = window.scrollY;
            document.body.style.top = `-${scrollY}px`;
            document.body.classList.add('modal-open');
        } else {
            document.body.classList.remove('modal-open');
            const scrollY = parseInt(document.body.style.top || '0');
            document.body.style.top = '';
            window.scrollTo(0, -scrollY);
        }
    }
});

window.openMapsLocation = (lat, lng) => {
    const url = `https://www.google.com/maps?q=${lat},${lng}`;
    window.open(url, '_blank');
};

const formatRupiah = (amount) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0, }).format(amount);
const calculateTotal = (price, fee) => price + fee;
const calculateTotalFormatted = computed(() => {
    if (selectedStation.value) {
        const durationMultiplier = durationOptions.find(d => d.value === selectedDuration.value)?.multiplier || 1;
        const adjustedPrice = selectedStation.value.price * durationMultiplier;
        const adjustedFee = selectedStation.value.serviceFee * durationMultiplier;
        return formatRupiah(calculateTotal(adjustedPrice, adjustedFee));
    }
    return '';
});

const reserveStation = (stationId) => {
    const station = stations.value.find(s => s.id === stationId);
    if (station && station.isBookable) {
        selectedStation.value = station;
        showConfirmationModal.value = true;
        history.pushState({modal: 'confirmation'}, '', window.location.href);
    }
};

const cancelProcess = () => {
    showConfirmationModal.value = false;
    showQrisPaymentModal.value = false;
    selectedStation.value = null;
    selectedPort.value = '';
    selectedDuration.value = '60';
    // Reset Drag offset
    dragOffset.value = 0;
    isDragging.value = false;
};

const proceedToPayment = () => {
    showConfirmationModal.value = false;
    showQrisPaymentModal.value = true;
    history.pushState({modal: 'payment'}, '', window.location.href);
};

const confirmPayment = () => {
    console.log(`Pembayaran dikonfirmasi`);
    showQrisPaymentModal.value = false;
    showReceiptModal.value = true;
};

const closeReceiptModal = () => {
    showReceiptModal.value = false;
    selectedStation.value = null;
    if (history.state && history.state.modal) history.back();
};

const openPrintStruk = () => {
    showReceiptModal.value = false;
    window.location.href = `/print-struk?station=${encodeURIComponent(JSON.stringify(selectedStation.value))}&total=${encodeURIComponent(calculateTotalFormatted.value)}`;
};

const formatBookingDate = (dateTime) => {
    const [date, time] = dateTime.split(' ');
    return `${date} ${time}`;
};

const getMarkerColor = (chargers) => {
    if (chargers.includes('Ultra Fast')) return '#9333ea';
    if (chargers.includes('Fast')) return '#3b82f6';
    if (chargers.includes('Regular')) return '#22c55e';
    return '#00C853';
};

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
    <div class="min-h-screen flex flex-col bg-gray-50 font-sans text-gray-800">
        <Navbar />

        <main class="flex-grow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

                <!-- SEARCH BAR -->
                <div class="flex flex-col md:flex-row justify-end items-start md:items-center mb-6">
                    <div class="relative w-full md:w-72 group">
                        <input 
                            type="text" 
                            placeholder="Cari Stasiun Lain..." 
                            class="w-full p-3.5 pl-12 border border-gray-200 rounded-2xl bg-white shadow-sm focus:ring-2 focus:ring-[#00C853]/20 focus:border-[#00C853] cursor-pointer transition-all hover:shadow-md text-sm sm:text-base"
                            @click="openModal"
                            readonly
                            value="Cari Stasiun Lainnya..."
                        >
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-hover:text-[#00C853] transition-colors"></i>
                    </div>
                </div>

                <!-- MAP CONTAINER -->
                <div class="relative w-full mb-8 rounded-3xl shadow-xl overflow-hidden border border-white h-72 md:h-[450px] bg-[#e9f5ff] z-0">
                    <div class="absolute inset-0 bg-[url('/images/map-grid.png')] bg-cover bg-center opacity-40"></div>
                    <div class="absolute inset-0">
                        <div class="w-full h-full relative">
                            <!-- Floating Label -->
                            <div class="absolute left-1/2 top-4 transform -translate-x-1/2 text-center bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full shadow-sm z-[500]">
                                <h3 class="text-xs md:text-sm font-semibold text-gray-700 flex items-center gap-1">
                                   <i class="fas fa-info-circle text-[#00C853]"></i> Area Batam
                                </h3>
                            </div>
                            <div id="map" class="w-full h-full z-10"></div>
                        </div>
                    </div>
                </div>

                <!-- CARD LIST HEADER -->
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                        Stasiun <span class="text-[#00C853]">Terdekat</span>
                    </h2>
                    <span class="text-xs sm:text-sm font-medium text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm">
                        {{ nearestStations.length }} Ditemukan
                    </span>
                </div>
                
                <!-- CARD GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                    <div v-for="station in nearestStations" :key="station.id"
                         class="bg-white p-5 sm:p-6 rounded-3xl shadow-md hover:shadow-xl border border-transparent transition-all duration-300 transform hover:-translate-y-1 flex flex-col relative group"
                         :class="{ 'ring-2 ring-[#00C853] ring-offset-2': selectedStation && selectedStation.id === station.id && (showQrisPaymentModal || showReceiptModal) }">
                        
                        <!-- Header Card -->
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h2 class="text-lg sm:text-xl font-bold text-gray-900 leading-tight mb-1">{{ station.name }}</h2>
                                <div class="flex items-center text-xs sm:text-sm text-gray-500">
                                    <i class="fas fa-map-marker-alt mr-1.5 text-gray-400"></i>
                                    {{ station.distance }}
                                </div>
                            </div>
                            <div class="bg-lime-50 text-lime-700 text-xs font-bold px-2.5 py-1 rounded-lg">
                                {{ station.status }}
                            </div>
                        </div>

                        <!-- Info Details -->
                        <div class="space-y-3 mb-6 text-sm sm:text-base bg-gray-50 p-4 rounded-2xl">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-bolt w-5 text-center mr-2 text-yellow-500"></i>
                                    <span>Tipe</span>
                                </div>
                                <span class="font-semibold text-gray-800">{{ station.chargers[0] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-tachometer-alt w-5 text-center mr-2 text-blue-500"></i>
                                    <span>Daya</span>
                                </div>
                                <span class="font-semibold text-gray-800">{{ station.power }}</span>
                            </div>
                        </div>

                        <!-- Pricing & Action -->
                        <div class="mt-auto space-y-4">
                            <div class="flex flex-col gap-1">
                                <div class="flex justify-between items-center text-sm text-gray-500">
                                    <span>Estimasi Total</span>
                                    <span class="text-xs">(Inc. Service Fee)</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xl sm:text-2xl font-bold text-[#00C853]">{{ formatRupiah(calculateTotal(station.price, station.serviceFee)) }}</span>
                                </div>
                            </div>

                            <button
                                @click="reserveStation(station.id)"
                                :disabled="!station.isBookable"
                                :class="[
                                    'w-full py-3.5 rounded-xl sm:rounded-2xl font-bold text-sm sm:text-base transition-all duration-200 flex items-center justify-center space-x-2 shadow-lg',
                                    station.isBookable 
                                        ? 'bg-[#00C853] text-white hover:bg-[#00A142] active:scale-95 hover:shadow-[#00C853]/30' 
                                        : 'bg-gray-200 text-gray-400 cursor-not-allowed shadow-none'
                                ]"
                            >
                                <i class="fas fa-ticket-alt"></i>
                                <span>{{ station.isBookable ? 'Pesan Sekarang' : 'Penuh' }}</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <Footer />
        
        <!-- SEARCH MODAL (Slide Up on Mobile with Drag-to-Dismiss) -->
        <Transition name="slide-up">
            <div v-if="showSearchModal" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm flex items-end sm:items-center justify-center z-[99999] p-0 sm:p-4" @click.self="closeModal">
                <div 
                    class="bg-white w-full h-[90vh] sm:h-auto sm:max-w-2xl rounded-t-[2rem] sm:rounded-3xl p-6 sm:p-8 shadow-2xl transform transition-transform duration-300 sm:duration-200 flex flex-col relative touch-none sm:touch-auto"
                    :style="{ transform: isDragging ? `translateY(${dragOffset}px)` : '' }"
                >
                    <!-- Handle bar for mobile (Draggable Area) -->
                     <div 
                        class="w-full h-8 absolute top-0 left-0 z-50 flex justify-center items-center sm:hidden cursor-grab active:cursor-grabbing"
                        @touchstart="onTouchStart"
                        @touchmove="onTouchMove"
                        @touchend="onTouchEnd"
                     >
                        <div class="w-14 h-1.5 bg-gray-300 rounded-full"></div>
                     </div>

                    <div class="mt-4 sm:mt-0 h-full flex flex-col"> <!-- Wrapper -->
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Cari Stasiun</h3>
                        
                        <form @submit.prevent="submitSearch" class="space-y-5 overflow-y-auto flex-grow custom-scrollbar px-1">
                             <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="relative">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Merk</label>
                                    <div @click.stop="openOnly('brand')" class="dropdown-trigger" :class="{'active': isBrandOpen}">
                                        <span class="text-gray-800 truncate">{{ formState.brand || 'Pilih Merk' }}</span>
                                        <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform" :class="{'rotate-180': isBrandOpen}"></i>
                                    </div>
                                    <div v-if="isBrandOpen" class="dropdown-menu">
                                        <div v-for="opt in brandOptions" :key="opt" @click="selectOption('brand', opt)" class="dropdown-item" :class="{'selected': formState.brand === opt}">{{ opt }}</div>
                                    </div>
                                </div>
                                <div class="relative">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Tipe</label>
                                    <div @click.stop="openOnly('type')" class="dropdown-trigger" :class="{'active': isTypeOpen}">
                                        <span class="text-gray-800 truncate">{{ formState.type || 'Pilih Tipe' }}</span>
                                        <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform" :class="{'rotate-180': isTypeOpen}"></i>
                                    </div>
                                    <div v-if="isTypeOpen" class="dropdown-menu">
                                        <div v-for="opt in typeOptions" :key="opt" @click="selectOption('type', opt)" class="dropdown-item" :class="{'selected': formState.type === opt}">{{ opt }}</div>
                                    </div>
                                </div>
                                <div class="relative">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Domisili</label>
                                    <div @click.stop="openOnly('domicile')" class="dropdown-trigger" :class="{'active': isDomicileOpen}">
                                        <span class="text-gray-800 truncate">{{ formState.domicile || 'Pilih Area' }}</span>
                                        <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform" :class="{'rotate-180': isDomicileOpen}"></i>
                                    </div>
                                    <div v-if="isDomicileOpen" class="dropdown-menu">
                                        <div v-for="opt in domicileOptions" :key="opt" @click="selectOption('domicile', opt)" class="dropdown-item" :class="{'selected': formState.domicile === opt}">{{ opt }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Stasiun</label>
                                    <div @click.stop="openOnly('station')" class="dropdown-trigger" :class="{'active': isStationOpen}">
                                        <span class="text-gray-800 truncate">{{ formState.station || 'Semua Stasiun' }}</span>
                                        <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform" :class="{'rotate-180': isStationOpen}"></i>
                                    </div>
                                    <div v-if="isStationOpen" class="dropdown-menu">
                                        <div v-for="opt in stationOptions" :key="opt" @click="selectOption('station', opt)" class="dropdown-item" :class="{'selected': formState.station === opt}">{{ opt }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="h-20 sm:hidden"></div>
                        </form>

                        <div class="pt-4 mt-auto border-t border-gray-100 flex flex-col-reverse sm:flex-row gap-3 sm:justify-end">
                             <button type="button" @click="closeModal" class="w-full sm:w-auto px-6 py-3.5 rounded-xl text-gray-600 font-semibold hover:bg-gray-100 transition">
                                Batal
                            </button>
                            <button type="button" @click="submitSearch" class="w-full sm:w-auto bg-[#00C853] text-white font-bold px-8 py-3.5 rounded-xl hover:bg-[#00A142] active:scale-95 transition shadow-lg shadow-[#00C853]/20">
                                Terapkan Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>

        <!-- CONFIRMATION MODAL (Slide Up on Mobile with Drag-to-Dismiss) -->
        <Transition name="slide-up">
            <div v-if="showConfirmationModal && selectedStation" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm flex items-end sm:items-center justify-center z-[99999] p-0 sm:p-4" @click.self="cancelProcess">
                <div 
                    class="bg-white w-full rounded-t-[2rem] sm:rounded-3xl p-6 sm:p-8 shadow-2xl max-w-lg transform transition-transform duration-300 sm:duration-200 pb-8 sm:pb-8 relative touch-none sm:touch-auto"
                    :style="{ transform: isDragging ? `translateY(${dragOffset}px)` : '' }"
                >
                    
                     <!-- Handle bar for mobile (Draggable Area) -->
                     <div 
                        class="w-full h-8 absolute top-0 left-0 z-50 flex justify-center items-center sm:hidden cursor-grab active:cursor-grabbing"
                        @touchstart="onTouchStart"
                        @touchmove="onTouchMove"
                        @touchend="onTouchEnd"
                     >
                        <div class="w-14 h-1.5 bg-gray-300 rounded-full"></div>
                     </div>

                    <div class="mt-4 sm:mt-0"> <!-- Spacer for handle -->
                        <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Konfirmasi Pesanan</h3>

                        <!-- Selection Inputs -->
                        <div class="space-y-4 mb-6">
                            <div class="relative">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Port Charging</label>
                                <div @click.stop="openOnly('port')" class="dropdown-trigger" :class="{'active': isPortOpen}">
                                    <span class="text-gray-800">{{ selectedPort ? portOptions.find(p => p.value === selectedPort)?.label : 'Pilih Port' }}</span>
                                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform" :class="{'rotate-180': isPortOpen}"></i>
                                </div>
                                <div v-if="isPortOpen" class="dropdown-menu">
                                    <div v-for="port in portOptions" :key="port.value" @click="selectOption('port', port.value)" class="dropdown-item" :class="{'selected': selectedPort === port.value}">{{ port.label }}</div>
                                </div>
                            </div>

                            <div class="relative">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Durasi</label>
                                <div @click.stop="openOnly('duration')" class="dropdown-trigger" :class="{'active': isDurationOpen}">
                                    <span class="text-gray-800">{{ durationOptions.find(d => d.value === selectedDuration)?.label || 'Pilih Durasi' }}</span>
                                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform" :class="{'rotate-180': isDurationOpen}"></i>
                                </div>
                                <div v-if="isDurationOpen" class="dropdown-menu">
                                    <div v-for="duration in durationOptions" :key="duration.value" @click="selectOption('duration', duration.value)" class="dropdown-item" :class="{'selected': selectedDuration === duration.value}">{{ duration.label }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Card -->
                        <div class="bg-gray-50 rounded-2xl p-4 space-y-3 mb-6 border border-gray-100">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Lokasi</span>
                                <span class="font-semibold text-gray-800 text-right">{{ selectedStation.name }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Waktu</span>
                                <span class="font-medium text-gray-800">{{ formatBookingDate(selectedStation.bookingTime) }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 flex justify-between items-center">
                                <span class="font-bold text-gray-900">Total</span>
                                <span class="font-bold text-xl text-[#00C853]">{{ calculateTotalFormatted }}</span>
                            </div>
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row gap-3">
                            <button type="button" @click="cancelProcess" class="w-full py-3.5 rounded-xl font-bold text-gray-500 bg-gray-100 hover:bg-gray-200 transition">
                                Batal
                            </button>
                            <button type="button" @click="proceedToPayment" :disabled="!selectedPort"
                                class="w-full py-3.5 rounded-xl font-bold text-white bg-[#00C853] hover:bg-[#00A142] shadow-lg shadow-[#00C853]/20 active:scale-95 transition disabled:bg-gray-300 disabled:shadow-none">
                                Lanjut Bayar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>

        <!-- QRIS MODAL -->
        <Transition name="fade">
            <div v-if="showQrisPaymentModal && selectedStation" class="fixed inset-0 bg-gray-900/90 backdrop-blur-sm flex items-center justify-center z-[99999] p-4" @click.self="cancelProcess">
                <div class="bg-white rounded-3xl p-6 shadow-2xl w-full max-w-md relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-[#00C853]"></div>
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Scan QRIS</h3>
                        <button @click="cancelProcess" class="bg-gray-100 rounded-full p-2 text-gray-500 hover:bg-gray-200 transition">
                           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <div class="flex flex-col items-center mb-6">
                        <div class="bg-white p-4 rounded-2xl shadow-[0_0_20px_rgba(0,0,0,0.1)] border border-gray-100 mb-4">
                             <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=QRIS%20Payment" alt="QRIS" class="w-48 h-48 rounded-lg">
                        </div>
                        <div class="text-center">
                             <p class="text-sm text-gray-500 mb-1">Total Pembayaran</p>
                             <p class="text-2xl font-bold text-gray-900">{{ calculateTotalFormatted }}</p>
                        </div>
                    </div>

                    <button @click="confirmPayment" 
                        class="w-full py-3.5 bg-[#00C853] text-white font-bold rounded-xl hover:bg-[#00A142] shadow-lg shadow-[#00C853]/30 active:scale-95 transition flex items-center justify-center gap-2">
                        <span>Cek Status Bayar</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </Transition>

        <!-- RECEIPT MODAL -->
        <Transition name="fade">
            <div v-if="showReceiptModal && selectedStation" class="fixed inset-0 bg-[#00C853] flex flex-col items-center justify-center z-[99999] p-4">
                <div class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden relative">
                    <div class="absolute top-0 left-0 right-0 h-4 bg-[#00A142]"></div>

                    <div class="p-8 text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check text-2xl text-[#00C853]"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-1">Booking Berhasil!</h2>
                        <p class="text-gray-500 text-sm mb-6">Kode booking Anda siap digunakan.</p>

                        <div class="bg-gray-50 rounded-xl p-4 border-2 border-dashed border-gray-200 mb-6">
                             <div class="text-xs text-gray-400 uppercase tracking-widest mb-1">Booking ID</div>
                             <div class="text-2xl font-mono font-bold text-gray-800 tracking-wider">{{ selectedStation.bookingNumber }}</div>
                        </div>
                        
                         <div class="bg-white p-2 rounded-xl border border-gray-100 inline-block mb-4 shadow-sm">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Access" alt="QR Access" class="w-32 h-32">
                        </div>
                        <p class="text-xs text-gray-400">Scan QR ini pada mesin charging</p>
                    </div>

                    <div class="p-4 bg-gray-50 border-t border-gray-100">
                         <button @click="openPrintStruk" class="w-full py-3.5 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 shadow-lg active:scale-95 transition mb-3">
                            <i class="fas fa-download mr-2"></i> Simpan Struk
                        </button>
                         <button @click="closeReceiptModal" class="w-full py-3.5 text-gray-500 font-bold hover:text-gray-800 transition">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
/* Custom Styles for Dropdowns */
.dropdown-trigger {
    width: 100%;
    padding: 0.875rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    background-color: #ffffff;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 200ms;
}
.dropdown-trigger:hover {
    border-color: #00C853;
}
.dropdown-trigger.active {
    border-color: #00C853;
    box-shadow: 0 0 0 2px rgba(0, 200, 83, 0.2), 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
.dropdown-menu {
    position: absolute;
    top: 100%;
    margin-top: 0.5rem;
    width: 100%;
    background-color: #ffffff;
    border-radius: 0.75rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border: 1px solid #f3f4f6;
    z-index: 50;
    max-height: 15rem;
    overflow-y: auto;
    padding: 0.5rem 0;
    animation: fadeInDown 0.2s ease-out forwards;
}
.dropdown-item {
    padding: 0.625rem 1rem;
    cursor: pointer;
    font-size: 0.875rem;
    color: #374151;
    transition: color 200ms, background-color 200ms;
}
.dropdown-item:hover {
    background-color: #f7fdee;
    color: #00C853;
}
.dropdown-item.selected {
    background-color: #f7fdee;
    color: #00C853;
    font-weight: 700;
}

/* Animation for Dropdowns */
.animate-fade-in-down {
    animation: fadeInDown 0.2s ease-out forwards;
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

/* Standard Fade Transition */
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

/* Slide Up Transition for Mobile Bottom Sheet */
.slide-up-enter-active, .slide-up-leave-active {
    transition: transform 0.3s cubic-bezier(0.33, 1, 0.68, 1), opacity 0.3s ease;
}
.slide-up-enter-from, .slide-up-leave-to {
    transform: translateY(100%);
    opacity: 1;
}

/* Desktop override for Slide Up (act as fade/scale) */
@media (min-width: 640px) {
    .slide-up-enter-from, .slide-up-leave-to {
        transform: scale(0.95);
        opacity: 0;
    }
}
</style>

<style>
/* Mobile Body Lock */
@media (max-width: 768px) {
    .modal-open { overflow: hidden; position: fixed; width: 100%; height: 100%; }
}
</style>