<script setup>
import { ref, reactive, computed } from "vue";
import { usePage, useForm, router } from "@inertiajs/vue3";
import Navbar from '@/Components/NavbarUser.vue';
import Footer from '@/Components/Footer.vue';

const page = usePage();
const authUser = page.props.auth?.user || {};
const user = reactive({
  name: authUser.name || "",
  email: authUser.email || "",
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

// === INERTIA FORM HANDLER ===
const form = useForm({
  name: user.name || '',
  email: user.email || '',
  phone: user.phone || '',
  address: user.address || '',
})

// Default inner tab aktif (hanya berlaku saat activeMenu === 'account')
const activeTab = ref('informasi_akun');

// Menu Items untuk Sidebar Navigation
const menuItems = computed(() => [
  { id: "account", label: "Akun", icon: "👤" },
  { id: "orders", label: "Pesanan Saya", icon: "🎟️" },
  { id: "news", label: "Berita", icon: "📰" },
  { id: "promo", label: "Promo", icon: "🏷️" },
  { id: "cancellation", label: "Pembatalan Tiket", icon: "⏰" },
  { id: "password", label: "Ubah Kata Sandi", icon: "🔑" },
  { id: "logout", label: "Keluar", icon: "🚪" },
]);

// --- FUNGSI UTAMA ---

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

// === HELPER ===
const getColorClass = (type) => {
  switch (type) {
    case "accent":
      return "bg-[#00C853] hover:bg-[#00A142] text-white";
    default:
      return "";
  }
};

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
  <div class="min-h-screen bg-gray-50 font-inter flex flex-col text-gray-700">

    <!-- Navbar -->
    <Navbar />

    <main
      class="flex-1 max-w-7xl mx-auto w-full p-6 flex flex-col md:flex-row md:space-x-8 space-y-6 md:space-y-0 pt-24">
      <!-- SIDEBAR -->
      <aside class="w-full md:w-64 bg-white shadow-lg rounded-xl p-5 flex flex-col h-fit md:sticky md:top-6">
        <div class="mb-6">
          <div class="text-lg font-bold">{{ user.name }}</div>
          <div class="text-sm text-gray-500">{{ user.email }}</div>
        </div>

        <nav class="flex flex-col space-y-1">
          <template v-for="item in menuItems" :key="item.id">
            <button @click="
              item.id === 'logout'
                ? handleLogout()
                : (activeMenu = item.id)
              " :class="[
                'flex items-center gap-2 px-3 py-2 rounded-lg text-left transition-all duration-150',
                item.id === activeMenu
                  ? 'bg-[#DAE200] text-dark font-semibold'
                  : 'text-gray-700 hover:bg-gray-100',
                item.id === 'logout' ? 'text-red-500 hover:bg-red-50' : '',
              ]">
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
            <button @click="activeTab = 'informasi_akun'" :class="[
              'px-4 py-2 rounded-lg font-semibold transition',
              activeTab === 'informasi_akun'
                ? getColorClass('accent')
                : 'hover:bg-gray-100',
            ]">
              Informasi Akun
            </button>
            <button @click="activeTab = 'informasi_personal'" :class="[
              'px-4 py-2 rounded-lg font-semibold transition',
              activeTab === 'informasi_personal'
                ? getColorClass('accent')
                : 'hover:bg-gray-100',
            ]">
              Informasi Personal
            </button>
          </div>

          <!-- Form -->
          <form @submit.prevent="submitProfile" class="space-y-6">
            <div v-if="activeTab === 'informasi_akun'">
              <div class="grid sm:grid-cols-2 gap-4">
                <div>
                  <label class="text-sm font-medium">Nama Lengkap</label>
                  <input v-model="accountForm.name" type="text" class="w-full border rounded-lg p-3" />
                </div>
                <div>
                  <label class="text-sm font-medium">Jenis Kelamin</label>
                  <select v-model="accountForm.gender" class="w-full border rounded-lg p-3">
                    <option>Laki-laki</option>
                    <option>Perempuan</option>
                  </select>
                </div>
                <div>
                  <label class="text-sm font-medium">Tanggal Lahir</label>
                  <input v-model="accountForm.birthDate" placeholder="DD/MM/YYYY"
                    class="w-full border rounded-lg p-3" />
                </div>
                <div>
                  <label class="text-sm font-medium">Jenis ID</label>
                  <select v-model="accountForm.idType" class="w-full border rounded-lg p-3">
                    <option>KTP</option>
                    <option>SIM</option>
                    <option>Paspor</option>
                  </select>
                </div>
                <div>
                  <label class="text-sm font-medium">Nomor ID</label>
                  <input v-model="accountForm.idNumber" type="text" class="w-full border rounded-lg p-3" />
                </div>
                <div>
                  <label class="text-sm font-medium">Kota Asal</label>
                  <select v-model="accountForm.city" class="w-full border rounded-lg p-3">
                    <option>Kota Batam</option>
                    <option>Jakarta</option>
                    <option>Surabaya</option>
                  </select>
                </div>
              </div>

              <button type="submit" :class="[
                'mt-6 px-6 py-2.5 font-bold rounded-lg shadow-md',
                getColorClass('accent'),
              ]">
                Simpan Perubahan
              </button>
            </div>

            <div v-else-if="activeTab === 'informasi_personal'" class="space-y-4">
              <div>
                <label class="text-sm font-medium">Email</label>
                <input v-model="personalForm.email" type="email" class="w-full border rounded-lg p-3" disabled />
              </div>
              <div>
                <label class="text-sm font-medium">Nomor HP</label>
                <input v-model="personalForm.phone" type="text" class="w-full border rounded-lg p-3" />
              </div>

              <button type="submit" :class="[
                'mt-4 px-6 py-2.5 font-bold rounded-lg shadow-md',
                getColorClass('accent'),
              ]">
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

        <!-- PEMBATALAN -->
        <div v-else-if="activeMenu === 'cancellation'">
          <h2 class="text-xl font-bold mb-4">Daftar Pembatalan</h2>
          <div v-for="c in cancellations" :key="c.id" class="border rounded p-3 mb-2">
            <div>{{ c.order }}</div>
            <div class="text-sm text-gray-500">
              {{ c.reason }} — {{ c.date }}
            </div>
          </div>
        </div>

        <!-- UBAH PASSWORD -->
        <div v-else-if="activeMenu === 'password'">
          <h2 class="text-xl font-bold mb-4">Ubah Kata Sandi</h2>
          <form @submit.prevent="changePassword" class="space-y-3 max-w-md">
            <div>
              <label class="text-sm font-medium">Kata Sandi Saat Ini</label>
              <input type="password" v-model="passwordForm.current" class="w-full border p-3 rounded mt-1" />
            </div>
            <div>
              <label class="text-sm font-medium">Kata Sandi Baru</label>
              <input type="password" v-model="passwordForm.password" class="w-full border p-3 rounded mt-1" />
            </div>
            <div>
              <label class="text-sm font-medium">Konfirmasi Kata Sandi</label>
              <input type="password" v-model="passwordForm.confirm" class="w-full border p-3 rounded mt-1" />
            </div>
            <button type="submit" class="px-4 py-2 rounded bg-[#00C853] text-white font-semibold">
              Simpan
            </button>
          </form>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap");

.font-inter {
  font-family: "Inter", sans-serif;
}
</style>
