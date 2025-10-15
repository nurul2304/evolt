<template>
  <div class="custom-select-wrapper" :class="{ open: isOpen }" ref="wrapperRef">
    <div class="custom-select-trigger" @click="toggleDropdown">
      <span>{{ selectedText }}</span>
      <svg class="trigger-icon" viewBox="0 0 320 512"><path d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z"/></svg>
    </div>
    <div class="custom-options">
      <div
        v-for="option in options"
        :key="option.value"
        class="custom-option"
        :class="{ selected: modelValue === option.value }"
        @click="selectOption(option)"
      >
        {{ option.text }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  modelValue: [String, Number],
  options: {
    type: Array,
    required: true,
    default: () => [],
  },
  placeholder: {
    type: String,
    default: 'Pilih salah satu',
  },
});

const emit = defineEmits(['update:modelValue']);

const isOpen = ref(false);
const wrapperRef = ref(null);

const selectedText = computed(() => {
  const selectedOption = props.options.find(opt => opt.value === props.modelValue);
  return selectedOption ? selectedOption.text : props.placeholder;
});

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
};

const selectOption = (option) => {
  emit('update:modelValue', option.value);
  isOpen.value = false;
};

const handleClickOutside = (event) => {
  if (wrapperRef.value && !wrapperRef.value.contains(event.target)) {
    isOpen.value = false;
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>

<style scoped>
/* CSS ini disesuaikan agar cocok dengan style di Dashboard.vue */
.custom-select-trigger {
    height: 55px;
    border-radius: 10px;
    border: 1px solid #dee2e6;
    background-color: #fff;
    padding: 0 1rem;
    width: 100%;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 1rem;
    color: #212529;
    cursor: pointer;
}
.custom-select-trigger:hover {
    border-color: #adb5bd;
}
.custom-select-wrapper.open .custom-select-trigger {
    border-color: #00C853; /* --evolt-green */
    box-shadow: 0 0 0 0.2rem rgba(0, 200, 83, 0.25);
    outline: none;
}
.custom-select-trigger .trigger-icon {
    width: 14px;
    height: 14px;
    fill: #6c757d;
    transition: transform 0.3s ease;
}
.custom-select-wrapper.open .trigger-icon {
    transform: rotate(180deg);
}
.custom-select-wrapper {
    position: relative;
}
.custom-options {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    margin-top: 8px;
    z-index: 100;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
    max-height: 240px;
    overflow-y: auto;
}
.custom-select-wrapper.open .custom-options {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}
.custom-option {
    padding: 12px 1rem;
    cursor: pointer;
    transition: background-color 0.2s ease;
}
.custom-option:hover {
    background-color: rgba(0, 200, 83, 0.1);
}
.custom-option.selected {
    font-weight: 600;
    color: #00C853; /* --evolt-green */
}
</style>

