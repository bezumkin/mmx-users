<template>
  <div>
    <BFormRadioGroup v-if="type === 'combo-boolean'" v-model="value">
      <BFormRadio value="1">True</BFormRadio>
      <BFormRadio value="0">False</BFormRadio>
    </BFormRadioGroup>
    <BFormInput v-else-if="type === 'numberfield'" v-model.number="value" type="number" />
    <BFormInput v-else-if="type === 'text-password'" v-model.trim="value" type="password" />
    <MmxInputComboBox v-else-if="type === 'modx-combo-user'" v-model="value" url="mgr/users" text-field="username" />
    <MmxInputComboBox
      v-else-if="type === 'modx-combo-context'"
      v-model="value"
      url="mgr/contexts"
      text-field="key"
      value-field="key"
    />
    <MmxInputComboBox
      v-else-if="type === 'modx-combo-namespace'"
      v-model="value"
      url="mgr/namespaces"
      text-field="name"
      value-field="name"
    />
    <MmxInputComboBox
      v-else-if="type === 'modx-combo-usergroup'"
      v-model="value"
      url="mgr/user-groups"
      text-field="name"
    />
    <MmxInputComboBox v-else-if="type === 'modx-combo-country'" v-model="value" url="mgr/countries" />
    <BFormTextarea v-else-if="type === 'textarea'" v-model="value" rows="5" />
    <BFormTextarea v-else-if="type === 'modx-grid-json'" v-model="value" rows="5" />
    <BFormInput v-else v-model="value" />
    <!--<pre class="mt-2">{{ type }}  {{ value }}</pre>-->
  </div>
</template>

<script setup lang="ts">
const props = defineProps({
  modelValue: {
    type: [Number, String, Boolean, Array, Object],
    required: true,
  },
  type: {
    type: String,
    default: 'textfield',
  },
})

const emit = defineEmits(['update:modelValue'])
const value: any = computed({
  get() {
    return props.modelValue
  },
  set(newValue: number) {
    emit('update:modelValue', newValue)
  },
})
</script>
