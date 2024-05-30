<template>
  <div>
    <BFormGroup :label="$t('models.user.username')">
      <BFormInput v-model="record.username" required />
    </BFormGroup>

    <BFormGroup :label="$t('models.user.fullname')">
      <BFormInput v-model="record.fullname" required />
    </BFormGroup>

    <BFormGroup :label="$t('models.user.email')">
      <BFormInput v-model="record.email" />
    </BFormGroup>

    <BFormGroup class="mt-3">
      <BFormCheckbox v-model="record.active">{{ $t('models.user.active') }}</BFormCheckbox>
    </BFormGroup>
  </div>
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
</script>
