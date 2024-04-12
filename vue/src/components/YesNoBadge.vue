<script setup>
import { computed } from 'vue'

const props = defineProps({
  yesNo: { type: Number }
})

const badgeClass = computed(() => {
  if (props.yesNo == 0) {
    return 'bg-green-600 text-white'
  }

  return 'bg-red-600'
})

const badgeText = computed(() => {
  if (props.yesNo == 0) {
    return 'Nie'
  }

  return 'Tak'
})
</script>

<template>
  <span :class="badgeClass" class="text-gray-50 px-2 py-0.5 rounded">{{ badgeText }}</span>
</template>
