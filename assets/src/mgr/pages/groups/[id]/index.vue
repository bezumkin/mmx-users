<template>
  <MmxModal v-model="record" v-bind="properties">
    <template #form-fields>
      <BNav tabs>
        <template v-for="key in tabs" :key="key">
          <BNavItem
            :to="{name: key === 'main' ? 'groups-id' : 'groups-id-index-' + key, params: {id: record.id}}"
            :active="key === 'main' ? !tab : tab === key"
            active-class=""
            @click="tab = key === 'main' ? '' : key"
          >
            {{ $t('models.user_group.tabs.' + key + '.title') }}
          </BNavItem>
        </template>
      </BNav>
      <div class="mt-3">
        <FormUserGroup v-show="!tab" v-model="record" />
        <RouterView />
      </div>
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const route = useRoute()
const router = useRouter()

const groupId = Number(route.params.id)
const record = ref({
  id: 0,
  name: '',
  description: '',
  active: true,
  aw_parallel: false,
  aw_contexts: [],
})
const tab = ref('')
const properties = computed(() => {
  return {
    url: 'mgr/user-groups' + (groupId ? '/' + groupId : ''),
    title: $t('models.user_group.title_one') + (groupId ? ': ' + record.value.name : ''),
    updateKey: 'mgr-user-groups',
    method: groupId ? 'patch' : 'put',
    size: tab.value ? 'lg' : 'md',
    hideFooter: tab.value !== '',
    onHidden() {
      router.push({name: 'groups'})
    },
  }
})

if (groupId) {
  try {
    record.value = await useGet(properties.value.url)
  } catch (e) {
    console.error(e)
    useError()
  }
}

const tabs = getSystemSetting(groupId ? 'group-tabs-edit' : 'group-tabs-create')
  .split(',')
  .map((g: string) => g.trim())
tabs.forEach((g) => {
  if (String(route.name).includes(g)) {
    tab.value = g
  }
})
if (!tabs.includes('main')) {
  tabs.unshift('main')
}
</script>
