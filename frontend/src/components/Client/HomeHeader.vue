<script setup>
import MenuIcon from '@/components/icons/MenuIcon.vue'
import CloseIcon from '@/components/icons/CloseIcon.vue'

const { isShowNavbar, toggleNavbar } = defineProps(['isShowNavbar', 'toggleNavbar'])
</script>

<template>
  <div class="bg-white border-b-2 shadow-lg px-4 py-2 flex justify-between h-20 items-center">
    <div class="flex-1">
      <h1 class="text-3xl">examination test</h1>
    </div>

    <div class="lg:hidden">
      <button @click="toggleNavbar"><MenuIcon /></button>
    </div>

    <nav class="lg:flex gap-10">
      <div class="flex items-center justify-center gap-10">
        <div class="navigate active">home</div>
        <div class="navigate">information</div>
        <div class="navigate">result</div>
      </div>
      <div class="flex items-center gap-10">
        <router-link class="btn btn-login" :to="{ name: 'login' }">login</router-link>
        <router-link class="btn btn-signup" :to="{ name: 'signup' }">sign up</router-link>
      </div>
    </nav>

    <ul
      :class="[
        'flex flex-col fixed gap-4 h-screen top-0 w-80 bg-white pt-2 border-l-2 border-black z-20 p-2 transition-all duration-300 ease-in-out',
        isShowNavbar ? 'right-0' : '-right-full'
      ]"
    >
      <li>
        <button @click="toggleNavbar" class="rounded-full border-2 p-1 ml-4 hover:bg-sky-300">
          <CloseIcon />
        </button>
        <hr class="mt-2" />
      </li>
      <li class="navigate active">home</li>
      <li class="navigate">information</li>
      <li class="navigate">result</li>

      <li class="flex flex-col gap-4 justify-end flex-1 pb-2">
        <hr class="border-1 border-gray-600" />
        <router-link class="btn btn-login mx-5" :to="{ name: 'login' }">login</router-link>
        <router-link class="btn btn-signup mx-5" :to="{ name: 'signup' }">sign up</router-link>
      </li>
    </ul>
  </div>
</template>

<style scoped>
.btn {
  @apply text-center px-5 py-2 border rounded-full transition transform duration-1000 ease-in-out hover:translate-y-1;
}

.btn-login {
  @apply bg-transparent hover:bg-sky-300;
}

.btn-signup {
  @apply bg-sky-500 hover:bg-sky-300;
}

.navigate {
  @apply p-4 rounded hover:bg-sky-300 cursor-pointer;
}

.active {
  @apply bg-sky-500 hover:bg-sky-300;
}

@media (max-width: 1024px) {
  nav {
    display: none;
  }
}
</style>
