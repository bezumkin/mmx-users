<template>
  <MmxTable ref="table" v-bind="{url, fields, headerActions, tableActions, updateKey, filters, sort, dir}">
    <RouterView />
  </MmxTable>
</template>

<script setup lang="ts">
const {params} = useRoute()

const url = computed(() => {
  return 'mgr/user/' + params.user + '/settings'
})
const table = ref()
const headerActions = computed(() => {
  return [
    {
      route: {name: 'index-user-index-settings-index-setting', params: {setting: 0}},
      icon: 'plus',
      title: $t('models.user_setting.title_one'),
    },
  ]
})
const fields = computed(() => {
  return [
    {key: 'key', label: $t('models.user_setting.key'), sortable: true},
    {key: 'value', label: $t('models.user_setting.value')},
    // {key: 'xtype', label: $t('models.user_setting.xtype')},
    {key: 'namespace', label: $t('models.user_setting.namespace')},
    {key: 'editedon', label: $t('models.user_setting.editedon'), sortable: true, formatter: formatDate},
  ]
})
const tableActions = computed(() => {
  return [
    {
      route: {name: 'index-user-index-settings-index-setting'},
      map: {user: 'user', setting: 'key'},
      icon: 'edit',
      title: $t('actions.edit'),
    },
    {function: table.value?.delete, icon: 'times', title: $t('actions.delete'), variant: 'danger'},
  ]
})
const filters = ref({query: ''})
const sort = 'key'
const dir = 'asc'
const updateKey = 'mgr-user-settings'
</script>
