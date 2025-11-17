<script setup>
import { ref, reactive, computed } from "vue";
import { usePage, useForm, router } from "@inertiajs/vue3";
import AppNavbar from "@/Components/AppNavbar.vue";
import AppFooter from "@/Components/AppFooter.vue";

<<<<<<< HEAD:resources/js/Pages/Profile.vue
// === PROPS & USER DATA ===
const props = defineProps({
  user: {
    type: Object,
    default: () => ({}),
  },
});
=======
import Navbar from '@/Components/NavbarUser.vue';
import Footer from '@/Components/Footer.vue';
// --- MOCK COMPONENTS (Untuk memastikan file dapat berjalan secara mandiri) ---
>>>>>>> cf521377e199df46e7c640f00151f3157f0aac62:resources/js/Pages/user/UserProfile.vue

const page = usePage();
const authUser = page.props.auth?.user || {};
const user = reactive({
  name: props.user?.name || authUser.name || "",
  email: props.user?.email || authUser.email || "",
});

// === FORM DATA ===
const accountForm = reactive({
  name: user.name,
  gender: "Laki-laki",
  birthDate: "",
  idType: "",
  idNumber: "",
  city: "",
});

const personalForm = reactive({
  email: user.email,
  phone: "",
  isEmailVerified: true,
  isPhoneVerified: true,
});

const passwordForm = reactive({ current: "", password: "", confirm: "" });

<<<<<<< HEAD:resources/js/Pages/Profile.vue
// === INERTIA FORM HANDLER ===
const form = useForm({
  name: user.name || '',
  email: user.email || '',
  phone: user.phone || '',
  address: user.address || '',
})
=======
// Default inner tab aktif (hanya berlaku saat activeMenu === 'account')
const activeTab = ref('informasi_akun'); 

// Menu Items untuk Sidebar Navigation
const menuItems = computed(() => [
    { id: 'account', label: 'Akun', icon: IconUser, route: '#account' },
    { id: 'orders', label: 'Pesanan saya', icon: IconTicket, route: '/orders' },
    { id: 'promo', label: 'Promo', icon: IconTag, route: '/promos' },
    { id: 'cancellation', label: 'Daftar Pembatalan Tiket', icon: IconClock, route: '/cancellation' },
    { id: 'password', label: 'Ubah Kata Sandi', icon: IconKey, route: '/change-password' },
    { id: 'logout', label: 'Keluar', icon: IconLogout, route: '/logout' },
]);

// --- FUNGSI UTAMA ---
>>>>>>> cf521377e199df46e7c640f00151f3157f0aac62:resources/js/Pages/user/UserProfile.vue

const submitProfile = () => {
  form.put(route("profile.update"), {
    onSuccess: () => alert("Profil berhasil diperbarui!"),
    onError: (errors) => console.error(errors),
  });
};

const changePassword = () => {
  if (!passwordForm.current || !passwordForm.password) {
    alert("Mohon isi semua field kata sandi!");
    return;
  }
  if (passwordForm.password !== passwordForm.confirm) {
    alert("Konfirmasi kata sandi tidak cocok!");
    return;
  }
  alert("Kata sandi berhasil diubah (simulasi)");
  Object.assign(passwordForm, { current: "", password: "", confirm: "" });
};

const handleLogout = () => {
  router.post(route("logout"));
};

// === UI STATE ===
const activeMenu = ref("account");
const activeTab = ref("informasi_akun");

// === HELPER ===
const getColorClass = (type) => {
  switch (type) {
    case "accent":
      return "bg-[#00C853] hover:bg-[#00A142] text-white";
    default:
      return "";
  }
};

// === SIDEBAR MENU ===
const menuItems = computed(() => [
  { id: "account", label: "Akun", icon: "👤" },
  { id: "orders", label: "Pesanan Saya", icon: "🎟️" },
  { id: "news", label: "Berita", icon: "📰" },
  { id: "promo", label: "Promo", icon: "🏷️" },
  { id: "cancellation", label: "Pembatalan Tiket", icon: "⏰" },
  { id: "password", label: "Ubah Kata Sandi", icon: "🔑" },
  { id: "logout", label: "Keluar", icon: "🚪" },
]);

