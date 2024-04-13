<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { useStore } from '@/stores/store'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import TableTable from '@/components/TableTable.vue'
import TableData from '@/components/TableData.vue'
import YesNoBadge from '@/components/YesNoBadge.vue'

const route = useRoute()
const store = useStore()

const item = ref(null)
const error = ref(null)
const apiUrl = `api/admins/products/${route.params.product_id}/types`
// console.log(apiUrl)

const { err, data } = await store.getOne(apiUrl, route.params.id)
error.value = err
item.value = data.data
</script>

<template>
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
          <TableData>-</TableData>
          <TableData>{{ item }}</TableData>
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
          <TableData><YesNoBadge :yes-no="item.hide" /></TableData>
        </tr>
        <tr>
          <TableData>Stan</TableData>
          <TableData>{{ item.condition_id }} | {{ item.condition }}</TableData>
        </tr>
        <tr>
          <TableData>Opis</TableData>
          <TableData>{{ item.description }}</TableData>
        </tr>
        <tr>
          <TableData>Zdjęcie</TableData>
          <TableData>
            <template v-if="item.img">
              <!-- <a href="#" id="show-modal" @click="showModal = true"> -->
              <img :src="item.img" width="200" />
              <!-- </a> -->
              <!-- <a @click="destroyImage(route.params.id)" href="#usunGrafike" class="btn btn-danger"
                >Usuń</a
              > -->
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
  </BtnGroup>
</template>
