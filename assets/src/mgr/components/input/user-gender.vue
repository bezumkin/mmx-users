<template>
  <BFormSelect v-model="record" :options="genders" />
</template>

<script setup lang="ts">
const props = defineProps({
  modelValue: {
    type: Object,
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

const genders = ref([
  {text: '', value: 0},
  {text: useLexicon('models.user.gender_male'), value: 1},
  {text: useLexicon('models.user.gender_female'), value: 2},
  {text: useLexicon('models.user.gender_other'), value: 3},
])
</script>
