<script setup>
import { ref } from 'vue'
import { useStore } from '@/stores/store'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'

const store = useStore()
const collection = ref([])
const error = ref(null)

const { err, collection: res } = await store.all('api/about')
error.value = err
collection.value = res
</script>

<template>
  <HeaderTwo>O aplikacji</HeaderTwo>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <template v-else>
    <div class="flex flex-row px-2 py-2 border-b-[1px] border-gray-300">
      <span class="basis-48">Wersja PHP:</span>
      <span>{{ collection.php }}</span>
    </div>
    <div class="flex flex-row px-2 py-2 border-b-[1px] border-gray-300">
      <span class="basis-48">Wersja Laravel:</span>
      <span>{{ collection.laravel }}</span>
    </div>
    <div class="flex flex-row px-2 py-2 border-b-[1px] border-gray-300">
      <span class="basis-48">Środowisko:</span>
      <span>{{ collection.environment }}</span>
    </div>
    <div class="flex flex-row px-2 py-2 border-b-[1px] border-gray-300">
      <span class="basis-48">Użytkownik:</span>
      <span>{{ collection.user.name }} &mdash; {{ collection.user.email }}</span>
    </div>
  </template>
</template>
