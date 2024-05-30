<template>
  <MmxModal v-model="record" v-bind="properties">
    <template #form-fields>
      <FormsUser v-model="record" />
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const record = ref({
  username: '',
  fullname: '',
  email: '',
  active: true,
})

const properties = {
  url: 'mgr/users',
  title: $t('models.user.title_one'),
  method: 'put',
}
</script>
