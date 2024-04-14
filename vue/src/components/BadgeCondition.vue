<script setup>
import { computed } from 'vue'

const props = defineProps({
  newUsed: { type: Number }
})

const badgeClass = computed(() => {
  if (props.newUsed == 1) {
    return 'bg-green-600'
  }

  return 'bg-orange-600'
})
</script>

<template>
  <span :class="badgeClass" class="text-sm text-white px-2 py-0.5 rounded"><slot /></span>
</template>
