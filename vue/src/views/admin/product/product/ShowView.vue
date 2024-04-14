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
import YesNoBadge from '@/components/YesNoBadge.vue'

const route = useRoute()
const store = useStore()

const item = ref(null)
const error = ref(null)
const showModal = ref(false)
const apiUrl = 'api/admins/products/products'
const apiImageUrl = 'api/admins/products/products/images'

const { err, data } = await store.getOne(apiUrl, route.params.id)
error.value = err
item.value = data.data

const destroyImage = async (id) => {
  if (confirm('Potwierdź')) {
    try {
      await store.destroy(apiImageUrl, id)
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
          <TableData>Firma</TableData>
          <TableData>{{ item.brand }}</TableData>
        </tr>
        <tr>
          <TableData>Kategoria</TableData>
          <TableData>{{ item.category }}</TableData>
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
          <TableData>Opis strony</TableData>
          <TableData>{{ item.site_description }}</TableData>
        </tr>
        <tr>
          <TableData>Słowa kluczowe</TableData>
          <TableData>{{ item.site_keyword }}</TableData>
        </tr>
        <tr>
          <TableData>Ukryj produkt</TableData>
          <TableData><YesNoBadge :yes-no="item.hide" /></TableData>
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
      <RouterLink :to="{ name: 'admin.product.type.index' }">Pokaż warianty produktu</RouterLink>
    </BtnGroup>
  </template>
  <AppAlert v-else>Brak danych</AppAlert>
</template>
