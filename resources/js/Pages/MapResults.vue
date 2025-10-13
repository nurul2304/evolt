<script setup>
import { ref, computed } from 'vue';

import AppNavbar from '@/Components/AppNavbar.vue';
import AppFooter from '@/Components/AppFooter.vue';

// -----------------------------------------------------------------------------------

const showSearchModal = ref(false);
const showConfirmationModal = ref(false);
const showQrisPaymentModal = ref(false); // Modal baru untuk pembayaran QRIS
const showReceiptModal = ref(false);    // Modal untuk struk akhir
const selectedStation = ref(null);

const formState = ref({
    brand: 'Nissan',
    type: 'SUV', 
    date: new Date().toISOString().split('T')[0],
    domicile: 'Batam Center', 
    station: 'SPKLU Mega Mall', 
    time: '12:00',
});

const openModal = () => {
    showSearchModal.value = true;
};

const closeModal = () => {
    showSearchModal.value = false;
};

const submitSearch = () => {
    console.log('Searching with:', formState.value);
    closeModal();
};

const stations = ref([
    // Sesuaikan format bookingTime agar lebih sesuai
    { id: 1, name: 'Plaza Senayan', location: 'Jl. Asia Afrika, Jakarta Pusat', chargerType: 'DC Fast', power: '150 kW', status: 'Tersedia', bookingTime: '2025-10-22 12:12', duration: '60 menit', price: 420000, serviceFee: 15000, isBookable: true, bookingNumber: 'BK72936476' },
    { id: 2, name: 'Grand Indonesia', location: 'Jl. MH Thamrin, Jakarta Pusat', chargerType: 'AC Standard', power: '22 kW', status: 'Tersedia', bookingTime: '2025-10-22 12:12', duration: '60 menit', price: 44000, serviceFee: 10000, isBookable: true, bookingNumber: 'BK72936477' },
    { id: 3, name: 'Mall Alam Sutera', location: 'Jl. Alam Sutera, Tangerang', chargerType: 'DC Fast', power: '100 kW', status: 'Penuh', bookingTime: '2025-10-22 14:00', duration: '30 menit', price: 210000, serviceFee: 15000, isBookable: false, bookingNumber: 'BK72936478' },
    { id: 4, name: 'SPKLU Bandara', location: 'Jl. Pajajaran, Bogor', chargerType: 'Tipe 2', power: '50 kW', status: 'Tersedia', bookingTime: '2025-10-22 10:00', duration: '90 menit', price: 630000, serviceFee: 20000, isBookable: true, bookingNumber: 'BK72936479' },
    { id: 5, name: 'SPKLU Batam', location: 'Jl. Sudirman, Batam', chargerType: 'AC Standard', power: '11 kW', status: 'Tersedia', bookingTime: '2025-10-22 10:00', duration: '90 menit', price: 22000, serviceFee: 10000, isBookable: true, bookingNumber: 'BK72936480' },
    { id: 6, name: 'Nagoya Hill', location: 'Jl. Teuku Umar, Batam', chargerType: 'DC Fast', power: '80 kW', status: 'Penuh', bookingTime: '2025-10-22 10:00', duration: '90 menit', price: 560000, serviceFee: 20000, isBookable: false, bookingNumber: 'BK72936481' },
]);

const formatRupiah = (amount) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0, }).format(amount);
};
const calculateTotal = (price, fee) => {
    return price + fee;
};
const calculateTotalFormatted = computed(() => {
    if (selectedStation.value) {
        return formatRupiah(calculateTotal(selectedStation.value.price, selectedStation.value.serviceFee));
    }
    return '';
});

// Fungsi untuk menampilkan modal konfirmasi
const reserveStation = (stationId) => {
    const station = stations.value.find(s => s.id === stationId);
    if (station && station.isBookable) {
        selectedStation.value = station;
        showConfirmationModal.value = true;
    }
};

// Fungsi untuk membatalkan proses (dari modal konfirmasi atau pembayaran)
const cancelProcess = () => {
    showConfirmationModal.value = false;
    showQrisPaymentModal.value = false;
    selectedStation.value = null;
};

