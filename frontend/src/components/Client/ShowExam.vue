<template>
  <h1 class="mt-20 text-3xl font-bold text-center uppercase">Select an Exam</h1>

  <div class="flex flex-wrap justify-center gap-4 mt-10 mb-5 gap-y-10">
    <router-link :to="{ name: 'exam', params: { id: 1 } }">
      <div class="exam-container">
        <img src="@/assets/images/word.png" alt="image_exam" />

        <p class="mt-2 mr-2 text-end"><strong>duration: </strong><em>10m</em></p>
        <p class="mr-2 text-end"><strong>attempt count: </strong><em>3 times</em></p>
        <p class="mt-2 text-xl font-bold text-center">Word Exam</p>
      </div>
    </router-link>

    <router-link :to="{ name: 'exam', params: { id: 1 } }">
      <div class="exam-container">
        <img src="@/assets/images/word.png" alt="image_exam" />

        <p class="mt-2 mr-2 text-end"><strong>duration: </strong><em>10m</em></p>
        <p class="mr-2 text-end"><strong>attempt count: </strong><em>3 times</em></p>
        <p class="mt-2 text-xl font-bold text-center">Word Exam</p>
      </div>
    </router-link>

    <router-link :to="{ name: 'exam', params: { id: 1 } }">
      <div class="exam-container">
        <img src="@/assets/images/word.png" alt="image_exam" />

        <p class="mt-2 mr-2 text-end"><strong>duration: </strong><em>10m</em></p>
        <p class="mr-2 text-end"><strong>attempt count: </strong><em>3 times</em></p>
        <p class="mt-2 text-xl font-bold text-center">Word Exam</p>
      </div>
    </router-link>

    <router-link :to="{ name: 'exam', params: { id: 1 } }">
      <div class="exam-container">
        <img src="@/assets/images/word.png" alt="image_exam" />

        <p class="mt-2 mr-2 text-end"><strong>duration: </strong><em>10m</em></p>
        <p class="mr-2 text-end"><strong>attempt count: </strong><em>3 times</em></p>
        <p class="mt-2 text-xl font-bold text-center">Word Exam</p>
      </div>
    </router-link>
  </div>
</template>

<style scoped>
img {
  @apply w-64 md:w-72 lg:w-80 rounded-t-3xl;
}

.exam-container {
  @apply bg-slate-100 rounded-3xl transform hover:-translate-y-5 hover:bg-primary-color hover:text-white duration-200 cursor-pointer pb-4;
}
</style>
