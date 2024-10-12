<script setup>
const tableColumns = [
  'Exam ID',
  'Start Time',
  'End Time',
  'Duration (mins)',
  'Total Score',
  'Status',
  'Details'
]

const data = [
  {
    id: '00001',
    startTime: '2024-10-10 10:00',
    endTime: '2024-10-10 10:45',
    duration: 45,
    totalScore: 85.5,
    status: 'Completed',
    link: 'pdf link'
  },
  {
    id: '00002',
    startTime: '2024-10-10 10:00',
    endTime: '2024-10-10 10:45',
    duration: 45,
    totalScore: 85.5,
    status: 'Completed',
    link: 'pdf link'
  },
  {
    id: '00003',
    startTime: '2024-10-10 10:00',
    endTime: '2024-10-10 10:45',
    duration: 45,
    totalScore: 85.5,
    status: 'Pending',
    link: 'pdf link'
  }
]
</script>

<template>
  <div class="container px-4 mx-auto">
    <h2 class="mb-6 text-2xl font-bold text-center">User Exam History</h2>

    <div class="overflow-x-auto">
      <table class="min-w-full table-auto">
        <thead class="bg-gray-100">
          <tr>
            <th
              class="px-4 py-2 text-sm font-medium text-gray-700"
              v-for="(col, idx) in tableColumns"
              :key="idx"
            >
              {{ col }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in data"
            :key="item.id"
            class="h-16 text-sm text-center text-gray-700 duration-300 ease-in-out transform hover:bg-gray-50 hover:font-bold hover:text-lg"
          >
            <td>{{ item.id }}</td>
            <td>{{ item.startTime }}</td>
            <td>{{ item.endTime }}</td>
            <td>{{ item.duration }}</td>
            <td>{{ item.totalScore }}</td>
            <td>
              <span
                :class="[
                  'inline-flex px-2 text-xs font-semibold leading-5  rounded-full',
                  item.status === 'Completed'
                    ? 'text-green-800 bg-green-100'
                    : 'text-red-800 bg-red-100'
                ]"
              >
                {{ item.status }}
              </span>
            </td>
            <td class="cursor-pointer">{{ item.link }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped></style>
