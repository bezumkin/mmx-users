<template>
  <MmxModal ref="modal" v-model="record" v-bind="properties" @keydown="onKeydown">
    <template #form-fields>
      <FormUserGroupMember v-model="record" :show-user="false" />
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const {params} = useRoute()
const groupId = Number(params.group)
const record = ref<Record<string, any>>({
  user_group: null,
  member: params.user,
  role: null,
  rank: 0,
})

const url = 'mgr/user/' + params.user + '/groups'
const properties = {
  url: groupId ? url + '/' + groupId : url,
  title: $t('models.user_group.title_one'),
  updateKey: 'mgr-user-groups',
  method: groupId ? 'patch' : 'put',
}

if (groupId) {
  try {
    record.value = await useGet(properties.url)
  } catch (e) {
    console.error(e)
    useError()
  }
}

const modal = ref()

function onKeydown(e: KeyboardEvent) {
  if (e.key === 'Escape') {
    e.stopPropagation()
    modal.value.hide()
  }
}
</script>
