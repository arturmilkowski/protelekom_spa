<script setup>
import { useAuthStore } from '@/stores/auth'
const store = useAuthStore()
</script>

<template>
  <nav
    class="flex justify-between border-b-[1px] border-black mx-2 mb-12 py-3 lg:py-4 xl:py-6 2xl:py-8 text-sm sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl-text-2xl"
  >
    <div class="flex gap-x-2 sm:gap-x-2 md:gap-x-4 lg:gap-x-8 xl:gap-x-12 2xl:gap-x-14">
      <RouterLink :to="{ name: 'page.home' }">
        <img alt="Vue logo" class="logo inline" src="@/assets/logo.svg" width="30" height="30" />
      </RouterLink>
      <RouterLink :to="{ name: 'page.home' }">Strona główna</RouterLink>
      <template v-if="store.isAuth">
        <RouterLink :to="{ name: 'admin.product.brand.index' }">Firmy</RouterLink>
        <RouterLink :to="{ name: 'admin.product.category.index' }">Kategorie</RouterLink>
        <RouterLink :to="{ name: 'admin.product.condition.index' }">Stan</RouterLink>
        <RouterLink :to="{ name: 'admin.product.home' }">Produkty</RouterLink>
      </template>
      <RouterLink :to="{ name: 'page.about' }">O firmie</RouterLink>
    </div>
    <div class="text-gray-400">
      <RouterLink :to="{ name: 'login' }" v-if="store.isGuest">Zaloguj</RouterLink>
      <RouterLink :to="{ name: 'logout' }" v-else>Wyloguj</RouterLink>
    </div>
  </nav>
</template>
