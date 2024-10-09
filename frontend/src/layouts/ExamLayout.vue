<script setup>
import ExamHeader from '@/components/Exam/ExamHeader.vue'
import ProgressTable from '@/components/Exam/ProgressTable.vue'
import QuestionShow from '@/components/Exam/QuestionShow.vue'
import ConfirmModal from '@/components/Exam/ConfirmModal.vue'
import { onBeforeUnmount, onMounted, reactive, ref } from 'vue'
import { onBeforeRouteLeave } from 'vue-router'
import ExamInfoModal from '@/components/Exam/ExamInfoModal.vue'

const statusArr = reactive([
  {
    question_number: 1,
    question_status: 0,
    question_id: 1
  },
  {
    question_number: 2,
    question_status: 0,
    question_id: 2
  },
  {
    question_number: 3,
    question_status: 1,
    question_id: 3
  },
  {
    question_number: 4,
    question_status: 0,
    question_id: 4
  },
  {
    question_number: 5,
    question_status: 2,
    question_id: 5
  },
  {
    question_number: 6,
    question_status: 1,
    question_id: 6
  },
  {
    question_number: 7,
    question_status: 2,
    question_id: 7
  },
  {
    question_number: 8,
    question_status: 1,
    question_id: 8
  },
  {
    question_number: 9,
    question_status: 1,
    question_id: 9
  },
  {
    question_number: 10,
    question_status: 0,
    question_id: 10
  }
])

const selectedQuestion = ref(1)
const duration = ref(20)
const showConfirm = ref(false)
const isSubmit = ref(false)
const data = reactive({
  examName: '',
  duration: 0,
  correctAnswer: 0,
  totalQuestion: 0
})

const handleChangeQuestion = (question_id) => {
  selectedQuestion.value = question_id
}
const handleShowConfirm = () => {
  showConfirm.value = !showConfirm.value
}
const handleSubmit = () => {
  isSubmit.value = true

  Object.assign(data, {
    examName: 'exam name',
    duration: 20,
    correctAnswer: 18,
    totalQuestion: 20
  })

  // turn off show confirm
  handleShowConfirm()
}

// Catch event go back & reload page
onMounted(() => {
  window.addEventListener('beforeunload', handleBeforeUnload)
})
onBeforeUnmount(() => {
  window.removeEventListener('beforeunload', handleBeforeUnload)
})
const handleBeforeUnload = (event) => {
  event.returnValue = 'message'
}
onBeforeRouteLeave((to, from, next) => {
  // check User exit after submit
  if (!isSubmit.value) {
    // User not submit
    const confirm = window.confirm('If you leave the Test will end here!')
    if (confirm) {
      next()
    }
  } else {
    // User submitted
    next()
  }
})
// End Catch event go back & reload page
</script>

<template>
  <div class="flex flex-col h-screen bg-cyan-300">
    <section class="bg-blue-200">
      <ExamHeader :duration="duration * 60" @submit-exam="handleShowConfirm" />
    </section>

    <section class="flex flex-1">
      <div class="flex-grow p-4 border-none rounded-r-3xl bg-sky-500">
        <QuestionShow :question_number="statusArr[selectedQuestion - 1].question_number" />
      </div>

      <div class="w-1/4 h-full">
        <ProgressTable :statusArr :selectedQuestion @change-question="handleChangeQuestion" />
      </div>
    </section>

    <ConfirmModal
      v-if="showConfirm"
      @close-modal="handleShowConfirm"
      @submit-confirm="handleSubmit"
    />

    <ExamInfoModal v-if="isSubmit" :data />
  </div>
</template>
