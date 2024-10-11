<script setup>
import { onBeforeMount, onBeforeUnmount, onMounted, ref } from 'vue'
import HomeHeader from '@/components/Client/HomeHeader.vue'

const isSticky = ref(false)

onBeforeMount(() => {
  if (isShowNavbar.value) toggleNavbar()
})

const handleScroll = () => {
  if (window.scrollY > 80) {
    isSticky.value = true
  } else {
    isSticky.value = false
  }
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onBeforeUnmount(() => window.removeEventListener('scroll', handleScroll))
</script>

<template>
  <div class="flex flex-col h-screen">
    <HomeHeader :isSticky :isShowNavbar :toggleNavbar />

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
