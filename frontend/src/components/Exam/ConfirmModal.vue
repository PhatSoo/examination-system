<script setup>
defineEmits(['close-modal', 'submit-confirm'])
</script>

<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="w-1/3 p-8 bg-white rounded-lg shadow-lg">
      <h2 class="mb-4 text-xl font-semibold">Submit Confirmation</h2>
      <p class="mb-4">Are you sure you want to submit your exam?</p>
      <div class="flex justify-end space-x-4">
        <button
          @click="$emit('close-modal')"
          class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
        >
          Cancel
        </button>
        <button
          @click="$emit('submit-confirm')"
          class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600"
        >
          Submit
        </button>
      </div>
    </div>
  </div>
</template>
