<script setup lang="ts">
import UserHistory from '@/components/Client/UserHistory.vue'
import UserInfo from '@/components/Client/UserInfo.vue'
import ClientLayout from '@/layouts/ClientLayout.vue'
import { ref } from 'vue'

const user = {
  name: 'John Doe',
  email: 'john.doe@example.com',
  password: '********'
}

const tabs = [
  {
    id: 1,
    name: 'Profile'
  },
  {
    id: 2,
    name: 'History'
  }
]

const tabSelected = ref(1)
</script>

<template>
  <ClientLayout>
    <div class="flex flex-col h-full py-10">
      <div class="relative flex justify-start gap-1 ml-5">
        <label
          v-for="tab in tabs"
          :key="tab.id"
          :class="[
            'relative p-4 text-center border-2 rounded-t-lg w-36',
            tabSelected === tab.id
              ? 'bg-slate-200 top-1 z-30 border-b-0 border-0 font-bold'
              : 'top-3 hover:-translate-y-2 duration-150 ease-in-out hover:bg-slate-100 hover:font-bold'
          ]"
        >
          <input
            type="radio"
            hidden
            name="tab_radio"
            @click="tabSelected = tab.id"
            :value="tab.id"
          />
          {{ tab.name }}
        </label>
      </div>

      <div class="relative z-10 flex-1 p-4 rounded-lg bg-slate-200">
        <UserInfo v-if="tabSelected === 1" :user />
        <UserHistory v-else />
      </div>
    </div>
  </ClientLayout>
</template>

<style scoped></style>
