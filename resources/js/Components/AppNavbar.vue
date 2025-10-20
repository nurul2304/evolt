<script setup>
import { ref } from 'vue'; // <--- BARIS BARU: Import ref
import { Link } from '@inertiajs/vue3'; 
// Gunakan Link dari Inertia untuk navigasi SPA

// <--- BARIS BARU: Tambahkan state untuk menu mobile
const isMenuOpen = ref(false); 
</script>

<template>
    <header class="w-full bg-white shadow-md relative z-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <Link :href="route('dashboard')" class="text-2xl font-semibold text-[#00C853]">
          E-<span class="text-gray-900 font-bsemiold">VOLT</span>
        </Link>
        
        <nav class="hidden md:flex ml-auto items-center gap-3 text-gray-700 font-medium">
            <Link :href="route('welcome')" class="hover:text-[#00C853] transition duration-150">Home</Link>
            <Link :href="route('about')" class="hover:text-[#00C853] transition duration-150">About us</Link>
            <Link :href="route('services')" class="hover:text-[#00C853] transition duration-150">Services</Link>
            <Link :href="route('blog')" class="hover:text-[#00C853] transition duration-150">Blog</Link>

            <!-- Avatar only (desktop) -->
            <div>
              <img src="/images/profile.jpg" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-gray-200 object-cover">
            </div>
  </nav>

        <!-- <div class="hidden md:flex items-center space-x-4">
          <Link :href="route('login')" class="px-6 py-2 border-2 border-[#00C853] text-[#00C853] font-semibold rounded-lg hover:bg-[#00C853] hover:text-white transition duration-300 shadow-md">
            Masuk
          </Link>
        </div> -->

        <button @click="isMenuOpen = !isMenuOpen" class="md:hidden text-gray-700 hover:text-[#00C853] transition duration-150">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        </button>
      </div>
      
      <transition name="mobile-menu" enter-active-class="transition ease-out duration-200" enter-from-class="transform opacity-0 -translate-y-2" enter-to-class="transform opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="transform opacity-100 translate-y-0" leave-to-class="transform opacity-0 -translate-y-2">
        <teleport to="body">
          <div v-if="isMenuOpen" class="md:hidden fixed inset-0 z-[99999]">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black bg-opacity-30" @click="isMenuOpen = false"></div>
            <!-- Menu panel positioned below header -->
            <div class="absolute top-16 left-0 right-0 bg-white shadow-lg border-t border-gray-100 rounded-b-xl mx-4 md:mx-8 p-4">
              <nav class="flex flex-col p-2 space-y-2">
                <Link @click="isMenuOpen = false" :href="route('welcome')" class="py-2 px-3 block hover:bg-gray-50 rounded-lg text-gray-700 font-medium transition duration-150">Home</Link>
                <Link @click="isMenuOpen = false" :href="route('about')" class="py-2 px-3 block hover:bg-gray-50 rounded-lg text-gray-700 font-medium transition duration-150">About us</Link>
                <Link @click="isMenuOpen = false" :href="route('services')" class="py-2 px-3 block hover:bg-gray-50 rounded-lg text-gray-700 font-medium transition duration-150">Services</Link>
                <Link @click="isMenuOpen = false" :href="route('blog')" class="py-2 px-3 block hover:bg-gray-50 rounded-lg text-gray-700 font-medium transition duration-150">Blog</Link>

                <div class="border-t border-gray-100 mt-2 pt-2">
                  <Link @click="isMenuOpen = false" :href="route('profile')" class="py-2 px-3 block hover:bg-gray-50 rounded-lg text-gray-700 font-medium transition duration-150">Profil</Link>
                  <button @click="isMenuOpen = false" class="w-full text-left py-2 px-3 hover:bg-gray-50 rounded-lg text-gray-700">Keluar</button>
                </div>

                <Link @click="isMenuOpen = false" :href="route('login')" class="mt-4 px-6 py-2 border-2 border-[#00C853] text-[#00C853] font-semibold rounded-lg hover:bg-[#00C853] hover:text-white transition duration-300 shadow-md text-center">
                    Masuk
                </Link>
              </nav>
            </div>
          </div>
        </teleport>
      </transition>
    </header>
</template>