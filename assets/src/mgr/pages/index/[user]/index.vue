<template>
  <MmxModal v-model="record" v-bind="properties">
    <template #form-fields>
      <BNav tabs>
        <template v-for="key in tabs" :key="key">
          <BNavItem
            :to="{name: key === 'main' ? 'index-user' : 'index-user-index-' + key, params: {user: record.id}}"
            :active="key === 'main' ? !tab : tab === key"
            active-class=""
            @click="tab = key === 'main' ? '' : key"
          >
            {{ $t('models.user.tabs.' + key + '.title') }}
          </BNavItem>
        </template>
      </BNav>
      <div class="mt-3">
        <FormUser v-show="!tab" v-model="record" />
        <RouterView />
      </div>
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const route = useRoute()
const router = useRouter()

const userId = Number(route.params.user)
const record = ref({
  id: 0,
  username: '',
  fullname: '',
  email: '',
  active: true,
  newpassword: !userId,
  specifiedpassword: '',
  confirmpassword: '',
  extended: {},
  settings: [],
  groups: [],
})

const tab = ref('')
const properties = computed(() => {
  return {
    url: 'mgr/users' + (userId ? '/' + userId : ''),
    title: $t('models.user.title_one') + (userId ? ': ' + record.value.username : ''),
    updateKey: 'mgr-users',
    method: userId ? 'patch' : 'put',
    size: 'lg',
    hideFooter: userId && ['settings', 'groups', 'commerce-addresses'].includes(tab.value),
    onHidden() {
      router.push({name: 'index'})
    },
    onAfterSubmit(data: any) {
      if (data && typeof data === 'string') {
        useToastSuccess(data)
      }
    },
  }
})

if (userId) {
  try {
    record.value = await useGet(properties.value.url)
  } catch (e) {
    console.error(e)
    useError()
  }
}

const tabs = getSystemSetting(userId ? 'user-tabs-edit' : 'user-tabs-create')
  .split(',')
  .map((g: string) => g.trim())
tabs.forEach((g: string) => {
  if (String(route.name).includes(g)) {
    tab.value = g
  }
})
if (!tabs.includes('main')) {
  tabs.unshift('main')
}

provide('record', record)
</script>
