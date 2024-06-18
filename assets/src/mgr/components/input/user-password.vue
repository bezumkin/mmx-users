<template>
  <div>
    <BFormCheckbox v-model="record.newpassword" :disabled="required" switch>
      {{ $t('models.user.password.new') }}
    </BFormCheckbox>

    <Transition name="fade">
      <BRow v-if="record.newpassword" class="mt-2">
        <BCol md="6">
          <BFormGroup :label="$t('models.user.password.specified')">
            <BFormInput v-model="record.specifiedpassword" type="password" autofocus :required="required" />
          </BFormGroup>
        </BCol>
        <BCol md="6" class="mt-3 mt-md-0">
          <BFormGroup :label="$t('models.user.password.confirm')">
            <BFormInput
              v-model="record.confirmpassword"
              type="password"
              :required="record.specifiedpassword !== ''"
              :state="checkPassword"
            />
          </BFormGroup>
        </BCol>
      </BRow>
    </Transition>
  </div>
</template>

<script setup lang="ts">
const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
  required: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['update:modelValue'])
const record = ref(props.modelValue)

if (props.required) {
  record.value.newpassword = true
}

watch(
  record,
  (newValue) => {
    emit('update:modelValue', newValue)
  },
  {deep: true},
)

const checkPassword = computed(() => {
  if (!record.value.specifiedpassword) {
    return null
  }
  return record.value.specifiedpassword === record.value.confirmpassword
})
</script>
