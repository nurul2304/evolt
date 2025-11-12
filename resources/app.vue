<template>
  <div class="w-full bg-white">
    <!-- Header/Navigation -->
    <header class="bg-white border-b border-gray-200">
      <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <div class="flex items-center gap-8">
          <div class="text-2xl font-bold text-green-600">EV</div>
          <div class="hidden md:flex gap-8 text-gray-700">
            <a href="#about" class="hover:text-gray-900">About us</a>
            <a href="#services" class="hover:text-gray-900">Services</a>
            <a href="#blog" class="hover:text-gray-900">Blog</a>
          </div>
        </div>
        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 font-medium">
          Sign Up
        </button>
      </nav>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-b from-yellow-300 to-yellow-100 py-16 md:py-24">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
          <!-- Text Content -->
          <div class="space-y-6">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
              Menghubungkan pengendara<br />
              Dengan Stasiun Pengecasan<br />
              Cerdas
            </h1>
            <p class="text-gray-700 text-lg leading-relaxed">
              KDERA TECHNOLOGY (PVT) LTD is a team of experienced mobile and web applications and website builders measuring dozens of completed projects.
            </p>
            <div class="flex gap-4 flex-wrap">
              <button class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 font-medium">
                Pelajari lebih
              </button>
              <button class="bg-blue-400 text-white px-8 py-3 rounded-lg hover:bg-blue-500 font-medium">
                Coba sekarang
              </button>
            </div>
          </div>

          <!-- Car Image -->
          <div class="relative h-96">
            <svg viewBox="0 0 400 300" class="w-full h-full">
              <!-- Simple EV Car SVG -->
              <rect x="80" y="120" width="240" height="100" rx="20" fill="#ffffff" stroke="#000" stroke-width="2"/>
              <circle cx="130" cy="220" r="30" fill="#666" stroke="#000" stroke-width="2"/>
              <circle cx="270" cy="220" r="30" fill="#666" stroke="#000" stroke-width="2"/>
              <circle cx="125" cy="220" r="20" fill="#888"/>
              <circle cx="265" cy="220" r="20" fill="#888"/>
              <rect x="100" y="80" width="200" height="50" rx="10" fill="#e0e0e0" stroke="#000" stroke-width="2"/>
              <polygon points="120,100 160,70 240,70 280,100" fill="#b0e0ff" stroke="#000" stroke-width="1.5"/>
            </svg>

            <!-- Floating decorative elements -->
            <div class="absolute top-10 right-10 w-12 h-12 bg-purple-500 rounded-full opacity-70"></div>
            <div class="absolute bottom-20 left-5 w-10 h-10 bg-red-400 rounded-full opacity-60"></div>
            <div class="absolute top-32 right-5 w-8 h-8 bg-blue-400 rounded-full opacity-50"></div>
          </div>
        </div>
      </div>
    </section>

    <!-- EV Charge Station Search -->
    <section class="bg-white py-16">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
          <h2 class="text-2xl font-bold text-gray-900 mb-8">Cari EV Charge Station</h2>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Row 1 -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Merek Mobil</label>
              <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option>Pilih Merek Mobil</option>
                <option>Tesla</option>
                <option>BMW</option>
                <option>Nissan</option>
              </select>
            </div>
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Merek Mobil</label>
              <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option>Pilih Merek Mobil</option>
              </select>
            </div>
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Merek Mobil</label>
              <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option>Pilih Merek Mobil</option>
              </select>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Row 2 -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Merek Mobil</label>
              <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option>Pilih Merek Mobil</option>
              </select>
            </div>
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Merek Mobil</label>
              <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option>Pilih Merek Mobil</option>
              </select>
            </div>
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Merek Mobil</label>
              <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option>Pilih Merek Mobil</option>
              </select>
            </div>
          </div>

          <div class="flex justify-end">
            <button class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 font-medium">
              Cari stasion
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="bg-gray-50 py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            Lorem ipsum is simply dummy text of the printing.
          </h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Lorem ipsum is simply dummy text of the printing and typesetting industry
          </p>
        </div>

        <!-- Feature Cards -->
        <div class="space-y-16">
          <!-- Feature 1 -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="flex items-start gap-4">
              <div class="w-12 h-12 bg-cyan-500 rounded-full flex-shrink-0 flex items-center justify-center">
                <span class="text-white font-bold">1</span>
              </div>
              <div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Lorem ipsum is simply dummy</h3>
                <p class="text-gray-600">
                  KDERA TECHNOLOGY (PVT) LTD is a team of experienced mobile and web applications and website builders measuring dozens of completed projects. The build-outs are built to last and only the best...
                </p>
              </div>
            </div>
            <div class="h-64 bg-gray-300 rounded-lg"></div>
          </div>

          <!-- Feature 2 -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="h-64 bg-gray-300 rounded-lg order-2 md:order-1"></div>
            <div class="flex items-start gap-4 order-1 md:order-2">
              <div class="w-12 h-12 bg-lime-500 rounded-full flex-shrink-0 flex items-center justify-center">
                <span class="text-white font-bold">2</span>
              </div>
              <div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Lorem ipsum is simply dummy</h3>
                <p class="text-gray-600">
                  KDERA TECHNOLOGY (PVT) LTD is a team of experienced mobile and web applications and website builders measuring dozens of completed projects. The build-outs are built to last and only the best...
                </p>
              </div>
            </div>
          </div>

          <!-- Feature 3 -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="flex items-start gap-4">
              <div class="w-12 h-12 bg-purple-600 rounded-full flex-shrink-0 flex items-center justify-center">
                <span class="text-white font-bold">3</span>
              </div>
              <div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Lorem ipsum is simply dummy</h3>
                <p class="text-gray-600">
                  KDERA TECHNOLOGY (PVT) LTD is a team of experienced mobile and web applications and website builders...
                </p>
              </div>
            </div>
            <div class="h-64 bg-gray-300 rounded-lg"></div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-white py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="bg-gray-100 rounded-lg p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">
              Lorem ipsum is simply dummy text
            </h3>
            <p class="text-gray-600 mb-6">
              KDERA TECHNOLOGY (PVT) LTD is a team of experienced mobile and web applications and website builders...
            </p>
            <button class="bg-yellow-400 text-gray-900 px-6 py-2 rounded-lg hover:bg-yellow-500 font-medium">
              View More
            </button>
          </div>
          <div class="bg-yellow-300 rounded-lg p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">
              Lorem ipsum is simply dummy text
            </h3>
            <p class="text-gray-600 mb-6">
              KDERA TECHNOLOGY (PVT) LTD is a team of experienced mobile and web applications and website builders...
            </p>
            <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 font-medium">
              View More
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Partner Section -->
    <section class="bg-gray-50 py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-12">You will be in good Company</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center">
          <div class="text-center font-bold text-gray-700">Company 1</div>
          <div class="text-center font-bold text-gray-700">Company 2</div>
          <div class="text-center font-bold text-gray-700">Company 3</div>
          <div class="text-center font-bold text-gray-700">Company 4</div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
          <div>
            <h3 class="text-xl font-bold mb-4">EV</h3>
            <p class="text-gray-400">
              Lorem ipsum is simply dummy text of the printing and typesetting industry.
            </p>
          </div>
          <div>
            <h4 class="font-bold mb-4">About</h4>
            <ul class="space-y-2 text-gray-400">
              <li><a href="#" class="hover:text-white">Link 1</a></li>
              <li><a href="#" class="hover:text-white">Link 2</a></li>
            </ul>
          </div>
          <div>
            <h4 class="font-bold mb-4">Contact</h4>
            <ul class="space-y-2 text-gray-400">
              <li>Email: info@ev.com</li>
              <li>+123 456789</li>
            </ul>
          </div>
        </div>
        <div class="border-t border-gray-800 pt-8 flex justify-between items-center">
          <p class="text-gray-400">Copyright 2024 (todos los derechos reservados)</p>
          <div class="flex gap-4">
            <a href="#" class="text-gray-400 hover:text-white">f</a>
            <a href="#" class="text-gray-400 hover:text-white">in</a>
            <a href="#" class="text-gray-400 hover:text-white">tw</a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
// Reactive state management
import { ref } from 'vue'

const selectedBrand = ref('')
const selectedModel = ref('')
</script>

<style scoped>
/* Custom styles if needed */
</style>
