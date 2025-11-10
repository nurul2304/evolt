<script setup>
import { ref } from 'vue';
// Import Link dan useForm dari Inertia
import { useForm, Link } from '@inertiajs/vue3'; 

// Menggunakan useForm untuk manajemen state form pendaftaran
const form = useForm({
  username: '', 
  email: '',
  password: '',
  password_confirmation: '', // Field standar untuk konfirmasi password
  terms: false,
});

const showPassword = ref(false);
const showConfirmation = ref(false); // State terpisah untuk konfirmasi password

const togglePasswordVisibility = (field) => {
    if (field === 'password') {
        showPassword.value = !showPassword.value;
    } else if (field === 'confirmation') {
        showConfirmation.value = !showConfirmation.value;
    }
};

// --- BAGIAN INI TELAH DIMODIFIKASI UNTUK FRONT-END SAJA ---
const submit = () => {
    // Cek apakah terms sudah dicentang
    if (!form.terms) {
        console.error('Harap setujui Syarat & Ketentuan.');
        return;
    }

    // Gantikan form.post(route('register'), ...) dengan konsol log
    console.log('--- Form Pendaftaran Berhasil Di-submit (Hanya Simulasi FE) ---');
    console.log('Data yang dikirim:', form.data());

    // Di lingkungan Front-End, kita bisa menambahkan penundaan kecil dan simulasi redirect
    form.processing = true; // Simulasikan loading
    
    setTimeout(() => {
        form.processing = false; // Matikan loading
        
        // Simulasikan berhasil dan pindah ke dashboard
        console.log('Simulasi pendaftaran berhasil. Anda seharusnya diarahkan ke /dashboard.');
        
        // Jika Anda ingin melihat apa yang terjadi setelah pendaftaran berhasil, 
        // Anda dapat menambahkan logika redirect front-end di sini (misalnya: window.location.href = '/dashboard')
        // Namun, karena ini Inertia, biarkan rute dikelola oleh backend nanti.
        
    }, 1000); // Tunggu 1 detik untuk simulasi loading
    // --- AKHIR MODIFIKASI ---
};
</script>