// === DUMMY DATA ===
const orders = ref([
  { id: 1, title: "Pesanan Station A", date: "2025-10-10", status: "Selesai" },
  { id: 2, title: "Pesanan Station B", date: "2025-10-12", status: "Proses" },
]);

const newsList = ref([
  { id: 1, title: "Rilis Fitur Baru", excerpt: "Reservasi stasiun kini tersedia!" },
  { id: 2, title: "Promo Musim Panas", excerpt: "Diskon 30% jam non-peak." },
]);

const promos = ref([{ id: 1, code: "HALOEV", desc: "Diskon 10% pengguna baru" }]);

const cancellations = ref([
  { id: 1, order: "Pesanan #2", reason: "Perubahan jadwal", date: "2025-09-20" },
]);
</script>

<template>
<<<<<<< HEAD:resources/js/Pages/Profile.vue
  <div class="min-h-screen bg-gray-50 font-inter flex flex-col text-gray-700">
    <AppNavbar />
=======
<div class="min-h-screen bg-gray-50 font-inter flex flex-col text-gray-700">
    
    <!-- Navbar -->
    <Navbar /> 
>>>>>>> cf521377e199df46e7c640f00151f3157f0aac62:resources/js/Pages/user/UserProfile.vue

    <main
      class="flex-1 max-w-7xl mx-auto w-full p-6 flex flex-col md:flex-row md:space-x-8 space-y-6 md:space-y-0"
    >
      <!-- SIDEBAR -->
      <aside
        class="w-full md:w-64 bg-white shadow-lg rounded-xl p-5 flex flex-col h-fit md:sticky md:top-6"
      >
        <div class="mb-6">
          <div class="text-lg font-bold">{{ user.name }}</div>
          <div class="text-sm text-gray-500">{{ user.email }}</div>
        </div>

        <nav class="flex flex-col space-y-1">
          <template v-for="item in menuItems" :key="item.id">
            <button
              @click="
                item.id === 'logout'
                  ? handleLogout()
                  : (activeMenu = item.id)
              "
              :class="[
                'flex items-center gap-2 px-3 py-2 rounded-lg text-left transition-all duration-150',
                item.id === activeMenu
                  ? 'bg-[#DAE200] text-dark font-semibold'
                  : 'text-gray-700 hover:bg-gray-100',
                item.id === 'logout' ? 'text-red-500 hover:bg-red-50' : '',
              ]"
            >
              <span>{{ item.icon }}</span>
              <span>{{ item.label }}</span>
            </button>
          </template>
        </nav>
      </aside>

      <!-- MAIN CONTENT -->
      <section class="flex-1 bg-white shadow-xl rounded-xl p-8">
        <!-- MENU: AKUN -->
        <div v-if="activeMenu === 'account'">
          <h1 class="text-2xl font-bold mb-4">Detail Akun</h1>

          <!-- Tabs -->
          <div class="flex flex-wrap gap-3 mb-6 border-b pb-4">
            <button
              @click="activeTab = 'informasi_akun'"
              :class="[
                'px-4 py-2 rounded-lg font-semibold transition',
                activeTab === 'informasi_akun'
                  ? getColorClass('accent')
                  : 'hover:bg-gray-100',
              ]"
            >
              Informasi Akun
            </button>
            <button
              @click="activeTab = 'informasi_personal'"
              :class="[
                'px-4 py-2 rounded-lg font-semibold transition',
                activeTab === 'informasi_personal'
                  ? getColorClass('accent')
                  : 'hover:bg-gray-100',
              ]"
            >
              Informasi Personal
            </button>
          </div>

          <!-- Form -->
          <form @submit.prevent="submitProfile" class="space-y-6">
            <div v-if="activeTab === 'informasi_akun'">
              <div class="grid sm:grid-cols-2 gap-4">
                <div>
                  <label class="text-sm font-medium">Nama Lengkap</label>
                  <input
                    v-model="accountForm.name"
                    type="text"
                    class="w-full border rounded-lg p-3"
                  />
                </div>
                <div>
                  <label class="text-sm font-medium">Jenis Kelamin</label>
                  <select
                    v-model="accountForm.gender"
                    class="w-full border rounded-lg p-3"
                  >
                    <option>Laki-laki</option>
                    <option>Perempuan</option>
                  </select>
                </div>
                <div>
                  <label class="text-sm font-medium">Tanggal Lahir</label>
                  <input
                    v-model="accountForm.birthDate"
                    placeholder="DD/MM/YYYY"
                    class="w-full border rounded-lg p-3"
                  />
                </div>
                <div>
                  <label class="text-sm font-medium">Jenis ID</label>
                  <select
                    v-model="accountForm.idType"
                    class="w-full border rounded-lg p-3"
                  >
                    <option>KTP</option>
                    <option>SIM</option>
                    <option>Paspor</option>
                  </select>
                </div>
                <div>
                  <label class="text-sm font-medium">Nomor ID</label>
                  <input
                    v-model="accountForm.idNumber"
                    type="text"
                    class="w-full border rounded-lg p-3"
                  />
                </div>
                <div>
                  <label class="text-sm font-medium">Kota Asal</label>
                  <select
                    v-model="accountForm.city"
                    class="w-full border rounded-lg p-3"
                  >
                    <option>Kota Batam</option>
                    <option>Jakarta</option>
                    <option>Surabaya</option>
                  </select>
                </div>
              </div>

              <button
                type="submit"
                :class="[
                  'mt-6 px-6 py-2.5 font-bold rounded-lg shadow-md',
                  getColorClass('accent'),
                ]"
              >
                Simpan Perubahan
              </button>
            </div>

            <div v-else-if="activeTab === 'informasi_personal'" class="space-y-4">
              <div>
                <label class="text-sm font-medium">Email</label>
                <input
                  v-model="personalForm.email"
                  type="email"
                  class="w-full border rounded-lg p-3"
                  disabled
                />
              </div>
              <div>
                <label class="text-sm font-medium">Nomor HP</label>
                <input
                  v-model="personalForm.phone"
                  type="text"
                  class="w-full border rounded-lg p-3"
                />
              </div>

              <button
                type="submit"
                :class="[
                  'mt-4 px-6 py-2.5 font-bold rounded-lg shadow-md',
                  getColorClass('accent'),
                ]"
              >
                Simpan
              </button>
            </div>
          </form>
        </div>

        <!-- PESANAN -->
        <div v-else-if="activeMenu === 'orders'">
          <h2 class="text-xl font-bold mb-4">Pesanan Saya</h2>
          <div v-for="o in orders" :key="o.id" class="border rounded p-3 mb-2">
            <div class="font-semibold">{{ o.title }}</div>
            <div class="text-xs text-gray-500">{{ o.date }}</div>
          </div>
        </div>

        <!-- BERITA -->
        <div v-else-if="activeMenu === 'news'">
          <h2 class="text-xl font-bold mb-4">Berita & Update</h2>
          <div v-for="n in newsList" :key="n.id" class="border rounded p-3 mb-2">
            <div class="font-semibold">{{ n.title }}</div>
            <p class="text-sm text-gray-600">{{ n.excerpt }}</p>
          </div>
        </div>

        <!-- PROMO -->
        <div v-else-if="activeMenu === 'promo'">
          <h2 class="text-xl font-bold mb-4">Promo</h2>
          <div v-for="p in promos" :key="p.id" class="border rounded p-3 mb-2">
            <div class="font-semibold">{{ p.code }}</div>
            <p>{{ p.desc }}</p>
          </div>
        </div>

