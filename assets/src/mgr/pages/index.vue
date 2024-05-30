<template>
  <MmxTable ref="table" v-bind="{url, fields, headerActions, tableActions, filters, rowClass, sort, dir}">
    <RouterView />
  </MmxTable>
</template>

<script setup lang="ts">
const url = 'mgr/users'
const table = ref()
const headerActions = computed(() => {
  return [{route: {name: 'index-create'}, icon: 'plus', title: $t('models.user.title_one')}]
})
const fields = computed(() => {
  return [
    {key: 'id', label: $t('models.user.id'), sortable: true},
    {key: 'username', label: $t('models.user.username'), sortable: true},
    {key: 'fullname', label: $t('models.user.fullname'), sortable: true},
    {key: 'email', label: $t('models.user.email'), sortable: true},
    {key: 'group.name', label: $t('models.user.group')},
    {key: 'createdon', label: $t('models.user.createdon'), sortable: true, formatter: formatDate},
  ]
})
const tableActions = computed(() => {
  return [
    {route: {name: 'index-id-edit'}, icon: 'edit', title: $t('actions.edit')},
    {function: table.value?.delete, icon: 'times', title: $t('actions.delete'), variant: 'danger'},
  ]
})
const filters = ref({query: ''})
const sort = ref('createdon')
const dir = ref('desc')

function rowClass(item: any) {
  return item && !item.active ? 'inactive' : ''
}
</script>
