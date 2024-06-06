<template>
  <BRow>
    <BCol md="6">
      <BFormGroup :label="$t('models.user.username')">
        <BFormInput v-model="record.username" required />
      </BFormGroup>

      <BFormGroup :label="$t('models.user.email')">
        <BFormInput v-model="record.email" type="email" required />
      </BFormGroup>

      <BFormGroup :label="$t('models.user.fullname')">
        <BFormInput v-model="record.fullname" />
      </BFormGroup>

      <BRow class="mb-3">
        <BCol md="6">
          <BFormGroup :label="$t('models.user.dob')">
            <BFormInput v-model="record.dob" type="date" />
          </BFormGroup>
        </BCol>
        <BCol md="6">
          <BFormGroup :label="$t('models.user.gender')">
            <BFormSelect v-model="record.gender" :options="genders" />
          </BFormGroup>
        </BCol>
      </BRow>

      <BFormGroup :label="$t('models.user.website')">
        <BFormInput v-model="record.website" type="url" />
      </BFormGroup>

      <BRow class="mb-3">
        <BCol md="6">
          <BFormGroup :label="$t('models.user.phone')">
            <BFormInput v-model="record.phone" type="tel" />
          </BFormGroup>
        </BCol>
        <BCol md="6">
          <BFormGroup :label="$t('models.user.mobilephone')">
            <BFormInput v-model="record.mobilephone" type="tel" />
          </BFormGroup>
        </BCol>
      </BRow>

      <BFormGroup :label="$t('models.user.fax')">
        <BFormInput v-model="record.fax" type="tel" />
      </BFormGroup>

      <BFormGroup :label="$t('models.user.country')">
        <MmxInputComboBox v-model="record.country" url="mgr/countries" />
      </BFormGroup>

      <BRow class="mb-3">
        <BCol md="4">
          <BFormGroup :label="$t('models.user.state')">
            <BFormInput v-model="record.state" />
          </BFormGroup>
        </BCol>
        <BCol md="4">
          <BFormGroup :label="$t('models.user.city')">
            <BFormInput v-model="record.city" />
          </BFormGroup>
        </BCol>
        <BCol md="4">
          <BFormGroup :label="$t('models.user.zip')">
            <BFormInput v-model="record.zip" />
          </BFormGroup>
        </BCol>
      </BRow>

      <BFormGroup :label="$t('models.user.address')">
        <BFormTextarea v-model="record.address" rows="2" />
      </BFormGroup>
    </BCol>
    <BCol md="6" class="mt-3 mt-md-0">
      <BRow>
        <BCol md="6">
          <BFormGroup>
            <BFormCheckbox v-model="record.active">{{ $t('models.user.active') }}</BFormCheckbox>
            <BFormCheckbox v-model="record.blocked">{{ $t('models.user.blocked') }}</BFormCheckbox>
            <BFormCheckbox v-model="record.sudo">{{ $t('models.user.sudo') }}</BFormCheckbox>
          </BFormGroup>
        </BCol>
        <BCol md="6">
          <BFormGroup>
            <BFormCheckbox v-model="extended.pay_afterwards">
              {{ $t('models.user.extended.pay_afterwards') }}
            </BFormCheckbox>

            <template v-for="setting in settings" :key="setting.key">
              <BFormCheckbox v-if="setting.xtype === 'combo-boolean'" v-model="setting.value">
                {{ $t('models.user.settings.' + setting.key) }}
              </BFormCheckbox>
              <!--<BFormInput v-else v-model="setting.value" :placeholder="$t('models.user.settings.' + setting.key)" />-->
            </template>
          </BFormGroup>
        </BCol>
      </BRow>

      <BFormGroup :label="$t('models.user.extended.main_branch')">
        <BFormSelect v-model="extended.main_branch" :options="branches" />
      </BFormGroup>

      <BFormGroup :label="$t('models.user.extended.max_days_order_overview')">
        <BFormInput v-model="extended.max_days_order_overview" />
      </BFormGroup>

      <BFormGroup :label="$t('models.user.comment')">
        <BFormInput v-model="record.comment" />
      </BFormGroup>

      <BFormGroup :label="$t('models.user.photo')">
        <BInputGroup>
          <BFormInput v-model="record.photo" readonly />
          <template #append>
            <BButton variant="outline-secondary" @click="openBrowser('photo')">
              <i class="icon icon-file" />
            </BButton>
            <BButton v-if="record.photo" variant="outline-danger" @click="record.photo = ''">
              <i class="icon icon-times" />
            </BButton>
          </template>
        </BInputGroup>
        <BImg v-if="record.photo" :src="getImage(record.photo)" class="mw-100 mt-1 rounded" />
      </BFormGroup>

      <BFormGroup :label="$t('models.user.extended.company_logo')">
        <BInputGroup>
          <BFormInput v-model="extended.company_logo" readonly />
          <template #append>
            <BButton variant="outline-secondary" @click="openBrowser('logo')">
              <i class="icon icon-file" />
            </BButton>
            <BButton v-if="extended.company_logo" variant="outline-danger" @click="extended.company_logo = ''">
              <i class="icon icon-times" />
            </BButton>
          </template>
        </BInputGroup>
        <BImg v-if="extended.company_logo" :src="getImage(extended.company_logo)" class="mw-100 mt-1 rounded" />
      </BFormGroup>

      <BFormCheckbox v-model="record.newpassword" :disabled="!record.id" switch>
        {{ $t('models.user.password.new') }}
      </BFormCheckbox>

      <Transition name="fade">
        <BRow v-if="!record.id || record.newpassword" class="mt-2">
          <BCol md="6">
            <BFormGroup :label="$t('models.user.password.specified')">
              <BFormInput v-model="record.specifiedpassword" type="password" autofocus />
            </BFormGroup>
          </BCol>
          <BCol md="6">
            <BFormGroup :label="$t('models.user.password.confirm')">
              <BFormInput
                v-model="record.confirmpassword"
                type="password"
                :required="record.specifiedpassword !== ''"
                :state="checkPassword"
              />
            </BFormGroup>
          </BCol>
        </BRow>
      </Transition>
    </BCol>
  </BRow>
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

const extended: any = computed({
  get() {
    return props.modelValue.extended
  },
  set(newValue: object) {
    record.extended = newValue
  },
})

const settings: any = computed({
  get() {
    const value = props.modelValue.settings || []
    if (!value.find((i: any) => i.key === 'twofactoroptions')) {
      value.push({key: 'twofactoroptions', value: false, xtype: 'combo-boolean'})
    }
    return value
  },
  set(newValue: object) {
    record.settings = newValue
  },
})

const genders = ref([
  {text: '', value: 0},
  {text: useLexicon('models.user.gender_male'), value: 1},
  {text: useLexicon('models.user.gender_female'), value: 2},
  {text: useLexicon('models.user.gender_other'), value: 3},
])

const branches = ref([
  {text: '', value: ''},
  {text: 'Drachten', value: 'Drachten'},
  {text: 'Leeuwarden', value: 'Leeuwarden'},
])

const checkPassword = computed(() => {
  if (!record.value.specifiedpassword) {
    return null
  }
  return record.value.specifiedpassword === record.value.confirmpassword
})

// @ts-ignore
const MODx = window.MODx || {}

function openBrowser(type = 'logo') {
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
            if (type === 'logo') {
              extended.value.company_logo = data.relativeUrl
            } else {
              record.value.photo = data.relativeUrl
            }
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
