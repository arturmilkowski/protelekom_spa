<script setup>
import { RouterView } from 'vue-router'
import AppNav from '@/components/AppNav.vue'
import AppFooter from '@/components/AppFooter.vue'
</script>

<template>
  <AppNav />
  <RouterView v-slot="{ Component }">
    <template v-if="Component">
      <KeepAlive>
        <Suspense>
          <main class="mx-2">
            <component :is="Component"></component>
          </main>
          <template #fallback>
            <div class="mx-2">Wczytuję...</div>
          </template>
        </Suspense>
      </KeepAlive>
    </template>
  </RouterView>
  <AppFooter />
</template>
