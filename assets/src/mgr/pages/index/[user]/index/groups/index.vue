<template>
  <MmxTable ref="table" v-bind="{url, fields, headerActions, tableActions, filters, sort, dir, updateKey}">
    <template #cell(group)="{value}">
      <BLink :to="{name: 'groups-id', params: {id: value.id}}">{{ value.name }}</BLink>
    </template>
    <RouterView />
  </MmxTable>
</template>

<script setup lang="ts">
const {params} = useRoute()

const url = computed(() => {
  return 'mgr/user/' + params.user + '/groups'
})
const table = ref()
const headerActions = computed(() => {
  return [
    {
      route: {name: 'index-user-index-groups-index-group', params: {group: 0}},
      icon: 'plus',
      title: $t('models.user_group.title_one'),
    },
  ]
})
const fields = computed(() => {
  return [
    // {key: 'id', label: $t('models.user_group_member.id'), sortable: true},
    {key: 'group', label: $t('models.user_group_member.user_group')},
    {key: 'role.name', label: $t('models.user_group_member.role')},
    {key: 'rank', label: $t('models.user_group_member.rank'), sortable: true},
  ]
})
const tableActions = computed(() => {
  return [
    {
      route: {name: 'index-user-index-groups-index-group'},
      map: {user: 'user', group: 'id'},
      icon: 'edit',
      title: $t('actions.edit'),
    },
    {function: table.value?.delete, icon: 'times', title: $t('actions.delete'), variant: 'danger'},
  ]
})
const filters = ref({query: ''})
const sort = 'rank'
const dir = 'asc'
const updateKey = 'mgr-user-groups'
</script>
