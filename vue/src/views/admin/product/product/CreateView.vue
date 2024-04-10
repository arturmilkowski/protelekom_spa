<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from '@/stores/store'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'
import InputLabel from '@/components/InputLabel.vue'
import InputGroup from '@/components/InputGroup.vue'
import InputButton from '@/components/InputButton.vue'
import InputField from '@/components/InputField.vue'
import InputSelect from '@/components/InputSelect.vue'
import InputTextarea from '@/components/InputTextarea.vue'
import InputCheckbox from '@/components/InputCheckbox.vue'
import ValidationError from '@/components/ValidationError.vue'

const router = useRouter()
const store = useStore()

const brands = ref([])
const categories = ref([])
let error = ref(null)
const validationError = ref(null)
const apiUrl = 'api/admins/products/products'

const { err: brandErr, collection: brandCollection } = await store.all('api/admins/products/brands')
error.value = brandErr
if (brandCollection.data) {
  brands.value = brandCollection.data
}

const { err: categoryErr, collection: categoryCollection } = await store.all(
  'api/admins/products/categories'
)
error.value = categoryErr
if (categoryCollection.data) {
  categories.value = categoryCollection.data
}

const item = reactive({
  brand_id: 1,
  category_id: 1,
  name: '',
  description: '',
  img: null,
  site_description: '',
  site_keyword: ''
  // hide: 0
})

const create = async () => {
  console.log(item)

  const { err, validationErr, data } = await store.createPostForm(apiUrl, item)
  error.value = err
  validationError.value = validationErr

  if (data?.status == 201) {
    router.push({ name: 'admin.product.product.index' })
  }
}
</script>

<template>
  <HeaderTwo>Produkt</HeaderTwo>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <form @submit.prevent="create">
    <InputGroup>
      <InputLabel for="brand">Firma</InputLabel>
      <InputSelect
        v-model="item.brand_id"
        :items="brands"
        id="brand"
        placeholder="Pole obowiązkowe"
      ></InputSelect>
      <template v-if="validationError?.brand">
        <template v-for="e in validationError.brand" :key="e.brand">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="category">Kategoria</InputLabel>
      <InputSelect
        v-model="item.category_id"
        :items="categories"
        id="category"
        placeholder="Pole obowiązkowe"
      ></InputSelect>
      <template v-if="validationError?.category">
        <template v-for="e in validationError.vategory" :key="e.category">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="name">Nazwa</InputLabel>
      <InputField v-model="item.name" id="name" placeholder="Pole obowiązkowe" />
      <template v-if="validationError?.name">
        <template v-for="e in validationError.name" :key="e.name">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="description">Opis</InputLabel>
      <InputTextarea
        v-model="item.description"
        id="description"
        placeholder="Pole nieobowiązkowe"
      />
      <template v-if="validationError?.description">
        <template v-for="e in validationError.description" :key="e.description">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="img">Grafika</InputLabel>
      <!-- <input type="file" @change="fileChange" />
      <template v-if="validationError?.img">
        <template v-for="e in validationError.img" :key="e.img">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template> -->
    </InputGroup>
    <InputGroup>
      <InputLabel for="site_description">Opis strony</InputLabel>
      <InputField
        v-model="item.site_description"
        id="site_description"
        placeholder="Pole nieobowiązkowe"
      />
      <template v-if="validationError?.site_description">
        <template v-for="e in validationError.site_description" :key="e.site_description">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="site_keyword">Słowa kluczowe</InputLabel>
      <InputField v-model="item.site_keyword" id="site_keyword" placeholder="Pole nieobowiązkowe" />
      <template v-if="validationError?.site_keyword">
        <template v-for="e in validationError.site_keyword" :key="e.site_keyword">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputCheckbox v-model="item.hide" id="hide" label="Ukryj" />
      <template v-if="validationError?.hide">
        <template v-for="e in validationError.hide" :key="e.hide">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputButton>Dodaj</InputButton>
  </form>
  <p class="mt-6">
    <RouterLink :to="{ name: 'admin.product.product.index' }">Powrót</RouterLink>
  </p>
</template>