<<<<<<< HEAD:resources/js/Pages/Profile.vue
        <!-- PEMBATALAN -->
        <div v-else-if="activeMenu === 'cancellation'">
          <h2 class="text-xl font-bold mb-4">Daftar Pembatalan</h2>
          <div v-for="c in cancellations" :key="c.id" class="border rounded p-3 mb-2">
            <div>{{ c.order }}</div>
            <div class="text-sm text-gray-500">
              {{ c.reason }} — {{ c.date }}
=======
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
                                            class="px-4 py-2 bg-green-50 text-dark text-sm font-semibold rounded-lg hover:bg-green-100 transition duration-150">
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
>>>>>>> cf521377e199df46e7c640f00151f3157f0aac62:resources/js/Pages/user/UserProfile.vue
            </div>
          </div>
        </div>

<<<<<<< HEAD:resources/js/Pages/Profile.vue
        <!-- UBAH PASSWORD -->
        <div v-else-if="activeMenu === 'password'">
          <h2 class="text-xl font-bold mb-4">Ubah Kata Sandi</h2>
          <form @submit.prevent="changePassword" class="space-y-3 max-w-md">
            <div>
              <label class="text-sm font-medium">Kata Sandi Saat Ini</label>
              <input
                type="password"
                v-model="passwordForm.current"
                class="w-full border p-3 rounded mt-1"
              />