// Fungsi setelah user mengklik "Ya, Pesan" di modal konfirmasi
const proceedToPayment = () => {
    showConfirmationModal.value = false; // Tutup modal konfirmasi
    showQrisPaymentModal.value = true;  // Buka modal pembayaran QRIS
};

// Fungsi setelah user mengklik "Konfirmasi Pembayaran" di modal QRIS
const confirmPayment = () => {
    // Di sini akan ada logika sebenarnya untuk memverifikasi pembayaran.
    // Untuk demo, kita langsung asumsikan berhasil.
    console.log(`Pembayaran dikonfirmasi untuk booking: ${selectedStation.value.bookingNumber}`);
    showQrisPaymentModal.value = false; // Tutup modal QRIS
    showReceiptModal.value = true;      // Buka modal struk
};

// Fungsi untuk menutup modal struk akhir
const closeReceiptModal = () => {
    showReceiptModal.value = false;
    selectedStation.value = null; // Reset data stasiun
};

// Fungsi untuk membuat QR code di struk (placeholder)
const generateQrisQrCode = () => {
    // Dalam implementasi nyata, ini akan menjadi library QR code dengan data QRIS
    return 'QRIS_PAYMENT_DATA_FOR_' + selectedStation.value.bookingNumber;
};

// Fungsi untuk membuat QR code untuk charging (placeholder)
const generateChargingQrCode = () => {
    // Ini adalah QR code yang berbeda untuk digunakan di stasiun charging.
    return 'CHARGING_SESSION_DATA_FOR_' + selectedStation.value.bookingNumber;
};

// Utility untuk memformat tanggal bookingTime
const formatBookingDate = (dateTime) => {
    const [date, time] = dateTime.split(' ');
    return `${date} ${time}`;
};
</script>

