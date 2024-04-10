<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import TableTable from '@/components/TableTable.vue'
import TableData from '@/components/TableData.vue'

const route = useRoute()

const item = ref(null)
const error = ref(null)
const apiUrl = `api/admins/products/brands/${route.params.id}`

try {
  const res = await axios(apiUrl)
  item.value = res.data.data
} catch (e) {
  error.value = e
}
</script>

<template>
  <HeaderTwo>Firma</HeaderTwo>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <template v-if="item">
    <TableTable>
      <tbody>
        <tr>
          <TableData>ID</TableData>
          <TableData>{{ item.id }}</TableData>
        </tr>
        <tr>
          <TableData>Nazwa</TableData>
          <TableData>{{ item.name }}</TableData>
        </tr>
        <tr>
          <TableData>Przyjazny adres</TableData>
          <TableData>{{ item.slug }}</TableData>
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
    <BtnGroup>
      <RouterLink :to="{ name: 'admin.product.brand.index' }">Powrót</RouterLink>
      <RouterLink :to="{ name: 'admin.product.brand.edit', params: { id: item.id } }"
        >Edytuj</RouterLink
      >
    </BtnGroup>
  </template>
  <AppAlert v-else>Brak danych</AppAlert>
</template>
