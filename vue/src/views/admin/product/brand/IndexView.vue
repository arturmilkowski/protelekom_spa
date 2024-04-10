<script setup>
import { ref } from 'vue'
import axios from 'axios'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'
import TableTable from '@/components/TableTable.vue'
import TableHeaderRow from '@/components/TableHeaderRow.vue'
import TableHeader from '@/components/TableHeader.vue'
import TableData from '@/components/TableData.vue'

const items = ref([])
const error = ref(null)
const apiUrl = 'api/admins/products/brands'

try {
  const res = await axios(apiUrl)
  items.value = res.data.data
} catch (e) {
  error.value = e
}
</script>

<template>
  <HeaderTwo>
    Firmy ↗<sup>({{ items.length }})</sup>
  </HeaderTwo>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <template v-else>
    <p class="my-6"><RouterLink :to="{ name: 'admin.product.brand.create' }">Dodaj</RouterLink></p>
    <TableTable v-if="items.length">
      <thead>
        <TableHeaderRow>
          <TableHeader>LP</TableHeader>
          <TableHeader>ID</TableHeader>
          <TableHeader>Nazwa</TableHeader>
          <TableHeader>Akcja</TableHeader>
        </TableHeaderRow>
      </thead>
      <tbody>
        <tr v-for="(item, index) in items" :key="item.id">
          <TableData>{{ index + 1 }}</TableData>
          <TableData>{{ item.id }}</TableData>
          <TableData>{{ item.name }}</TableData>
          <TableData>
            <RouterLink :to="{ name: 'admin.product.brand.show', params: { id: item.id } }"
              >Pokaż 🡢</RouterLink
            >
          </TableData>
        </tr>
      </tbody>
    </TableTable>
    <AppAlert v-else>Brak danych</AppAlert>
  </template>
</template>
