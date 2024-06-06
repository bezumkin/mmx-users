<template>
  <div ref="input" class="form-control" @keydown="onKeydown"></div>
</template>

<script setup lang="ts">
import {JSONEditor, type Mode, type JSONContent} from 'vanilla-jsoneditor'

const props = defineProps({
  modelValue: {
    type: [Object, String],
    required: true,
  },
})

const emit = defineEmits(['update:modelValue'])
const record: any = computed({
  get() {
    return {
      text: undefined,
      json: props.modelValue,
    }
  },
  set(newValue) {
    emit('update:modelValue', newValue)
  },
})

const editor = ref()
const input = ref()

onMounted(() => {
  input.value.addEventListener('keypress', onKeydown)

  editor.value = new JSONEditor({
    target: input.value,
    props: {
      content: record.value,
      mode: 'tree' as Mode,
      mainMenuBar: false,
      navigationBar: false,
      onChange: (updatedContent) => {
        record.value = (updatedContent as JSONContent).json
      },
    },
  })
})

function onKeydown(e: KeyboardEvent) {
  if (e.key === 'Enter') {
    e.preventDefault()
  }
}
</script>

<style scoped>
.form-control {
  --jse-main-border: transparent;
}
</style>
