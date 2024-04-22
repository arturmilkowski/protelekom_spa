<script setup>
import { ref } from 'vue'
import { useStore } from '@/stores/store'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'
const store = useStore()

const products = ref([])
const error = ref(null)
const apiUrl = 'api/admins/products/products'

const { err, collection } = await store.all(apiUrl)
error.value = err
products.value = collection.data
</script>

<template>
  <HeaderTwo>Index</HeaderTwo>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <section
    v-else
    class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4"
  >
    <div v-for="(product, index) in products" :key="product.id" class="mb-12">
      <div
        class="border-y-[1px] hover:bg-gray-50 border-black p-4 h-full bg-contain bg-right bg-no-repeat hover:bg-cover hover:bg-center"
        :style="{ backgroundImage: 'url(' + product.img + ')' }"
      >
        <div>{{ index + 1 }}</div>
        <div>{{ product.brand }}</div>
        <div>{{ product.category }}</div>
        <div>{{ product.name }}</div>
        <div>{{ product.description }}</div>
        <div>img: {{ product.img }}</div>
        <!-- <template v-if="product.img">
          <img :src="product.img" />
        </template> -->
      </div>
    </div>
  </section>
</template>
