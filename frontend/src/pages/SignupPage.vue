<script setup lang="ts">
import SignUpForm from '@/components/SignUpForm.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'
</script>

<template>
  <AuthLayout>
    <template v-slot:title>signup</template>
    <SignUpForm />
  </AuthLayout>
</template>
