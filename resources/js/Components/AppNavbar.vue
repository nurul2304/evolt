<script setup>
import { ref } from 'vue'; // <--- BARIS BARU: Import ref
import { Link } from '@inertiajs/vue3'; 
// Gunakan Link dari Inertia untuk navigasi SPA

// <--- BARIS BARU: Tambahkan state untuk menu mobile
const isMenuOpen = ref(false); 
</script>

<template>
    <header class="w-full bg-white shadow-md relative z-30">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <Link :href="route('dashboard')" class="text-2xl font-semibold text-[#00C853]">
          E-<span class="text-gray-900 font-bsemiold">VOLT</span>
        </Link>
        
        <nav class="hidden md:flex space-x-8 text-gray-700 font-medium">
          <Link :href="route('welcome')" class="hover:text-[#00C853] transition duration-150">Home</Link>
          <Link :href="route('about')" class="hover:text-[#00C853] transition duration-150">About us</Link>
          <Link :href="route('services')" class="hover:text-[#00C853] transition duration-150">Services</Link>
          <Link :href="route('blog')" class="hover:text-[#00C853] transition duration-150">Blog</Link>
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
      
      <div v-if="isMenuOpen" class="md:hidden bg-white shadow-lg border-t border-gray-100 absolute top-full w-full z-20">
          <nav class="flex flex-col p-4 space-y-2">
            <Link @click="isMenuOpen = false" :href="route('welcome')" class="py-2 px-3 block hover:bg-gray-50 rounded-lg text-gray-700 font-medium transition duration-150">Home</Link>
            <Link @click="isMenuOpen = false" :href="route('about')" class="py-2 px-3 block hover:bg-gray-50 rounded-lg text-gray-700 font-medium transition duration-150">About us</Link>
            <Link @click="isMenuOpen = false" :href="route('services')" class="py-2 px-3 block hover:bg-gray-50 rounded-lg text-gray-700 font-medium transition duration-150">Services</Link>
            <Link @click="isMenuOpen = false" :href="route('blog')" class="py-2 px-3 block hover:bg-gray-50 rounded-lg text-gray-700 font-medium transition duration-150">Blog</Link>
            
            <Link @click="isMenuOpen = false" :href="route('login')" class="mt-4 px-6 py-2 border-2 border-[#00C853] text-[#00C853] font-semibold rounded-lg hover:bg-[#00C853] hover:text-white transition duration-300 shadow-md text-center">
                Masuk
            </Link>
          </nav>
      </div>
    </header>
</template>