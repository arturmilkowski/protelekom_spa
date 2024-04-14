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
import InputTextarea from '@/components/InputTextarea.vue'
import InputCheckbox from '@/components/InputCheckbox.vue'
import InputButton from '@/components/InputButton.vue'
import ValidationError from '@/components/ValidationError.vue'

const route = useRoute()
const router = useRouter()
const store = useStore()

const item = ref(null)
const conditions = ref([])
const error = ref(null)
const validationError = ref(null)
const apiUrl = `api/admins/products/${route.params.product_id}/types`
const apiUrlCondition = 'api/admins/products/conditions'

const { err: conditionErr, collection } = await store.all(apiUrlCondition)
error.value = conditionErr
if (collection.data) {
  conditions.value = collection.data
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
    delete item.value.img // send only images, not file name
  }

  const { err, validationErr, data } = await store.updatePostForm(apiUrl, item.value.id, item.value)
  error.value = err
  validationError.value = validationErr

  if (data?.status == 200) {
    router.push({
      name: 'admin.product.type.show',
      params: { product_id: route.params.product_id, id: item.value.id }
    })
  }
}

const destroy = async () => {
  if (confirm('Potwierdź')) {
    const { err, data } = await store.destroy(apiUrl, route.params.id)
    error.value = err

    if (data?.status == 204) {
      router.push({ name: 'admin.product.type.index', params: { id: route.params.product_id } })
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
        <InputField v-model="item.name" id="name" placeholder="Pole obowiązkowe" />
        <template v-if="validationError?.name">
          <template v-for="e in validationError.name" :key="e.name">
            <ValidationError>{{ e }}</ValidationError>
          </template>
        </template>
      </InputGroup>
      <InputGroup>
        <InputLabel for="price">Cena</InputLabel>
        <InputField
          type="number"
          v-model="item.price"
          id="price"
          min="1"
          max="99999"
          step="1"
          placeholder="Pole obowiązkowe"
        />
        <template v-if="validationError?.price">
          <template v-for="e in validationError.price" :key="e.price">
            <ValidationError>{{ e }}</ValidationError>
          </template>
        </template>
      </InputGroup>
      <InputGroup>
        <InputLabel for="promo_price">Cena promocyjna</InputLabel>
        <InputField
          type="number"
          v-model="item.promo_price"
          id="promo_price"
          max="99999"
          step="1"
          placeholder="Pole nieobowiązkowe"
        />
        <template v-if="validationError?.promo_price">
          <template v-for="e in validationError.promo_price" :key="e.promo_price">
            <ValidationError>{{ e }}</ValidationError>
          </template>
        </template>
      </InputGroup>
      <InputGroup>
        <InputLabel for="quantity">Ilość</InputLabel>
        <InputField
          type="number"
          v-model="item.quantity"
          id="quantity"
          min="1"
          max="9999"
          placeholder="Pole obowiązkowe"
        />
        <template v-if="validationError?.promo_price">
          <template v-for="e in validationError.promo_price" :key="e.promo_price">
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
      <InputGroup>
        <InputLabel for="condition">Stan</InputLabel>
        <InputSelect
          v-model="item.condition_id"
          :items="conditions"
          id="condition"
          placeholder="Pole obowiązkowe"
        ></InputSelect>
        <template v-if="validationError?.condition">
          <template v-for="e in validationError.condition" :key="e.condition">
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
        <input type="file" @change="fileChange" />
        <template v-if="validationError?.img">
          <template v-for="e in validationError.img" :key="e.img">
            <ValidationError>{{ e }}</ValidationError>
          </template>
        </template>
      </InputGroup>
      <InputButton>Edytuj</InputButton>
    </form>
    <BtnGroup>
      <RouterLink
        :to="{
          name: 'admin.product.type.show',
          params: { product_id: item.product_id, id: item.id }
        }"
        >Powrót</RouterLink
      >
      <a @click="destroy()" href="#delete">Usuń</a>
    </BtnGroup>
  </template>
  <AppAlert v-else>Brak danych</AppAlert>
</template>
