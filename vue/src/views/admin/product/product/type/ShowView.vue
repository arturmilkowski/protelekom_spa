<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { useStore } from '@/stores/store'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import TableTable from '@/components/TableTable.vue'
import TableData from '@/components/TableData.vue'
import ImageModal from '@/components/ImageModal.vue'
import BadgeYesNo from '@/components/BadgeYesNo.vue'
import BadgeCondition from '@/components/BadgeCondition.vue'

const route = useRoute()
const store = useStore()

const item = ref(null)
const error = ref(null)
const showModal = ref(false)
const apiUrl = `api/admins/products/${route.params.product_id}/types`
const apiUrlImage = `api/admins/products/${route.params.product_id}/types/images`

const { err, data } = await store.getOne(apiUrl, route.params.id)
error.value = err
item.value = data.data

const destroyImage = async (id) => {
  if (confirm('Potwierdź')) {
    try {
      await store.destroy(apiUrlImage, id)
    } catch (e) {
      error.value = e
    }

    item.value.img = null
  }
}
</script>

<template>
  <Teleport to="body">
    <ImageModal :show="showModal" :img="item.img" @close="showModal = false" />
  </Teleport>
  <HeaderTwo>Wariant produktu</HeaderTwo>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <template v-if="item">
    <TableTable>
      <tbody>
        <tr>
          <TableData>ID</TableData>
          <TableData>{{ item.id }}</TableData>
        </tr>
        <tr>
          <TableData>ID produktu</TableData>
          <TableData>{{ item.product_id }}</TableData>
        </tr>
        <tr>
          <TableData>Produkt</TableData>
          <TableData>{{ item.product }}</TableData>
        </tr>
        <tr>
          <TableData>Nazwa wariantu</TableData>
          <TableData>{{ item.name }}</TableData>
        </tr>
        <tr>
          <TableData>Cena [zł]</TableData>
          <TableData>{{ item.price }}</TableData>
        </tr>
        <tr>
          <TableData>Cena promocyjna [zł]</TableData>
          <TableData>{{ item.promo_price }}</TableData>
        </tr>
        <tr>
          <TableData>Ilość</TableData>
          <TableData>{{ item.quantity }}</TableData>
        </tr>
        <tr>
          <TableData>Ukryj produkt</TableData>
          <TableData><BadgeYesNo :yes-no="item.hide" /></TableData>
        </tr>
        <tr>
          <TableData>Stan</TableData>
          <TableData>
            <BadgeCondition :new-used="item.condition_id">{{ item.condition }}</BadgeCondition>
          </TableData>
        </tr>
        <tr>
          <TableData>Opis</TableData>
          <TableData>{{ item.description }}</TableData>
        </tr>
        <tr>
          <TableData>Zdjęcie</TableData>
          <TableData>
            <template v-if="item.img">
              <a href="#" id="show-modal" @click="showModal = true">
                <img :src="item.img" width="200" />
              </a>
              <a @click="destroyImage(route.params.id)" href="#usunGrafike" class="btn btn-danger"
                >Usuń</a
              >
            </template>
            <template v-else>&mdash;</template>
          </TableData>
        </tr>
        <tr>
          <TableData>Utworzono</TableData>
          <TableData>{{ item.created_at }}</TableData>
        </tr>
        <tr>
          <TableData>Edytowano</TableData>
          <TableData>{{ item.updated_at }}</TableData>
        </tr>
      </tbody>
    </TableTable>
  </template>
  <BtnGroup>
    <RouterLink :to="{ name: 'admin.product.type.index', params: { id: 1 } }">🡠 Powrót</RouterLink>
    <RouterLink
      :to="{
        name: 'admin.product.type.edit',
        params: { product_id: item.product_id, id: item.id }
      }"
      >Edytuj</RouterLink
    >
  </BtnGroup>
</template>
