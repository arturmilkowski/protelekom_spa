<script setup>
import { ref } from 'vue'
import { useStore } from '@/stores/store'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'
import TableTable from '@/components/TableTable.vue'
import TableHeaderRow from '@/components/TableHeaderRow.vue'
import TableHeader from '@/components/TableHeader.vue'
import TableData from '@/components/TableData.vue'

const store = useStore()

const items = ref([])
const error = ref(null)
const apiUrl = 'api/admins/products/products'

const { err, collection } = await store.all(apiUrl)
error.value = err
items.value = collection.data
</script>

<template>
  <HeaderTwo>Produkty</HeaderTwo>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <template v-else>
    <p class="my-6">
      <RouterLink :to="{ name: 'admin.product.product.create' }">Dodaj</RouterLink>
    </p>
    <TableTable v-if="items.length">
      <thead>
        <TableHeaderRow>
          <TableHeader>LP</TableHeader>
          <TableHeader>ID</TableHeader>
          <TableHeader>Firma</TableHeader>
          <TableHeader>Kategoria</TableHeader>
          <TableHeader>Nazwa</TableHeader>
          <TableHeader>Akcja</TableHeader>
        </TableHeaderRow>
      </thead>
      <tbody>
        <tr v-for="(item, index) in items" :key="item.id">
          <TableData>{{ index + 1 }}</TableData>
          <TableData>{{ item.id }}</TableData>
          <TableData>{{ item.brand }}</TableData>
          <TableData>{{ item.category }}</TableData>
          <TableData>{{ item.name }}</TableData>
          <TableData>
            <RouterLink :to="{ name: 'admin.product.product.show', params: { id: item.id } }"
              >Pokaż 🡢</RouterLink
            >
          </TableData>
        </tr>
      </tbody>
    </TableTable>
    <AppAlert v-else>Brak danych</AppAlert>
  </template>
</template>
