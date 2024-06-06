<template>
  <div>
    <section class="mmx-table">
      <BRow class="mb-3 align-items-center">
        <BCol>
          <BButton class="col-12 col-md-auto" @click="onCreateMember">
            <i class="icon icon-plus fa-fw" /> {{ $t('models.user_group.title_one') }}
          </BButton>
        </BCol>
      </BRow>
      <BTableSimple v-if="members.length">
        <BThead>
          <BTr>
            <BTh>{{ $t('models.user_group.title_one') }}</BTh>
            <BTh>{{ $t('models.user_group_role.title_one') }}</BTh>
            <BTh>{{ $t('models.user_group.rank') }}</BTh>
            <BTh></BTh>
          </BTr>
        </BThead>
        <BTbody>
          <BTr v-for="(m, idx) in members" :key="idx">
            <BTd>{{ groups[m.user_group] }}</BTd>
            <BTd>{{ roles[m.role] }}</BTd>
            <BTd>{{ m.rank }}</BTd>
            <BTd class="table-actions">
              <BButton size="sm" variant="danger" @click="deleteMember(idx)">
                <i class="icon icon-times fa-fw" />
              </BButton>
            </BTd>
          </BTr>
        </BTbody>
      </BTableSimple>
    </section>

    <BModal v-if="Boolean(member)" :model-value="true" v-bind="modalProps" :ok-disabled="!canSubmit">
      <FormUserGroupMember v-if="member !== undefined" v-model="member" />
    </BModal>
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
const members = computed<Record<string, any>[]>({
  get() {
    return props.modelValue
  },
  set(newValue: number) {
    emit('update:modelValue', newValue)
  },
})

const groups = ref<Record<number, string>>({})
const roles = ref<Record<number, string>>({})
const member = ref<undefined | Record<string, any>>()
const canSubmit = computed(() => {
  return (
    member.value &&
    member.value.user_group &&
    member.value.role &&
    !members.value.find((i) => i.user_group === member.value?.user_group)
  )
})

const modalProps = {
  teleportDisabled: true,
  title: $t('models.user_group.title_one'),
  onHidden() {
    member.value = undefined
  },
  onKeydown(e: KeyboardEvent) {
    if (e.key === 'Escape') {
      e.stopPropagation()
    }
  },
  onOk() {
    if (member.value) {
      members.value.push(member.value)
    }
  },
}

function onCreateMember() {
  member.value = {user_group: null, role: null, rank: members.value.length}
}

function deleteMember(idx: number) {
  members.value.splice(idx, 1)
}

onMounted(async () => {
  try {
    const params = {limit: 0, combo: true}
    const [r1, r2] = await Promise.all([useGet('mgr/user-groups', params), useGet('mgr/user-group-roles', params)])
    r1.rows.forEach((i: any) => {
      groups.value[i.id] = i.name
    })
    r2.rows.forEach((i: any) => {
      roles.value[i.id] = i.name
    })
  } catch (e) {}
})
</script>
