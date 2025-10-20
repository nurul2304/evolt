<script setup>
import { ref, reactive, computed } from 'vue';

import AppNavbar from '@/Components/AppNavbar.vue';
import AppFooter from '@/Components/AppFooter.vue';
// --- MOCK COMPONENTS (Untuk memastikan file dapat berjalan secara mandiri) ---




// --- MOCK ICON COMPONENTS (Menggantikan lucide-vue-next) ---
const IconUser = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>' }
const IconTicket = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="10" width="18" height="12" rx="2"/><path d="M7 10v2a2 2 0 0 1-2 2H3"/><path d="M17 10v2a2 2 0 0 0 2 2h2"/><path d="M12 2v4"/><path d="M12 6h2"/><path d="M12 6H10"/></svg>' }
const IconNews = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg>' }
const IconTag = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="7.5" cy="7.5" r="5.5"/><path d="M13.5 19l4.5 4.5 3-3L16.5 16l-3 3z"/></svg>' }
const IconClock = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>' }
const IconKey = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12h-3a4 4 0 0 0-4 4v3a4 4 0 0 0 4 4h3a4 4 0 0 0 4-4v-3a4 4 0 0 0-4-4z"/><circle cx="16" cy="16" r="2"/></svg>' }
const IconLogout = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>' }
const IconUserSmall = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>' }
const IconCalendar = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>' }
const IconIdCard = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 10h10"/><path d="M7 14h6"/></svg>' }
const IconMapPin = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21.5s-6-7-6-9.5A6 6 0 0 1 12 6a6 6 0 0 1 6 6c0 2.5-6 9.5-6 9.5z"/><circle cx="12" cy="12" r="3"/></svg>' }
const IconLockOpen = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 11c0-.667.333-2 2-2s2 1.333 2 2v3m-4 4h4m-2-7h.01M5 13V7a4 4 0 118 0v6m-4 4h4" /></svg>' }
const IconCheckCircle = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>' }
const IconMail = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>' }
const IconPhone = { template: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2 2c-3.23 0-6.4-.9-9.25-2.61-2.92-1.74-5.26-4.08-7-7C2.9 10.42 2 7.25 2 4a2 2 0 0 1 2-2h3c.6 0 1.25.2 1.7.7l.6 1.4c.15.4.15.8 0 1.2l-1.3 2.7c-.2.4.1.9.5 1.2l5 5c.4.4.8.7 1.2.5l2.7-1.3c.4-.2.8-.2 1.2 0l1.4.6c.5.4.7 1 .7 1.6v3z"/></svg>' }

// --- HELPER FUNCTION ---
const getColorClass = (type) => {
    switch (type) {
        // Updated accent color to purple for consistency with the image (Ubah Kata Sandi button/tabs)
        case 'accent': return 'bg-[#00C853] hover:bg-[#00A142] text-white';
        case 'light-accent-bg': return 'bg-[#00C853] border-l-4 border-l-green-400 text-purple-800';
        case 'tab-active-bg': return 'bg-[#00C853] text-dark';
        case 'icon-active': return 'text-dark';
        case 'icon-inactive': return 'text-gray-500';
        default: return '';
    }
};

// --- DUMMY DATA ---
const user = reactive({
    name: 'Admin',
    email: 'admin@evcharge.com',
});

// Data untuk 'Informasi Akun' (Demografis/Fisik)
const accountForm = reactive({
    name: user.name,
    gender: 'Laki-laki',
    birthDate: '23/09/1997',
    idType: 'KTP',
    idNumber: '8098765421216789',
    city: 'Kota Batam',
});

// Data untuk 'Informasi Personal' (Kontak/Verifikasi)
const personalForm = reactive({
    email: user.email,
    phone: '628217012451',
    isEmailVerified: true,
    isPhoneVerified: true,
});

// Default sidebar menu aktif
const activeMenu = ref('account');

// Default inner tab aktif (hanya berlaku saat activeMenu === 'account')
const activeTab = ref('informasi_akun');

// Menu Items untuk Sidebar Navigation (Updated for Admin)
const menuItems = computed(() => [
    { id: 'account', label: 'Akun', icon: IconUser, route: '#account' },
    { id: 'orders', label: 'Daftar Pesanan', icon: IconTicket, route: '/admin/orders' },
    { id: 'partners', label: 'List Partner', icon: IconTag, route: '/admin/partners' },
    { id: 'reports', label: 'Laporan', icon: IconNews, route: '/admin/reports' },
    { id: 'logout', label: 'Keluar', icon: IconLogout, route: '/logout' },
]);

// --- FUNGSI UTAMA ---

const submitProfile = () => {
    // Fungsi ini akan dipanggil saat tombol di klik (Ubah Kata Sandi/Ubah Profil)
    if (activeTab.value === 'informasi_akun') {
        console.log('Mengirim data Informasi Akun:', accountForm);
        alert('Perubahan Informasi Akun berhasil disimpan (Simulasi)');
    } else if (activeTab.value === 'informasi_personal') {
        // Untuk Informasi Personal, tombol utama diubah menjadi 'Ubah Kata Sandi' di UI,
        // sehingga form submission ini mungkin lebih cocok untuk menyimpan data kontak
        // atau untuk mengarahkan ke halaman ubah kata sandi (diumulasikan di bawah).
        console.log('Mengirim data Informasi Personal:', personalForm);
        alert('Mengalihkan ke halaman Ubah Kata Sandi (Simulasi)');
    }
};

const handleLogout = () => {
    console.log('User logging out...');
    alert('Anda telah keluar (Simulasi)');
    // router.visit('/logout');
};

// Placeholder data for admin menus
const orders = ref([
    { id: 1, title: 'Pesanan - Pengisian di Station A', date: '2025-10-10', status: 'Selesai', user: 'User1' },
    { id: 2, title: 'Pesanan - Pengisian di Station B', date: '2025-10-12', status: 'Dalam Proses', user: 'User2' },
]);

const partners = ref([
    { id: 1, name: 'Partner A', location: 'Batam', status: 'Active' },
    { id: 2, name: 'Partner B', location: 'Jakarta', status: 'Inactive' },
]);

const reports = ref([
    { id: 1, title: 'Laporan Bulanan', date: '2025-10-01', type: 'Revenue' },
    { id: 2, title: 'Laporan Pengguna', date: '2025-10-05', type: 'User Activity' },
]);

// Simple password change state (simulasi)
const passwordForm = reactive({ current: '', password: '', confirm: '' });
const changePassword = () => {
    if (!passwordForm.current || !passwordForm.password) {
        alert('Mohon isi semua field kata sandi (Simulasi)');
        return;
    }
    if (passwordForm.password !== passwordForm.confirm) {
        alert('Konfirmasi kata sandi tidak cocok');
        return;
    }
    console.log('Menyimpan kata sandi baru (simulasi)', passwordForm.password);
    alert('Kata sandi berhasil diubah (Simulasi)');
    passwordForm.current = '';
    passwordForm.password = '';
    passwordForm.confirm = '';
};
</script>

<template>
<div class="min-h-screen bg-gray-50 font-inter flex flex-col text-gray-700">

    <!-- AppNavbar -->
    <AppNavbar />

    <!-- Konten Utama (Sidebar + Main Content) -->
    <main class="flex-1 max-w-7xl mx-auto w-full p-6 flex flex-col md:flex-row md:space-x-8 space-y-6 md:space-y-0">

        <!-- Sidebar Navigation -->
    <aside class="w-full md:w-64 bg-white shadow-lg rounded-xl p-5 flex flex-col h-fit md:sticky md:top-6">
            <div class="mb-6 leading-tight">
                <div class="text-lg font-bold text-gray-900">{{ user.name }}</div>
                <div class="text-sm text-gray-500">{{ user.email }}</div>
            </div>

            <nav class="flex flex-col w-full space-y-1">
                <template v-for="item in menuItems" :key="item.id">
                    <button
                        @click="item.id === 'logout' ? handleLogout() : activeMenu = item.id"
                        class="flex items-center w-full px-3 py-2 rounded-lg text-left transition-all duration-150"
                        :class="[
                            item.id === activeMenu
                                ? 'bg-[#DAE200] text-dark font-semibold'
                                : 'text-gray-700 hover:bg-gray-100',
                            // Menangani tombol keluar secara visual
                            item.id === 'logout' ? 'text-red-500 hover:bg-red-50' : ''
                        ]"
                    >
                        <component :is="item.icon" class="w-5 h-5 mr-3"
                            :class="[item.id === activeMenu ? 'text-purple-600' : 'text-gray-500',
                                    item.id === 'logout' ? 'text-red-500' : '']" />
                        <span class="truncate">{{ item.label }}</span>
                    </button>
                </template>
            </nav>
        </aside>

        <!-- Main Content (Detail Akun) -->
        <section class="flex-1 bg-white shadow-xl rounded-xl p-8">

            <!-- Content Header -->
            <div class="mb-8" v-if="activeMenu === 'account'">
                <h1 class="text-2xl font-bold text-gray-900">Detail Akun</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola informasi akun dan data personal Anda.</p>
            </div>

            <!-- TAB CONTENT CONTAINER -->
            <div v-if="activeMenu === 'account'">

                <!-- Tab Headers & Button -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center pb-4 mb-6 border-b border-gray-200">
                    <div class="flex flex-wrap gap-4 items-center">
                        <!-- Tabs -->
                        <button
                            @click="activeTab = 'informasi_akun'"
                            :class="['flex items-center justify-center w-full md:w-auto gap-2 py-2 px-4 font-semibold rounded-lg transition duration-150',
                                    activeTab === 'informasi_akun' ? getColorClass('accent') : 'text-gray-500 hover:bg-gray-100']">
                            Informasi Akun
                        </button>
                        <button
                            @click="activeTab = 'informasi_personal'"
                            :class="['flex items-center justify-center w-full md:w-auto gap-2 py-2 px-4 font-semibold rounded-lg transition duration-150',
                                    activeTab === 'informasi_personal' ? getColorClass('accent') : 'text-gray-500 hover:bg-gray-100']">
                            Informasi Personal
                        </button>
                    </div>

                    <!-- UBAH KATA SANDI Button (Sesuai Gambar) -->
                    <button type="submit" @click.prevent="submitProfile"
                            :class="['mt-4 md:mt-0 w-full md:w-auto px-6 py-2.5 text-sm font-bold rounded-lg transition duration-150 ease-in-out shadow-md', getColorClass('accent')]">
                        {{ activeTab === 'informasi_akun' ? 'SIMPAN PERUBAHAN' : 'UBAH KATA SANDI' }}
                    </button>
                </div>

                <!-- Tabbed Form Content -->
                <form @submit.prevent="submitProfile" id="profile-form" class="space-y-6">

                    <!-- Tab Content: Informasi Akun (Demografis & Identitas) -->
                    <div v-if="activeTab === 'informasi_akun'">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            <!-- Nama Lengkap -->
                            <div class="col-span-1">
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                    <IconUserSmall class="w-4 h-4 mr-1 text-green-600" /> Nama Lengkap
                                </label>
                                <input type="text" v-model="accountForm.name" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-1  focus:ring-lime-500 focus:border-lime-500 transition duration-150" />
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="col-span-1">
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                    <IconUserSmall class="w-4 h-4 mr-1 text-purple-600" /> Jenis Kelamin
                                </label>
                                <select v-model="accountForm.gender" class="w-full border border-gray-300 rounded-lg p-3 bg-white focus:outline-none focus:ring-1  focus:ring-lime-500 focus:border-lime-500  transition duration-150">
                                    <option>Laki-laki</option>
                                    <option>Perempuan</option>
                                </select>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="col-span-1">
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                    <IconCalendar class="w-4 h-4 mr-1 text-purple-600" /> Tanggal Lahir
                                </label>
                                <input type="text" v-model="accountForm.birthDate" placeholder="DD/MM/YYYY" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-1  focus:ring-lime-500 focus:border-lime-500  transition duration-150" />
                            </div>

                            <!-- Jenis ID -->
                            <div class="col-span-1">
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                    <IconIdCard class="w-4 h-4 mr-1 text-purple-600" /> Jenis ID
                                </label>
                                <select v-model="accountForm.idType" class="w-full border border-gray-300 rounded-lg p-3 bg-white  focus:ring-lime-500 focus:border-lime-500  transition duration-150">
                                    <option>KTP</option>
                                    <option>SIM</option>
                                    <option>Paspor</option>
                                </select>
                            </div>

                            <!-- Nomor Identitas -->
                            <div class="col-span-1">
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                    <IconIdCard class="w-4 h-4 mr-1 text-purple-600" /> Nomor Identitas
                                </label>
                                <input type="text" v-model="accountForm.idNumber" class="w-full border border-gray-300 rounded-lg p-3  focus:ring-lime-500 focus:border-lime-500  transition duration-150" />
                            </div>

                            <!-- Kota Asal -->
                            <div class="col-span-1">
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                    <IconMapPin class="w-4 h-4 mr-1 text-purple-600" /> Kota Asal
                                </label>
                                <select v-model="accountForm.city" class="w-full border border-gray-300 rounded-lg p-3 bg-white  focus:ring-lime-500 focus:border-lime-500 transition duration-150">
                                    <option>Kota Batam</option>
                                    <option>Surabaya</option>
                                    <option>Jakarta</option>
                                </select>
                            </div>
                        </div>

                        <!-- Privasi & Keamanan Data (Kotak Kuning/Purple) -->
                        <div :class="['mt-8 p-6 rounded-lg shadow-inner', 'bg-yellow-50 border border-yellow-200 text-yellow-800']">
                            <div class="flex items-start gap-3">
                                <IconLockOpen class="w-6 h-6 text-yellow-700 flex-shrink-0 mt-1"/>
                                <div>
                                    <h4 class="font-bold text-yellow-800">Privasi & Keamanan Data</h4>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        Data personal Anda dienkripsi dan hanya digunakan untuk verifikasi identitas serta keperluan transaksi.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content: Informasi Personal (Kontak & Verifikasi) -->
                    <div v-else-if="activeTab === 'informasi_personal'" class="space-y-6">

                        <!-- Alamat Email -->
                        <div class="border-l-4 border-green-400 pl-4 py-2">
                            <label class="flex items-center text-sm font-bold text-gray-700 mb-2">
                                <IconMail class="w-4 h-4 mr-1 text-green-600" /> Alamat Email
                            </label>
                            <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-gray-300">
                                <input type="email" v-model="personalForm.email" class="font-medium w-full border-0 focus:ring-0 p-0" :disabled="personalForm.isEmailVerified"/>
                                <span v-if="personalForm.isEmailVerified"
                                    :class="['text-xs font-semibold flex items-center gap-1 text-green-600 bg-green-50 px-2 py-0.5 rounded-full']">
                                    <IconCheckCircle class="w-3 h-3"/> Verified
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 ml-1">
                                * Email Anda telah diverifikasi dan aktif untuk menerima notifikasi.
                            </p>
                        </div>

                         <!-- Nomor Handphone -->
                        <div class="border-l-4 border-green-400 pl-4 py-2">
                            <label class="flex items-center text-sm font-bold text-gray-700 mb-2">
                                <IconPhone class="w-4 h-4 mr-1 text-green-600" /> Nomor Handphone
                            </label>
                            <div class="flex items-center justify-between bg-white rounded-lg border border-gray-300 pr-3">
                                <!-- Input -->
                                <input type="text" v-model="personalForm.phone" class="font-medium w-full border-0 focus:ring-0 p-3"/>

                                <div class="flex items-center gap-3">
                                    <!-- Status Verifikasi -->
                                    <span v-if="personalForm.isPhoneVerified"
                                        :class="['text-xs font-semibold flex items-center gap-1 text-green-600 bg-green-50 px-2 py-0.5 rounded-full']">
                                        <IconCheckCircle class="w-3 h-3"/> Verified
                                    </span>
                                    <button type="button"
                                            class="px-4 py-2 bg-green-50 text-dark text-sm font-semibold rounded-lg hover:bg-purple-100 transition duration-150">
                                        Ubah Nomor
                                    </button>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 ml-1">
                                * Nomor HP digunakan untuk autentikasi dan notifikasi penting.
                            </p>
                        </div>

                        <!-- Akun Anda Terlindungi Alert -->
                        <div class="mt-6 bg-green-50 border border-green-200 rounded-xl p-5 flex items-start gap-4">
                            <IconLockOpen class="w-6 h-6 text-green-700 flex-shrink-0 mt-1"/>
                            <div>
                                <h3 class="font-bold text-green-800">Akun Anda Terlindungi</h3>
                                <p class="text-sm text-green-700 mt-1">
                                    Kedua metode verifikasi aktif. Kami merekomendasikan untuk mengubah kata sandi secara berkala
                                    dan mengaktifkan autentikasi dua faktor untuk keamanan maksimal.
                                </p>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <!-- Other Menu Contents -->
            <div v-else>
                <!-- Daftar Pesanan -->
                <div v-if="activeMenu === 'orders'">
                    <h2 class="text-xl font-bold mb-4">Daftar Pesanan</h2>
                    <div class="space-y-3">
                        <div v-for="o in orders" :key="o.id" class="p-4 border rounded-lg flex justify-between items-center">
                            <div>
                                <div class="font-semibold">{{ o.title }}</div>
                                <div class="text-xs text-gray-500">{{ o.date }} - {{ o.user }}</div>
                            </div>
                            <div class="text-sm font-semibold" :class="o.status === 'Selesai' ? 'text-green-600' : 'text-yellow-600'">{{ o.status }}</div>
                        </div>
                    </div>
                </div>

                <!-- List Partner -->
                <div v-else-if="activeMenu === 'partners'">
                    <h2 class="text-xl font-bold mb-4">List Partner</h2>
                    <div class="space-y-3">
                        <div v-for="p in partners" :key="p.id" class="p-4 border rounded-lg flex justify-between items-center">
                            <div>
                                <div class="font-semibold">{{ p.name }}</div>
                                <div class="text-sm text-gray-600">{{ p.location }}</div>
                            </div>
                            <div class="text-sm font-semibold" :class="p.status === 'Active' ? 'text-green-600' : 'text-red-600'">{{ p.status }}</div>
                        </div>
                    </div>
                </div>

                <!-- Laporan -->
                <div v-else-if="activeMenu === 'reports'">
                    <h2 class="text-xl font-bold mb-4">Laporan</h2>
                    <div class="space-y-3">
                        <div v-for="r in reports" :key="r.id" class="p-4 border rounded-lg">
                            <div class="font-semibold">{{ r.title }}</div>
                            <div class="text-sm text-gray-600">{{ r.date }} - {{ r.type }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- AppFooter -->
    <AppFooter />
</div>
</template>

<style>
/* Memuat font Inter untuk estetika yang lebih baik */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
.font-inter {
    font-family: 'Inter', sans-serif;
}
input[disabled] {
    background-color: #f9fafb !important;
    color: #4b5563 !important;
    cursor: default; /* Menggunakan default karena sudah tidak menggunakan bg-gray-50 */
}
</style>
