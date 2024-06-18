<template>
  <MmxTable ref="table" v-bind="{url, fields, headerActions, tableActions, filters, sort, dir}">
    <template #cell()="{value, field}">
      <div v-if="cellType(field.key).startsWith('bool')">
        <i v-if="Number(value)" class="icon icon-check text-success" />
        <i v-else class="icon icon-times text-danger" />
      </div>
      <template v-else>{{ value }}</template>
    </template>
    <RouterView />
  </MmxTable>
</template>

<script setup lang="ts">
const url = 'mgr/user-groups'
const table = ref()
const headerActions = computed(() => {
  return [{route: {name: 'groups-id', params: {id: 0}}, icon: 'plus', title: $t('models.user_group.title_one')}]
})
const fields = computed(() => {
  const columns = getSystemSetting('group-grid-columns')
  const enabled: any = []
  Object.keys(columns).forEach((key: string) => {
    const field = {key, label: $t('models.user_group.' + key), ...columns[key]}
    if (key === 'createdon') {
      field.formatter = formatDate
    }
    if (field.sort) {
      sort.value = key
      dir.value = field.dir === 'desc' ? 'desc' : 'asc'
    }
    enabled.push(field)
  })
  return enabled
})
const tableActions = computed(() => {
  return [
    {route: {name: 'groups-id'}, icon: 'edit', title: $t('actions.edit')},
    {function: table.value?.delete, icon: 'times', title: $t('actions.delete'), variant: 'danger'},
  ]
})
const filters = ref({query: ''})
const sort = ref('rank')
const dir = ref('asc')

function cellType(key: string) {
  const field = fields.value.find((f: any) => f.key === key)
  return field && field.type ? field.type : ''
}
</script>
