<template>
  <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
    <h1 class="text-2xl font-bold mb-4">Verifikasi OTP</h1>

    <form @submit.prevent="submitOtp" class="bg-white p-6 rounded-lg shadow-md w-80">
      <p class="mb-3 text-gray-600">Masukkan kode OTP yang dikirim ke nomor Anda.</p>

      <input
        v-model="otp"
        type="text"
        placeholder="Masukkan OTP"
        class="w-full border rounded px-3 py-2 mb-3"
      />

      <button
        type="submit"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded w-full"
      >
        Verifikasi
      </button>

      <button
        type="button"
        @click="resendOtp"
        class="text-sm text-blue-500 mt-3 underline w-full"
      >
        Kirim Ulang OTP
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const otp = ref('')
const props = defineProps({ user: Object })

const submitOtp = () => {
  router.post('/verify-otp', {
    user_id: props.user.id,
    otp: otp.value,
  })
}

const resendOtp = () => {
  router.post('/resend-otp', { user_id: props.user.id })
  alert('Kode OTP baru telah dikirim.')
}
</script>
