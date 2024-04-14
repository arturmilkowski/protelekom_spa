<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useStore } from '@/stores/store'
import HeaderTwo from '@/components/HeaderTwo.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import AppAlert from '@/components/AppAlert.vue'
import TableTable from '@/components/TableTable.vue'
import TableHeaderRow from '@/components/TableHeaderRow.vue'
import TableHeader from '@/components/TableHeader.vue'
import TableData from '@/components/TableData.vue'
import BadgeYesNo from '@/components/BadgeYesNo.vue'
import BadgeCondition from '@/components/BadgeCondition.vue'

const route = useRoute()
const router = useRouter()
const store = useStore()

const items = ref([])
const error = ref(null)
const apiUrl = `api/admins/products/${route.params.id}/types`
const { err, collection } = await store.all(apiUrl)
error.value = err
items.value = collection.data

if (error.value?.message == 'Request failed with status code 401') {
  router.push({ name: 'logout' })
}
</script>

<template>
  <HeaderTwo>Typy produktu</HeaderTwo>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <template v-else>
    <p class="my-6">
      <RouterLink :to="{ name: 'admin.product.type.create', params: { id: route.params.id } }"
        >Dodaj</RouterLink
      >
    </p>
    <TableTable v-if="items.length">
      <thead>
        <TableHeaderRow>
          <TableHeader>LP</TableHeader>
          <TableHeader>ID</TableHeader>
          <TableHeader>ID produktu</TableHeader>
          <TableHeader>Produkt</TableHeader>
          <TableHeader>Nazwa</TableHeader>
          <TableHeader>Cena [zł]</TableHeader>
          <TableHeader>Cena promocyjna [zł]</TableHeader>
          <TableHeader>Stan</TableHeader>
          <TableHeader>Ilość</TableHeader>
          <TableHeader>Ukryty</TableHeader>
          <TableHeader>Akcja</TableHeader>
        </TableHeaderRow>
      </thead>
      <tbody>
        <tr v-for="(item, index) in items" :key="item.id">
          <TableData>{{ index + 1 }}</TableData>
          <TableData>{{ item.id }}</TableData>
          <TableData>{{ item.product_id }}</TableData>
          <TableData>{{ item.product }}</TableData>
          <TableData>{{ item.name }}</TableData>
          <TableData>{{ item.price }}</TableData>
          <TableData>{{ item.promo_price }}</TableData>
          <TableData>
            <BadgeCondition :new-used="item.condition_id">{{ item.condition }}</BadgeCondition>
          </TableData>
          <TableData>{{ item.quantity }}</TableData>
          <TableData><BadgeYesNo :yes-no="item.hide" /></TableData>
          <TableData>
            <RouterLink
              :to="{
                name: 'admin.product.type.show',
                params: { product_id: item.product_id, id: item.id }
              }"
            >
              Pokaż 🡢
            </RouterLink>
          </TableData>
        </tr>
      </tbody>
    </TableTable>
    <AppAlert v-else>Brak danych</AppAlert>
  </template>
  <BtnGroup>
    <RouterLink :to="{ name: 'admin.product.product.show', params: { id: route.params.id } }">
      🡠 Powrót
    </RouterLink>
  </BtnGroup>
</template>
