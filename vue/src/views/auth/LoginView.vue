<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import HeaderTwo from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import InputButton from '@/components/InputButton.vue'
import InputGroup from '@/components/InputGroup.vue'
import InputField from '@/components/InputField.vue'
import ValidationError from '@/components/ValidationError.vue'

const router = useRouter()
const store = useAuthStore()
const error = ref(null)
const validationError = ref(null)

const email = ref('artur-milkowski@tlen.pl')
const password = ref('12345678')

const onSubmit = async () => {
  const payload = {
    email: email.value,
    password: password.value
  }
  const { err, validationErr, response } = await store.login(payload)
  error.value = err
  validationError.value = validationErr

  if (response?.status === 204 || response?.status === 200) {
    router.push({ name: 'page.home' })
  }
}
</script>

<template>
  <HeaderTwo>Logowanie</HeaderTwo>
  <AppAlert v-if="error" type="danger">{{ error }}</AppAlert>
  <template v-if="store.isGuest">
    <form @submit.prevent="onSubmit">
      <InputGroup>
        <InputField v-model="email" type="email" id="email" placeholder="Login" />
        <template v-if="validationError?.email">
          <template v-for="e in validationError.email" :key="e.name">
            <ValidationError>{{ e }}</ValidationError>
          </template>
        </template>
      </InputGroup>
      <InputGroup>
        <InputField v-model="password" type="password" id="password" placeholder="Hasło" />
        <template v-if="validationError?.password">
          <template v-for="e in validationError.password" :key="e.name">
            <ValidationError>{{ e }}</ValidationError>
          </template>
        </template>
      </InputGroup>
      <InputButton />
    </form>
  </template>
  <AppAlert v-else>Jesteś już zalogowany</AppAlert>
</template>
