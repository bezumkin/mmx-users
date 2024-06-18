<template>
  <BRow v-if="Array.isArray(fields)" class="mb-3">
    <BCol v-for="(col, colIdx) in fields" :key="colIdx" :md="size" :class="colIdx > 0 ? 'mt-3 mt-md-0' : ''">
      <template v-if="Array.isArray(col)">
        <component :is="FormLayoutUser" v-for="(row, rowIdx) in col" :key="rowIdx" v-model="record" :fields="row" />
      </template>
      <FormLayoutUserField v-else-if="typeof col === 'string'" v-model="record" :field="col" />
    </BCol>
  </BRow>
  <FormLayoutUserField v-else v-model="record" :field="fields" />
</template>

<script setup lang="ts">
import FormLayoutUser from './user.vue'

const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
  fields: {
    type: [Array, String],
    required: true,
  },
})

const emit = defineEmits(['update:modelValue'])
const record: any = computed({
  get() {
    return props.modelValue
  },
  set(newValue: number) {
    emit('update:modelValue', newValue)
  },
})

const size = computed(() => {
  return 12 / (props.fields?.length || 2)
})
</script>
