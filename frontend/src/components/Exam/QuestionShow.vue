<script setup>
import { reactive } from 'vue'
import AnswerButton from './AnswerButton.vue'

const { question_number } = defineProps(['question_number'])

const question_content = reactive({
  id: 1,
  title: 'How many ways to center a <div>?',
  answer: [
    {
      id: 1,
      title: 1
    },
    {
      id: 2,
      title: 2
    },
    {
      id: 3,
      title: 3
    },
    {
      id: 4,
      title: 4
    }
  ],
  selectedAnswer: 0
})

const buttonColors = ['red', 'green', 'blue', 'yellow']
</script>

<template>
  <div class="container flex flex-col h-full bg-gray-200 rounded-3xl">
    <div class="bg-slate-300 rounded-3xl">
      <p class="py-4 text-lg text-center">
        Question Number: <strong>#{{ question_number }}</strong>
      </p>
    </div>

    <div class="p-4 overflow-auto text-xl h-52">
      {{ question_content.title }}
    </div>

    <div class="flex flex-wrap flex-1">
      <AnswerButton
        v-for="(item, idx) in question_content.answer"
        :key="item.id"
        :color="buttonColors[idx]"
        >{{ item.title }}</AnswerButton
      >
    </div>
  </div>
</template>
