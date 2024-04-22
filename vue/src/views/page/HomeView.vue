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
    class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-4"
  >
    <div v-for="(product, index) in products" :key="product.id" class="mb-12">
      <div
        class="border-black border-y-[1px] hover:bg-gray-50 p-4 h-full bg-contain bg-right bg-no-repeat hover:bg-cover hover:bg-center"
        :style="{ backgroundImage: 'url(' + product.img + ')' }"
      >
        <div class="text-xs sm:text-xs md:text-sm lg:text-base xl:text-sm 2xl:text-sm">
          {{ index + 1 }}
        </div>
        <h5 class="text-xs sm:text-xs md:text-sm lg:text-base xl:text-sm 2xl:text-sm">
          {{ product.category }}
        </h5>
        <h4 class="text-xs sm:text-xs md:text-sm lg:text-base xl:text-base 2xl:text-lg">
          {{ product.brand }}
        </h4>
        <h3 class="text-xs sm:text-xs md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
          <a href="#" title="Pokaż" class="hover:bg-black"
            >{{ product.name }}
            <span class="text-xs sm:text-xs md:text-sm lg:text-base xl:text-sm 2xl:text-sm"
              >🡢</span
            ></a
          >
        </h3>
        <!-- <template v-if="product.img">
          <img :src="product.img" />
        </template> -->
      </div>
    </div>
  </section>
</template>
