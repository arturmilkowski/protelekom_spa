<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useStore } from '@/stores/store'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import InputLabel from '@/components/InputLabel.vue'
import InputGroup from '@/components/InputGroup.vue'
import InputField from '@/components/InputField.vue'
import InputSelect from '@/components/InputSelect.vue'
// import InputTextarea from '@/components/InputTextarea.vue'
import InputCheckbox from '@/components/InputCheckbox.vue'
import InputButton from '@/components/InputButton.vue'
import ValidationError from '@/components/ValidationError.vue'
import TipTap from '@/components/TipTap.vue'
import { RiDeleteBinLine } from '@remixicon/vue'

const route = useRoute()
const router = useRouter()
const store = useStore()

const item = ref(null)
let brands = ref([])
let categories = ref([])
const error = ref(null)
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

const { err, data } = await store.getOne(apiUrl, route.params.id)
error.value = err
item.value = data.data
item.value.hide = Boolean(item.value.hide)

const fileChange = async (event) => {
  item.value.img = event.target.files[0]
}

const update = async () => {
  if (typeof item.value.img == 'string') {
    // send only images, not file name
    delete item.value.img
  }

  const { err, validationErr, data } = await store.updatePostForm(
    apiUrl,
    route.params.id,
    item.value
  )
  error.value = err
  validationError.value = validationErr

  if (data?.status == 200) {
    router.push({ name: 'admin.product.index' })
  }
}

const destroy = async () => {
  if (confirm('Potwierdź')) {
    const { err, data } = await store.destroy(apiUrl, route.params.id)
    error.value = err

    if (data?.status == 204) {
      router.push({ name: 'admin.product.index' })
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
        <TipTap v-model="item.description" id="description" placeholder="Pole nieobowiązkowe" />
        <template v-if="validationError?.description">
          <template v-for="e in validationError.description" :key="e.description">
            <ValidationError>{{ e }}</ValidationError>
          </template>
        </template>
      </InputGroup>
      <!-- <InputGroup>
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
      </InputGroup> -->
      <InputGroup>
        <InputLabel for="img">Grafika</InputLabel>
        <input type="file" @change="fileChange" />
        <template v-if="validationError?.img">
          <template v-for="e in validationError.img" :key="e.img">
            <ValidationError>{{ e }}</ValidationError>
          </template>
        </template>
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
        <InputLabel for="site_keyword">Opis strony</InputLabel>
        <InputField
          v-model="item.site_keyword"
          id="site_keyword"
          placeholder="Pole nieobowiązkowe"
        />
        <template v-if="validationError?.site_keyword">
          <template v-for="e in validationError.site_description" :key="e.site_keyword">
            <ValidationError>{{ e }}</ValidationError>
          </template>
        </template>
      </InputGroup>
      <InputGroup>
        <InputCheckbox v-model="item.hide" id="hide" label="Ukryty" />
        <template v-if="validationError?.hide">
          <template v-for="e in validationError.hide" :key="e.hide">
            <ValidationError>{{ e }}</ValidationError>
          </template>
        </template>
      </InputGroup>
      <InputButton>Edytuj</InputButton>
    </form>
    <BtnGroup>
      <RouterLink :to="{ name: 'admin.product.show', params: { id: item.id } }"
        >🡠 Powrót</RouterLink
      >
      <a @click="destroy()" href="#delete" class="text-red-600"
        ><RiDeleteBinLine
          class="inline mr-0.5 h-4 w-4 sm:h-4 sm:w-4 md:h-4 md:w-4 lg:h-4 lg:w-4 xl:h-5 xl:w-5 2xl:h-5 2xl:w-5"
        />Usuń</a
      >
      <RiDeleteBinLine
        class="inline mr-0.5 h-4 w-4 sm:h-4 sm:w-4 md:h-4 md:w-4 lg:h-4 lg:w-4 xl:h-5 xl:w-5 2xl:h-5 2xl:w-5"
      />
      Usuń
    </BtnGroup>
  </template>
  <AppAlert v-else>Brak danych</AppAlert>
</template>
