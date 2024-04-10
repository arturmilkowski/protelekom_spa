<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import HeaderTwo from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
const error = ref(null)

onMounted(async () => {
  const router = useRouter()
  const store = useAuthStore()
  const { err, success } = await store.logout()
  error.value = err

  if (success) {
    router.push({ name: 'page.home' })
  }
})
</script>

<template>
  <HeaderTwo>Wylogowanie</HeaderTwo>
  <AppAlert v-if="error" type="danger">{{ error }}</AppAlert>
</template>
