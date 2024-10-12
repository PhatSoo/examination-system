<script setup>
const { color } = defineProps(['color'])

const colorVariants = {
  red: 'bg-red-300 hover:bg-red-500',
  green: 'bg-green-300 hover:bg-green-500',
  blue: 'bg-blue-300 hover:bg-blue-500',
  yellow: 'bg-yellow-300 hover:bg-yellow-500'
}
</script>

<template>
  <div
    :class="[
      'flex items-center justify-center w-2/5 p-4 m-auto mx-4 border cursor-pointer grow shrink h-1/3 rounded-3xl',
      colorVariants[color]
    ]"
  >
    <p class="text-2xl font-bold"><slot></slot></p>
  </div>
</template>

<style scoped></style>
