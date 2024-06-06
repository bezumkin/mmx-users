<template>
  <div>
    <BFormGroup v-if="showUser" :label="$t('models.user_group_member.member')">
      <MmxInputComboBox
        v-model="record.member"
        url="mgr/users"
        text-field="username"
        :disabled="Boolean(record.id)"
        required
      />
    </BFormGroup>

    <BFormGroup v-if="showGroup" :label="$t('models.user_group_member.user_group')">
      <MmxInputComboBox
        v-model="record.user_group"
        url="mgr/user-groups"
        text-field="name"
        :disabled="Boolean(record.id)"
        required
      />
    </BFormGroup>

    <BFormGroup :label="$t('models.user_group_member.role')">
      <MmxInputComboBox v-model="record.role" url="mgr/user-group-roles" text-field="name" required />
    </BFormGroup>

    <BFormGroup :label="$t('models.user_group_member.rank')">
      <BFormInput v-model.number="record.rank" />
    </BFormGroup>
  </div>
</template>

<script setup lang="ts">
const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
  showUser: {
    type: Boolean,
    default: true,
  },
  showGroup: {
    type: Boolean,
    default: true,
  },
})

const emit = defineEmits(['update:modelValue'])
const record: any = computed({
  get() {
    return props.modelValue
  },
  set(newValue: number) {
    emit('update:modelValue', newValue)
  },
})
</script>
