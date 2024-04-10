<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useStore } from '@/stores/store'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import InputLabel from '@/components/InputLabel.vue'
import InputGroup from '@/components/InputGroup.vue'
import InputButton from '@/components/InputButton.vue'
import ValidationError from '@/components/ValidationError.vue'

const route = useRoute()
const router = useRouter()
const store = useStore()

const item = ref(null)
const name = ref('')
const error = ref(null)
const validationError = ref(null)
const apiUrl = 'api/admins/products/products'

const { err, data } = await store.getOne(apiUrl, route.params.id)
error.value = err
item.value = data.data
name.value = item.value.name
console.log(item)
const update = async () => {
  const payload = { name: name.value }
  const { err, validationErr, data } = await store.update(apiUrl, route.params.id, payload)
  error.value = err
  validationError.value = validationErr

  if (data?.status == 200) {
    router.push({ name: 'admin.product.products.index' })
  }
}

const destroy = async () => {
  if (confirm('Potwierdź')) {
    const { err, data } = await store.destroy(apiUrl, route.params.id)
    error.value = err

    if (data?.status == 204) {
      router.push({ name: 'admin.product.products.index' })
    }
  }
}
</script>

<template>
  <HeaderTwo>Edycja</HeaderTwo>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <template v-if="item">
    <form @submit.prevent="update">
      <InputGroup>
        <InputLabel for="name">Nazwa</InputLabel>
        <input v-model="name" class="border border-black" type="text" id="name" />
        <template v-if="validationError?.name">
          <template v-for="e in validationError.name" :key="e.name">
            <ValidationError>{{ e }}</ValidationError>
          </template>
        </template>
      </InputGroup>
      <InputButton>Edytuj</InputButton>
    </form>
    <BtnGroup>
      <RouterLink :to="{ name: 'admin.product.product.show', params: { id: item.id } }"
        >Powrót</RouterLink
      >
      <a @click="destroy()" href="#delete">Usuń</a>
    </BtnGroup>
  </template>
  <AppAlert v-else>Brak danych</AppAlert>
</template>
