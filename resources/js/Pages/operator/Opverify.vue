<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <!-- Verification Modal -->
    <div class="fixed inset-0 bg-[#B6F500] bg-opacity-90 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full mx-4 border border-[#ffffff]">
        <h3 class="text-xl font-bold text-gray-900 mb-2 text-center">Verifikasi Akses</h3>
        <p class="text-sm text-gray-600 mb-6 text-center">Masukkan kode verifikasi untuk mengakses halaman Operator.</p>
        <form @submit.prevent="verifyCode" class="space-y-6">
          <div class="flex justify-center space-x-2">
            <div
              v-for="(letter, index) in displayCode"
              :key="index"
              class="relative w-12 h-12"
            >
              <div class="w-full h-full text-center text-xl font-bold border-2 border-gray-500 rounded-md bg-white text-gray-900 flex items-center justify-center">
                {{ verificationCode[index] ? '' : letter }}
              </div>
              <input
                :id="`code-${index}`"
                :value="displayCode[index]"
                type="text"
                maxlength="1"
                @keydown="handleKey(index, $event)"
                class="absolute inset-0 w-full h-full text-center text-xl font-bold bg-transparent border-none outline-none text-[#00C853]"
                required
              />
            </div>
          </div>
          <p v-if="verificationError" class="text-sm text-red-400 text-center">{{ verificationError }}</p>
          <div class="flex justify-center">
            <button
              type="submit"
              class="px-6 py-2 bg-[#00C853] text-white rounded-md text-sm font-medium hover:bg-[#00A142] transition-colors"
            >
              Verifikasi
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

// Verification state
const verificationCode = ref(['', '', '', '', '']);
const displayCode = ref(['', '', '', '', '']);
const verificationError = ref('');
const codeInputs = ref([]);

// Function to handle keydown and auto-focus next field
const handleKey = (index, event) => {
  const key = event.key;
  if (key.length === 1 && /^[0-9]$/.test(key)) {
    event.preventDefault();
    verificationCode.value[index] = key;
    // Generate random letter for display
    const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    displayCode.value[index] = letters[Math.floor(Math.random() * letters.length)];
    if (index < 4) {
      document.getElementById(`code-${index + 1}`).focus();
    }
  }
};

// Verification function
const verifyCode = () => {
  const code = verificationCode.value.join('');
  if (code === '12345') {
    verificationError.value = '';
    router.visit('/operator');
  } else {
    verificationError.value = 'Kode verifikasi salah. Coba lagi.';
    verificationCode.value = ['', '', '', '', ''];
    displayCode.value = ['', '', '', '', ''];
    document.getElementById('code-0').focus();
  }
};

// Mount hook to show verification modal
onMounted(() => {
  // Focus on first input
  document.getElementById('code-0').focus();
});
</script>
