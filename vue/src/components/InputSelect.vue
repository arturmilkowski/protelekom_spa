<script setup>
defineProps({
  items: { type: [Array, Object], required: true },
  id: { type: String },
  placeholder: { type: String, default: 'Wybierz' },
  modelValue: { type: [String, Number] }
})
defineEmits(['update:modelValue'])
</script>

<template>
  <select
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    :id="id"
    class="border border-gray-400 hover:border-gray-900 focus:outline-none focus:border-black bg-white p-1.5 w-full"
  >
    <option disabled value="">{{ placeholder }}</option>
    <option v-for="item in items" :key="item.id" :value="item.id">
      {{ item.name }}
    </option>
  </select>
</template>
