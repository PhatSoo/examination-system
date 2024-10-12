<script setup>
const { user } = defineProps(['user'])

const localInfo = { ...user }
</script>

<template>
  <div class="max-w-xl p-6 mx-auto mt-10 bg-white rounded-lg shadow-md">
    <h2 class="mb-4 text-xl font-bold text-center">User Profile</h2>

    <div class="mb-4">
      <label class="block mb-2 text-sm font-bold text-gray-700">Name</label>
      <input
        type="text"
        v-model="localInfo.name"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
        disabled
      />
    </div>

    <div class="mb-4">
      <label class="block mb-2 text-sm font-bold text-gray-700">Email</label>
      <input
        type="email"
        v-model="localInfo.email"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
        disabled
      />
    </div>

    <div class="mb-4">
      <label class="block mb-2 text-sm font-bold text-gray-700">Password</label>
      <input
        type="password"
        v-model="localInfo.password"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
        disabled
      />
    </div>
  </div>

  <div class="flex justify-center mt-10">
    <div
      class="px-10 py-4 font-bold text-center rounded-full bg-rose-400 hover:bg-rose-600 hover:text-white"
    >
      Change Info
    </div>
  </div>
</template>
