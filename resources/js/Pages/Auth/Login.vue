<script setup>
import { ref } from 'vue';
// Import Link dan useForm dari Inertia
import { useForm, Link } from '@inertiajs/vue3'; 

// Menggunakan useForm untuk manajemen state form dan Inertia
const form = useForm({
  email: '', 
  password: '',
  remember: false,
});

const isPasswordVisible = ref(false);

// Fungsi untuk menangani submit form
const handleLogin = () => {
  // Kirim data ke rute '/login' (POST request)
  form.post(route('login'), {
    onFinish: () => form.reset('password'), // Reset password setelah selesai
  });
};
</script>

<template>
  <!-- Main container: Full screen, centered, with background image -->
  <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 bg-gray-50 bg-[url('https://i.imgur.com/G323a2A.jpg')] bg-cover bg-center font-sans">
    
    <!-- Login Card: Responsive card centered on screen -->
    <main class="w-full max-w-sm sm:max-w-md bg-white rounded-3xl shadow-2xl p-6 sm:p-8 lg:p-10">
      
      <!-- Logo -->
      <div class="text-center text-3xl font-bold mb-2">
        <span class="text-lime-500">E</span><span class="text-gray-700">-VOLT</span>
      </div>
      <h1 class="text-center text-xl sm:text-2xl font-semibold text-gray-800 mb-6">Welcome back to the E-Volt Community</h1>

      <!-- Social Login Buttons -->
      <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <button class="flex-1 flex items-center justify-center gap-2 p-3 border border-gray-300 rounded-lg bg-white text-gray-700 text-sm font-medium cursor-pointer hover:bg-gray-50 transition duration-150 shadow-sm">
          <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" class="w-5 h-5">
          <span>Log in with Google</span>
        </button>
      </div>

      <!-- Separator (Opsional: Garis pemisah) -->
      <div class="flex items-center my-6">
        <hr class="flex-grow border-t border-gray-300">
        <span class="px-3 text-sm text-gray-500 font-medium">or</span>
        <hr class="flex-grow border-t border-gray-300">
      </div>

      <!-- Form Login -->
      <form class="text-left" @submit.prevent="handleLogin">
        
        <!-- Error Message (Jika ada error dari backend) -->
        <div v-if="form.errors.email" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm font-medium" role="alert">
          {{ form.errors.email }}
        </div>

        <!-- Email or Username Input -->
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email or Username</label>
          <input type="text" id="email" name="email" v-model="form.email" required 
                 class="w-full p-3 text-base border border-gray-300 rounded-lg outline-none transition duration-200 focus:border-lime-500 focus:ring-4 focus:ring-lime-100"
                 autocomplete="username">
        </div>

        <!-- Password Input -->
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
          <div class="relative">
            <input :type="isPasswordVisible ? 'text' : 'password'" id="password" name="password" v-model="form.password" required 
                   class="w-full p-3 text-base border border-gray-300 rounded-lg outline-none transition duration-200 focus:border-lime-500 focus:ring-4 focus:ring-lime-100"
                   autocomplete="current-password">
            
            <button type="button" @click="isPasswordVisible = !isPasswordVisible"
                    class="absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition duration-150 p-0 flex items-center border-none bg-transparent">
              <!-- Ikon Mata -->
              <svg v-if="!isPasswordVisible" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
              <!-- Ikon Mata Dicoret -->
              <svg v-else class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243L6.228 6.228" /></svg>
            </button>
          </div>
        </div>

        <!-- Remember Me & Submit Button Area -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mt-6 mb-4">
          <div class="flex items-center gap-2 mb-4 sm:mb-0">
            <input type="checkbox" id="remember" name="remember" v-model="form.remember"
                   class="w-4 h-4 text-lime-600 bg-gray-100 border-gray-300 rounded focus:ring-lime-500 cursor-pointer">
            <label for="remember" class="text-sm text-gray-600 font-medium cursor-pointer">Remember me</label>
          </div>
          
          <button type="submit" :disabled="form.processing"
                  class="w-full sm:w-auto bg-[#00C853] text-white font-semibold text-base py-2 px-6 rounded-lg cursor-pointer hover:bg-[#00A142] transition duration-200 shadow-md disabled:bg-gray-400 disabled:cursor-not-allowed">
            Masuk
          </button>
        </div>
      </form>

      <!-- Sign Up Link -->
      <div class="text-center text-sm text-gray-500 mt-6">
        No Account yet? 
        <Link :href="route('register')" class="text-lime-600 font-semibold hover:underline">SIGN UP</Link>
      </div>
    </main>
  </div>
</template>
