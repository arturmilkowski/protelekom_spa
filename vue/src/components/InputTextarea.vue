<script setup>
defineProps({
  // name: { type: String, required: true },
  id: { type: String },
  placeholder: { type: String },
  modelValue: { type: String }
})

defineEmits(['update:modelValue'])
</script>

<template>
  <!-- :name="name" -->
  <textarea
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    :id="id"
    class="border border-gray-400 hover:border-gray-900 focus:outline-none focus:border-black p-1 w-full"
    :placeholder="placeholder"
  ></textarea>
</template>
