<template>
  <div class="min-h-screen flex items-center justify-center p-4 bg-gray-50 bg-ev-pattern">
    <div class="w-full max-w-lg bg-white rounded-xl shadow-2xl p-8 z-10">
      
      <div class="text-center mb-6">
        <h1 class="text-2xl font-extrabold text-green-600">EV-VOLT</h1> 
      </div>
      
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">
        Join & Connect the Fastest Growing Online Community
      </h2>

      <form @submit.prevent="submit" class="space-y-4">
        
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
          <input
            id="username"
            type="text"
            v-model="form.username"
            required
            autocomplete="username"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
          />
          <p v-if="form.errors.username" class="text-sm text-red-600 mt-1">{{ form.errors.username }}</p>
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            id="email"
            type="email"
            v-model="form.email"
            required
            autocomplete="email"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
          />
          <p v-if="form.errors.email" class="text-sm text-red-600 mt-1">{{ form.errors.email }}</p>
        </div>

        <div>
          <label for="nomor_plat" class="block text-sm font-medium text-gray-700">Nomor Plat</label>
          <input
            id="nomor_plat"
            type="text"
            v-model="form.nomor_plat"
            required
            autocomplete="off"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
            placeholder="Contoh: BP 1234 XY"
          />
          <p v-if="form.errors.nomor_plat" class="text-sm text-red-600 mt-1">{{ form.errors.nomor_plat }}</p>
        </div>

        <div>
          <label for="nomor_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
          <input
            id="nomor_telepon"
            type="tel"
            v-model="form.nomor_telepon"
            required
            autocomplete="tel"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
            placeholder="Contoh: 08123456789"
          />
          <p v-if="form.errors.nomor_telepon" class="text-sm text-red-600 mt-1">{{ form.errors.nomor_telepon }}</p>
        </div>

        <div>
          <label for="captcha" class="block text-sm font-medium text-gray-700">Captcha</label>
          <div class="flex space-x-2 mt-1">
            <div class="flex-shrink-0 w-32 h-10 bg-gray-200 border border-gray-300 rounded-md flex items-center justify-center text-gray-500 italic text-sm">
              [Gambar Captcha]
            </div>
            <input
              id="captcha"
              type="text"
              v-model="form.captcha"
              required
              autocomplete="off"
              class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
              placeholder="Masukkan kode di samping"
            />
          </div>
          <p v-if="form.errors.captcha" class="text-sm text-red-600 mt-1">{{ form.errors.captcha }}</p>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <div class="relative">
            <input
              id="password"
              :type="showPassword ? 'text' : 'password'"
              v-model="form.password"
              required
              autocomplete="new-password"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm pr-10"
            />
            <button
              type="button"
              @click="togglePasswordVisibility"
              class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
            >
              <span class="text-gray-500">{{ showPassword ? '🙈' : '👁️' }}</span>
            </button>
          </div>
          <p v-if="form.errors.password" class="text-sm text-red-600 mt-1">{{ form.errors.password }}</p>
        </div>
        
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Password Confirmation</label>
          <input
            id="password_confirmation"
            type="password"
            v-model="form.password_confirmation"
            required
            autocomplete="new-password"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
          />
        </div>
        <div class="flex items-center">
          <input
            id="terms"
            name="terms"
            type="checkbox"
            v-model="form.terms"
            required
            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
          />
          <label for="terms" class="ml-2 block text-sm text-gray-900">
            I accept the <span class="text-green-600 hover:text-green-500 cursor-pointer">terms & Condition</span>
          </label>
        </div>

        <div>
          <button
            type="submit"
            :disabled="form.processing || !form.terms"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 disabled:opacity-50 transition duration-150"
          >
            SIGN UP
          </button>
        </div>
      </form>

      <div class="mt-6 text-center text-sm">
        <p>
          Own an Account?
          <Link :href="route('login')" class="font-medium text-green-600 hover:text-green-500">
            JUMP RIGHT IN
          </Link>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
// 1. Impor 'Link' dan 'router'
import { useForm, Link, router } from '@inertiajs/vue3';

// Perbarui form state untuk mencakup SEMUA kolom
const form = useForm({
    username: '',
    email: '',
    nomor_plat: '',
    nomor_telepon: '',
    captcha: '',
    password: '',
    password_confirmation: '', // <-- TAMBAHKAN INI
    terms: false,
});

const showPassword = ref(false);

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};

const submit = () => {
    form.post(route('register'), {
        // PERBARUI INI: Reset kedua bidang password
        onFinish: () => form.reset('password', 'password_confirmation'),
        
        onSuccess: () => {
            router.visit(route('login'));
        }
    });
};
</script>

<style scoped>
/* 1. Definisikan custom utility class untuk latar belakang
  2. Ganti 'path/to/image-4.jpg' dan 'path/to/image-5.jpg' dengan lokasi gambar Anda yang sebenarnya.
  3. Menggunakan dua gambar dalam satu `background-image` menggunakan `url()` yang dipisahkan koma.
*/

.bg-ev-pattern {
    /* Gunakan URL gambar Anda di sini. Sesuaikan jalurnya! */
    background-image: url('/images/image5.png'), url('/images/image4.png'); 
    background-position: left center, right center; /* Atur posisi masing-masing gambar */
    background-repeat: no-repeat, no-repeat; /* Jangan ulangi gambar */
    background-size: contain; /* Sesuaikan ukuran gambar agar muat di elemen */
    /* Tambahkan efek overlay semi-transparan (misalnya, putih) untuk memastikan teks formulir tetap terbaca */
    /* background-color: rgba(255, 255, 255, 0.7); */
}

/* Gaya tambahan dari contoh sebelumnya untuk warna */
.bg-yellow-500 {
    background-color: #f6e05e;
}
.hover\:bg-yellow-600:hover {
    background-color: #ecc94b;
}
.text-green-600 {
    color: #38a169;
}
</style>