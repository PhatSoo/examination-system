<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
import ProgressTable from './ProgressTable.vue'
defineEmits(['submit-exam'])

const nearTimeOut = ref(false)

const isMenuOpen = ref(false)
const { duration } = defineProps(['duration'])

const timeLeft = ref(duration)

const minutes = computed(() => Math.floor(timeLeft.value / 60))
const seconds = computed(() =>
  timeLeft.value % 60 < 10 ? '0' + (timeLeft.value % 60) : timeLeft.value % 60
)

const handleOpenMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}

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
  <div
    class="flex justify-between px-2 mt-4 mb-4 text-3xl font-bold text-center uppercase md:block"
  >
    <p>exam name</p>
    <div class="md:hidden" @click="handleOpenMenu">
      <i class="fa-solid fa-bars"></i>
    </div>
  </div>

  <div class="flex flex-col items-center justify-between mx-5 mb-2 gap-y-2 md:flex-row">
    <p class="text-lg capitalize">
      time left:
      <strong :class="['mr-2', { 'animate-ping text-red-600 ': nearTimeOut }]"
        >{{ minutes }}:{{ seconds }}</strong
      >
      <em class="lowercase">mins</em>
    </p>
    <div class="flex justify-between w-full md:w-fit">
      <button
        class="px-5 py-2 text-lg font-bold text-black uppercase duration-150 border border-none rounded-lg bg-violet-500 md:hidden"
      >
        Next <i class="fa-solid fa-right-long"></i>
      </button>

      <button
        @click="$emit('submit-exam')"
        class="px-5 py-2 text-lg font-bold text-black uppercase duration-150 bg-green-300 border border-none rounded-lg md:text-2xl hover:text-white hover:bg-green-600 hover:translate-x-3"
      >
        submit <i class="fas fa-upload"></i>
      </button>
    </div>
  </div>

  <div
    :class="{ 'translate-y-full': !isMenuOpen, 'translate-y-0': isMenuOpen }"
    class="fixed bottom-0 left-0 right-0 h-screen duration-500 ease-in-out bg-black bg-opacity-55"
  >
    <div class="p-4 bg-white rounded-t-xl h-4/5 translate-y-1/4">
      <div class="flex flex-col">
        <button class="self-end" @click="handleOpenMenu">
          <i class="fa-solid fa-x"></i>
        </button>

        <hr class="mt-5 border-2" />

        <ProgressTable />
      </div>
    </div>
  </div>
</template>
