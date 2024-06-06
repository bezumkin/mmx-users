<template>
  <MmxModal v-model="record" v-bind="properties">
    <template #form-fields>
      <BNav tabs>
        <BNavItem :active="!tab" active-class="" @click.prevent="tab = ''">
          {{ $t('models.user.tabs.general') }}
        </BNavItem>
        <BNavItem v-for="key in tabs" :key="key" :active="tab === key" @click.prevent="tab = key">
          {{ $t('models.user.tabs.' + key) }}
        </BNavItem>
      </BNav>
      <div class="mt-3">
        <FormUser v-show="!tab" v-model="record" />
        <FormUserExtended v-show="tab === 'extended'" v-model="record.extended" />
        <FormUserGroups v-show="tab === 'groups'" v-model="record.groups" />
      </div>
    </template>
  </MmxModal>
</template>

<script setup lang="ts">
const record = ref({
  username: '',
  fullname: '',
  email: '',
  active: true,
  newpassword: true,
  specifiedpassword: '',
  confirmpassword: '',
  extended: {
    pay_afterwards: false,
    main_branch: '',
    max_days_order_overview: 60,
    company_logo: '',
  },
  settings: [],
  groups: [],
})

const properties = {
  url: 'mgr/users',
  title: $t('models.user.title_one'),
  method: 'put',
  size: 'lg',
  onAfterSubmit(data: any) {
    if (data && typeof data === 'string') {
      useToastSuccess(data)
    }
  },
}

const tab = ref('')
const tabs = ['extended', 'groups']
const route = String(useRoute().name)
tabs.forEach((g) => {
  if (route.includes(g)) {
    tab.value = g
  }
})
</script>
