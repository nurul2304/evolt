<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

const isModalOpen = ref(false); 

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const closePickersOnOutsideClick = (event) => {
    if (isModalOpen.value && !event.target.closest('.modal-content')) {
        closeModal();
    }
};

const updateViewport = () => {
  // Logic viewport tambahan jika diperlukan
};

onMounted(() => {
    document.body.addEventListener('click', closePickersOnOutsideClick);
    window.addEventListener('resize', updateViewport);
});

onBeforeUnmount(() => {
    document.body.removeEventListener('click', closePickersOnOutsideClick);
    window.removeEventListener('resize', updateViewport);
});
</script>

<template>
  <div class="min-h-screen flex flex-col bg-white font-sans">
    <Navbar />

    <main class="flex-grow relative z-10"> 
      
      <!-- HERO SECTION -->
      <section class="bg-[#CCFF00] pt-10 pb-12 sm:pt-16 sm:pb-16 lg:pt-20 lg:pb-20 relative overflow-hidden rounded-b-[2.5rem] lg:rounded-none shadow-sm lg:shadow-none z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          <div class="flex flex-col lg:flex-row items-center justify-between gap-8 md:gap-10 lg:gap-12">
            
            <div class="w-full lg:w-1/2 text-center lg:text-left order-1 lg:order-1">
              <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-[#333] leading-tight mb-4 lg:mb-6 tracking-tight">
                Menghubungkan Pengendara Dengan <span class="text-lime-700 lg:text-[#333]">Stasiun Cerdas</span>
              </h2>
              <p class="text-base sm:text-lg lg:text-xl text-gray-800 font-medium mb-8 lg:mb-8 max-w-md mx-auto lg:mx-0 leading-relaxed opacity-90">
                Temukan, reservasi, dan isi daya dengan mudah di mana saja tanpa ribet.
              </p>
              
              <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start w-full">
                <Link
                  :href="route('register')"
                  class="w-full sm:w-auto bg-[#00C853] text-white font-bold px-6 py-3.5 rounded-xl shadow-lg hover:bg-[#00A142] active:scale-95 transition duration-200 focus:outline-none focus:ring-4 focus:ring-lime-300/50 text-base text-center"
                >
                  Mulai Sekarang
                </Link>

                <Link
                  href="#"
                  class="w-full sm:w-auto bg-white/80 backdrop-blur-sm border-2 border-[#00C853] text-[#00C853] font-bold px-6 py-3.5 rounded-xl hover:bg-white active:scale-95 transition duration-200 focus:outline-none focus:ring-4 focus:ring-lime-300/50 text-base text-center"
                >
                  Pelajari Lebih Lanjut
                </Link>
              </div>
            </div>

            <!-- Gambar Hero (KEMBALI KE ORIGINAL) -->
            <div class="w-full lg:w-1/2 flex justify-center order-2 lg:order-2 mt-2 lg:mt-0">
              <div class="relative">
                  <div class="absolute inset-0 bg-white/30 blur-2xl rounded-full transform scale-90 lg:hidden"></div>
                  <img 
                    src="images/mobil.png" 
                    alt="EV Car" 
                    class="relative z-10 w-full max-w-[280px] sm:max-w-sm md:max-w-md lg:max-w-full drop-shadow-xl lg:drop-shadow-none transform hover:scale-105 transition duration-500"
                  >
              </div>
            </div>
          </div>
        </div>
      </section>
      

      <!-- STEP 1: Pencarian Stasiun -->
      <section class="py-12 lg:py-20 bg-white lg:bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12">
            <!-- Text Content -->
            <div class="w-full lg:w-1/2 text-center lg:text-left"> 
              <span class="inline-block px-3 py-1 bg-lime-100 text-lime-700 rounded-full text-xs font-bold uppercase tracking-wider mb-3 lg:mb-3">Langkah 1</span>
              <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 text-balance leading-tight">
                Pencarian Stasiun <span class="text-lime-600">Terdekat</span>
              </h2>
              <p class="text-gray-600 text-base sm:text-lg leading-relaxed max-w-lg mx-auto lg:mx-0">
                Aplikasi menampilkan peta geolokasi dengan semua SPKLU terdaftar. Data <span class="font-semibold text-gray-800">Real-Time</span> memastikan Anda hanya melihat slot yang siap pakai.
              </p>
            </div>
            <!-- Image: Map Navigation Aesthetic (BARU) -->
            <div class="w-full lg:w-1/2 flex justify-center mt-4 lg:mt-0">
              <div class="bg-lime-50 p-4 rounded-[2rem] lg:bg-transparent lg:p-0 w-full flex justify-center">
                 <img src="https://i.pinimg.com/736x/28/8b/44/288b44c8e76a00feed1853b351057876.jpg" alt="Aesthetic Map Navigation UI" class="w-full max-w-[260px] sm:max-w-xs md:max-w-sm rounded-2xl shadow-lg lg:shadow-2xl transform rotate-0 lg:rotate-2 transition hover:rotate-0 duration-300 object-cover" loading="lazy">
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- STEP 2: Reservasi Slot -->
      <section class="py-12 lg:py-20 bg-gray-50 lg:bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col lg:flex-row-reverse items-center gap-8 lg:gap-12">
            
            <div class="w-full lg:w-1/2 text-center lg:text-left">
              <span class="inline-block px-3 py-1 bg-lime-100 text-lime-700 rounded-full text-xs font-bold uppercase tracking-wider mb-3 lg:mb-3">Langkah 2</span>
              <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 text-balance leading-tight">
                Reservasi Slot <span class="text-lime-600">Terjamin</span>
              </h2>
              <p class="text-gray-600 text-base sm:text-lg leading-relaxed max-w-lg mx-auto lg:mx-0">
                Kunci slot pengisian spesifik sebelum Anda tiba. Sistem OCPP kami menjamin slot Anda aman. Dapatkan QR Booking dan lewati antrian.
              </p>
            </div>

            <!-- Image: Booking UI Clean (BARU) -->
            <div class="w-full lg:w-1/2 flex justify-center mt-4 lg:mt-0">
              <div class="bg-white p-4 rounded-[2rem] shadow-sm lg:bg-transparent lg:shadow-none lg:p-0 w-full flex justify-center">
                <img src="images/uibooking.png" alt="Clean Booking Slot UI" class="w-full max-w-xs sm:max-w-sm md:max-w-md rounded-2xl shadow-lg lg:shadow-xl object-cover" loading="lazy">
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- STEP 3: Otomasi & Audit -->
      <section class="py-12 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12">
            
            <div class="w-full lg:w-1/2 text-center lg:text-left">
              <span class="inline-block px-3 py-1 bg-lime-100 text-lime-700 rounded-full text-xs font-bold uppercase tracking-wider mb-3 lg:mb-3">Langkah 3</span>
              <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 text-balance leading-tight">
                <span class="text-lime-600">Otomasi</span> & Data Audit
              </h2>
              <p class="text-gray-600 text-base sm:text-lg leading-relaxed max-w-lg mx-auto lg:mx-0">
                Komunikasi dua arah antara Server dan SPKLU memungkinkan audit transaksi otomatis. Efisiensi tinggi dengan model <span class="italic">Zero Operator Cost</span>.
              </p>
            </div>

            <!-- Image: Dashboard/Analytics Isometric (BARU) -->
            <div class="w-full lg:w-1/2 flex justify-center mt-4 lg:mt-0">
               <div class="bg-gray-50 p-4 rounded-[2rem] lg:bg-transparent lg:p-0 w-full flex justify-center">
                  <img src="images/admin.png" alt="Automation Dashboard Isometric" class="w-full max-w-xs sm:max-w-sm md:max-w-md rounded-2xl shadow-lg lg:shadow-xl object-contain" loading="lazy">
               </div>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA & TESTIMONIAL -->
      <section class="py-12 lg:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-center">

            <!-- Sign Up CTA Card -->
            <div class="bg-[#00C853] p-6 sm:p-8 rounded-3xl shadow-xl text-white relative overflow-hidden flex flex-col justify-center h-full">
                <!-- Decorative circles overlay -->
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white opacity-10 rounded-full"></div>
                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 bg-white opacity-10 rounded-full"></div>
                
                <div class="relative z-10 text-center lg:text-left">
                  <h3 class="text-2xl sm:text-3xl font-bold mb-3">
                    Siap Bergabung?
                  </h3>
                  <p class="mb-6 text-lime-50 text-sm sm:text-base leading-relaxed">
                    Daftar sekarang. Gratis, cepat, dan langsung bisa digunakan di seluruh jaringan kami.
                  </p>
                  <button class="bg-white text-[#00C853] font-bold px-6 py-3.5 rounded-xl shadow-md hover:bg-gray-50 active:scale-95 transition duration-300 w-full lg:w-auto text-base">
                    Daftar Gratis
                  </button>
                </div>
            </div>

          </div>
        </div>
      </section>

      <!-- TRUSTED BY -->
      <section class="py-10 lg:py-20 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h3 class="text-sm sm:text-base md:text-lg font-semibold text-gray-400 uppercase tracking-widest mb-8">
            Didukung Oleh Teknologi
          </h3>
          <!-- Di mobile pake grid 2/3 kolom supaya ga terlalu kecil -->
          <div class="grid grid-cols-3 sm:flex sm:flex-wrap justify-center items-center gap-8 sm:gap-12 grayscale opacity-70">
            <img src="https://cdn.worldvectorlogo.com/logos/tesla-9.svg" alt="Tesla" class="h-6 sm:h-8 md:h-10 mx-auto transition hover:grayscale-0 hover:opacity-100">
            <img src="https://upload.wikimedia.org/wikipedia/commons/e/e2/BYD_Auto_2022_logo.svg" alt="BYD" class="h-6 sm:h-8 md:h-10 mx-auto transition hover:grayscale-0 hover:opacity-100">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Hyundai_Motor_Company_logo.svg" alt="Hyundai" class="h-6 sm:h-8 md:h-10 mx-auto transition hover:grayscale-0 hover:opacity-100">
            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b6/KIA_logo3.svg" alt="Kia" class="h-6 sm:h-8 md:h-10 mx-auto transition hover:grayscale-0 hover:opacity-100">
            <img src="https://upload.wikimedia.org/wikipedia/commons/1/16/Wuling-logo.svg" alt="Wuling" class="h-6 sm:h-8 md:h-10 col-span-3 sm:col-span-1 mx-auto transition hover:grayscale-0 hover:opacity-100">
          </div>
        </div>
      </section>
      
    </main>
    
    <Transition name="fade">
      <div v-if="isModalOpen" @click="closeModal" class="fixed inset-0 bg-gray-900 bg-opacity-80 backdrop-blur-sm z-[99] flex items-center justify-center p-4">
        <div @click.stop class="modal-content bg-white p-6 rounded-3xl shadow-2xl max-w-md w-full transform transition-all">
          <div class="flex justify-between items-center mb-4">
            <h4 class="text-xl font-bold text-gray-900">Informasi</h4>
            <button @click="closeModal" class="bg-gray-100 p-2 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-200 transition">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
          </div>
          <p class="text-gray-600 mb-6">
            Fitur pencarian sedang dioptimalkan untuk pengalaman mobile yang lebih baik.
          </p>
          <div class="flex justify-end">
            <button @click="closeModal" class="w-full sm:w-auto bg-[#00C853] text-white font-bold px-6 py-3 rounded-xl hover:bg-[#00A142] transition duration-300">Mengerti</button>
          </div>
        </div>
      </div>
    </Transition>
    
    <Footer />
  </div>
</template>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>