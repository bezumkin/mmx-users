<template>
  <MmxModal v-model="record" v-bind="properties">
    <template #form-fields>
      <BNav tabs>
        <BNavItem :to="{name: 'groups-id', params: {id: record.id}}" :active="!tab" active-class="" @click="tab = ''">
          {{ $t('models.user_group.title_one') }}
        </BNavItem>
        <BNavItem
          v-for="(title, key) in tabs"
          :key="key"
          :to="{name: 'groups-id-index-' + key, params: {id: record.id}}"
          @click="tab = key"
        >
          {{ $t(title) }}
        </BNavItem>
      </BNav>

      <div class="mt-3">
        <FormUserGroup v-show="!tab" v-model="record" />
        <RouterView />
      </div>
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const router = useRouter()
const record = ref<Record<string, any>>({})

const route = useRoute()
const tab = ref('')
const properties = computed(() => {
  return {
    url: 'mgr/user-groups/' + route.params.id,
    title: $t('models.user_group.title_one') + ': ' + record.value.name,
    updateKey: 'mgr-user-groups',
    method: 'patch',
    size: tab.value ? 'lg' : 'md',
    hideFooter: Boolean(tab.value),
    onHidden() {
      router.push({name: 'groups'})
    },
  }
})

try {
  record.value = await useGet(properties.value.url)
} catch (e) {
  console.error(e)
  useError()
}

const tabs = {
  users: 'models.user.title_many',
}
Object.keys(tabs).forEach((g) => {
  if (String(route.name).includes(g)) {
    tab.value = g
  }
})
</script>
