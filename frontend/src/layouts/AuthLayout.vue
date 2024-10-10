<script setup>
import Logo from '@/assets/images/logo.png'
</script>

<template>
  <div class="flex flex-col items-center h-screen space-y-5">
    <router-link :to="{ name: 'client' }">
      <img :src="Logo" alt="examination system image" width="350" class="mt-4" />
    </router-link>
    <h1 class="text-2xl font-bold"><slot name="title"></slot></h1>

    <div class="flex justify-center flex-1 w-screen p-4">
      <slot></slot>
    </div>
  </div>
</template>

<style scoped>
* {
  text-transform: capitalize;
}
</style>
