<script setup>
defineProps({
  type: { type: String, default: 'submit' }
})
</script>

<template>
  <button
    :type="type"
    class="border-[1px] border-gray-400 px-2 py-0.5 hover:bg-gray-600 hover:text-gray-50"
  >
    <slot>Wyślij</slot>
  </button>
</template>
