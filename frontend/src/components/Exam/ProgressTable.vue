<script setup lang="ts">
import QuestionButton from './QuestionButton.vue'

const { statusArr, selectedQuestion } = defineProps(['statusArr', 'selectedQuestion'])

const statusMapping = {
  0: 'bg-white', // not choose
  1: 'bg-green-300', // chosen
  2: 'bg-red-300' // bookmark
}
</script>

<template>
  <div class="mt-5">
    <p class="mb-5 text-lg font-medium text-center capitalize">list questions</p>
    <QuestionButton
      v-for="item in statusArr"
      :key="item.question_id"
      :status="statusMapping[item.question_status]"
      :isClicked="item.question_number === selectedQuestion"
      @click="$emit('changeQuestion', item.question_id)"
      >{{ item.question_number }}</QuestionButton
    >
  </div>
</template>
