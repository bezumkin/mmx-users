<template>
  <MmxTable ref="table" v-bind="{url, fields, headerActions, tableActions, filters, sort, dir, updateKey}">
    <template #header-middle>
      <BFormSelect v-model="filters.type" :options="types" />
    </template>
    <template #cell(receiver)="{item}">
      <div v-if="item.fullname">{{ item.fullname }}</div>
      <div class="small text-muted">
        {{ formatReceiver(item) }}
      </div>
    </template>
    <template #cell(address)="{item}">
      {{ formatAddress(item) }}
      <div class="small text-muted">
        {{ formatAddressData(item) }}
      </div>
    </template>
    <RouterView />
  </MmxTable>
</template>

<script setup lang="ts">
const {params} = useRoute()

const url = computed(() => {
  return 'mgr/user/' + params.user + '/commerce/addresses'
})
const table = ref()
const headerActions = computed(() => {
  return [
    {
      route: {name: 'index-user-index-addresses-index-address', params: {address: 0}},
      icon: 'plus',
      title: $t('models.commerce.address.title_one'),
    },
  ]
})
const fields = computed(() => {
  return [
    {key: 'id', label: $t('models.commerce.address.id'), sortable: true},
    {key: 'type', label: $t('models.commerce.address.type'), sortable: true},
    {key: 'last_used', label: $t('models.commerce.address.last_used'), sortable: true, formatter: formatDate},
    {key: 'company', label: $t('models.commerce.address.company'), sortable: true},
    {key: 'receiver', label: $t('models.commerce.address.receiver')},
    {key: 'address', label: $t('models.commerce.address.address')},
  ]
})
const tableActions = computed(() => {
  return [
    {
      route: {name: 'index-user-index-addresses-index-address'},
      map: {user: 'user', address: 'id'},
      icon: 'edit',
      title: $t('actions.edit'),
    },
    {function: table.value?.delete, icon: 'times', title: $t('actions.delete'), variant: 'danger'},
  ]
})
const filters = ref({query: '', type: ''})
const sort = 'last_used'
const dir = 'desc'
const updateKey = 'mgr-user-commerce-addresses'

const types = getCommerceAddressTypes(true)

function formatReceiver(item: Record<string, any>) {
  const data = [item.email, item.mobile, item.phone].filter((n) => Boolean(n))
  return data.join(', ')
}

function formatAddress(item: Record<string, any>) {
  const data = [item.address1, item.address2, item.address3].filter((n) => Boolean(n))
  return data.join(', ')
}

function formatAddressData(item: Record<string, any>) {
  const data = [item.zip, item.city, item.state, item.country].filter((n) => Boolean(n))
  return data.join(', ')
}
</script>
