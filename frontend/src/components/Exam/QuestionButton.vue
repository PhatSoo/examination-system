<script setup>
const { status, isClicked } = defineProps(['status', 'id', 'isClicked'])
</script>

<template>
  <button
    type="button"
    :class="[
      'w-10 h-10 m-2 rounded-full md:hover:bg-slate-300 md:hover:text-black font-bold ',
      isClicked ? 'bg-fuchsia-400 text-white' : status
    ]"
  >
    <slot></slot>
  </button>
</template>