=======

                <!-- Promo -->
                <div v-else-if="activeMenu === 'promo'">
                    <h2 class="text-xl font-bold mb-4">Promo Aktif</h2>
                    <div class="space-y-3">
                        <div v-for="p in promos" :key="p.id" class="p-4 border rounded-lg flex justify-between items-center">
                            <div>
                                <div class="font-semibold">{{ p.code }}</div>
                                <div class="text-sm text-gray-600">{{ p.desc }}</div>
                            </div>
                            <button class="px-3 py-1 bg-green-50 text-green-700 rounded">Salin Kode</button>
                        </div>
                    </div>
                </div>

                <!-- Daftar Pembatalan Tiket -->
                <div v-else-if="activeMenu === 'cancellation'">
                    <h2 class="text-xl font-bold mb-4">Daftar Pembatalan Tiket</h2>
                    <div class="space-y-3">
                        <div v-for="c in cancellations" :key="c.id" class="p-4 border rounded-lg">
                            <div class="font-semibold">{{ c.order }}</div>
                            <div class="text-sm text-gray-600">Alasan: {{ c.reason }} — {{ c.date }}</div>
                        </div>
                    </div>
                </div>

                <!-- Ubah Kata Sandi -->
                <div v-else-if="activeMenu === 'password'">
                    <h2 class="text-xl font-bold mb-4">Ubah Kata Sandi</h2>
                    <form @submit.prevent="changePassword" class="space-y-4 max-w-md">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Kata Sandi Saat Ini</label>
                            <input type="password" v-model="passwordForm.current" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-1  focus:ring-lime-500 focus:border-lime-500 transition duration-150"/>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Kata Sandi Baru</label>
                            <input type="password" v-model="passwordForm.password" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-1  focus:ring-lime-500 focus:border-lime-500 transition duration-150"/>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                            <input type="password" v-model="passwordForm.confirm" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-1  focus:ring-lime-500 focus:border-lime-500 transition duration-150" />
                        </div>
                        <div>
                            <button type="submit" class="px-4 py-2 rounded-lg bg-[#00C853] text-white font-semibold">Ubah Kata Sandi</button>
                        </div>
                    </form>
                </div>
>>>>>>> cf521377e199df46e7c640f00151f3157f0aac62:resources/js/Pages/user/UserProfile.vue
            </div>
            <div>
              <label class="text-sm font-medium">Kata Sandi Baru</label>
              <input
                type="password"
                v-model="passwordForm.password"
                class="w-full border p-3 rounded mt-1"
              />
            </div>
            <div>
              <label class="text-sm font-medium">Konfirmasi Kata Sandi</label>
              <input
                type="password"
                v-model="passwordForm.confirm"
                class="w-full border p-3 rounded mt-1"
              />
            </div>
            <button
              type="submit"
              class="px-4 py-2 rounded bg-[#00C853] text-white font-semibold"
            >
              Simpan
            </button>
          </form>
        </div>
      </section>
    </main>
<<<<<<< HEAD:resources/js/Pages/Profile.vue

    <AppFooter />
  </div>
=======
    
    <!-- Footer -->
    <Footer />
</div>
>>>>>>> cf521377e199df46e7c640f00151f3157f0aac62:resources/js/Pages/user/UserProfile.vue
</template>

<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap");
.font-inter {
  font-family: "Inter", sans-serif;
}
</style>
