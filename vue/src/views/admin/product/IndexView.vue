<template>
  <div class="grid grid-cols-2 gap-4">
    <RouterLink
      class="border-[1px] border-black p-4 border-dashed hover:border-solid"
      :to="{ name: 'admin.product.brand.index' }"
      >Firmy 🡢</RouterLink
    >
    <RouterLink
      class="border-[1px] border-black p-4 border-dashed hover:border-solid"
      :to="{ name: 'admin.product.category.index' }"
      >Kategorie 🡢</RouterLink
    >
    <RouterLink
      class="border-[1px] border-black p-4 border-dashed hover:border-solid"
      :to="{ name: 'admin.product.condition.index' }"
      >Stan 🡢</RouterLink
    >
    <RouterLink
      class="border-[1px] border-black p-4 border-dashed hover:border-solid"
      :to="{ name: 'admin.product.index' }"
      >Produkty 🡢</RouterLink
    >
  </div>
</template>
