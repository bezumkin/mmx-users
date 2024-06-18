<template>
  <div>
    <div v-if="!Number(params.id)" class="alert alert-info" v-html="$t('models.user_group.tabs.users.disabled')" />
    <MmxTable v-else ref="table" v-bind="{url, fields, headerActions, tableActions, filters, sort, dir, updateKey}">
      <template #cell(user)="{value}">
        <BLink :to="{name: 'index-user', params: {user: value.id}}">{{ value.username }}</BLink>
      </template>
      <RouterView />
    </MmxTable>
  </div>
</template>

<script setup lang="ts">
const {params} = useRoute()

const url = computed(() => {
  return 'mgr/user-group/' + params.id + '/users'
})
const table = ref()
const headerActions = computed(() => {
  return [
    {
      route: {name: 'groups-id-index-users-index-uid', params: {uid: 0}},
      icon: 'plus',
      title: $t('models.user.title_one'),
    },
  ]
})
const fields = computed(() => {
  return [
    // {key: 'id', label: $t('models.user_group_member.id'), sortable: true},
    {key: 'user', label: $t('models.user_group_member.member')},
    {key: 'role.name', label: $t('models.user_group_member.role')},
    {key: 'rank', label: $t('models.user_group_member.rank'), sortable: true},
  ]
})
const tableActions = computed(() => {
  return [
    {
      route: {name: 'groups-id-index-users-index-uid'},
      map: {id: 'user_group', uid: 'id'},
      icon: 'edit',
      title: $t('actions.edit'),
    },
    {function: table.value?.delete, icon: 'times', title: $t('actions.delete'), variant: 'danger'},
  ]
})
const filters = ref({query: ''})
const sort = 'rank'
const dir = 'desc'
const updateKey = 'mgr-user-group-users'
</script>
