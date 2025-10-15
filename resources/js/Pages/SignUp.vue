<template>
  <main class="signup-container">
    <div class="logo">
      <span class="green">E</span><span class="dark">-VOLT</span>
    </div>
    <h1 class="subtitle">Create Your Account</h1>

    <form class="signup-form" @submit.prevent="handleSignUp">
      <div class="input-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="yourusername" v-model="formData.username" required>
      </div>

      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="you@example.com" v-model="formData.email" required>
      </div>

      <div class="input-group">
        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone" placeholder="08xxxxxxxxxx" v-model="formData.phone" required maxlength="13" minlength="10" pattern="[0-9]{10,13}" inputmode="numeric" title="Enter 10-13 digits number">
      </div>
      
      <div class="input-group">
        <label for="password">Password</label>
        <div class="password-wrapper">
          <input :type="isPasswordVisible ? 'text' : 'password'" id="password" name="password" placeholder="********" v-model="formData.password" required>
          <button type="button" id="togglePassword" @click="togglePasswordVisibility">
            <svg v-if="!isPasswordVisible" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243L6.228 6.228" />
            </svg>
          </button>
        </div>
      </div>
      
      <div class="input-group">
        <label for="captcha">Captcha</label>
        <div class="captcha-box">
          <input type="text" id="captcha-input" name="captcha" placeholder="Enter code" v-model="captchaInput" required>
          <div id="captcha-text">{{ captchaText }}</div>
          <button type="button" id="refresh-captcha" @click="generateCaptcha">↻</button>
        </div>
      </div>

      <div class="form-footer">
        <button type="submit" class="signup-btn">SIGN UP</button>
      </div>
    </form>

    <div class="login-link">
      Already have an account? <a href="#">LOG IN</a>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted, reactive, watch } from 'vue';

// Menggunakan reactive untuk mengelompokkan data form
const formData = reactive({
  username: '',
  email: '',
  phone: '',
  password: '',
});

// State untuk UI
const isPasswordVisible = ref(false);
const captchaText = ref('');
const captchaInput = ref('');
let currentCaptcha = '';

// Fungsi untuk membuat CAPTCHA
const generateCaptcha = () => {
  const chars = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
  let result = '';
  for (let i = 0; i < 5; i++) {
    result += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  currentCaptcha = result;
  captchaText.value = currentCaptcha; // Update variabel reaktif
};

// Fungsi untuk toggle visibilitas password
const togglePasswordVisibility = () => {
  isPasswordVisible.value = !isPasswordVisible.value;
};

// Fungsi untuk menangani submit form
const handleSignUp = () => {
  if (captchaInput.value.toLowerCase() !== currentCaptcha.toLowerCase()) {
    alert('Captcha does not match. Please try again.');
    generateCaptcha();
    captchaInput.value = ''; // Reset input CAPTCHA
  } else {
    alert('Registration successful!');
    console.log('Form Data:', formData);
    // Di sini Anda bisa menambahkan logika untuk mengirim data ke server
  }
};

// Watcher untuk memformat input nomor telepon agar hanya angka
watch(() => formData.phone, (newValue) => {
  formData.phone = newValue.replace(/[^0-9]/g, '');
});

// onMounted adalah lifecycle hook Vue, setara dengan window.onload
onMounted(() => {
  generateCaptcha();
});
</script>

<style scoped>
/* Semua CSS dari kode asli Anda ditempatkan di sini */
/* 'scoped' memastikan style ini tidak bocor ke komponen lain */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:host { /* Styling untuk elemen root komponen jika diperlukan */
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    background-image: url('https://i.imgur.com/G323a2A.jpg');
    background-size: cover;
    background-position: center;
    background-color: #f0f4f8;
}

.signup-container {
    width: 100%;
    max-width: 460px;
    background-color: #ffffff;
    border-radius: 24px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    padding: 2.5rem;
}

.logo {
    text-align: center;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.logo .green {
    color: #84CC16;
}

.logo .dark {
    color: #4B5563;
}

.subtitle {
    text-align: center;
    font-size: 1.25rem;
    font-weight: 600;
    color: #1F2937;
    margin-bottom: 1.5rem;
}

.signup-form {
    text-align: left;
}

.input-group {
    margin-bottom: 1rem;
}

.input-group label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
}

.input-group input {
    width: 100%;
    padding: 0.8rem 1rem;
    font-size: 0.95rem;
    border: 1px solid #D1D5DB;
    border-radius: 8px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    font-family: 'Poppins', sans-serif;
}

.input-group input:focus {
    border-color: #84CC16;
    box-shadow: 0 0 0 3px rgba(132, 204, 22, 0.2);
}

.password-wrapper {
    position: relative;
}

#togglePassword {
    position: absolute;
    top: 50%;
    right: 1rem;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #6B7280;
    padding: 0;
    display: flex;
    align-items: center;
}

#togglePassword svg {
    width: 20px;
    height: 20px;
}

.captcha-box {
    display: flex;
    align-items: center;
    gap: 10px;
}

#captcha-input {
    flex: 1;
}

#captcha-text {
    background: #F3F4F6;
    color: #374151;
    font-weight: 600;
    padding: 0.8rem 1rem;
    border-radius: 8px;
    user-select: none;
    letter-spacing: 3px;
    text-decoration: line-through;
    font-family: 'Courier New', Courier, monospace;
    border: 1px solid #D1D5DB;
    display: flex;
    align-items: center;
    height: 46px; /* Menyamakan tinggi dengan input */
}

#refresh-captcha {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.5em;
    color: #6B7280;
    transition: color 0.2s, transform 0.2s;
}

#refresh-captcha:hover {
    color: #1F2937;
    transform: rotate(360deg);
}

.form-footer {
    margin-top: 1.5rem;
    margin-bottom: 1.5rem;
}

.signup-btn {
    width: 100%;
    background-color: #D9EF54;
    color: #1F2937;
    font-weight: 700;
    font-size: 0.95rem;
    border: none;
    border-radius: 8px;
    padding: 0.8rem 2rem;
    cursor: pointer;
    transition: background-color 0.2s ease;
    font-family: 'Poppins', sans-serif;
}

.signup-btn:hover {
    background-color: #cde441;
}

.login-link {
    text-align: center;
    font-size: 0.9rem;
    color: #6B7280;
}

.login-link a {
    color: #84CC16;
    font-weight: 600;
    text-decoration: none;
    transition: text-decoration 0.2s;
}

.login-link a:hover {
    text-decoration: underline;
}
</style>