<template>
    <div class="min-h-screen flex flex-col bg-gray-50">
        <AppNavbar />

        <main class="flex-grow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

                <div class="flex flex-col md:flex-row justify-end items-start md:items-center mb-6">
                    <div class="relative w-full md:w-64">
                        <input 
                            type="text" 
                            placeholder="Cari Stasiun Lain..." 
                            class="w-full p-3 pl-4 border border-gray-300 rounded-xl focus:ring-[#00C853] focus:border-[#00C853] cursor-pointer"
                            @click="openModal"
                            readonly
                            value="Cari Stasiun Lainnya..."
                        >
                        <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <div class="relative w-full mb-8 rounded-xl shadow-lg overflow-hidden border border-gray-200" style="height: 450px; background-color: #f0f0f0;">
                    <div class="absolute inset-0 flex items-center justify-center bg-gray-100/50">
                        <div class="text-center">
                            <h3 class="text-xl font-medium text-gray-800 mb-2">Leaflet.js Map Placeholder</h3>
                            <p class="text-gray-600">Implementasi peta sesungguhnya (menggunakan Leaflet.js) akan dilakukan di sini.</p>
                        </div>
                    </div>
                </div>

                <h2 class="text-2xl font-medium text-gray-800 mb-6">Stasiun Charging Tersedia</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="station in stations" :key="station.id"
                         class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl relative"
                         :class="{ 'border-[#00C853] ring-1 ring-[#00C853]': selectedStation && selectedStation.id === station.id && showQrisPaymentModal || showReceiptModal }">
                        
                        <div :class="[
                            'absolute top-0 right-0 m-4 px-4 py-1 rounded-lg text-sm font-medium z-10',
                            station.status === 'Tersedia' ? 'bg-[#00C853] text-white' : 'bg-red-600 text-white'
                        ]">
                            {{ station.status }}
                        </div>
                        
                        <h2 class="text-xl font-semibold text-gray-900 mb-1">{{ station.name }}</h2>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ station.location }}
                        </div>

                        <div class="space-y-2 mb-6 text-sm">
                            <div class="flex justify-between items-center bg-[#F7FFE4] p-3 rounded-lg text-gray-700">
                                <span class="font-medium text-gray-900 flex items-center"><i class="fas fa-bolt mr-2 text-yellow-600"></i>Jenis Charger:</span>
                                <span class="text-right font-medium">{{ station.chargerType }} &bull; {{ station.power }}</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-700">
                                <span class="font-medium text-gray-900 flex items-center"><i class="fas fa-clock mr-2 text-blue-600"></i>Waktu Booking:</span>
                                <span class="text-right">{{ formatBookingDate(station.bookingTime) }} ({{ station.duration }})</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-4 space-y-2 mb-4 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Harga Charging:</span>
                                <span class="font-medium">{{ formatRupiah(station.price) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Biaya Layanan:</span>
                                <span class="font-medium">{{ formatRupiah(station.serviceFee) }}</span>
                            </div>
                            <div class="flex justify-between font-medium text-lg p-2 rounded-lg" style="background-color: #e6ffb3;">
                                <span>Total Harga:</span>
                                <span class="text-gray-900">{{ formatRupiah(calculateTotal(station.price, station.serviceFee)) }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button 
                                @click="reserveStation(station.id)"
                                :disabled="!station.isBookable"
                                :class="[
                                    'w-full py-3 rounded-xl text-white font-medium transition duration-200 shadow-md flex items-center justify-center space-x-2',
                                    station.isBookable ? 'bg-[#00C853] hover:bg-[#00A142]' : 'bg-gray-400 cursor-not-allowed'
                                ]"
                            >
                                <i class="fas fa-dollar-sign"></i> <span>Pesan Tiket</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <AppFooter />
        
        <Transition name="fade">
            <div v-if="showSearchModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="closeModal">
                <div class="bg-white rounded-xl p-8 shadow-2xl w-full max-w-2xl transform transition-all duration-300">
                    <h3 class="text-2xl font-medium text-gray-900 mb-6">Cari Jadwal Pengecasan</h3>
                    
                    <form @submit.prevent="submitSearch" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Merk Mobil</label>
                                <select id="brand" v-model="formState.brand" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-lime-600 focus:border-lime-600 appearance-none bg-white">
                                    <option value="Nissan">Nissan</option>
                                    <option value="Toyota">Toyota</option>
                                    <option value="Wuling">Wuling</option>
                                </select>
                            </div>
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Mobil</label>
                                <select id="type" v-model="formState.type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-lime-600 focus:border-lime-600 appearance-none bg-white">
                                    <option value="SUV">SUV</option>
                                    <option value="City Car">City Car</option>
                                </select>
                            </div>
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                <input type="date" id="date" v-model="formState.date"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-lime-600 focus:border-lime-600">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="domicile" class="block text-sm font-medium text-gray-700 mb-1">Domisili</label>
                                <select id="domicile" v-model="formState.domicile" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-lime-600 focus:border-lime-600 appearance-none bg-white">
                                    <option value="Batam Center">Batam Center</option>
                                    <option value="Nagoya">Nagoya</option>
                                </select>
                            </div>
                            <div>
                                <label for="station" class="block text-sm font-medium text-gray-700 mb-1">Stasiun Charger</label>
                                <select id="station" v-model="formState.station" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-lime-600 focus:border-lime-600 appearance-none bg-white">
                                    <option value="SPKLU Mega Mall">SPKLU Mega Mall</option>
                                    <option value="SPKLU Grand Batam Mall">SPKLU Grand Batam Mall</option>
                                </select>
                            </div>
                            <div>
                                <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Jam</label>
                                <input type="time" id="time" v-model="formState.time"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-lime-600 focus:border-lime-600">
                            </div>
                        </div>
                        
                        <div class="pt-3 flex justify-end space-x-3">
                            <button type="button" @click="closeModal" class="px-6 py-3 text-sm text-gray-600 hover:text-gray-900 transition duration-300 rounded-lg">
                                Batal
                            </button>
                            <button type="submit" 
                                class="bg-[#00C853] text-white font-medium px-8 py-3 rounded-lg hover:bg-[#00A142] transition duration-300 shadow-md">
                                Cari Stasiun
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Transition>

        <Transition name="fade">
            <div v-if="showConfirmationModal && selectedStation" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="cancelProcess">
                <div class="bg-white rounded-lg p-6 shadow-2xl w-full max-w-lg transform transition-all duration-300">
                    <h3 class="text-xl font-medium text-gray-900 mb-6">Anda yakin ingin memesan tiket ini?</h3>
                    
                    <div class="space-y-3 text-gray-700">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-gray-400 mt-1 mr-3"></i>
                            <div>
                                <p class="font-medium">{{ selectedStation.name }}</p>
                                <p class="text-sm">{{ selectedStation.location }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock text-gray-400 mr-3"></i>
                            <p class="text-sm">{{ formatBookingDate(selectedStation.bookingTime) }} ({{ selectedStation.duration }})</p>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <div class="flex items-center">
                                <i class="fas fa-dollar-sign text-xl text-gray-500 mr-2"></i>
                                <span class="text-lg font-medium text-gray-900">Total Harga:</span>
                            </div>
                            <span class="text-xl font-medium text-[#00C853]">{{ calculateTotalFormatted }}</span>
                        </div>
                    </div>

                    <div class="pt-6 flex justify-end space-x-3">
                        <button type="button" @click="cancelProcess" class="px-6 py-3 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-300">
                            Batal
                        </button>
                        <button type="button" @click="proceedToPayment" 
                            class="bg-[#00C853] text-white font-medium px-8 py-3 rounded-lg hover:bg-[#00A142] transition duration-300 shadow-md">
                            Ya, Pesan
                        </button>
                    </div>
                </div>
            </div>
        </Transition>

        <Transition name="fade">
            <div v-if="showQrisPaymentModal && selectedStation" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="cancelProcess">
                <div class="bg-white rounded-lg p-4 shadow-2xl w-full max-w-2xl transform transition-all duration-300">
                    <div class="flex justify-between items-center pb-2">
                        <div class="flex items-center bg-[#FFFBEB] text-[#9A6A01] px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-clock mr-2"></i> <span>Menunggu Pembayaran</span>
                        </div>
                        <button @click="cancelProcess" class="text-gray-400 hover:text-gray-600 text-2xl font-light">
                            &times;
                        </button>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-900 mb-4 text-center">Pembayaran QRIS</h3>
                    
                    <div class="flex flex-col md:flex-row gap-4 items-center">
                        <div class="w-full md:w-1/2 p-4 rounded-xl flex flex-col items-center" style="background-color: #f7ffe4; border: 1px solid #e6ffb3;">
                            <div class="w-48 h-48 bg-[#00C853] flex items-center justify-center rounded-lg shadow-inner">
                                <span class="text-white font-semibold text-lg">QRIS CODE</span>
                            </div>
                            <p class="text-center text-sm text-gray-600 mt-3">Scan QR code dengan aplikasi pembayaran Anda</p>
                        </div>
                        
                        <div class="w-full md:w-1/2 space-y-3">
                            <div>
                                <div class="text-sm font-medium text-gray-700">Nomor Booking</div>
                                <div class="text-lg font-semibold text-[#00C853]">{{ selectedStation.bookingNumber }}</div>
                            </div>
                            <div class="space-y-2 pt-2 border-t border-gray-100">
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-gray-500 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">Lokasi Charging</p>
                                        <p class="text-sm text-gray-600">{{ selectedStation.name }}</p>
                                        <p class="text-sm text-gray-600">{{ selectedStation.location }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-gray-500 mr-3"></i>
                                    <p class="text-sm text-gray-600">{{ formatBookingDate(selectedStation.bookingTime) }} ({{ selectedStation.duration }})</p>
                                    <p class="text-sm text-gray-600"></p> </div>
                                <div class="flex items-center">
                                    <i class="fas fa-bolt text-yellow-600 mr-3"></i>
                                    <p class="text-sm text-gray-600">Jenis Charger: **{{ selectedStation.chargerType }}** &bull; **{{ selectedStation.power }}**</p>
                                </div>
                            </div>

                            <div class="flex justify-between items-center bg-[#E6FFB3] p-3 rounded-lg mt-4">
                                <div class="flex items-center text-lg text-gray-900">
                                    <i class="fas fa-dollar-sign mr-2"></i> <span class="font-semibold">Total Pembayaran :</span>
                                </div>
                                <span class="text-xl font-semibold text-gray-900">{{ calculateTotalFormatted }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button @click="confirmPayment" 
                            class="w-full py-3 bg-[#00C853] text-white font-semibold rounded-xl hover:bg-[#00A142] transition duration-300 shadow-md flex items-center justify-center space-x-2">
                            <i class="fas fa-check-circle"></i> <span>Konfirmasi Pembayaran</span>
                        </button>
                    </div>
                </div>
            </div>
        </Transition>

        <Transition name="fade">
            <div v-if="showReceiptModal && selectedStation" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="closeReceiptModal">
                <div class="bg-white rounded-xl p-4 shadow-2xl w-full max-w-xl transform transition-all duration-300">
                    
                    <div class="flex justify-between items-center pb-2">
                        <div class="flex items-center bg-[#D4EDDA] text-[#008000] px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-check-circle mr-2"></i> <span>Pembayaran Berhasil</span>
                        </div>
                        <button @click="closeReceiptModal" class="text-gray-400 hover:text-gray-600 text-2xl font-light">
                            &times;
                        </button>
                    </div>

                    <h3 class="text-xl font-medium text-gray-900 mb-4 text-center">Struk Pembayaran</h3>
                    
                    <div class="flex flex-col md:flex-row gap-4 items-center">
                        <div class="w-full md:w-1/2 p-4 rounded-xl flex flex-col items-center" style="background-color: #f7ffe4; border: 1px solid #e6ffb3;">
                            <div class="w-48 h-48 bg-[#00C853] flex items-center justify-center rounded-lg shadow-inner">
                                <span class="text-white font-medium text-lg">QR CHARGING</span>
                            </div>
                            <p class="text-center text-sm text-gray-600 mt-3">Scan QR code ini saat tiba di lokasi charging</p>
                        </div>

                        <div class="w-full md:w-1/2 space-y-3">
                            <div>
                                <div class="text-sm font-medium text-gray-700">Nomor Booking</div>
                                <div class="text-lg font-medium text-[#00C853]">{{ selectedStation.bookingNumber }}</div>
                            </div>
                            <div class="space-y-2 pt-2 border-t border-gray-100">
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-gray-500 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">Lokasi</p>
                                        <p class="text-sm text-gray-600">{{ selectedStation.name }}</p>
                                        <p class="text-sm text-gray-600">{{ selectedStation.location }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-gray-500 mr-3"></i>
                                    <p class="text-sm text-gray-600">{{ formatBookingDate(selectedStation.bookingTime) }} ({{ selectedStation.duration }})</p>
                                    <p class="text-sm text-gray-600"></p> </div>
                                <div class="flex items-center">
                                    <i class="fas fa-bolt text-yellow-600 mr-3"></i>
                                    <p class="text-sm text-gray-600">Jenis Charger: **{{ selectedStation.chargerType }}** &bull; **{{ selectedStation.power }}**</p>
                                </div>
                            </div>

                            <div class="flex justify-between items-center bg-[#E6FFB3] p-3 rounded-lg mt-4">
                                <div class="flex items-center text-lg text-gray-900">
                                    <i class="fas fa-dollar-sign mr-2"></i> <span class="font-medium">Total Harga</span>
                                </div>
                                <span class="text-xl font-medium text-gray-900">{{ calculateTotalFormatted }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button class="w-full py-3 bg-[#00C853] text-white font-medium rounded-xl hover:bg-[#00A142] transition duration-300 shadow-md flex items-center justify-center space-x-2">
                            <i class="fas fa-download"></i> <span>Unduh Struk</span>
                        </button>
                        <div class="bg-[#FFFBEB] text-[#9A6A01] p-3 rounded-lg text-sm text-center mt-3 font-medium">
                            Terima kasih telah menggunakan layanan kami!
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
/* Ikon menggunakan warna yang sesuai dengan desain E-VOLT */
.fa-bolt { color: #f59e0b; /* kuning */ }
.fa-clock { color: #3b82f6; /* biru */ } /* Digunakan juga untuk "Menunggu Pembayaran" */
.fa-hourglass-half { color: #8b5cf6; /* ungu */ }
.fa-check-circle { color: #008000; } /* hijau untuk sukses */
.fa-dollar-sign { color: #00C853; } /* hijau E-VOLT untuk icon total harga */


/* Animasi untuk Modal */
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>