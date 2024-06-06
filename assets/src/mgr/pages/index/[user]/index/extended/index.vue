<template>
  <div>
    <FormUserExtended v-model="record.extended" />
  </div>
</template>

<script setup lang="ts">
const record = inject<Record<string, any>>('record') || {}
</script>
