<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
defineEmits(['submit-exam'])

const nearTimeOut = ref(false)

const { duration } = defineProps(['duration'])

const timeLeft = ref(duration)

const minutes = computed(() => Math.floor(timeLeft.value / 60))
const seconds = computed(() =>
  timeLeft.value % 60 < 10 ? '0' + (timeLeft.value % 60) : timeLeft.value % 60
)

onMounted(() => {
  startCountdown()
})

const startCountdown = () => {
  const interval = setInterval(() => {
    if (timeLeft.value > 0) {
      timeLeft.value--
      if (timeLeft.value < 60) {
        nearTimeOut.value = true
      }
    } else {
      clearInterval(interval)
    }
  }, 1000)

  onUnmounted(() => {
    clearInterval(interval)
  })
}
</script>

<template>
  <div class="mt-4 mb-4 text-3xl font-bold text-center uppercase">exam name</div>

  <div class="flex justify-between mx-5 mb-2">
    <p class="text-lg capitalize">
      time left:
      <strong :class="['mr-2', { 'animate-ping text-red-600 ': nearTimeOut }]"
        >{{ minutes }}:{{ seconds }}</strong
      >
      <em class="lowercase">mins</em>
    </p>
    <div>
      <button
        @click="$emit('submit-exam')"
        class="px-5 py-2 text-2xl font-bold text-black uppercase duration-150 bg-green-300 border border-none rounded-lg hover:text-white hover:bg-green-600 hover:translate-x-3"
      >
        submit <i class="fa-solid fa-arrow-right"></i>
      </button>
    </div>
  </div>
</template>
