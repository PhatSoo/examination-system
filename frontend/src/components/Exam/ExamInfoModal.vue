<script setup>
const { data } = defineProps(['data'])
</script>

<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="w-4/5 p-8 bg-white rounded-lg shadow-lg md:w-1/3">
      <h2 class="mb-4 text-2xl font-semibold text-center">Exam Information</h2>
      <div class="p-2 border-4 rounded-lg border-violet-400">
        <span class="flex justify-between px-2 py-4 border-b-2">
          <p>Exam Name:</p>
          <strong>{{ data.examName }}</strong>
        </span>

        <span class="flex justify-between px-2 py-4 border-b-2">
          <p>Duration:</p>
          <strong>{{ data.duration }}</strong>
        </span>

        <span class="flex justify-between px-2 py-4 border-b-2">
          <p>Correct Answers:</p>
          <strong>{{ data.correctAnswer }}</strong>
        </span>

        <span class="flex justify-between px-2 py-4">
          <p>Total Questions:</p>
          <strong>{{ data.totalQuestion }}</strong>
        </span>
      </div>

      <div class="flex justify-center mt-5 space-x-4 md:justify-end">
        <router-link :to="{ name: 'client' }">
          <button
            class="px-4 py-2 font-bold text-white bg-red-600 rounded hover:bg-gray-400 hover:text-black"
          >
            Exit
          </button>
        </router-link>

        <button
          class="px-4 py-2 font-bold text-white bg-green-600 rounded hover:bg-gray-400 hover:text-black"
        >
          Result
        </button>
      </div>
    </div>
  </div>
</template>
