<template>
  <MmxModal ref="modal" v-model="record" v-bind="properties" @keydown="onKeydown">
    <template #form-fields>
      <FormUserSetting v-model="record" />
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const {params} = useRoute()
const settingId = params.setting === '0' ? '' : params.setting
const record = ref<Record<string, any>>({
  user: params.user,
  key: settingId,
  xtype: 'textfield',
  value: '',
  namespace: 'core',
  area: '',
})

const url = 'mgr/user/' + params.user + '/settings'
const properties = {
  url: settingId ? url + '/' + settingId : url,
  title: $t('models.user_setting.title_one'),
  updateKey: 'mgr-user-settings',
  method: settingId ? 'patch' : 'put',
  onAfterSubmit,
  onKeydown,
}

if (settingId) {
  try {
    record.value = await useGet(properties.url)
  } catch (e) {
    console.error(e)
    useError()
  }
}

const modal = ref()
const userData = inject<Record<string, any>>('record')

function onAfterSubmit(data: any) {
  if (data.key && userData?.value?.settings) {
    // Update user settings on main tab
    userData.value.settings.forEach((s: any) => {
      if (s.key === data.key) {
        s.value = data.xtype === 'combo-boolean' ? Boolean(Number(data.value)) : data.value
      }
    })
  }
}

function onKeydown(e: KeyboardEvent) {
  if (e.key === 'Escape') {
    e.stopPropagation()
    modal.value.hide()
  }
}
</script>
