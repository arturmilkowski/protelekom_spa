<script setup>
import axios from 'axios'
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'
import InputLabel from '@/components/InputLabel.vue'
import InputGroup from '@/components/InputGroup.vue'
import InputButton from '@/components/InputButton.vue'
import ValidationError from '@/components/ValidationError.vue'

const router = useRouter()

let name = ref('')
let error = ref(null)
const validationError = ref(null)
const apiUrl = 'api/admins/products/brands'
const input = ref(null)

onMounted(() => {
  input.value.focus()
})

const store = async () => {
  const item = { name: name.value }
  let data = null
  try {
    data = await axios.post(apiUrl, item)
  } catch (e) {
    if (e.response.status != 422) {
      error.value = e
    }
    if (e.response?.data.errors) {
      validationError.value = e.response.data.errors
    }
  }

  if (data?.status == 201) {
    router.push({ name: 'admin.product.brand.index' })
  }
}
</script>

<template>
  <HeaderTwo>Firma</HeaderTwo>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <form @submit.prevent="store">
    <InputGroup>
      <InputLabel for="name">Nazwa</InputLabel>
      <input v-model="name" ref="input" class="border border-black" type="text" id="name" />
      <template v-if="validationError?.name">
        <template v-for="e in validationError.name" :key="e.name">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputButton>Dodaj</InputButton>
  </form>
  <p class="mt-6"><RouterLink :to="{ name: 'admin.product.brand.index' }">Powrót</RouterLink></p>
</template>
