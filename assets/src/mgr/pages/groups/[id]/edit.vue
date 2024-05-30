<template>
  <MmxModal v-model="record" v-bind="properties">
    <template #form-fields>
      <FormsUserGroup v-model="record" />
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const record = ref({})

const properties = {
  url: 'mgr/user-groups/' + useRoute().params.id,
  title: $t('models.user_group.title_one'),
  updateKey: 'mgr-user-groups',
  method: 'patch',
}

try {
  record.value = await useGet(properties.url)
} catch (e) {
  console.error(e)
  useError()
}
</script>
