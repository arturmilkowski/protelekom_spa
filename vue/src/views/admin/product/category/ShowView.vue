<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { useShow } from '@/composables/show'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import TableTable from '@/components/TableTable.vue'
import TableData from '@/components/TableData.vue'

const route = useRoute()

const item = ref(null)
const error = ref(null)
const apiUrl = `api/admins/products/categories/${route.params.id}`

const { err, data } = await useShow(apiUrl)
error.value = err
item.value = data
</script>

<template>
  <HeaderTwo>Kategoria</HeaderTwo>
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
      <RouterLink :to="{ name: 'admin.product.category.index' }">Powrót</RouterLink>
      <RouterLink :to="{ name: 'admin.product.category.edit', params: { id: item.id } }"
        >Edytuj</RouterLink
      >
    </BtnGroup>
  </template>
  <AppAlert v-else>Brak danych</AppAlert>
</template>
