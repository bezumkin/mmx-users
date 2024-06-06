<template>
  <div>
    <BFormGroup :label="$t('models.user_setting.key')" :disabled="exists">
      <BFormInput v-model="record.key" required />
    </BFormGroup>

    <BFormGroup :label="$t('models.user_setting.xtype')">
      <BFormSelect v-model="record.xtype" :options="types" />
    </BFormGroup>

    <BFormGroup :label="$t('models.user_setting.value')">
      <InputSetting v-model="record.value" :type="record.xtype" />
    </BFormGroup>

    <BFormGroup :label="$t('models.user_setting.namespace')">
      <MmxInputComboBox v-model="record.namespace" url="mgr/namespaces" text-field="name" value-field="name" required />
    </BFormGroup>

    <BFormGroup :label="$t('models.user_setting.area')">
      <BFormInput v-model.number="record.area" />
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

const exists = props.modelValue.key !== ''
const types = ref<Record<string, string>[]>([])
getSettingTypes().forEach((i) => {
  types.value.push({value: i, text: $t('models.user_setting.types.' + i)})
})
</script>
