<template>
  <div>
    <BFormGroup :label="$t('models.commerce.address.type')">
      <BFormSelect v-model="record.type" :options="types" />
    </BFormGroup>

    <BFormGroup :label="$t('models.commerce.address.fullname')">
      <BFormInput v-model="record.fullname" />
    </BFormGroup>

    <BRow class="mb-3">
      <BCol md="6">
        <BFormGroup :label="$t('models.commerce.address.firstname')">
          <BFormInput v-model="record.firstname" />
        </BFormGroup>
      </BCol>
      <BCol md="6">
        <BFormGroup :label="$t('models.commerce.address.lastname')">
          <BFormInput v-model="record.lastname" />
        </BFormGroup>
      </BCol>
    </BRow>

    <BFormGroup :label="$t('models.commerce.address.email')">
      <BFormInput v-model="record.email" />
    </BFormGroup>

    <BFormGroup :label="$t('models.commerce.address.company')">
      <BFormInput v-model="record.company" />
    </BFormGroup>

    <BFormGroup :label="$t('models.commerce.address.address1')">
      <BFormInput v-model="record.address1" />
    </BFormGroup>

    <div v-if="!showAdditional" class="pb-3">
      <BLink href="#" @click.prevent="showAdditional = true">{{ $t('actions.more') }}</BLink>
    </div>
    <template v-else>
      <BFormGroup :label="$t('models.commerce.address.address2')">
        <BFormInput v-model="record.address2" />
      </BFormGroup>
      <BFormGroup :label="$t('models.commerce.address.address3')">
        <BFormInput v-model="record.address3" />
      </BFormGroup>
    </template>

    <BRow class="mb-3">
      <BCol md="6">
        <BFormGroup :label="$t('models.commerce.address.zip')">
          <BFormInput v-model="record.zip" />
        </BFormGroup>
      </BCol>
      <BCol md="6">
        <BFormGroup :label="$t('models.commerce.address.city')">
          <BFormInput v-model="record.city" />
        </BFormGroup>
      </BCol>
    </BRow>

    <BRow class="mb-3">
      <BCol md="6">
        <BFormGroup :label="$t('models.commerce.address.state')">
          <BFormInput v-model="record.state" />
        </BFormGroup>
      </BCol>
      <BCol md="6">
        <BFormGroup :label="$t('models.commerce.address.country')">
          <MmxInputComboBox v-model="record.country" url="mgr/countries" />
        </BFormGroup>
      </BCol>
    </BRow>

    <BRow class="mb-3">
      <BCol md="6">
        <BFormGroup :label="$t('models.commerce.address.phone')">
          <BFormInput v-model="record.phone" />
        </BFormGroup>
      </BCol>
      <BCol md="6">
        <BFormGroup :label="$t('models.commerce.address.mobile')">
          <BFormInput v-model="record.mobile" />
        </BFormGroup>
      </BCol>
    </BRow>

    <BFormGroup :label="$t('models.commerce.address.notes')">
      <BFormTextarea v-model="record.notes" rows="3" />
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

const types = getCommerceAddressTypes()
const showAdditional = ref(false)
</script>
