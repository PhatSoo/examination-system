<script setup>
import MenuIcon from '@/components/icons/MenuIcon.vue'
import CloseIcon from '@/components/icons/CloseIcon.vue'
import { useRoute } from 'vue-router'
import { reactive } from 'vue'

const { isShowNavbar, toggleNavbar, isSticky } = defineProps([
  'isShowNavbar',
  'toggleNavbar',
  'isSticky'
])
const route = useRoute()

const navigate = reactive([
  {
    displayName: 'Home',
    routeName: 'client',
    route: '/'
  },
  {
    displayName: 'Information',
    routeName: 'info',
    route: '/info'
  },
  {
    displayName: 'About',
    routeName: 'about',
    route: '/about'
  }
])
</script>

<template>
  <header
    :class="[
      'flex items-center justify-between h-20 px-4 py-9 bg-white border-b-2 shadow-lg',
      {
        'bg-opacity-90 fixed w-full duration-300 -top-20 translate-y-full z-50': isSticky
      }
    ]"
  >
    <div>
      <router-link :to="{ name: 'client' }">
        <h1 class="text-3xl w-fit">examination test</h1>
      </router-link>
    </div>

    <div class="lg:hidden">
      <button @click="toggleNavbar"><MenuIcon /></button>
    </div>

    <nav class="gap-10 lg:flex">
      <div class="flex items-center justify-center gap-10">
        <router-link v-for="item in navigate" :to="{ name: item.routeName }" :key="item.routeName">
          <div :class="['navigate', route.name === item.routeName ? 'active' : '']">
            {{ item.displayName }}
          </div>
        </router-link>
      </div>
      <div class="flex items-center gap-10">
        <router-link class="btn btn-login" :to="{ name: 'login' }">login</router-link>
        <router-link class="btn btn-signup" :to="{ name: 'signup' }">sign up</router-link>
      </div>
    </nav>

    <ul
      :class="[
        'flex flex-col fixed gap-4 h-screen top-0 w-80 bg-white pt-2 rounded-l-xl border-black z-50 p-2 transition-all duration-300 ease-in-out',
        isShowNavbar ? 'right-0' : '-right-full'
      ]"
    >
      <li>
        <button @click="toggleNavbar" class="p-1 ml-4 border-2 rounded-full hover:bg-sky-300">
          <CloseIcon />
        </button>
        <hr class="mt-2" />
      </li>

      <router-link v-for="item in navigate" :to="{ name: item.routeName }" :key="item.routeName">
        <li :class="['navigate', route.name === item.routeName ? 'active' : '']">
          {{ item.displayName }}
        </li>
      </router-link>

      <li class="flex flex-col justify-end flex-1 gap-4 pb-2">
        <hr class="border-gray-600 border-1" />
        <router-link class="mx-5 btn btn-login" :to="{ name: 'login' }">login</router-link>
        <router-link class="mx-5 btn btn-signup" :to="{ name: 'signup' }">sign up</router-link>
      </li>
    </ul>
  </header>
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

* {
  text-transform: capitalize;
}
</style>
