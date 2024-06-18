<template>
  <MmxTable ref="table" v-bind="{url, fields, headerActions, tableActions, filters, rowClass, sort, dir}">
    <template #header-middle>
      <BRow class="align-items-center mt-2 mt-md-0">
        <BCol md="6"><BFormSelect v-model="filters.group" :options="groups" /></BCol>
        <BCol md="6" class="mt-2 mt-md-0"><BFormSelect v-model="filters.status" :options="statuses" /></BCol>
      </BRow>
    </template>
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
const url = 'mgr/users'
const table = ref()
const headerActions = computed(() => {
  return [{route: {name: 'index-user', params: {user: 0}}, icon: 'plus', title: $t('models.user.title_one')}]
})
const fields = computed(() => {
  const columns = getSystemSetting('user-grid-columns')
  const enabled: any = []
  Object.keys(columns).forEach((key: string) => {
    const field = {key, label: $t('models.user.' + key), ...columns[key]}
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
    {route: {name: 'index-user'}, map: {user: 'id'}, icon: 'edit', title: $t('actions.edit')},
    {function: table.value?.delete, icon: 'times', title: $t('actions.delete'), variant: 'danger'},
    {function: sendInvitation, icon: 'envelope', title: $t('actions.invite')},
  ]
})
const filters = ref({query: '', group: '', status: ''})
const sort = ref('id')
const dir = ref('desc')

function rowClass(item: any) {
  if (!item) {
    return ''
  }
  const cls = []
  if (!item.active) {
    cls.push('inactive')
  }
  if (item.blocked) {
    cls.push('blocked')
  }
  if (item.sudo) {
    cls.push('sudo')
  }

  return cls
}

function cellType(key: string) {
  const field = fields.value.find((f: any) => f.key === key)
  return field && field.type ? field.type : ''
}

async function sendInvitation(user: Record<string, any>) {
  try {
    await usePost('mgr/user/' + user.id + '/invite')
    useToastSuccess(useLexicon('success.user.invited'))
  } catch (e) {}
}

const groups = ref([{value: '', text: $t('models.user_group.filter_any')}])
const statuses = ref([
  {value: '', text: $t('models.user.filter.any')},
  {value: '1', text: $t('models.user.filter.active')},
  {value: '0', text: $t('models.user.filter.inactive')},
])

onMounted(async () => {
  try {
    const res = await useGet('mgr/user-groups', {limit: 0, combo: true, sort: 'rank'})
    res.rows?.forEach((g: any) => {
      groups.value.push({value: g.id, text: g.name})
    })
  } catch (e) {}
})
</script>

<style scoped lang="scss">
:deep(.b-table) {
  tr {
    &.blocked {
      td:not(.table-actions) {
        font-style: italic;
      }
    }

    &.sudo {
      td:not(.table-actions) {
        font-weight: bold;
      }
    }
  }
}
</style>
