<script setup>
import { onBeforeMount, ref } from 'vue'
import HomeHeader from '@/components/Client/HomeHeader.vue'

onBeforeMount(() => {
  if (isShowNavbar.value) toggleNavbar()
})
</script>

<template>
  <div class="flex flex-col h-screen">
    <HomeHeader :isShowNavbar :toggleNavbar />

    <main class="flex-1 px-10">
      <slot>
        <!-- Content -->
      </slot>
    </main>

    <div
      v-if="isShowNavbar"
      class="fixed inset-0 z-40 bg-black bg-opacity-50"
      @click="toggleNavbar"
    ></div>
  </div>
</template>

<script>
const isShowNavbar = ref(false)

const toggleNavbar = () => (isShowNavbar.value = !isShowNavbar.value)
</script>

<style scoped></style>
