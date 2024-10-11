<script setup lang="ts">
import ClientLayout from '@/layouts/ClientLayout.vue'
</script>

<template>
  <ClientLayout>
    <div class="min-h-screen py-12 my-10 bg-gray-100 rounded-md">
      <div class="max-w-5xl px-6 mx-auto">
        <!-- Header -->
        <div class="mb-12 text-center">
          <h1 class="mb-4 text-4xl font-bold text-gray-800">About My Examination System</h1>
          <p class="text-lg text-gray-600">
            A modern platform for managing exams, built with Vue.js and Laravel 11
          </p>
        </div>

        <!-- Section: Vue.js Frontend -->
        <div class="p-8 mb-8 bg-white rounded-lg shadow-md">
          <h2 class="mb-4 text-3xl font-semibold text-gray-700">Frontend - Vue.js</h2>
          <p class="mb-6 leading-relaxed text-gray-600">
            The user interface of my Examination System is designed with <strong>Vue.js</strong>, a
            modern and flexible JavaScript framework. Vue.js allows us to create a responsive,
            dynamic, and efficient user experience that works seamlessly across devices.
          </p>
          <ul class="text-gray-600 list-disc list-inside">
            <li class="mb-2">
              <strong>Real-time Exam Interface:</strong> Students can navigate questions, submit
              answers, and track their progress with ease.
            </li>
            <li class="mb-2">
              <strong>Responsive Design:</strong> My system is optimized for both desktop and mobile
              devices.
            </li>
            <li class="mb-2">
              <strong>State Management:</strong> I leverage Vue's state management capabilities to
              handle exam data.
            </li>
            <li class="mb-2">
              <strong>Interactive Components:</strong> My UI is built to be interactive and
              engaging.
            </li>
          </ul>
        </div>

        <!-- Section: Laravel Backend -->
        <div class="p-8 mb-8 bg-white rounded-lg shadow-md">
          <h2 class="mb-4 text-3xl font-semibold text-gray-700">Backend - Laravel 11</h2>
          <p class="mb-6 leading-relaxed text-gray-600">
            At the heart of my system lies <strong>Laravel 11</strong>, the latest version of the
            PHP framework, which powers the backend services. Laravel ensures secure and efficient
            operation of the system.
          </p>
          <ul class="text-gray-600 list-disc list-inside">
            <li class="mb-2">
              <strong>API-Driven Architecture:</strong> Laravel 11 powers a RESTful API for smooth
              frontend-backend communication.
            </li>
            <li class="mb-2">
              <strong>User Authentication & Authorization:</strong> Role-based permissions ensure
              secure user access.
            </li>
            <li class="mb-2">
              <strong>Exam Management:</strong> Admins and instructors can manage exams, including
              random question generation.
            </li>
            <li class="mb-2">
              <strong>Real-time Grading:</strong> The system provides real-time grading and
              performance analytics.
            </li>
          </ul>
        </div>

        <!-- Section: Why Choose -->
        <div class="p-8 mb-8 bg-white rounded-lg shadow-md">
          <h2 class="mb-4 text-3xl font-semibold text-gray-700">
            Why Choose My Examination System?
          </h2>
          <p class="mb-6 leading-relaxed text-gray-600">
            I offer a scalable, secure, and customizable solution that fits institutions of all
            sizes, from small classrooms to large universities.
          </p>
          <ul class="text-gray-600 list-disc list-inside">
            <li class="mb-2">
              <strong>Scalability:</strong> My system supports thousands of students with ease.
            </li>
            <li class="mb-2">
              <strong>Security:</strong> Laravel's security features, including CSRF protection and
              encryption, ensure data safety.
            </li>
            <li class="mb-2">
              <strong>Customization:</strong> The system is highly customizable to meet your
              institution's specific needs.
            </li>
          </ul>
        </div>

        <!-- Call to Action -->
        <div class="mt-12 text-center cursor-pointer">
          <p
            class="px-6 py-3 mx-auto text-white transition duration-300 bg-blue-500 rounded-lg shadow-lg hover:bg-blue-600 w-fit"
          >
            Contact Me to Learn More
          </p>
        </div>
      </div>
    </div>
  </ClientLayout>
</template>

<style scoped></style>
