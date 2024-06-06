<template>
  <MmxTable ref="table" v-bind="{url, fields, headerActions, tableActions, filters, sort, dir}">
    <RouterView />
  </MmxTable>
</template>

<script setup lang="ts">
const url = 'mgr/user-groups'
const table = ref()
const headerActions = computed(() => {
  return [{route: {name: 'groups-create'}, icon: 'plus', title: $t('models.user_group.title_one')}]
})
const fields = computed(() => {
  return [
    {key: 'id', label: $t('models.user_group.id'), sortable: true},
    {key: 'name', label: $t('models.user_group.name'), sortable: true},
    {key: 'parent.name', label: $t('models.user_group.parent')},
    {key: 'members_count', label: $t('models.user.title_many'), sortable: true},
    {key: 'rank', label: $t('models.user_group.rank'), sortable: true},
  ]
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
</script>
