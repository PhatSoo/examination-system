<script setup lang="ts">
import LoginForm from '@/components/LoginForm.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'
</script>

<template>
  <AuthLayout>
    <template v-slot:title>login</template>
    <LoginForm />
  </AuthLayout>
</template>
