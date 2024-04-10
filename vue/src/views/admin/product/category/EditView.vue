<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useShow } from '@/composables/show'
import axios from 'axios'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import InputLabel from '@/components/InputLabel.vue'
import InputGroup from '@/components/InputGroup.vue'
import InputButton from '@/components/InputButton.vue'
import ValidationError from '@/components/ValidationError.vue'
import { useUpdate } from '@/composables/update.js'
import { useDestroy } from '@/composables/destroy.js'

const route = useRoute()
const router = useRouter()

const item = ref(null)
const name = ref('')
const error = ref(null)
const validationError = ref(null)
const apiUrl = `api/admins/products/categories/${route.params.id}`

/*
try {
  const res = await axios(apiUrl)
  item.value = res.data.data
  name.value = item.value.name
} catch (e) {
  error.value = e
}
*/
const { err, data } = await useShow(apiUrl)
error.value = err
item.value = data
name.value = item.value.name

const update = async () => {
  const payload = { name: name.value }
  const { err, validationErr, data } = await useUpdate(apiUrl, payload)
  error.value = err
  validationError.value = validationErr

  if (data?.status == 200) {
    router.push({ name: 'admin.product.category.index' })
  }
}

const destroy = async () => {
  if (confirm('Potwierdź')) {
    const { err, data } = await useDestroy(apiUrl)
    error.value = err

    if (data?.status == 204) {
      router.push({ name: 'admin.product.category.index' })
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
      <RouterLink :to="{ name: 'admin.product.category.show', params: { id: item.id } }"
        >Powrót</RouterLink
      >
      <a @click="destroy()" href="#delete">Usuń</a>
    </BtnGroup>
  </template>
  <AppAlert v-else>Brak danych</AppAlert>
</template>
