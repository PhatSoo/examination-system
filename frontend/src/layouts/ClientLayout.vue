<script setup>
import { ref } from 'vue'
import HomeHeader from '@/components/Client/HomeHeader.vue'
</script>

<template>
  <div class="flex flex-col h-screen">
    <HomeHeader :isShowNavbar :toggleNavbar />

    <slot>
      <!-- Content -->
    </slot>

    <div
      v-if="isShowNavbar"
      class="fixed inset-0 bg-black bg-opacity-50 z-10"
      @click="toggleNavbar"
    ></div>
  </div>
</template>

<script>
const isShowNavbar = ref(false)

const toggleNavbar = () => (isShowNavbar.value = !isShowNavbar.value)
</script>

<style scoped>
* {
  text-transform: capitalize;
}
</style>
