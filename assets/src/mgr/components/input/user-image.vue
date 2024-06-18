<template>
  <div>
    <BInputGroup>
      <BFormInput v-model="record" readonly />
      <template #append>
        <BButton variant="outline-secondary" @click="openBrowser()">
          <i class="icon icon-file" />
        </BButton>
        <BButton v-if="record" variant="outline-danger" @click="record = ''">
          <i class="icon icon-times" />
        </BButton>
      </template>
    </BInputGroup>
    <BImg v-if="record" :src="getImage(record)" class="mw-100 mt-1 rounded" />
  </div>
</template>

<script setup lang="ts">
const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['update:modelValue'])
const record: any = computed({
  get() {
    return props.modelValue
  },
  set(newValue) {
    emit('update:modelValue', newValue)
  },
})

// @ts-ignore
const MODx = window.MODx || {}
function openBrowser() {
  const images = MODx.config.upload_images.split(',')
  MODx.load({
    xtype: 'modx-browser-window',
    closeAction: 'close',
    multiple: false,
    source: MODx.config.default_media_source,
    hideFiles: false,
    rootVisible: false,
    allowedFileTypes: '',
    wctx: 'web',
    openTo: '',
    rootId: '/',
    hideSourceCombo: true,
    onSelectHandler() {},
    listeners: {
      select: {
        fn: function (data: any) {
          const ext = data.relativeUrl.split('.').pop()
          if (images.includes(ext)) {
            record.value = data.relativeUrl
          } else {
            useToastError(useLexicon('errors.user.image_required'))
          }
        },
      },
    },
  }).show()
}

function getImage(image: string) {
  return (MODx.config.base_url || '/') + image
}
</script>
