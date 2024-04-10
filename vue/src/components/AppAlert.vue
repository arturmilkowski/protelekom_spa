<script setup>
import { computed } from 'vue'
const props = defineProps({
  type: { type: String, default: 'primary' }
})
const alertClass = computed(() => {
  if (props.type == 'danger') {
    return 'bg-red-500 text-stone-50'
  }
  return 'bg-yellow-300 text-stone-800'
})
</script>

<template>
  <div
    :class="alertClass"
    class="px-2 py-1 text-base sm:base md:text-base lg:text-lg xl:text-xl 2xl:text-2xl"
  >
    <slot />
  </div>
</template>
