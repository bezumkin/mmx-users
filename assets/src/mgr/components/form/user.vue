<template>
  <div>
    <FormLayoutUser v-model="record" :fields="userFields" />
  </div>
</template>

<script setup lang="ts">
// @ts-ignore
const MODx = window.MODx || {user: {}}
const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
})

const userFields = getSystemSetting(MODx.user.sudo ? 'user-form-fields-sudo' : 'user-form-fields-user')
const fields: Record<string, any> = getSystemSetting('user-form-fields-available')

const emit = defineEmits(['update:modelValue'])
const record: any = computed({
  get() {
    return props.modelValue
  },
  set(newValue: number) {
    emit('update:modelValue', newValue)
  },
})

function setDefaultValue(key: string) {
  const params = fields[key as string] || {}
  if (params.default !== undefined || key.startsWith('settings.')) {
    const value = params.default
    if (key.startsWith('extended.')) {
      setDeepValue(record.value, value, key)
    } else if (key.startsWith('settings.')) {
      key = key.slice(9)
      const setting = record.value.settings.find((s: any) => s.key === key)
      if (setting) {
        setting.value = value
      } else {
        record.value.settings.push({key, xtype: params.type === 'checkbox' ? 'combo-boolean' : 'textfield', value})
      }
    } else {
      record.value[key] = value
    }
  }
}

function setDefaultValues(key: string | string[]) {
  if (Array.isArray(key)) {
    key.forEach((f: string | string[]) => {
      if (Array.isArray(f)) {
        setDefaultValues(f)
      } else {
        setDefaultValue(f)
      }
    })
  } else {
    setDefaultValue(key)
  }
}

if (!record.value.id) {
  userFields.forEach((f: any) => {
    setDefaultValues(f)
  })
}
</script>