<template>
  <!-- Main container: Full screen, centered, with background image (matching Login.vue) -->
  <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 bg-gray-50 bg-[url('https://i.imgur.com/G323a2A.jpg')] bg-cover bg-center font-sans">
    
    <!-- Sign Up Card: Responsive card centered on screen -->
    <main class="w-full max-w-sm sm:max-w-xl bg-white rounded-3xl shadow-2xl p-6 sm:p-8 lg:p-10">
      
      <!-- Logo (Matching E-VOLT Style) -->
      <div class="text-center text-3xl font-bold mb-2">
        <span class="text-lime-500">E</span><span class="text-gray-700">-VOLT</span>
      </div>
      
      <h1 class="text-center text-xl sm:text-2xl font-semibold text-gray-800 mb-6">Join & Connect the Fastest Growing Online Community</h1>

      <!-- Social Login Buttons -->
      <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <button class="flex-1 flex items-center justify-center gap-2 p-3 border border-gray-300 rounded-lg bg-white text-gray-700 text-sm font-medium cursor-pointer hover:bg-gray-50 transition duration-150 shadow-sm">
          <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" class="w-5 h-5">
          <span>Sign up with Google</span>
        </button>
      </div>

      <!-- Separator -->
      <div class="flex items-center my-6">
        <hr class="flex-grow border-t border-gray-300">
        <span class="px-3 text-sm text-gray-500 font-medium">or</span>
        <hr class="flex-grow border-t border-gray-300">
      </div>

      <!-- Form Sign Up -->
      <form class="text-left space-y-4" @submit.prevent="submit">
        
        <!-- Error Message (Global form error, if any) -->
        <div v-if="form.errors.email || form.errors.username" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm font-medium" role="alert">
          {{ form.errors.email || form.errors.username }}
        </div>

        <!-- FORM FIELDS CONTAINER: Menggunakan grid 2 kolom di layar yang lebih besar (sm: dan ke atas) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 sm:gap-y-6 sm:gap-x-4"> 
            
            <!-- Username Input (Kolom 1) -->
            <div>
              <label for="username" class="block text-sm font-medium text-gray-700 mb-1.5">Username</label>
              <input type="text" id="username" name="username" v-model="form.username" required 
                    class="w-full p-3 text-base border border-gray-300 rounded-lg outline-none transition duration-200 focus:border-lime-500 focus:ring-4 focus:ring-lime-100"
                    autocomplete="username">
              <p v-if="form.errors.username" class="text-sm text-red-600 mt-1">{{ form.errors.username }}</p>
            </div>

            <!-- Email Input (Kolom 2) -->
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
              <input type="email" id="email" name="email" v-model="form.email" required 
                    class="w-full p-3 text-base border border-gray-300 rounded-lg outline-none transition duration-200 focus:border-lime-500 focus:ring-4 focus:ring-lime-100"
                    autocomplete="email">
              <p v-if="form.errors.email" class="text-sm text-red-600 mt-1">{{ form.errors.email }}</p>
            </div>

            <!-- Password Input (Kolom 1) -->
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
              <div class="relative">
                <input :type="showPassword ? 'text' : 'password'" id="password" name="password" v-model="form.password" required 
                      class="w-full p-3 text-base border border-gray-300 rounded-lg outline-none transition duration-200 focus:border-lime-500 focus:ring-4 focus:ring-lime-100"
                      autocomplete="new-password">
                
                <button type="button" @click="togglePasswordVisibility('password')"
                        class="absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition duration-150 p-0 flex items-center border-none bg-transparent">
                  <svg v-if="!showPassword" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                  <svg v-else class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243L6.228 6.228" /></svg>
                </button>
              </div>
              <p v-if="form.errors.password" class="text-sm text-red-600 mt-1">{{ form.errors.password }}</p>
            </div>

            <!-- Password Confirmation Input (Kolom 2) -->
            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password</label>
              <div class="relative">
                <input :type="showConfirmation ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" v-model="form.password_confirmation" required 
                      class="w-full p-3 text-base border border-gray-300 rounded-lg outline-none transition duration-200 focus:border-lime-500 focus:ring-4 focus:ring-lime-100"
                      autocomplete="new-password">
                
                <button type="button" @click="togglePasswordVisibility('confirmation')"
                        class="absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition duration-150 p-0 flex items-center border-none bg-transparent">
                  <svg v-if="!showConfirmation" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                  <svg v-else class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243L6.228 6.228" /></svg>
                </button>
              </div>
              <p v-if="form.errors.password_confirmation" class="text-sm text-red-600 mt-1">{{ form.errors.password_confirmation }}</p>
            </div>
        </div> 
        <!-- END: FORM FIELDS CONTAINER -->


        <!-- Terms & Condition Checkbox (Membuat ini melebar penuh/spanning dua kolom di desktop) -->
        <div class="sm:col-span-2 flex items-start pt-2">
          <input id="terms" name="terms" type="checkbox" v-model="form.terms" required
            class="mt-1 h-4 w-4 text-lime-600 bg-gray-100 border-gray-300 rounded focus:ring-lime-500 cursor-pointer">
          <label for="terms" class="ml-2 block text-sm text-gray-700 leading-5">
            I accept the 
            <span class="text-lime-600 font-medium hover:text-lime-500 cursor-pointer">terms & Condition</span>
          </label>
        </div>

       <div class="pt-4 sm:col-span-2 text-right">
        <Link href="/dashboard"
          class="inline-block bg-[#00C853] text-white font-semibold text-base py-2 px-6 rounded-lg cursor-pointer hover:bg-[#00a142] transition duration-200 shadow-md disabled:bg-gray-400 disabled:cursor-not-allowed">
          Daftar
        </Link>
      </div>
      </form>

      <!-- Login Link -->
      <div class="mt-6 text-center text-sm text-gray-500">
        <p>
          Own an Account?
          <Link :href="route('login')" class="font-semibold text-lime-600 hover:underline">
            JUMP RIGHT IN
          </Link>
        </p>
      </div>
    </main>
  </div>
</template>
