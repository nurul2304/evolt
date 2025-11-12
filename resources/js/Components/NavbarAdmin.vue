<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const isMenuOpen = ref(false);
const closeAllMenus = () => {
  isMenuOpen.value = false;
};
</script>

<template>
  <header class="w-full bg-white shadow-md relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
      <!-- Logo -->
      <Link href="/admin-dashboard" class="text-2xl font-semibold text-[#00C853]">
        E-<span class="text-gray-900 font-bsemiold">VOLT</span>
      </Link>

      <!-- Ikon Profil -->
      <div class="hidden md:flex items-center ml-6">
        <Link
          href="/admin-profile"
          class="flex items-center space-x-2 p-2 rounded-full hover:bg-gray-100 transition duration-150 focus:outline-none focus:ring-2 focus:ring-[#00C853] group"
          title="Pengaturan Profil"
        >
          <div class="w-9 h-9 bg-lime-500 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-inner group-hover:bg-lime-600 transition duration-150">
            U
          </div>
          <span class="text-gray-800 font-medium hidden sm:inline group-hover:text-lime-700 transition duration-150">Profil</span>
        </Link>
      </div>

      <!-- Tombol Menu Mobile -->
      <button @click="isMenuOpen = !isMenuOpen" class="md:hidden text-gray-700 hover:text-[#00C853] transition duration-150 ml-4">
        <svg v-if="isMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
      </button>
    </div>

    <!-- Menu Mobile -->
    <transition
      name="mobile-menu"
      enter-active-class="transition ease-out duration-200"
      enter-from-class="transform opacity-0 -translate-y-2"
      enter-to-class="transform opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="transform opacity-100 translate-y-0"
      leave-to-class="transform opacity-0 -translate-y-2"
    >
      <div v-if="isMenuOpen" class="md:hidden absolute top-full left-0 right-0 z-40">
        <div class="bg-white shadow-lg border-t border-gray-100 rounded-b-xl mx-4 p-4">
          <nav class="flex flex-col p-2 space-y-2">
            <Link @click="closeAllMenus" href="/" class="py-2 px-3 block hover:bg-lime-50 rounded-lg text-gray-700 font-medium transition duration-150">Beranda</Link>
            <Link @click="closeAllMenus" href="/admin" class="py-2 px-3 block hover:bg-lime-50 rounded-lg text-gray-700 font-medium transition duration-150">Pengaturan Profil</Link>
          </nav>
        </div>
      </div>
    </transition>
  </header>
</template>
