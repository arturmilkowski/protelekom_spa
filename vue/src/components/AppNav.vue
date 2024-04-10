<script setup>
import { useAuthStore } from '@/stores/auth'
const store = useAuthStore()
</script>

<template>
  <nav
    class="flex border-b-[1px] border-black mx-2 mb-12 lg:mb-14 xl:mb-16 2xl:mb-16 py-3 lg:py-4 xl:py-6 2xl:py-8 gap-x-2 sm:gap-x-2 md:gap-x-4 lg:gap-x-8 xl:gap-x-12 2xl:gap-x-14 text-sm sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl-text-2xl"
  >
    <RouterLink :to="{ name: 'page.home' }">
      <img alt="Vue logo" class="logo" src="@/assets/logo.svg" width="30" height="30" />
    </RouterLink>
    <RouterLink :to="{ name: 'page.home' }">Strona główna</RouterLink>
    <template v-if="store.isAuth">
      <RouterLink :to="{ name: 'admin.product.brand.index' }">Firmy</RouterLink>
      <RouterLink :to="{ name: 'admin.product.category.index' }">Kategorie</RouterLink>
      <RouterLink :to="{ name: 'admin.product.condition.index' }">Stan</RouterLink>
      <RouterLink :to="{ name: 'admin.product.product.index' }">Produkty</RouterLink>
    </template>
    <RouterLink :to="{ name: 'page.about' }">O firmie</RouterLink>
    <RouterLink :to="{ name: 'login' }" v-if="store.isGuest">Zaloguj</RouterLink>
    <RouterLink :to="{ name: 'logout' }" v-else>Wyloguj</RouterLink>
  </nav>
</template>
