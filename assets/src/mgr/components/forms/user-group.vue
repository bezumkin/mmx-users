<template>
  <div>
    <BFormGroup :label="$t('models.user_group.name')">
      <BFormInput v-model="record.name" required />
    </BFormGroup>

    <BFormGroup :label="$t('models.user_group.description')">
      <BFormTextarea v-model="record.description" rows="3" />
    </BFormGroup>

    <BFormGroup :label="$t('models.user_group.parent')">
      <MmxInputComboBox
        v-model="record.parent"
        url="mgr/user-groups"
        text-field="name"
        sort="name"
        :filter-props="{exclude: record.id}"
      />
    </BFormGroup>

    <BFormGroup :label="$t('models.user_group.rank')">
      <BFormInput v-model.number="record.rank" />
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
