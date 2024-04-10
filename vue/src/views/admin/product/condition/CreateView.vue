<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from '@/stores/store'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'
import InputLabel from '@/components/InputLabel.vue'
import InputGroup from '@/components/InputGroup.vue'
import InputButton from '@/components/InputButton.vue'
import InputField from '@/components/InputField.vue'
import ValidationError from '@/components/ValidationError.vue'

const router = useRouter()
const store = useStore()

let name = ref('')
let error = ref(null)
const validationError = ref(null)
const apiUrl = 'api/admins/products/conditions'

const create = async () => {
  const { err, validationErr, data } = await store.create(apiUrl, { name: name.value })
  error.value = err
  validationError.value = validationErr

  if (data?.status == 201) {
    router.push({ name: 'admin.product.condition.index' })
  }
}
</script>

<template>
  <HeaderTwo>Stan produktu</HeaderTwo>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <form @submit.prevent="create">
    <InputGroup>
      <InputLabel for="name">Nazwa</InputLabel>
      <InputField v-model="name" id="name" placeholder="Pole obowiązkowe" />
      <template v-if="validationError?.name">
        <template v-for="e in validationError.name" :key="e.name">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputButton>Dodaj</InputButton>
  </form>
  <p class="mt-6">
    <RouterLink :to="{ name: 'admin.product.condition.index' }">Powrót</RouterLink>
  </p>
</template>
