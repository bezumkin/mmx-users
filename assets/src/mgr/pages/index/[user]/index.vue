<template>
  <MmxModal v-model="record" v-bind="properties">
    <template #form-fields>
      <BNav tabs>
        <BNavItem
          :to="{name: 'index-user', params: {user: record.id}}"
          :active="!tab"
          active-class=""
          @click="tab = ''"
        >
          {{ $t('models.user.tabs.general') }}
        </BNavItem>
        <BNavItem
          v-for="key in tabs"
          :key="key"
          :to="{name: 'index-user-index-' + key, params: {user: record.id}}"
          @click="tab = key"
        >
          {{ $t('models.user.tabs.' + key) }}
        </BNavItem>
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
const record = ref<Record<string, any>>({})

const tab = ref('')
const properties = computed(() => {
  return {
    url: 'mgr/users/' + route.params.user,
    title: $t('models.user.title_one') + ': ' + record.value.username,
    updateKey: 'mgr-users',
    method: 'patch',
    size: 'lg',
    hideFooter: Boolean(tab.value) && tab.value !== 'extended',
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

try {
  record.value = await useGet(properties.value.url)
} catch (e) {
  console.error(e)
  useError()
}

const tabs = ['extended', 'groups', 'settings', 'addresses']
tabs.forEach((g) => {
  if (String(route.name).includes(g)) {
    tab.value = g
  }
})

provide('record', record)
</script>
