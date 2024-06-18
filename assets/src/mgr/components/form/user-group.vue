<template>
  <div>
    <BFormGroup :label="$t('models.user_group.name')">
      <BFormInput v-model="record.name" required />
    </BFormGroup>

    <BFormGroup :label="$t('models.user_group.description')">
      <BFormTextarea v-model="record.description" rows="3" />
    </BFormGroup>

    <BFormGroup :label="$t('models.user_group.parent.name')">
      <MmxInputComboBox
        v-model="record.parent"
        url="mgr/user-groups"
        text-field="name"
        sort="name"
        :filter-props="{exclude: record.id}"
      />
    </BFormGroup>

    <BFormGroup :label="$t('models.user_group.rank')">
      <BFormInput v-model.number="record.rank" />
    </BFormGroup>

    <BFormGroup v-if="!record.id">
      <BFormCheckbox v-model="record.aw_parallel">{{ $t('models.user_group.resource_group.create') }}</BFormCheckbox>
    </BFormGroup>

    <BFormGroup v-if="record.aw_parallel" :description="$t('models.user_group.resource_group.desc')">
      <input v-model="record.aw_contexts" style="display: none" required />
      <BFormTags v-if="allContexts.length" v-model="record.aw_contexts" add-on-change no-outer-focus>
        <template #default="{tags, inputAttrs, inputHandlers, removeTag}">
          <BFormSelect
            v-if="availableContexts.length > 0"
            v-bind="inputAttrs"
            :options="availableContexts"
            v-on="inputHandlers"
          >
            <template #first>
              <option disabled value="">{{ $t('models.user_group.resource_group.select') }}</option>
            </template>
          </BFormSelect>
          <div v-if="tags.length > 0" class="d-flex my-2 gap-1">
            <div v-for="tag in tags" :key="tag">
              <BFormTag variant="info" @remove="removeTag(tag)">{{ tag }}</BFormTag>
            </div>
          </div>
        </template>
      </BFormTags>
    </BFormGroup>
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
  set(newValue: number) {
    emit('update:modelValue', newValue)
  },
})

const allContexts = ref<Record<string, any>[]>([])
const availableContexts = computed(() => {
  return allContexts.value.filter((i) => !record.value.aw_contexts.includes(i.value))
})

onMounted(async () => {
  try {
    const res = await useGet('mgr/contexts', {combo: true, sort: 'rank'})
    res.rows.forEach((i: Record<string, any>) => {
      if (i.key !== 'mgr') {
        allContexts.value.push({text: i.name, value: i.key})
        record.value.aw_contexts.push(i.key)
      }
    })
  } catch (e) {}
})
</script>
