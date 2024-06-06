<template>
  <MmxModal ref="modal" v-model="record" v-bind="properties" @keydown="onKeydown">
    <template #form-fields>
      <FormCommerceAddress v-model="record" />
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const record = ref<Record<string, any>>({
  type: 'shipping',
})
const {params} = useRoute()
const addressId = Number(params.address)

const url = 'mgr/user/' + params.user + '/commerce/addresses'
const properties = {
  url: addressId ? url + '/' + addressId : url,
  title: $t('models.commerce.address.title_one'),
  updateKey: 'mgr-user-commerce-addresses',
  method: addressId ? 'patch' : 'put',
}

if (addressId) {
  try {
    record.value = await useGet(properties.url)
  } catch (e) {
    console.error(e)
    useError()
  }
}

const modal = ref()

function onKeydown(e: KeyboardEvent) {
  if (e.key === 'Escape') {
    e.stopPropagation()
    modal.value.hide()
  }
}
</script>
