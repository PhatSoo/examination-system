<script setup>
const data = [
  {
    id: 1,
    image_url: 'src/assets/images/word.png',
    duration: 10,
    attempt_count: 3,
    title: 'Word Exam'
  },
  {
    id: 2,
    image_url: 'src/assets/images/word.png',
    duration: 10,
    attempt_count: 3,
    title: 'Word Exam'
  },
  {
    id: 3,
    image_url: 'src/assets/images/word.png',
    duration: 10,
    attempt_count: 3,
    title: 'Word Exam'
  },
  {
    id: 4,
    image_url: 'src/assets/images/word.png',
    duration: 10,
    attempt_count: 3,
    title: 'Word Exam'
  }
]
</script>

<template>
  <h1 class="mt-20 text-3xl font-bold text-center uppercase">Select an Exam</h1>

  <div class="flex flex-wrap justify-center gap-4 mt-10 mb-5 gap-y-10">
    <router-link
      v-for="item in data"
      :key="item.id"
      :to="{ name: 'exam', params: { id: item.id } }"
    >
      <div
        class="pb-4 duration-200 transform cursor-pointer bg-slate-100 rounded-3xl hover:-translate-y-5 hover:bg-primary-color hover:text-white"
      >
        <img :src="item.image_url" alt="image_exam" class="w-64 md:w-72 lg:w-80 rounded-t-3xl" />

        <p class="mt-2 mr-2 text-end">
          <strong>Duration: </strong><em>{{ item.duration }}m</em>
        </p>
        <p class="mr-2 text-end">
          <strong>Attempt count: </strong><em>{{ item.attempt_count }} times</em>
        </p>
        <p class="mt-2 text-xl font-bold text-center">{{ item.title }}</p>
      </div>
    </router-link>
  </div>
</template>

<style scoped></style>
