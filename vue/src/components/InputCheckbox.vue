<script setup>
import { computed } from 'vue'

const props = defineProps({
  id: { type: String },
  label: { type: String },
  modelValue: { type: [Boolean, Number] } // , Array, String
})
const emit = defineEmits(['update:modelValue'])

const value = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  }
})
</script>

<template>
  <input type="checkbox" v-model="value" :id="id" />
  <label :for="id" class="text-sm ml-1">{{ label }}</label>
</template>
