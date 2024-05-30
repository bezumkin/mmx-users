<template>
  <MmxModal v-model="record" v-bind="properties">
    <template #form-fields>
      <FormsUserGroup v-model="record" />
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const record = ref({
  name: '',
  description: '',
  active: true,
})

const properties = {
  url: 'mgr/user-groups',
  title: $t('models.user_group.title_one'),
  method: 'put',
}
</script>
