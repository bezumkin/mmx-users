<template>
  <BFormGroup :label="label">
    <component :is="component" v-bind="params" v-model="record">
      <template v-if="['checkbox', 'radio'].includes(type)">{{ $t('models.user.' + field) }}</template>
    </component>
  </BFormGroup>
</template>

<script setup lang="ts">
import {MmxInputComboBox} from '@vesp/mmx-frontend'
import {BFormInput, BFormCheckbox, BFormTextarea, BFormSelect} from 'bootstrap-vue-next'
import InputUserGender from '../input/user-gender.vue'
import InputUserImage from '../input/user-image.vue'
import InputUserPassword from '../input/user-password.vue'

const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
  field: {
    type: String,
    required: true,
  },
})

const fields = getSystemSetting('user-form-fields-available')
const type = computed(() => {
  return fields[props.field] && fields[props.field].type ? fields[props.field].type : 'text'
})
const component = computed(() => {
  switch (type.value) {
    case 'textarea':
      return BFormTextarea
    case 'checkbox':
      return BFormCheckbox
    case 'select':
      return BFormSelect
    case 'country':
      return MmxInputComboBox
    case 'gender':
      return InputUserGender
    case 'image':
      return InputUserImage
    case 'user-password':
      return InputUserPassword
    default:
      return BFormInput
  }
})
const params = computed(() => {
  const settings = fields[props.field] || {}
  const options: Record<string, any> = {
    required: Boolean(settings.required),
  }
  if (component.value === BFormInput && settings.type) {
    options.type = settings.type
    if (options.type === 'number') {
      if (options.min) {
        settings.min = Number(options.min)
      }
      if (options.max) {
        settings.max = Number(options.max)
      }
      if (options.step) {
        settings.step = Number(options.step)
      }
    }
  }
  if (component.value === BFormSelect && settings.options) {
    options.options = settings.options
  }
  if (type.value === 'country') {
    options.url = 'mgr/countries'
  }
  return options
})

const emit = defineEmits(['update:modelValue'])
const record: any = computed({
  get() {
    let value = props.modelValue
    if (type.value === 'user-password') {
      value = reactive({
        newpassword: value.newpassword || false,
        specifiedpassword: value.specifiedpassword || '',
        confirmpassword: value.confirmpassword || '',
      })
    } else if (props.field?.startsWith('settings.')) {
      const key = props.field.slice(9)
      const setting = value.settings.find((s: any) => s.key === key)
      if (setting) {
        value = setting.value
      }
    } else if (props.field?.startsWith('extended.')) {
      props.field?.split('.').forEach((p: string) => {
        value = value[p]
      })
    } else {
      value = props.modelValue[props.field]
    }
    return value
  },
  set(newValue) {
    const value = JSON.parse(JSON.stringify(props.modelValue))
    if (type.value === 'user-password') {
      value.newpassword = newValue.newpassword
      value.specifiedpassword = newValue.specifiedpassword
      value.confirmpassword = newValue.confirmpassword
    } else if (props.field?.startsWith('settings.')) {
      const key = props.field.slice(9)
      const setting = value.settings.find((s: any) => s.key === key)
      if (setting) {
        setting.value = newValue
      } else {
        value.settings.push({key, type: type.value === 'checkbox' ? 'combo-boolean' : 'textfield', value: newValue})
      }
    } else if (props.field?.startsWith('extended.')) {
      setDeepValue(value, newValue, props.field)
    } else {
      value[props.field] = newValue
    }
    emit('update:modelValue', value)
  },
})

const label = computed(() => {
  return !['user-password', 'checkbox', 'radio'].includes(type.value) ? $t('models.user.' + props.field) : ''
})
</script>
