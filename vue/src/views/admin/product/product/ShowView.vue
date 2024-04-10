<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { useStore } from '@/stores/store'
import { useTrueFalseMessage } from '@/composables/useTrueFalseMessage'
import HeaderTwo from '@/components/HeaderTwo.vue'
import AppAlert from '@/components/AppAlert.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import TableTable from '@/components/TableTable.vue'
import TableData from '@/components/TableData.vue'

const route = useRoute()
const store = useStore()

const item = ref(null)
const error = ref(null)
const apiUrl = 'api/admins/products/products'

const { err, data } = await store.getOne(apiUrl, route.params.id)
error.value = err
item.value = data.data
const { message: hideMessage } = useTrueFalseMessage(item.value.hide)
</script>

<template>
  <HeaderTwo>Produkt</HeaderTwo>
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
          <TableData>Opis</TableData>
          <TableData>{{ item.description }}</TableData>
        </tr>
        <tr>
          <TableData>Opis strony</TableData>
          <TableData>{{ item.site_description }}</TableData>
        </tr>
        <tr>
          <TableData>Słowa kluczowe</TableData>
          <TableData>{{ item.site_keyword }}</TableData>
        </tr>
        <tr>
          <TableData>Ukryj produkt</TableData>
          <TableData>{{ item.hide }} | {{ hideMessage }}</TableData>
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
      <RouterLink :to="{ name: 'admin.product.product.index' }">🡠 Powrót</RouterLink>
      <RouterLink :to="{ name: 'admin.product.product.edit', params: { id: item.id } }"
        >Edytuj</RouterLink
      >
    </BtnGroup>
  </template>
  <AppAlert v-else>Brak danych</AppAlert>
</template>
