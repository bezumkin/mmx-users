<template>
  <MmxModal ref="modal" v-model="record" v-bind="properties" @keydown="onKeydown">
    <template #form-fields>
      <FormUserGroupMember v-model="record" :show-group="false" />
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const {params} = useRoute()
const userId = Number(params.uid)
const record = ref<Record<string, any>>({
  user_group: params.id,
  member: null,
  role: null,
  rank: 0,
})

const url = 'mgr/user-group/' + params.id + '/users'
const properties = {
  url: userId ? url + '/' + userId : url,
  title: $t('models.user.title_one'),
  updateKey: 'mgr-user-group-users',
  method: userId ? 'patch' : 'put',
}

if (userId) {
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
